<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PostAuthLoginRequest;
use App\Http\Requests\Auth\PostAuthUserRequest;
use App\Http\Requests\Auth\PatchAuthUserRequest;
use App\Http\Requests\Auth\PatchPasswordUserRequest;
use App\Http\Requests\Auth\PostUserImageRequest;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jrean\UserVerification\Facades\UserVerification;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Filter request for credentials
     *
     * @param Request $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Get user information out of token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return $this->respondWithOk($user);
    }


    /**
     * Authenticates user using credentials and returns token
     *
     * @param PostAuthLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAuthLogin(PostAuthLoginRequest $request)
    {
        $user = $this->user->where('email', $request->input('email'))->first();

        $credentials = $this->getCredentials($request);

        try {
            //attempt to verify credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->error("Incorrect email/password combination", 403);
            } elseif (!$user->verified) {
                $this->sendVerificationMail($user);
            }
        } catch (JWTException $e) {
            //something went wrong while attempting to encode the token
            return $this->response->errorInternal();
        }

        $user = $this->getAuthenticatedUser($token);
        $user->token = $token;

        return $this->respondWithOk($user);
    }


    /**
     * Logout method
     *
     * @return $this
     */
    public function getAuthLogout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return $this->respondWithOk("Logout successful.");
    }

    /**
     * Refreshes expired token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAuthTokenRefresh()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            $user_id = $e->getTrace()[0]['args'][0]['sub'];
            $user = $this->user->find($user_id);
        } catch (JWTException $e) {
            return response()->error("Token is not valid!", 403);
        }

        if (!$user->verified) {
            $this->sendVerificationMail($user);
        }

        // Refresh token
        $token = JWTAuth::refresh();

        $user = $this->getAuthenticatedUser($token);
        $user->token = $token;

        return $this->respondWithOk($user);
    }


    /**
     * Creates new user
     *
     * @param PostAuthUserRequest $request
     * @return $this
     */
    public function postAuthUser(PostAuthUserRequest $request)
    {
        $request->merge(['type' => 'user']);

        $user = User::create($request->input());

        UserVerification::generate($user);

        UserVerification::send($user, 'Activate account');

        $user->token = JWTAuth::fromUser($user);

        return $this->respondWithSuccessCreation($user);
    }

    /**
     * Edit user information
     *
     * @param PatchAuthUserRequest $request
     * @return $this
     */
    public function patchAuthUser(PatchAuthUserRequest $request)
    {
        $user = $this->getAuthenticatedUser();

        $user->update($request->all());

        return $this->respondWithOk($user);
    }

    /**
     * Delete users account and invalidates token
     *
     * @return mixed
     */
    public function deleteAuthUser()
    {
        $user = $this->getAuthenticatedUser();

        $user->delete();

        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->respondWithOk("Deleted successful.");
    }

    /**
     * Change password method
     *
     * @param PatchPasswordUserRequest $request
     * @return $this|mixed
     */
    public function patchAuthPassword(PatchPasswordUserRequest $request)
    {
        $user = $this->getAuthenticatedUser();

        if (Auth::attempt(['email' => $user->email, 'password' => $request->input('old_password')])) {
            $user = $this->user->find($user->id);

            $params = $request->filter(request()->only([
                "password",
            ]));

            $user->update($params);

            return $this->respondWithOk($user);
        }

        return $this->respondWithForbidden("Old password is wrong.");
    }


    /**
     * Send activation mail
     *
     * @param User $user
     */
    protected function sendVerificationMail(User $user)
    {
        UserVerification::generate($user);

        UserVerification::send($user, 'Activate account');
    }


    /**
     * Upload profile picture
     *
     * @param PostUserImageRequest $request
     * @return mixed
     */
    public function postAuthUserImage(PostUserImageRequest $request)
    {
        $user = Auth::user();

        $delete = [];

        if ($user->image_id) {
            $delete[] = 'profile_pictures/' . $user->id . '/' . $user->image_id;
        }

        $user_image_id = rand();
        $user->image_id = $user_image_id;
        $user->save();

        $request->image->storeAs('profile_pictures/' . $user->id, $user_image_id, 's3', "public");
        Storage::disk('s3')->delete($delete);

        return $this->respondWithOk($user);
    }


    /**
     * Get user image
     *
     * @param Request $request
     * @return mixed
     */
    public function getAuthUserImage(Request $request)
    {
        $user = Auth::user();

        $name = "";

        if ($user->image_id) {
            $name = $user->image_id;
        }

        return $this->respondWithOk($this->getUserImageUrls($name, $user->id));
    }


    /**
     * Create image url
     *
     * @param $name
     * @param $user_id
     * @return string
     */
    protected function getUserImageUrls($name, $user_id)
    {
        $response['image'] = "";

        if ($name) {
            $response['image'] = Storage::disk('s3')->url('profile_pictures/' . $user_id . '/' . $name);
        }

        return $response;
    }
}

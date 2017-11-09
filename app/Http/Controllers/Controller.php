<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    protected $statusCode = 200;


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Status code getter
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Status code setter
     *
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Method for manually creating response content
     *
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Response with status code 201
     *
     * @param string $content
     * @return mixed
     */
    public function respondWithSuccessCreation($content = "Created")
    {
        $this->setStatusCode(201);

        return response()->success($content, $this->getStatusCode());
    }

    /**
     * Response with status code 201
     *
     * @param string $content
     * @return mixed
     */
    public function respondWithOk($content = "Ok")
    {
        $this->setStatusCode(200);

        return response()->success($content, $this->getStatusCode());
    }

    /**
     * Response with status code 404
     *
     * @param string $content
     * @return mixed
     */
    public function respondWithNotFound($content = "Not found")
    {
        $this->setStatusCode(404);

        return response()->error($content, $this->getStatusCode());
    }


    /**
     * Response with status code 400
     *
     * @param string $content
     * @param int $status_code
     * @return mixed
     */
    public function respondWithError($content = "Bad request", $status_code = 400)
    {
        $this->setStatusCode($status_code);

        return response()->error($content, $this->getStatusCode());
    }


    /**
     * Response with status code 400
     *
     * @param string $content
     * @return mixed
     */
    public function respondWithInternalError($content = "Internal server error")
    {
        $this->setStatusCode(500);

        return response()->error($content, $this->getStatusCode());
    }


    /**
     * Response with status code 403
     *
     * @param string $content
     * @return mixed
     */
    public function respondWithForbidden($content = "Forbidden")
    {
        $this->setStatusCode(403);

        return response()->error($content, $this->getStatusCode());
    }


    /**
     * Response with status code 401
     *
     * @param string $content
     * @return mixed
     */
    public function respondWithUnauthorized($content = "Unauthorized")
    {
        $this->setStatusCode(401);

        return response()->error($content, $this->getStatusCode());
    }


    /**
     * Pagination strucutred response
     *
     * @param $paginator
     * @param int $status
     * @param string $contentType
     * @return $this
     */
    public function respondWithPagination($paginator, $status=200, $contentType='application/json')
    {
        $paginator->setPath(url()->current());

        $response = [
            'meta' => [
                'currentPage' => $paginator->currentPage(),
                'totalItems' => $paginator->total(),
                'itemsPerPage' => $paginator->perPage(),
                'totalPages' => $paginator->lastPage(),
            ],
            'data' => $paginator->items(),
            'links' => [
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
                'self' => $paginator->url($paginator->currentPage()),
                'template' => url()->current() . "?%page%",
            ]
        ];

        return $this->setStatusCode(200)->respond($response);
    }



    /**
     * Gets user id from token
     * @return bool
     */
    public function getAuthenticatedUserId()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return false;
        }

        return $user->id;
    }

    /**
     * Gets all user information from token
     * @param bool|false $token
     * @return mixed
     */
    public function getAuthenticatedUser($token=false)
    {
        if (!$token) {
            $user = JWTAuth::parseToken()->authenticate();
        } else {
            $user = JWTAuth::authenticate($token);
        }

        return $user;
    }

    /**
     * Returns authenticated user information
     *
     * @return mixed
     */
    public function getUserInformation()
    {
        return Auth::user();
    }
}

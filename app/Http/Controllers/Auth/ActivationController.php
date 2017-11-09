<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendActivationTokenRequest;
use Illuminate\Support\Facades\Auth;
use Jrean\UserVerification\Facades\UserVerification as UserVerificationFacade;
use Jrean\UserVerification\Traits\VerifiesUsers;

class ActivationController extends Controller
{
    use VerifiesUsers;

    protected $redirectIfVerified = 'auth/email-verification/success';
    protected $redirectAfterVerification = 'auth/email-verification/success';
    protected $redirectIfVerificationFails = 'auth/email-verification/error';
    protected $verificationErrorView = 'vendor.laravel-user-verification.error';

    /**
     * Route for manual sending (resending) activation token
     *
     * @param ResendActivationTokenRequest $request
     * @return mixed
     */
    public function getAuthUserActivate(ResendActivationTokenRequest $request)
    {
        $user = Auth::user();

        UserVerificationFacade::generate($user);

        UserVerificationFacade::send($user, 'Activate account');

        return response()->successMessage("Mail sent.", 200);
    }

    /**
     * Returns view for successful activation
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getVerificationSuccess()
    {
        return view('vendor.laravel-user-verification.success');
    }
}

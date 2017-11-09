<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GetPasswordResetTokenRequest;
use App\Traits\SendsAPIPasswordResetEmails;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsAPIPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Serves password reset form
     *
     * @param GetPasswordResetTokenRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPasswordResetToken(GetPasswordResetTokenRequest $request)
    {
        $resets_row = DB::table('password_resets')->where('token', $request->route('token'))->first();

        return view('password/reset', ['token' => $resets_row->token, 'email' => $resets_row->email]);
    }
}

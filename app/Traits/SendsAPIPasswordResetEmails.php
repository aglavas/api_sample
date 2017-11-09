<?php

namespace App\Traits;

use App\Events\Password\PasswordResetRequestEvent;
use App\Http\Requests\Auth\PostPasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

trait SendsAPIPasswordResetEmails
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Your Password Reset Link';
    }

    /**
     * Send a reset link to the given user.
     *
     * @param PostPasswordResetRequest $request
     * @return mixed
     */
    public function postPasswordReset(PostPasswordResetRequest $request)
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse()
                    : $this->sendResetLinkFailedResponse();
    }

    /**
     * Get the response for a successful password reset link.
     * @return mixed
     */
    protected function sendResetLinkResponse()
    {
        return response()->successMessage("Password reset email sent.");
    }

    /**
     * Get the response for a failed password reset link.
     * @return mixed
     */
    protected function sendResetLinkFailedResponse()
    {
        return response()->error("Password reset email failed.", 500);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}

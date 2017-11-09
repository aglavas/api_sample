<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FoundationRequest;
use Illuminate\Http\Request;

class PostPasswordResetTokenRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'token' => 'required|existsWith:password_resets,token,email,'. Request::capture()->input('email'),
            'password' => 'required|confirmed|min:6',
        ];
    }
}

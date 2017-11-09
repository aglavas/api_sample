<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FoundationRequest;

class PatchPasswordUserRequest extends FoundationRequest
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
            'password' => 'required|string|confirmed',
            'old_password' => 'required|string',
        ];
    }
}

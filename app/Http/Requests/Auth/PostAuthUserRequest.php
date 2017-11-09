<?php

namespace App\Http\Requests\Auth;

use Carbon\Carbon;
use App\Http\Requests\FoundationRequest;

class PostAuthUserRequest extends FoundationRequest
{
    /**
     * @inherit
     */
    protected function prepareForValidation()
    {
        $this->replace($this->only(
            [
                'first_name',
                'last_name',
                'sex',
                'birth_date',
                'email',
                'password',
                'password_confirmation',
                'locale',
            ]
        ));

        $this->filter();
    }


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
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'sex'         => 'required|in:male,female',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed',
            'birth_date' => 'required|date_format:Y-m-d|before:today',
            'locale'     => 'required|exists:locale,code_3',
        ];
    }
}

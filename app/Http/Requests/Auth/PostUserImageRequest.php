<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FoundationRequest;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

class PostUserImageRequest extends FoundationRequest
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
            'image' => 'required|image|max:6500',
        ];
    }
}

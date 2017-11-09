<?php
namespace App\Http\Requests\Auth;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class PatchAuthUserRequest extends FoundationRequest
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
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'sex' => 'in:male,female',
            'birth_date' => 'date_format:Y-m-d|before:today',
        ];
    }
}

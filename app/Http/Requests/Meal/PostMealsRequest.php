<?php

namespace App\Http\Requests\Meal;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\App;

class PostMealsRequest extends FoundationRequest
{
    /**
     * @inherit
     */
    protected function prepareForValidation()
    {
//    	var_dump($this->input('diet_type_ids'));
//    	die();
        // Remove all params from request which are empty
        $this->filter();
        $this->merge(['locale' => App::getLocale()]);
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
            'name'              => 'required|string',
            'preparation'       => 'required|string',
            'description'       => 'required|string',
            'meal_type_id'      => 'required|numeric|exists:meal_types,id',
            'diet_type_ids'     => 'required|array',
            'diet_type_ids.*'   => 'required|numeric|exists:diet_type,id',
            'duration'          => 'required|numeric',
            'calories'          => 'required|integer',
            'fat_amount'        => 'required|numeric',
            'protein_amount'    => 'required|numeric',
            'sugar_amount'      => 'required|numeric',
        ];
    }
}

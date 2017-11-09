<?php

namespace App\Http\Requests\Meal;

use App\Http\Requests\FoundationRequest;

class PatchMealsRequest extends FoundationRequest
{
    /**
     * @inherit
     */
    protected function prepareForValidation()
    {
        $this->replace($this->only(
            [
                'meal_type_id',
                'diet_type_ids',
                'duration',
                'calories',
                'fat_amount',
                'protein_amount',
                'sugar_amount',
                'name',
                'preparation',
                'description',
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
        $rules = [
            'id'                => 'required|exists:meals,id',
            'meal_type_id'      => 'numeric|exists:meal_types,id',
            'diet_type_ids'     => 'array',
            'diet_type_ids.*'   => 'numeric|exists:diet_type,id',
            'duration'          => 'numeric',
            'calories'          => 'numeric',
            'fat_amount'        => 'numeric',
            'protein_amount'    => 'numeric',
            'sugar_amount'      => 'numeric',
        ];

        return $rules;
    }
}

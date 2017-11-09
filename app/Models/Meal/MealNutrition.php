<?php

namespace App\Models\Meal;

use App\Models\BaseModel;

class MealNutrition extends BaseModel
{
    protected $table = "meals_nutrition";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meals_id', 'fat_amount', 'protein_amount', 'fiber_amount', 'sugar_amount'
    ];

    public $timestamps = false;

    protected $casts = [
        'id' => 'integer',
        'meal_id' => 'integer',
        'fat_amount' => 'integer',
        'protein_amount' => 'integer',
        'fiber_amount' => 'integer',
        'sugar_amount' => 'integer',
    ];
}

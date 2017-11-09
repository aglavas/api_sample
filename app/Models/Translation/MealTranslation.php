<?php

namespace App\Models\Translation;

use App\Models\BaseModel;
use App\Models\Meal\Meal;

class MealTranslation extends BaseModel
{
    protected $table = "meals_translation";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale', 'name', 'preparation', 'description', 'meal_notes'
    ];

    public $timestamps = false;

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id', 'id');
    }
}

<?php

namespace App\Models\Meal;

use App\Models\BaseModel;
use App\Traits\Filterable;

class MealType extends BaseModel
{
    use Filterable;

    protected $table = "meal_types";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type'
    ];

    protected $hidden = ['meal_type_id', 'locale'];

    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
    ];

    public $timestamps = false;

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_type_id', 'id');
    }
}

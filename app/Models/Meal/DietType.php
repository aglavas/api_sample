<?php

namespace App\Models\Meal;

use App\Models\BaseModel;
use App\Traits\Filterable;

class DietType extends BaseModel
{
    use Filterable;

    protected $table = "diet_type";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    protected $hidden = [

    ];

    public $timestamps = false;


    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'diet_type_to_meals', 'type_id', 'meal_id');
    }
}

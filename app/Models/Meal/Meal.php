<?php

namespace App\Models\Meal;

use App\Models\Translation\MealTranslation;
use Illuminate\Database\Eloquent\Builder;
use App\Models\BaseModel;
use App\Traits\Filterable;
use Illuminate\Support\Facades\App;

class Meal extends BaseModel
{
    use Filterable;

    /**
     * Define meal table
     *
     * @var string
     */
    protected $table = "meals";


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'note', 'status', 'parent_meal_id', 'meal_type_id', 'duration', 'calories', 'fat_amount', 'protein_amount', 'sugar_amount', 'pre', 'post', 'measure_unit'
    ];

    /**
     * Get translation using raw query
     *
     * @param Builder $builder
     */
    public function scopeWithTranslation(Builder $builder)
    {
        $builder
            ->select(
                'meals.*',
                'meals_translation.name',
                'meals_translation.preparation'
            )
            ->leftJoin('meals_translation', function ($join) {
                $join->on('meals.id', '=', 'meals_translation.meal_id')
                    ->where('meals_translation.locale', '=', $this->getLocale());
            });
    }

    /**
     * One to many translation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(MealTranslation::class, 'meal_id', 'id')->where('locale', App::getLocale());
    }

    /**
     * Meal nutritional value relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nutrition()
    {
        return $this->hasOne(MealNutrition::class, 'meal_id', 'id');
    }


    /**
     * This function is in use
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function diet_type()
    {
        return $this->belongsToMany(DietType::class, 'diet_type_to_meals', 'meal_id', 'type_id');
    }


    /**
     * This function is in use
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function meal_type()
    {
        return $this->hasOne(MealType::class, 'id', 'meal_type_id');
    }
}

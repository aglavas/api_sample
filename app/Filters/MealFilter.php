<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MealFilter extends QueryFilters
{
    /**
     * Create a new QueryFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        if (!$request->has('with')) {
            $request->merge([
                'with' => ['diet_type', 'translations', 'nutrition', 'meal_type']
            ]);
        }

        parent::__construct($request);
    }


    /**
     * Filter by meal type (breakfast, lunch, dinner, snack)
     *
     * @param $type
     * @return $this
     */
    public function meal_type($type)
    {
        $this->builder->with('meal_type')->whereHas('meal_type', function ($query) use ($type) {
            $query->where('type', $type);
        });

        return $this;
    }


    /**
     * Diet type: regular, vegetarian, vegan, GF
     *
     * @param $type
     * @return $this
     */
    public function diet_type($type)
    {
        $typeArray = explode(',', $type);

        $this->builder->with('diet_type')->whereHas('diet_type', function ($query) use ($typeArray) {
            $query->whereIn('type', $typeArray);
        });

        return $this;
    }


    /**
     * Add relations to Meal resource
     *
     * @param $args
     * @return $this
     */
    protected function with($args)
    {
        if (!is_array($args)) {
            $args = array_filter(explode(',', $args));
        }
        $allowed = ['diet_type', 'translations', 'nutrition', 'meal_type'];
        $relations = array_intersect($args, $allowed);

        $this->builder->with($relations);

        return $this;
    }
}

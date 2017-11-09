<?php

namespace App\Repository;

use App\Models\Meal\Meal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class MealRepository implements MealRepositoryInterface
{
    /**
     * @var Meal
     */
    protected $model;

    /**
     * MealRepository constructor.
     * @param Meal $meal
     */
    public function __construct(Meal $meal)
    {
        $this->model = $meal;
    }

    /**
     * Filter out null values
     *
     * @param array $data
     * @return array
     */
    private function filterData(array $data)
    {
        return array_filter($data, function ($var) {
            return !is_null($var);
        });
    }

    /**
     * Update Meal entity
     *
     * @param array $data
     * @param Model $model
     * @return bool
     */
    public function update(array $data, Model $model)
    {
        $data = $this->filterData($data);

        return $model->update($data);
    }

    /**
     * Update Meal translation entity
     *
     * @param array $data
     * @param Model $model
     * @return bool
     */
    public function updateTranslation(array $data, Model $model)
    {
        $data = $this->filterData($data);

        if (!empty($data)) {
            return $model->translations()->update($data);
        }

        return true;
    }

    /**
     * Update Meal nutrition entity
     *
     * @param array $data
     * @param Model $model
     * @return bool
     */
    public function updateNutrition(array $data, Model $model)
    {
        $data = $this->filterData($data);

        if (!empty($data)) {
            return $model->nutrition()->update($data);
        }

        return true;
    }
}

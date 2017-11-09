<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface MealRepositoryInterface
{
    public function update(array $data, Model $model);

    public function updateTranslation(array $data, Model $model);

    public function updateNutrition(array $data, Model $model);
}

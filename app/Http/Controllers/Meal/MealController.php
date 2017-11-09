<?php

namespace App\Http\Controllers\Meal;

use App\Http\Controllers\Controller;
use App\Repository\MealRepositoryInterface;
use Illuminate\Database\Query\Builder;
use App\Http\Requests\Meal\DeleteMealsRequest;
use App\Http\Requests\Meal\GetMealsByIdRequest;
use App\Http\Requests\Meal\GetMealsSearchRequest;
use App\Http\Requests\Meal\PostMealsRequest;
use App\Http\Requests\Meal\PatchMealsRequest;
use App\Models\Meal\Meal;
use App\Filters\MealFilter;

class MealController extends Controller
{
    protected $meal;

    public function __construct(Meal $meal)
    {
        $this->meal = $meal;
    }

    /**
     * Creates new meal with other dependencies (translation, ingredients, nutritional value)
     *
     * @param PostMealsRequest $request
     * @return $this
     */
    public function postMeals(PostMealsRequest $request)
    {
        $meal = $this->meal->create($request->only([
            'meal_type_id',
            'duration',
            'calories'
        ]));

        $meal->translations()->create($request->only([
            'name',
            'preparation',
            'description',
            'locale'
        ]));

        $meal->nutrition()->create($request->only([
            'fat_amount',
            'protein_amount',
            'sugar_amount'
        ]));

        $meal->diet_type()->attach($request->input('diet_type_ids'));

        $meal->load('diet_type', 'translations', 'nutrition', 'meal_type');

        return $this->respondWithSuccessCreation($meal);
    }


    /**
     * Edits meal and related dependencies
     *
     * @param PatchMealsRequest $request
     * @param $id
     * @param MealRepositoryInterface $mealRepository
     * @return mixed
     */
    public function patchMeals(PatchMealsRequest $request, $id, MealRepositoryInterface $mealRepository)
    {
        $meal = $this->meal->find($id);

        $mealRepository->update($request->only([
            'meal_type_id',
            'duration',
            'calories',
        ]), $meal);

        $mealRepository->updateTranslation($request->only([
            'name',
            'preparation',
            'description',
        ]), $meal);

        $mealRepository->updateNutrition($request->only([
            'fat_amount',
            'protein_amount',
            'sugar_amount'
        ]), $meal);

        if ($request->has('diet_type_ids')) {
            $meal->diet_type()->sync($request->input('diet_type_ids'));
        }

        return $this->respondWithOk($meal->load(['diet_type', 'translations', 'nutrition','meal_type']));
    }

    /**
     * Soft deletes meal by id.
     *
     * @param DeleteMealsRequest $request
     * @return mixed
     */
    public function deleteMeals(DeleteMealsRequest $request)
    {
        $meal = $this->meal->find($request->route('id'));

        $meal->delete();

        return response()->successMessage("", 200);
    }

    /**
     * Get meal by Id.
     *
     * @param GetMealsByIdRequest $request
     * @return $this
     */
    public function getMealsById(GetMealsByIdRequest $request, $id)
    {
        $meal = $this->meal
            ->find($id)
            ->load(['diet_type', 'translations', 'nutrition', 'meal_type']);

        return $this->respondWithOk($meal);
    }


    /**
     * Get meals using query.
     *
     * @param GetMealsSearchRequest $request
     * @param MealFilter $filter
     * @return $this
     */
    public function getMealsSearch(GetMealsSearchRequest $request, MealFilter $filter)
    {
        /** @var Builder $meals */
        $meals = $this->meal
            ->select('meals.*')
            ->withTranslation()
            ->filter($filter)
            ->paginate(min(20, $request->input("per_page", 50)));

        return $this->respondWithPagination($meals);
    }
}

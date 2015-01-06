<?php

/**
 * Class EloquentMealCategoryRepository
 */
class EloquentMealCategoryRepository implements MealCategoryRepositoryInterface
{


    /**
     * @param $id
     *
     * @throws NotFoundException
     * @return Meal
     */
    public function findById ($id)
    {
        $mealCategory = MealCategory::find($id);

        if (!$mealCategory)
        {
            throw new NotFoundException('MealCategory not found');
        }
        return $mealCategory;
    }


    /**
     * @param $id
     *
     * @throws NotFoundException
     * @return Meal
     */
    public function findByOrder ($id)
    {
        $order = Order::find($id);
        $mealCategory = MealCategory::where('restaurant_id','=',$order->restaurant_id)->with('meals')->get();

        if (!$mealCategory)
        {
            throw new NotFoundException('MealCategory not found');
        }
        return $mealCategory;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll ()
    {
        return MealCategory::with('meals')->get();
    }

    /**
     * @param null $limit
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate ($limit = NULL)
    {
        return MealCategory::paginate($limit);
    }

    /**
     * @param $data
     *
     * @return MealCategory
     */
    public function store ($data)
    {
        $this->validate($data);
        return MealCategory::create($data);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return MealCategory
     */
    public function update ($id, $data)
    {
        $mealCategory = $this->findById($id);
        $this->validate($data);
        $mealCategory->fill($data);
        $mealCategory->save();

        return $mealCategory;
    }

    /**
     * @param $id
     *
     * @return bool|null
     */
    public function destroy ($id)
    {
        $mealCategory = $this->findById($id);

        return $mealCategory->delete();
    }

    /**
     * @param        $data
     *
     * @param string $scenario
     *
     * @throws ValidationException
     * @throws ValidationScenarioException
     * @return bool
     */
    public function validate ($data, $scenario = 'default')
    {
        if (!array_key_exists($scenario,MealCategory::$rules))
        {
            throw new ValidationScenarioException('Scenario: '.$scenario.' not found in MealCategory model');
        }
        $validator = Validator::make($data, MealCategory::$rules[$scenario]);
        if($validator->fails())
        {
            throw new ValidationException($validator);
        }
        return true;
    }

    /**
     * @param array $data
     *
     * @return MealCategory
     */
    public function instance ($data = array())
    {
        return new MealCategory($data);
    }
}
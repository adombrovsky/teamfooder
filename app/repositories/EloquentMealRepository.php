<?php

/**
 * Class EloquentMealRepository
 */
class EloquentMealRepository implements MealRepositoryInterface
{


    /**
     * @param $id
     *
     * @throws NotFoundException
     * @return Meal
     */
    public function findById ($id)
    {
        $meal = Meal::find($id);

        if (!$meal)
        {
            throw new NotFoundException('Meal not found');
        }
        return $meal;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll ()
    {
        return Meal::all();
    }

    /**
     * @param null $limit
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate ($limit = NULL)
    {
        return Meal::paginate($limit);
    }

    /**
     * @param $data
     *
     * @return Meal
     */
    public function store ($data)
    {
        $this->validate($data);
        return Meal::create($data);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return Meal
     */
    public function update ($id, $data)
    {
        $meal = $this->findById($id);
        $this->validate($data);
        $meal->fill($data);
        $meal->save();

        return $meal;
    }

    /**
     * @param $id
     *
     * @return bool|null
     */
    public function destroy ($id)
    {
        $meal = $this->findById($id);

        return $meal->delete();
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
        if (!array_key_exists($scenario,Meal::$rules))
        {
            throw new ValidationScenarioException('Scenario: '.$scenario.' not found in Meal model');
        }
        $validator = Validator::make($data, Meal::$rules[$scenario]);
        if($validator->fails())
        {
            throw new ValidationException($validator);
        }
        return true;
    }

    /**
     * @param array $data
     *
     * @return Meal
     */
    public function instance ($data = array())
    {
        return new Meal($data);
    }
}
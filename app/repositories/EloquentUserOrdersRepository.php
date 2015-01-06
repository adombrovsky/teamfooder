<?php

/**
 * Class EloquentUserOrdersRepository
 */
class EloquentUserOrdersRepository implements UserOrdersRepositoryInterface
{


    /**
     * @param $id
     *
     * @throws NotFoundException
     * @return UserOrder
     */
    public function findById ($id)
    {
        $user = UserOrder::with(array('user','meal','order'))->find($id);

        if (!$user) throw new NotFoundException('UserOrder not found');
        return $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll ()
    {
        return UserOrder::all();
    }

    /**
     * @param null $limit
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate ($limit = NULL)
    {
        return UserOrder::paginate($limit);
    }

    /**
     * @param $data
     *
     * @return UserOrder
     */
    public function store ($data)
    {
//        $this->validate($data);
//        $model = UserOrder::
//            where('user_id','=',$data['user_id'])->
//            where('order_id','=',$data['order_id'])->
//            where('meal_id','=',$data['meal_id'])->
//            first();
//        if ($model)
//        {
//            $data['count'] +=$model->count;
//            return $this->update($model->id,$data);
//        }
        $this->validate($data);
        $model = UserOrder::create($data);

        return $this->findById($model->id);
    }
/**
     * @param $id
     * @param $data
     *
     * @return UserOrder
     */
    public function update ($id, $data)
    {
        $user = $this->findById($id);
        $this->validate($data);
        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * @param $id
     *
     * @return bool|null
     */
    public function destroy ($id)
    {
        $user = $this->findById($id);

        return $user->delete();
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
        if (!isset(UserOrder::$rules[$scenario])) throw new ValidationScenarioException("Scenario: ".$scenario." not found in UserOrder model");
        $validator = Validator::make($data, UserOrder::$rules[$scenario]);
        if($validator->fails()) throw new ValidationException($validator);
        return true;
    }

    /**
     * @param array $data
     *
     * @return UserOrder
     */
    public function instance ($data = array())
    {
        return new UserOrder($data);
    }

    /**
     * @param $id
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUsersOrdersByRequest($id)
    {
        return UserOrder::where('order_id','=',$id)->with(array('user','meal','order'))->get();
    }

    /**
     * @param $id
     * @param $userId
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserOrderByRequest($id, $userId)
    {
        return UserOrder::where('order_id','=',$id)->where('user_id','=',$userId)->with(array('user','meal','order'))->get();
    }

    /**
     * @param $id
     * @param $userId
     *
     * @return bool
     */
    public function removeByUser($id, $userId)
    {
        $result = UserOrder::where('order_id','=',$id)->where('user_id','=',$userId)->delete();
        return $result;
    }
}
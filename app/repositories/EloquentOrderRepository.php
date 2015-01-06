<?php

/**
 * Class EloquentOrderRepository
 */
class EloquentOrderRepository implements OrderRepositoryInterface
{

    /**
     * @param $id
     *
     * @throws NotFoundException
     * @return Order
     */
    public function findById ($id)
    {
        $order = Order::with('restaurant')->find($id);

        if (!$order) throw new NotFoundException('Order not found');
        return $order;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll ()
    {
        $orders = Order::with(array('users','owner','restaurant'))->orderBy('id','DESC')->get();
        foreach ($orders as $index=>$o)
        {
            $orders[$index]['statusName'] = $o->getStatusName();
        }
        return $orders;
    }

    /**
     * @param null $limit
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate ($limit = NULL)
    {
        return Order::paginate($limit);
    }

    /**
     * @param $data
     *
     * @return Order
     */
    public function store ($data)
    {
        $data['user_id'] = Auth::user()->id;
        $this->validate($data);
        Order::observe(new OrderObserver());
        $order = Order::create($data);
        $order->newOrderNotifier(Input::get('emails',array()));
        return $order;
    }

    /**
     * @param $id
     * @param $data
     *
     * @return Order
     */
    public function update ($id, $data)
    {
        Order::observe(new OrderObserver());
        $order = $this->findById($id);
        $this->validate($data);
        $order->fill($data);
        $order->save();

        return $order;
    }

    /**
     * @param $id
     *
     * @return bool|null
     */
    public function destroy ($id)
    {
        $order = $this->findById($id);

        return $order->delete();
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
        if (!isset(Order::$rules[$scenario])) throw new ValidationScenarioException("Scenario: ".$scenario." not found in Order model");
        $validator = Validator::make($data, Order::$rules[$scenario]);
        if($validator->fails())
        {
            throw new ValidationException($validator);
        }
        return true;
    }

    /**
     * @param array $data
     *
     * @return Order
     */
    public function instance ($data = array())
    {
        return new Order($data);
    }

    /**
     * @param $id
     *
     * @return array|mixed
     */
    public function getUsersByOrder($id)
    {
        $result = array();
        $usersOrder = UserOrder::where('order_id','=',$id)->with(array('user','meal'))->get();
        /**
         * @var $uo UserOrder
         */
        foreach ($usersOrder as $uo)
        {
            if (isset($result[$uo->user_id],$result[$uo->user_id]['totalCount']))
            {
                $result[$uo->user_id]['totalCount'] += $uo->count;
                $result[$uo->user_id]['totalPrice'] += $uo->count*$uo->meal->price;
            }
            else
            {
                $result[$uo->user_id] = array('user'=>$uo->user,'totalCount'=>$uo->count,'totalPrice'=>$uo->count*$uo->meal->price);
            }

        }
        return array_values($result);
    }

    /**
     * @param $status
     *
     * @return array
     * @throws NotFoundException
     * @throws PermissionException
     */
    public function setOrderStatus($status)
    {
        $return = array('status'=>'error');
        $data = Input::all();
        if (isset($data['id'],$data['userId']))
        {
            $order = $this->findById($data['id']);
            if (!$order)
            {
                throw new NotFoundException();
            }

            if ($order->user_id != $data['userId'])
            {
                throw new PermissionException();
            }
            $order->status = $status;
            if ($order->save())
            {
                $return['status']=self::RETURN_SUCCESS_STATUS;
            }
        }
        return $return;
    }
}
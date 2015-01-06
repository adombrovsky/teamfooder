<?php

//use our new namespace
namespace dev;

//import classes that are not in this new namespace
use BaseController;
use NotFoundException;
use OrderRepositoryInterface;
use Input;
use Order;
use Symfony\Component\HttpFoundation\Response;
use UserOrder;
use View;
use Mail;

/**
 * Class OrdersController
 * @package dev
 */
class OrdersController extends \BaseController {

    /**
     * @var OrderRepositoryInterface
     */
    private $orders;

    /**
     * @param OrderRepositoryInterface $orders
     */
    public function __construct(OrderRepositoryInterface $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Display a listing of the resource.
     * GET /orders
     *
     * @return Response
     */
    public function index()
    {
        return $this->orders->findAll();
    }

    /**
     * Show the form for creating a new resource.
     * GET /orders/create
     *
     * @return Response
     */
    public function create()
    {
        $order = $this->orders->instance();
        return View::make('orders._form',compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /orders
     *
     * @return Response
     */
    public function store()
    {
        return $this->orders->store(Input::all());
    }

    /**
     * Display the specified resource.
     * GET /orders/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->orders->findById($id);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /orders/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $order = $this->orders->findById($id);

        return View::make('orders._form',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /orders/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        return $this->orders->update($id,Input::all());
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /orders/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->orders->destroy($id);
        return '';
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getUsers($id)
    {
        return $this->orders->getUsersByOrder($id);
    }

    /**
     * PATCH: /orders/cancel
     * @return mixed
     */
    public function cancelOrder()
    {
        $result = $this->orders->setOrderStatus(Order::DENY_STATUS);
        if ($result['status'] === OrderRepositoryInterface::RETURN_SUCCESS_STATUS)
        {
            UserOrder::notifyUsersByOrderId(Input::get('id'),Order::DENY_STATUS);
        }
        return $result;
    }

    /**
     * PATCH: /orders/finish
     * @return mixed
     */
    public function finishOrder()
    {
        $result = $this->orders->setOrderStatus(Order::COMPLETED_STATUS);
        if ($result['status'] === OrderRepositoryInterface::RETURN_SUCCESS_STATUS)
        {
            UserOrder::notifyUsersByOrderId(Input::get('id'), Order::COMPLETED_STATUS);
        }
        return $result;
    }

}
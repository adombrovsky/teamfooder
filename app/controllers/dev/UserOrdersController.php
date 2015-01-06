<?php

//use our new namespace
namespace dev;

//import classes that are not in this new namespace
use BaseController;
use UserOrdersRepositoryInterface;
use View;
use Input;
use Response;

/**
 * Class UserOrdersController
 * @package dev
 */
class UserOrdersController extends BaseController
{

    /**
     * @var UserOrdersRepositoryInterface
     */
    private $userOrders;

    /**
     * @param UserOrdersRepositoryInterface $userOrders
     */
    public function __construct(UserOrdersRepositoryInterface $userOrders)
    {
        $this->userOrders = $userOrders;
    }

	/**
	 * Display a listing of the resource.
	 * GET /userorders
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->userOrders->findAll();
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /userorders/create
	 *
	 * @return Response
	 */
	public function create()
	{
        $userOrder = $this->userOrders->instance();

        return View::make('user_orders._form',compact('userOrder'));
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /userorders
	 *
	 * @return Response
	 */
	public function store()
	{
        return $this->userOrders->store(Input::all());
    }

	/**
	 * Display the specified resource.
	 * GET /userorders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return $this->userOrders->findById($id);
    }

	/**
	 * Show the form for editing the specified resource.
	 * GET /userorders/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $userOrder = $this->userOrders->findById($id);

        return View::make('user_orders._form',compact('userOrder'));
    }

	/**
	 * Update the specified resource in storage.
	 * PUT /userorders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        return $this->userOrders->update($id,Input::all());

	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /userorders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->userOrders->destroy($id);
        return '{}';
	}


    /**
     * @param $id
     *
     * @return mixed
     */
    public function byRequest($id)
    {
        return $this->userOrders->getUsersOrdersByRequest($id);
    }

    /**
     * @param $id
     *
     * @param $userId
     *
     * @return mixed
     */
    public function byUserRequest($id,$userId)
    {
        return $this->userOrders->getUserOrderByRequest($id, $userId);
    }

    /**
     * @param $id
     * @param $userId
     *
     * @return mixed
     */
    public function removeByUser($id, $userId)
    {
        return $this->userOrders->removeByUser($id, $userId);
    }

}
<?php

//use our new namespace
namespace dev;

//import classes that are not in this new namespace
use BaseController;
use Response;
use UserRepositoryInterface;
use Input;
use View;
use Auth;
use User;
use Hash;
use Redirect;

/**
 * Class UsersController
 * @package dev
 */
class UsersController extends BaseController
{
    /**
     * @var \UserRepositoryInterface
     */
    private $users;

    /**
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->users->findAll();
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
        $user = $this->users->instance();

        return View::make('users._form',compact("user"));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return mixed
	 */
	public function store()
	{
        return $this->users->store(Input::all(), User::CREATE_SCENARIO);
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return $this->users->findById($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = $this->users->findById($id);
        return View::make('users._form',compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        return $this->users->update($id,Input::all());
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->users->destroy($id);
        return '';
	}

    /**
     * POST: /login
     * @return bool|\Illuminate\Auth\UserInterface|null
     */
    public function login()
    {
        $responseData = array('status'=>'false','errors'=>array('email'=>'Please enter correct email','password'=>'Please enter correct password'));
        $credentials = Input::only(array('email','password'));
        if (Auth::attempt($credentials))
        {
            return Auth::getUser();
        }
        return Response::json($responseData, 400);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/login');
    }

}
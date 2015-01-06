<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
use Redbaron76\Googlavel\Support\Facades\Googlavel;
App::bind('UserRepositoryInterface', 'EloquentUserRepository');
App::bind('OrderRepositoryInterface', 'EloquentOrderRepository');
App::bind('UserOrdersRepositoryInterface', 'EloquentUserOrdersRepository');
App::bind('MealRepositoryInterface', 'EloquentMealRepository');
App::bind('MealCategoryRepositoryInterface', 'EloquentMealCategoryRepository');
App::bind('ContactRepositoryInterface', 'ApiContactRepository');
App::bind('RestaurantRepositoryInterface', 'EloquentRestaurantRepository');

Route::group(array('prefix'=>'dev'),function(){

    Route::controller('auth', 'dev\AuthController');

    Route::post('login', 'dev\UsersController@login'); //notice the namespace
    Route::get('logout', 'dev\UsersController@logout'); //notice the namespace
    Route::resource('users', 'dev\UsersController'); //notice the namespace

    Route::group(array('before' => 'auth'), function()
    {
        Route::get('userorders/byRequest/{id}', 'dev\UserOrdersController@byRequest'); //notice the namespace
        Route::get('userorders/byUserRequest/{id}/{userId}', 'dev\UserOrdersController@byUserRequest'); //notice the namespace
        Route::get('orders/{id}/getUsers', 'dev\OrdersController@getUsers'); //notice the namespace
        Route::get('meals/byOrder/{id}', 'dev\MealsController@byOrder'); //notice the namespace

        Route::delete('userorders/removeByUser/{id}/{userId}', 'dev\UserOrdersController@removeByUser'); //notice the namespace

        Route::patch('orders/finish', 'dev\OrdersController@finishOrder'); //notice the namespace
        Route::patch('orders/cancel', 'dev\OrdersController@cancelOrder'); //notice the namespace

        Route::resource('meals', 'dev\MealsController'); //notice the namespace
        Route::resource('contacts', 'dev\ContactsController'); //notice the namespace

        Route::resource('orders', 'dev\OrdersController'); //notice the namespace
        Route::resource('restaurants', 'dev\RestaurantsController'); //notice the namespace
        Route::resource('userorders', 'dev\UserOrdersController'); //notice the namespace
    });



});

Route::get('/{path?}', function($path = null)
{
    $userData = "false";
    if (Auth::check())
    {
        $user = Auth::user();
        $userData = json_encode(array('id'=>$user->id,'email'=>$user->email,'name'=>$user->name));
    }

    $loginUrl = array(
        'google' => Googlavel::authUrl()
    );

    return View::make('layouts.application',array('user'=>$userData, 'loginUrl'=>json_encode($loginUrl)))->nest('content', 'app');
})->where('path', '.*'); //regex to match anything (dots, slashes, letters, numbers, etc)

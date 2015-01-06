<?php

//use our new namespace
namespace dev;

//import classes that are not in this new namespace
use BaseController;
use RestaurantRepositoryInterface;

/**
 * Class RestaurantsController
 * @package dev
 */
class RestaurantsController extends BaseController {

    /**
     * @var RestaurantRepositoryInterface
     */
    private $restaurant;

	/**
	 * private $restaurantCategory;
	 *
	 * /**
	 * @param RestaurantRepositoryInterface         $restaurant
	 */
    public function __construct(RestaurantRepositoryInterface $restaurant)
    {
        $this->restaurant = $restaurant;
    }

	/**
	 * Display a listing of the resource.
	 * GET /restaurants
	 *
	 */
	public function index()
	{
        return $this->restaurant->findAll();
	}
}
<?php

//use our new namespace
namespace dev;

//import classes that are not in this new namespace
use BaseController;
use MealCategoryRepositoryInterface;
use MealRepositoryInterface;

/**
 * Class MealsController
 * @package dev
 */
class MealsController extends \BaseController {

    /**
     * @var MealRepositoryInterface
     */
    private $meal;

	/**
	 * @var MealCategoryRepositoryInterface
	 */
    private $mealCategory;

	/**
	 * private $mealCategory;
	 *
	 * /**
	 * @param MealRepositoryInterface         $meal
	 * @param MealCategoryRepositoryInterface $mealCategory
	 */
    public function __construct(MealRepositoryInterface $meal, MealCategoryRepositoryInterface $mealCategory)
    {
        $this->meal = $meal;
        $this->mealCategory = $mealCategory;
    }

	/**
	 * Display a listing of the resource.
	 * GET /meals
	 *
	 */
	public function index()
	{
        return $this->mealCategory->findAll();
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function byOrder($id)
	{
		return $this->mealCategory->findByOrder($id);
	}

}
<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 30.11.14
 * Time: 20:26
 */

namespace Adombrovsky\RestaurantParser\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class RestaurantParser
 * @package Adombrovsky\RestaurantParser\Facades
 */
class RestaurantParser  extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'restaurantParser';
    }
} 
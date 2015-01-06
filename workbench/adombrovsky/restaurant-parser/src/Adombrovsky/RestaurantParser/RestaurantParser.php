<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 30.11.14
 * Time: 20:24
 */

namespace Adombrovsky\RestaurantParser;
use Adombrovsky\RestaurantParser\Classes\Categories\EcoSushiCategoryParser;
use Adombrovsky\RestaurantParser\Classes\Categories\PizzaOdUaCategoryParser;
use Adombrovsky\RestaurantParser\Classes\Categories\RikshaCategoryParser;
use Adombrovsky\RestaurantParser\Classes\Categories\StarPizzaCategoryParser;
use Adombrovsky\RestaurantParser\Classes\Products\EcoSushiProductParser;
use Adombrovsky\RestaurantParser\Classes\Products\PizzaOdUaProductParser;
use Adombrovsky\RestaurantParser\Classes\Products\RikshaProductParser;
use Adombrovsky\RestaurantParser\Classes\Products\StarPizzaProductParser;
use Adombrovsky\RestaurantParser\Classes\Restaurants\EcoSushiRestaurantParser;
use Adombrovsky\RestaurantParser\Classes\Restaurants\PizzaOdUaRestaurantParser;
use Adombrovsky\RestaurantParser\Classes\Restaurants\RikshaRestaurantParser;
use Adombrovsky\RestaurantParser\Classes\Restaurants\StarPizzaRestaurantParser;


/**
 * Class RestaurantParser
 * @package Adombrovsky\RestaurantParser
 */
class RestaurantParser
{
    /**
     * @return RikshaRestaurantParser
     */
    public function getRikshaParser()
    {
        return new RikshaRestaurantParser(new RikshaProductParser(),new RikshaCategoryParser());
    }

    /**
     * @return EcoSushiRestaurantParser
     */
    public function getEcoSushiParser()
    {
        return new EcoSushiRestaurantParser(new EcoSushiProductParser(),new EcoSushiCategoryParser());
    }

    /**
     * @return PizzaOdUaRestaurantParser
     */
    public function getPizzaOdUaParser()
    {
        return new PizzaOdUaRestaurantParser(new PizzaOdUaProductParser(),new PizzaOdUaCategoryParser());
    }

    /**
     * @return StarPizzaRestaurantParser
     */
    public function getStarPizzaParser()
    {
        return new StarPizzaRestaurantParser(new StarPizzaProductParser(),new StarPizzaCategoryParser());
    }
} 
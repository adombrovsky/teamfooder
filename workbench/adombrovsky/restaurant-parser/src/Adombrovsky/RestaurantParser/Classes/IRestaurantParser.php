<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 30.11.14
 * Time: 0:24
 */

namespace Adombrovsky\RestaurantParser\Classes;

/**
 * Interface IRestaurantParser
 * @package IRestaurantParser\Classes
 */
interface IRestaurantParser
{
    /**
     * @param IProductParser  $productParser
     * @param ICategoryParser $categoryParser
     */
    public function __construct(IProductParser $productParser, ICategoryParser $categoryParser);

    /**
     * @return void
     */
    public function parse();

    /**
     * @return string
     */
    public function getMainHost();

    /**
     * @return array
     */
    public function parseProduct();

    /**
     * @return array
     */
    public function parseCategory();
}
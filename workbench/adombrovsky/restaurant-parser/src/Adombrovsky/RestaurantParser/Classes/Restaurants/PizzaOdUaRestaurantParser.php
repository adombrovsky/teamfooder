<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 30.11.14
 * Time: 0:32
 */

namespace Adombrovsky\RestaurantParser\Classes\Restaurants;


use Adombrovsky\RestaurantParser\Classes\ICategoryParser;
use Adombrovsky\RestaurantParser\Classes\IProductParser;
use Adombrovsky\RestaurantParser\Classes\IRestaurantParser;
use Meal;
use MealCategory;
use Restaurant;
use Yangqi\Htmldom\Htmldom;

/**
 * Class PizzaOdUaRestaurantParser
 * @package Adombrovsky\RestaurantParser\Classes\Restaurants
 */
class PizzaOdUaRestaurantParser implements IRestaurantParser
{


    const MAIN_HOST = 'http://www.pizza.od.ua';

    /**
     * @var \Adombrovsky\RestaurantParser\Classes\IProductParser
     */
    private $productParser;

    /**
     * @var \Adombrovsky\RestaurantParser\Classes\ICategoryParser
     */
    private $categoryParser;

    /**
     * @var \Yangqi\Htmldom\Htmldom
     */
    private $htmlDom;

    /**
     * @param IProductParser  $productParser
     * @param ICategoryParser $categoryParser
     */
    public function __construct (IProductParser $productParser, ICategoryParser $categoryParser)
    {
        $this->productParser = $productParser;
        $this->categoryParser = $categoryParser;
        $this->htmlDom = new Htmldom($this->getMainHost());
    }

    /**
     * @return void
     */
    public function parse ()
    {
        $categories = $this->parseCategory();
        $restaurant = Restaurant::where('alias','=', Restaurant::PIZZAODUA_RESTAURANT)->first();
        $productIds = array();
        $categoryIds = array();
        foreach ($categories as $categoryAttributes)
        {
            $categoryAttributes['restaurant_id'] = $restaurant->id;
            $categoryAttributes['url'] = $this->getMainHost().$categoryAttributes['url'];
            $category = MealCategory::updateOrCreate(array('title'=>$categoryAttributes['title'],'restaurant_id'=>$restaurant->id),$categoryAttributes);
            $categoryIds[] = $category->id;

            $this->htmlDom->load_file($category->url);

            $products = $this->parseProduct();
            foreach ($products as $productAttributes)
            {
                $productAttributes['category_id'] = $category->id;
                $productAttributes['url'] = $productAttributes['url'] ? $categoryAttributes['url'].$productAttributes['url']:'';
                $productAttributes['image'] = $this->getMainHost().$productAttributes['image'];
                $imageContent = file_get_contents($productAttributes['image']);
                if ($imageContent)
                {
                    $productAttributes['image'] = uniqid().'.jpg';
                    file_put_contents(public_path('images/'.$productAttributes['image']),$imageContent);
                }

                $meal = Meal::updateOrCreate(array('title'=>$productAttributes['title'],'category_id'=>$productAttributes['category_id']),$productAttributes);
                $productIds[] = $meal->id;
            }
            Meal::whereNotIn('id',$productIds)->where('category_id','=',$category->id)->delete();
        }

        MealCategory::whereNotIn('id',$categoryIds)->where('restaurant_id','=',$restaurant->id)->delete();
    }

    /**
     * @return string
     */
    public function getMainHost ()
    {
        return self::MAIN_HOST;
    }

    /**
     * @return array
     */
    public function parseProduct ()
    {
        return $this->productParser->parse($this->htmlDom);
    }

    /**
     * @return array
     */
    public function parseCategory ()
    {
        return $this->categoryParser->parse($this->htmlDom);
    }

}
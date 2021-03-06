<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 30.11.14
 * Time: 1:50
 */

namespace Adombrovsky\RestaurantParser\Classes\Categories;


use Adombrovsky\RestaurantParser\Classes\ICategoryParser;
use Yangqi\Htmldom\Htmldom;
use Yangqi\Htmldom\Htmldomnode;

/**
 * Class PizzaOdUaCategoryParser
 * @package Adombrovsky\RestaurantParser\Classes\Categories
 */
class PizzaOdUaCategoryParser implements ICategoryParser
{
    /**
     * @var Htmldom $htmlDom
     */
    private $htmlDom;

    const CATEGORY_ITEMS_PATH = '#top_menu ul li';
    const TITLE_PATH = 'a';
    const URL_PATH = 'a';

    /**
     * @param \Yangqi\Htmldom\Htmldom $htmlDom
     *
     * @return array
     */
    public function parse (Htmldom $htmlDom)
    {
        $this->htmlDom = $htmlDom;

        $categoryItems = $this->htmlDom->find(self::CATEGORY_ITEMS_PATH);
        $categories = array();
        foreach ($categoryItems as $ci)
        {
            $title = $this->getTitle($ci);
            $url = $this->getUrl($ci);

            $categories[] = array(
                'title' => $title,
                'url' => $url,
            );
        }
        return $categories;
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getTitle (Htmldomnode $dom)
    {
        /**
         * @var $el Htmldomnode
         */
        $el = $dom->find(self::TITLE_PATH,0);

        return $el ? $el->plaintext : "";
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getUrl (Htmldomnode $dom)
    {
        /**
         * @var $el Htmldomnode
         */
        $el = $dom->find(self::TITLE_PATH,0);

        return $el ? $el->href : "";
    }
}
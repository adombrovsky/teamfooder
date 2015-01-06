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
 * Class RikshaCategoryParser
 * @package Adombrovsky\RestaurantParser\Classes\Categories
 */
class RikshaCategoryParser implements ICategoryParser
{
    private $excludeCategories = array(
        'http://riksha.com.ua/category/bbq'
    );
    /**
     * @var Htmldom $htmlDom
     */
    private $htmlDom;

    const CATEGORY_ITEMS_PATH = '.side-menu .inner a.item';
    const TITLE_PATH = 'span.title';
    const URL_PATH = '';

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

            if (in_array($url,$this->excludeCategories)) continue;

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
        return trim($dom->find(self::TITLE_PATH,0)->plaintext);
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getUrl (Htmldomnode $dom)
    {
        return trim($dom->href);
    }
}
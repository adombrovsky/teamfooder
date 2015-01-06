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
 * Class StarPizzaCategoryParser
 * @package Adombrovsky\RestaurantParser\Classes\Categories
 */
class StarPizzaCategoryParser implements ICategoryParser
{
    /**
     * @var Htmldom $htmlDom
     */
    private $htmlDom;

    const CATEGORY_ITEMS_PATH = '#menu_container .menu_list li';
    const TITLE_PATH = 'a';
    const URL_PATH = 'a';

    /**
     * @param Htmldom $htmlDom
     *
     * @return array
     */
    public function parse (Htmldom $htmlDom)
    {
        $this->htmlDom = $htmlDom;

        $categoryItems = $this->htmlDom->find(self::CATEGORY_ITEMS_PATH);
        $categories = array();
        /**
         * @var $ci Htmldomnode
         */
        $categoryTitlePrefix = '';
        foreach ($categoryItems as $ci)
        {
            $title = $this->getTitle($ci);
            $url = $this->getUrl($ci);


            //this is a hack for specific categories with subcategories
            $nextSibling = $ci->nextSibling();
            $prevSibling = $ci->previousSibling();
            if ($nextSibling && $nextSibling->tag === 'ul')
            {
                $categoryTitlePrefix = $title." ";
                continue;
            }

            if ($prevSibling && $prevSibling->tag === 'ul')
            {
                $categoryTitlePrefix = '';
            }

            $categories[] = array(
                'title' => $categoryTitlePrefix.$title,
                'url' => $url,
            );
        }
        return $categories;
    }

    /**
     * @param Htmldomnode $dom
     *
     * @return string
     */
    public function getTitle (Htmldomnode $dom)
    {
        return trim($dom->find(self::TITLE_PATH,0)->plaintext);
    }

    /**
     * @param Htmldomnode $dom
     *
     * @return string
     */
    public function getUrl (Htmldomnode $dom)
    {
        return trim($dom->find(self::URL_PATH,0)->href);
    }
}
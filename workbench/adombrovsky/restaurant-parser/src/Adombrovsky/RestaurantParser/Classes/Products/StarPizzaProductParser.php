<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 30.11.14
 * Time: 1:43
 */

namespace Adombrovsky\RestaurantParser\Classes\Products;


use Adombrovsky\RestaurantParser\Classes\IProductParser;
use Yangqi\Htmldom\Htmldom;
use Yangqi\Htmldom\Htmldomnode;

/**
 * Class StarPizzaProductParser
 * @package Adombrovsky\RestaurantParser\Classes\Products
 */
class StarPizzaProductParser  implements IProductParser
{
    /**
     * @var Htmldom $htmlDom
     */
    private $htmlDom;

    const PRODUCT_LIST_PATH = 'div.good_item';
    const TITLE_PATH = '.good_header';
    const PRICE_PATH = '.good_footer .good_price';
    const URL_PATH = '';
    const IMAGE_PATH = '.good_image img';
    const DESCRIPTION_PATH = '.good_description';

    /**
     * @param Htmldom $htmlDom
     *
     * @return array
     */
    public function parse (Htmldom $htmlDom)
    {
        $this->htmlDom = $htmlDom;

        $productItems = $this->htmlDom->find(self::PRODUCT_LIST_PATH);
        $products = array();
        foreach ($productItems as $pi)
        {

            $products[] = array(
                'price' => $this->getPrice($pi),
                'title' => $this->getTitle($pi),
                'url' => $this->getUrl($pi),
                'image' => $this->getImage($pi),
                'description' => $this->getDescription($pi),
            );
        }

        return $products;
    }

    /**
     * @param Htmldomnode $dom
     *
     * @return float
     */
    public function getPrice (Htmldomnode $dom)
    {
        return intval(trim($dom->find(self::PRICE_PATH,0)->plaintext));
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
        return '';
    }

    /**
     * @param Htmldomnode $dom
     *
     * @return string
     */
    public function getImage (Htmldomnode $dom)
    {
        return trim($dom->find(self::IMAGE_PATH,0)->src);
    }

    /**
     * @param Htmldomnode $dom
     *
     * @return string
     */
    public function getDescription (Htmldomnode $dom)
    {
        return trim($dom->find(self::DESCRIPTION_PATH,0)->plaintext);
    }
}
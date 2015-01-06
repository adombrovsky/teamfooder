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
use MealCategory;

/**
 * Class RikshaProductParser
 * @package Adombrovsky\RestaurantParser\Classes\Products
 */
class RikshaProductParser  implements IProductParser
{
    /**
     * @var Htmldom $htmlDom
     */
    private $htmlDom;

    const PRODUCT_LIST_PATH = 'div.item';
    const TITLE_PATH = 'div.name';
    const INTEGER_PRICE_PATH = 'div.price span';
    const DECIMAL_PRICE_PATH = 'div.price span sup';
    const URL_PATH = '';
    const IMAGE_PATH = '';
    const DESCRIPTION_PATH = '.about-text';

    /**
     * @param \Yangqi\Htmldom\Htmldom $htmlDom
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
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return float
     */
    public function getPrice (Htmldomnode $dom)
    {
        $integerEl = $dom->find(self::INTEGER_PRICE_PATH,0);
        if (!$integerEl) return '';
        $integerPart = $integerEl->plaintext;
        $decimalEl = $dom->find(self::DECIMAL_PRICE_PATH,0);
        if ($decimalEl)
        {
            return $integerPart/100;
        }
        return $integerPart;
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getTitle (Htmldomnode $dom)
    {
        $el = $dom->find(self::TITLE_PATH,0);
        return $el ? trim($el->plaintext) : "";
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getUrl (Htmldomnode $dom)
    {
        return '';
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getImage (Htmldomnode $dom)
    {
        return '';
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getDescription (Htmldomnode $dom)
    {
        $el = $dom->find(self::DESCRIPTION_PATH,0);

        return $el ?  trim($el->plaintext) : "";
    }
}
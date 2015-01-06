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
 * Class EcoSushiProductParser
 * @package Adombrovsky\RestaurantParser\Classes\Products
 */
class EcoSushiProductParser  implements IProductParser
{
    /**
     * @var Htmldom $htmlDom
     */
    private $htmlDom;

    const PRODUCT_LIST_PATH = 'ul.item-list li figure';
    const TITLE_PATH        = 'div.item-info p.item-name';
    const URL_PATH          = 'div.item-info p.item-name a';
    const PRICE_PATH        = 'div.item-info p.item-price span';
    const IMAGE_PATH        = '.img-wrap div div a img';
    const DESCRIPTION_PATH  = 'div.item-info p.ingredients';

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
        $el = $dom->find(self::PRICE_PATH,0);

        return $el ? trim($el->plaintext) : "";
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
        $el = $dom->find(self::URL_PATH,0);

        return $el ? trim($el->href) : "";
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getImage (Htmldomnode $dom)
    {
        $el = $dom->find(self::IMAGE_PATH,0);
        return $el ? trim($el->src) : "";
    }

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getDescription (Htmldomnode $dom)
    {
        $el = $dom->find(self::DESCRIPTION_PATH,0);

        return $el ? trim($el->plaintext) : "";
    }
}
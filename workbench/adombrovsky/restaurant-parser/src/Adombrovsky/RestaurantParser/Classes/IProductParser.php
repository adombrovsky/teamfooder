<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 30.11.14
 * Time: 1:39
 */

namespace Adombrovsky\RestaurantParser\Classes;
use Yangqi\Htmldom\Htmldom;
use Yangqi\Htmldom\Htmldomnode;

/**
 * Interface IProductParser
 * @package Adombrovsky\RestaurantParser\Classes
 */
interface IProductParser
{
    /**
     * @param \Yangqi\Htmldom\Htmldom $htmlDom
     *
     * @return array
     */
    public function parse(Htmldom $htmlDom);

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return float
     */
    public function getPrice(Htmldomnode $dom);

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getTitle(Htmldomnode $dom);

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getUrl(Htmldomnode $dom);

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getImage(Htmldomnode $dom);

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $dom
     *
     * @return string
     */
    public function getDescription(Htmldomnode $dom);

}
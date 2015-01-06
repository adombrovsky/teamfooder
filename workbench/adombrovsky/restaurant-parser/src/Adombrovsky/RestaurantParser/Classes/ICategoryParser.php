<?php
/**
 * Created by PhpStorm.
 * User: farw
 * Date: 30.11.14
 * Time: 1:49
 */

namespace Adombrovsky\RestaurantParser\Classes;
use Yangqi\Htmldom\Htmldom;
use Yangqi\Htmldom\Htmldomnode;


/**
 * Interface ICategoryParser
 * @package Adombrovsky\RestaurantParser\Classes
 */
interface ICategoryParser
{
    /**
     * @param \Yangqi\Htmldom\Htmldom $htmlDom
     *
     * @return array
     */
    public function parse(Htmldom $htmlDom);

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $htmlDom
     *
     * @return string
     */
    public function getTitle(Htmldomnode $htmlDom);

    /**
     * @param \Yangqi\Htmldom\Htmldomnode $htmlDom
     *
     * @return string
     */
    public function getUrl(Htmldomnode $htmlDom);
} 
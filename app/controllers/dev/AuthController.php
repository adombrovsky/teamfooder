<?php

//use our new namespace
namespace dev;

//import classes that are not in this new namespace
use BaseController;
use Input;
use Googlavel;

/**
 * Class AuthController
 * @package dev
 */
class AuthController extends BaseController
{

    public function getGoogleOauth2Callback()
    {
        if ( Input::has('code') )
        {
            $code = Input::get('code');
            Googlavel::authenticate($code);
        }
    }
}
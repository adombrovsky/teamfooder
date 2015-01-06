<?php

return [

    // OAuth2 Setting, you can get these keys in Google Developers Console
    'oauth2_client_id'      => '1010624822307-60sis8u57fbtqplbp2e0c9892of31vbf.apps.googleusercontent.com',
    'oauth2_client_secret'  => 'xCvkeaGMYVfS4RgAt-1-O9bQ',
    'oauth2_redirect_uri'   => 'http://'.$_SERVER['SERVER_NAME'].'/dev/auth/google-oauth2-callback',   // Change it according to your needs

    // Definition of service specific values like scopes, OAuth token URLs, etc
    'services' => array(

//        'calendar' => array(
//            'scope' => 'https://www.googleapis.com/auth/calendar'
//        ),
        'contacts' => array(
            'scope' => 'https://www.googleapis.com/auth/contacts.readonly'
        ),
        /*'books' => [
            'scope' => 'https://www.googleapis.com/auth/books'
        ]*/

    ),

    // Service file name prefix
    'service_class_prefix' => 'Google_Service_',

    // Custom settings
    'access_type' => 'online',    
    'approval_prompt' => 'auto',

];
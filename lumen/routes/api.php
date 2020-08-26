<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
	$api->group(['namespace' => 'App\Http\Controllers'], function($api) {

        /*
        |--------------------------------------------------------------------------
        | Throttled APIs
        |--------------------------------------------------------------------------
        |
        | Throttle requests that usually comes from human users
        |
        */
        $api->group(['middleware' => 'throttle:10,60'], function($api) {

            /*
            |--------------------------------------------------------------------------
            | Public APIs
            |--------------------------------------------------------------------------
            |
            | Open endpoints that doesn't require authentication
            |
            */

            // auth
            $api->group(['prefix' => 'auth', 'namespace' => 'Auth'], function($api) {
                $api->post('/login', 'AuthController@login');
                $api->post('/register', 'AuthController@register');
            });

            // user
            $api->group(['prefix' => 'user'], function($api) {
                $api->get('/list', 'UserController@list');
            });

            /*
            |--------------------------------------------------------------------------
            | Secured APIs
            |--------------------------------------------------------------------------
            |
            | Endpoints that are only accessible with valid auth token
            |
            */
            $api->group(['middleware' => 'api.auth'], function($api) {

                // auth
                $api->group(['prefix' => 'auth', 'namespace' => 'Auth'], function($api) {
                    $api->post('/refresh', 'AuthController@refresh');
                    $api->post('/logout', 'AuthController@logout');
                });

                // user
                $api->group(['prefix' => 'user'], function($api) {
                    $api->get('/me', 'UserController@me');
                });
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Unthrottled APIs
        |--------------------------------------------------------------------------
        |
        | APis usually for autonomous calls (webhooks, etc)
        |
        */
    });
});

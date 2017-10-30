<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group([
    'prefix' => 'api/v1', 'middleware' => ['cors', 'log','lang']], function () use ($router) {


    $router->group([
        'prefix'    => '/components',
        'namespace' => 'Component'], function () use ($router) {

        $router->get('/', ['uses' => 'ComponentController@index']);
        $router->post('/', ['uses' => 'ComponentController@store']);
        $router->put('/{id:[\d]+}', ['uses' => 'ComponentController@update']);
        $router->delete('/{id:[\d]+}', ['uses' => 'ComponentController@destroy']);

        $router->get('/{id:[\d]+}/leaves', ['uses' => 'ComponentLeafController@index']);

/*
        $router->post('/{id:[\d]+}/leaf-jobs', ['uses' => 'ComponentJobLeafController@create']);
        $router->post('/{id:[\d]+}/jobs', ['uses' => 'ComponentJobController@create']);*/

    });

    $router->group([
        'prefix'    => '/ci-systems',
        'namespace' => 'ContinuousIntegrationSystem'], function () use ($router) {
        $router->get('/', ['uses' => 'CISystemController@index']);
    });

    $router->group([
        'prefix'    => '/ci-system-instances',
        'namespace' => 'ContinuousIntegrationSystem'], function () use ($router) {
        $router->get('/', ['uses' => 'CISystemInstanceController@index']);
        $router->get('/verify', ['uses' => 'CISystemInstanceController@verify']);
        $router->post('/', ['uses' => 'CISystemInstanceController@store']);
        $router->put('/{id:[\d]+}', ['uses' => 'CISystemInstanceController@update']);
    });

    $router->group([
        'prefix'    => '/api-clients',
        'namespace' => 'APIClient'], function () use ($router) {
        $router->get('/{code}/roots', ['uses' => 'APIClientComponentController@index']);
        $router->post('/{code}/changes', ['uses' => 'APIClientComponentController@update']);

    });

});

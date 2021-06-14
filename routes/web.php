<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'poi'], function () use ($router) {
    $router->post('add', ['as' => 'addPOI', 'uses' => 'PoiController@postPoi']);
    $router->get('list', ['as' => 'listPOIs', 'uses' => 'PoiController@getPois']);
    $router->get('{id}', ['as' => 'listPOI', 'uses' => 'PoiController@getPoi']);
    $router->post('find', ['as' => 'findPOIs', 'uses' => 'PoiController@findPois']);
});
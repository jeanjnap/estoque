<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('sign_in', array('uses' => 'Auth\LoginController@login'));
Route::post('sign_up', array('uses' => 'Auth\RegisterController@create'));
Route::get('products/new', array('uses' => 'ProductsController@new'));


Route::group([
    'middleware' => 'user',
    //'prefix' => 'user_auth'
], function ($router) {
    //User
    Route::get('user', array('uses' => 'UserController@all'));
    Route::post('products', array('uses' => 'ProductsController@create'));
    Route::get('products', array('uses' => 'ProductsController@index'));
    Route::get('products/{product}', array('uses' => 'ProductsController@show'));
    Route::put('products/{product}', array('uses' => 'ProductsController@edit'));
    Route::put('products/add/{product}', array('uses' => 'ProductsController@add'));
    Route::put('products/rem/{product}', array('uses' => 'ProductsController@rem'));
    Route::delete('products/{product}', array('uses' => 'ProductsController@destroy'));
    Route::get('reports', array('uses' => 'ProductsUpdatesController@index'));
});
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

Route::group(['namespace' => 'Api'], function (){
    Route::get('exchange-currencies', 'RatesController@index');
    Route::get('exchange-rates', 'RatesController@getRate');
    Route::get('exchange-rates/history', 'RatesController@history');
});

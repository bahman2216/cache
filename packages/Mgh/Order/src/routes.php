<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/8/17
 * Time: 1:31 PM
 */


Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('/order', 'Mgh\Order\Controllers\OrderController');
});

Route::get('/search', 'Mgh\Order\Controllers\OrderController@search');
Route::post('/searchItem', 'Mgh\Order\Controllers\OrderController@searchItem');
//Auth::routes();

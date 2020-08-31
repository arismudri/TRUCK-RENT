<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//ITEMS
    Route::get('/items', 'ItemsController@index');
    Route::get('/items/{id}', 'ItemsController@show');

    Route::post('/items', 'ItemsController@store');

    Route::put('/items/{id}', 'ItemsController@update');

    Route::delete('/items/{id}', 'ItemsController@destroy');

//RENT
    Route::get('/trucks', 'TrucksController@index');
    Route::get('/trucks/{id}', 'TrucksController@show');

    Route::post('/trucks', 'TrucksController@store');

    Route::put('/trucks/{id}', 'TrucksController@update');

    Route::delete('/trucks/{id}', 'TrucksController@destroy');

// Route::group(array('prefix'=>'truck_rent'),function(){
//     Route::resource(
//         'items',
//         'ItemsController',
//         array(
//             'except'=>array('create','edit')
//             )
//         );
//     }
// );
<?php

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

Route::get('/', 'CitiesController@index')->name('index');
Route::get('/city', 'CitiesController@search')->name('search_city');
Route::get('/city/{id}', 'CitiesController@show')->name('show_city');
Route::get('/near-cities/', 'CitiesController@show')->name('near-cities');

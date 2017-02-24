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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(["prefix" => "dashboard"] , function (){

      Route::get('/', 'HomeController@index');

      Route::get("/{table}" , "PagesController@showAll");

});

Route::get('/test', function()
{

  Artisan::call('make:model', [
        "name" => "koko"
    ]);

});
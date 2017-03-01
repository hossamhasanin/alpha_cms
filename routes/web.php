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

Route::group(["prefix" => "dashboard" , "middleware" => "auth"] , function (){

      Route::get('/', 'HomeController@index');

      Route::get("/link/{table}" , "PagesController@showAll");

      Route::get("/add" , function () {
        return view("blades.addTable");
      });

      Route::post("/add" , "TableController@AddNew");

});

Route::get('/test', function()
{

  Artisan::call('make:model', [
        "name" => "koko"
    ]);

});

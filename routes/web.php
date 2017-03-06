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

      Route::group(["prefix" => "link"] , function (){

            Route::get("/{table}" , "PagesController@showAll");

            Route::get("/add/{table}" , "PagesController@newData");

      });

      Route::get("/add" , function () {
        return view("blades.addTable");
      });

      Route::post("/add" , "TableController@AddNew")->name("add_field");

});

Route::get('/test', function()
{

  // Artisan::call('make:model', [
  //       "name" => "koko"
  //   ]);

  // $files = file(app_path() . "/a_Tables.php");
  //
  // if (in_array("}\n" , $files)){
  //   echo "Exist";
  // }

  $m = file_get_contents(app_path() . "/a_Tables.php");

  $m = str_replace("}\n" , "" , $m);

  $h = $m . "koko
}
  ";

  file_put_contents(app_path() . "/test.php" , $h);

});

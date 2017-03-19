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

      Route::group(["prefix" => "table"] , function (){

            Route::get("/add" , function () {
              $tables = \App\a_Tables::get();
              return view("blades.addTable" , ["all_tables" => $tables]);
            });

            Route::post("/add" , "TableController@AddNew")->name("add_table");

            Route::get("/option/{table}" , "TableController@AddOption")->name("add_option")->where("table" , "[a-zA-Z]+|[a-zA-Z]+\d+");

            Route::post("/option/{table_id}" , "TableController@StoreOption")->name("store_option")->where("table_id" , "\d+");
      });

      Route::get("/{table}" , "PagesController@showAll");

      Route::get("/add/{table}" , "PagesController@newData");

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

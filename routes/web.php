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

            Route::get("/edit/{table}" , "TableController@EditTable")->name("edit_table")->where("table" , "[a-zA-Z]+|[a-zA-Z]+\d+");

          Route::get("/update/{table_id}" , "TableController@UpdateTable")->name("update_table")->where("table_id" , "\d+");
      });

      Route::get("/tables/" , "TableController@ShowAll")->name("show_all");

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
/*
  $m = file_get_contents(app_path() . "/a_Tables.php");

  $m = str_replace("}\n" , "" , $m);

  $h = $m . "koko
}
  ";

  file_put_contents(app_path() . "/test.php" , $h);
*/


/*
$tr = ["1" => "test" , "2" => "test" , "3" => "sldkfs" , "4" => "lsdkfds"];

foreach (array_count_values($tr) as $v){
    if ($v < 2){
        echo "allow";
    }
}*/

    //$app_child_model = "'App\\$parent_model'";
    /*$table = "tester";
    $child_model_edit = '/public\s*function\s*'. $table .'\s*\(\)\s*\n*\{\s*\n*return\s+\$this->belongsTo\(.*\);\s*\n*\}/';

    $parent_model_edit = '/public\s*function\s*users\s*\(\)\s*\n*\{\s*\n*return\s+\$this->hasMany\(.*\);\s*\n*\}/';
    // get the child model content
    $child_model_file = file_get_contents(app_path() . "/User.php");


    $child_model_file = preg_replace($child_model_edit , "" , $child_model_file);

    file_put_contents(app_path() . "/User.php" , $child_model_file);*/

     //dd(\App\a_Tables::pluck("table"));

    $s = \App\a_Tables::where("slug" , "tester")->first()->child_relation()->get();
   // $d = \App\relationships::where("child_id" , "2")->get()->all()->fields->get();
    dd($s);



});

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\a_Tables;
use Artisan;

class TableController extends Controller
{
    public $names;
    public $types;
    public $nullables;

    public function AddNew(Request $request)
    {

      $this->validate($request, [
        'table_name' => 'required|unique:a_tables,table|max:255',
        'link_name' => 'required|unique:a_tables',
        'slug' => 'required|unique:a_tables',
        'module_name' => 'required|unique:a_tables',
        'label_name.*' => 'required',
        'icon' => 'required',
        'field_name.*' => 'required',
        'field_type.*' => 'required',
    ]);

      $a_tables = new a_Tables;
      $a_tables->table = $request->table_name;
      $a_tables->link_name = $request->link_name;
      $a_tables->slug = $request->slug;
      $a_tables->module_name = $request->module_name;
      $a_tables->labels_name = implode("," ,$request->label_name);
      $a_tables->field_types = implode("," ,$request->field_type);
      $a_tables->icon = $request->icon;
      $a_tables->save();

      $this->nullables = $request->nullable;
      $this->names = $request->field_name;
      $this->types = $request->field_type;

      Artisan::call('make:model', [
            "name" => $request->module_name
        ]);

        Schema::create($request->table_name , function (Blueprint $table) {
          $table->increments('id');
          foreach ($this->names as $name_id => $name ) {
                $type = $this->types[$name_id];
                if ($this->nullables[$name_id]){
                    $table->$type($name)->nullable();
                } else {
                    $table->$type($name);
                }
          }
          $table->timestamps();
        });

        $model_file = file_get_contents(app_path() . "/$request->module_name.php");

        $model_file = str_replace("}\n" , "" , $model_file);

        $model_file = $model_file . '
            public function '.$request->table_name.'(){
                return $this->belongsTo("App\Phone");
            }
      }
        ';

        file_put_contents(app_path() . "/$request->module_name.php" , $model_file);

     //dd($request->nullable);

    }
}

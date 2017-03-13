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

    // name instance to store the Request->field_name array in it to use it in schema function
    public $names;
    // type instance to contain the array of field_types to use it in schema function
    public $types;
    // nullables to define if that field accept the null value or not
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
        'relation_tabels.*' => "required",
        "relation_fields.*" => "required"
    ]);

      // save the data of new table in a_table (avillable tables) to use it later
      $a_tables = new a_Tables;
      // table name
      $a_tables->table = $request->table_name;
      // this is the name of link in dashlinks in a slide
      $a_tables->link_name = $request->link_name;
      // store the slug that should be url of this table
      $a_tables->slug = $request->slug;
      // store model name in database
      $a_tables->module_name = $request->module_name;
      // check if label_name field empty or not not make errors in laravel
      if (isset($request->label_name)){
        // store array data in field by implode "," in it to avoid errors
        $a_tables->labels_name = implode("," ,$request->label_name);
      }
      // store array data in field by implode "," in it to avoid errors
      $a_tables->field_types = implode("," ,$request->field_type);
      // store the icon that should appear in the slide list in dashboard (I use the icons of font awoesome)
      $a_tables->icon = $request->icon;
      // store array data in field by implode "," in it to avoid errors
      // define if it is allowed to show this field in add bage in its controller
      $a_tables->visible_fields = implode(",", $request->visible);
      $a_tables->save();

      $this->nullables = $request->nullable;
      $this->names = $request->field_name;
      $this->types = $request->field_type;

      // Create the new model in App folder from artisan function instead of artisan command
      Artisan::call('make:model', [
            "name" => $request->module_name
        ]);

        // Create the new table in data base
        Schema::create($request->table_name , function (Blueprint $table) {
          $table->increments('id');
          // iritate the names array to generate the fields in the table
          foreach ($this->names as $name_id => $name ) {
            //define the type of this field easily
                $type = $this->types[$name_id];
                if ($this->nullables[$name_id]){
                    $table->$type($name)->nullable();
                } else {
                    $table->$type($name);
                }
          }
          $table->timestamps();
        });

        // modify the two models of relationships parent_model and child model
        $this->modify_model($request->relation_tabels , $request->relation_fields , $request->table_name , $request->module_name);

    }


    protected function modify_model($relation_tabels , $relation_fields , $child_table, $child_model)
    {
      // irritate the relation tables that should contain the parent table
        foreach ($relation_tabels as $relation_tabel) {
          // irritate the relation fields to exctract the field that suppose to be the foriegn key
            foreach ($relation_fields as $relation_field) {
             
             // get the parent model of the relationship
                $parent_model = a_Tables::where("table" , $relation_tabel)->first()->module_name;
             // get the child model content
                $child_model_file = file_get_contents(app_path() . "/$child_model.php");
             // remove the final line of the model that is "}\n"
                $child_model_file = str_replace("}\n" , "" , $child_model_file);
             // define the model that should be the parent of the relation ship
                $app_child_model = "'App\\$parent_model'";
             // add the function of the relationship to the child model
                $child_model_file = $child_model_file . '
                    public function '.$relation_tabel.'(){
                        return $this->belongsTo('. $app_child_model .');
                    }
              }
                ';
                // modify the content of this child model and the new changes
                file_put_contents(app_path() . "/$child_model.php" , $child_model_file);
                // get the content of the parent model
                $parent_model_file = file_get_contents(app_path() . "/$parent_model.php");
                // remove the last line in the parent model
                $parent_model_file = str_replace("}\n" , "" , $parent_model_file);
                // define the parent model to put it in the function
                $app_parent_model = "'App\\$child_model'";
                // add the relationship function to parent model
                $parent_model_file = $parent_model_file . '
                    public function '.$child_table.'(){
                        return $this->hasMany('. $app_parent_model .');
                    }
              }
                ';
                // put this changes in the parent model
                file_put_contents(app_path() . "/$parent_model.php" , $parent_model_file);
            }
        }
    }
}

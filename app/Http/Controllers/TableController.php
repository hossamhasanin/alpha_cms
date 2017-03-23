<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Validation\Factory;
use Mockery\CountValidator\Exception;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\a_Tables;
use Artisan;
use App\fields;

class TableController extends Controller
{

    // name instance to store the Request->field_name array in it to use it in schema function
    public $names;
    // type instance to contain the array of field_types to use it in schema function
    public $types;
    // nullables to define if that field accept the null value or not
    public $nullables;
    //default values of the fields
    public $default_values;

    public function AddNew(Request $request)
    {

      $this->validate($request, [
        'table_name' => 'required|unique:a_tables,table|max:255',
        'link_name' => 'required|unique:a_tables',
        'slug' => 'required|unique:a_tables',
        'module_name' => 'required|unique:a_tables',
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
      // store array data in field by implode "," in it to avoid errors
      $a_tables->field_types = implode("," ,$request->field_type);
      // store the icon that should appear in the slide list in dashboard (I use the icons of font awoesome)
      $a_tables->icon = $request->icon;
      // store array data in field by implode "," in it to avoid errors
      $a_tables->save();

      foreach ($request->field_name as $id => $name) {
          // save the data of the field in the fields tabl
          $fields = new fields;
          // save the field_name in field name column
          $fields->field_name = $name;
          // store the field_type
          $fields->field_type = $request->field_type[$id];
          // save the table_name (indicate to the table of this column) in table_name column
          $fields->table_id = $a_tables->id;
          // store if it nullable or nor
          $fields->field_nullable = isset($request->nullable[$id]) ? 1 : 0;
          // store the default value of the field
          $fields->default_value = isset($request->default_values[$id]) ? $request->default_values[$id] : "";
          // save the default label_name
          $fields->label_name = $name; 
          $fields->save();
      }


      $this->nullables = $request->nullable;
      $this->names = $request->field_name;
      $this->types = $request->field_type;
      $this->default_values = $request->default_values;

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
                  if ($this->default_values[$name_id]){
                    $table->$type($name)->nullable()->default($this->default_values[$name_id]);
                  } else {
                    $table->$type($name)->nullable();
                  }
                } else {
                  if ($this->default_values[$name_id]){
                    $table->$type($name)->default($this->default_values[$name_id]);
                  } else {
                    $table->$type($name);
                  }
                }
          }
          $table->timestamps();
        });

        // modify the two models of relationships parent_model and child model
        if ($request->relation_tabels){
          $this->modify_model($request->relation_tabels , $request->relation_fields , $request->table_name , $request->module_name);
        }

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

    public function AddOption($table){
        $fields_data = a_Tables::where("slug" , $table)->first()->fields()->get();

        $table_id = a_Tables::where("slug" , $table)->first()->id;

        return view("blades.addOption" , ["fields_data" => $fields_data , "table_id" => $table_id]);

    }

    public function StoreOption($table_id , Request $request){

        $table_name = a_Tables::find($table_id)->table;

        $this->validate($request , [
            'field_name.*' => "required",
            'ids.*' => "required|numeric",
            'field_type.*' => "required",
            'visibility.*' => "required",
            'label_name.*' => "required",
        ]);

        foreach (array_count_values($request->field_name) as $names){
            if ($names > 1){
                return redirect("dashboard/table/option/tester")->withErrors("There is fields repeated");
                die();
            }
        }

        $get_old_vals = fields::where("table_id" , $table_id)->get();

        foreach ($get_old_vals as $old_val){
            $new_name = $request->field_name[$old_val->id];
            $new_type = $request->field_type[$old_val->id];
            $new_nullable = isset($request->nullable[$old_val->id]) ? "NULL" : "NOT NULL";
            $new_default_value = isset($request->default_value[$old_val->id]) && ($new_type == "varchar(255)" or $new_type == "int(11)") ? "DEFAULT " . "'" .$request->default_value[$old_val->id] . "'" : "DEFAULT NULL";
            if ($new_name != $old_val->field_name or $new_type != $old_val->field_type or $new_nullable != $old_val->nullable or $new_default_value != $old_val->default_value){
                // ALTER TABLE `tester` CHANGE `lljjllj` `lljjllj` LONGTEXT NULL DEFAULT NULL;
                try{
                    DB::statement("ALTER TABLE $table_name CHANGE $old_val->field_name $new_name $new_type $new_nullable $new_default_value;");
                }catch (Exception $e){
                    echo "OHHHHH ! Sorry but i think there big problem in database";
                }
                    //DB::statement("ALTER TABLE tester CHANGE dsfsdf hihihi text NULL DEFAULT weuhiwf");
            }
        }


        //$table_fields = fields::where("table_id" , $table_id)->get();
        foreach ($request->ids as $field_id) {
            $requested_field = fields::find($field_id);
            $requested_field->field_name = $request->field_name[$field_id];
            $requested_field->table_id = $table_id;
            $requested_field->field_type = $request->field_type[$field_id];
            $requested_field->visibility = $request->visibility[$field_id];
            $requested_field->field_nullable = isset($request->nullable[$field_id]) ? $request->nullable[$field_id] : 0;
            if ($request->field_type[$field_id] == "varchar(255)" or $request->field_type[$field_id] == "int(11)" or $request->field_type[$field_id] == "float"){
                $requested_field->default_value = $request->default_value[$field_id];
            }
            $requested_field->label_name = $request->label_name[$field_id];
            $requested_field->save();
        }

        $request->session()->flash('add_option', 'you added this options successfully!');


        return redirect()->back();


    }

    public function ShowAll(){
        $all_tables = a_Tables::get();

        return view("blades.AllTables" , ["all_tables" => $all_tables]);
    }

    public function EditTable($table){
        $table_data = a_Tables::where("slug" , $table)->first()->fields()->get();

        $table_id = a_Tables::where("slug" , $table)->first()->id;

        return view("blades.EditTable" , ["table_data" => $table_data , "table_id" => $table_id]);
    }

}

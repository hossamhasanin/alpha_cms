<?php
/**
 * Created by PhpStorm.
 * User: saif
 * Date: 23/03/2017
 * Time: 08:28 م
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\a_Tables;
use App\fields;

class TableControllerApi extends Controller
{
    public function DeleteField(Request $request){
        $field = fields::find($request->id);
        $id = $field->id;
        $name = $field->field_name;
        $type = $field->field_type;
        $nullable = $field->field_nullable;
        $visibility = $field->visibility;
        $default_value = $field->default_value;
        $label_name = $field->label_name;
        //$field->delete();
        return response(["id" => $id,"name" => $name , "type" => $type , "nullable" => $nullable , "visibility" => $visibility , "default_value" => $default_value , "label_name" => $label_name] , 200);
    }

    public function DeleteRelationship(Request $request){
        // get the parent model of the relationship
        $parent_model = a_Tables::where("table" , $request->relation_table)->first()->module_name;

        $child_model = a_Tables::find($request->child_table_id)->module_name;

        $child_table = a_Tables::find($request->child_table_id)->table;

        //$app_child_model = "'App\\$parent_model'";
        $child_model_edit = '/public\s*function\s*'. $request->relation_table .'\s*\(\)\s*\n*\{\s*\n*return\s+\$this->belongsTo\(.*\);\s*\n*\}/';


        // get the child model content
        $child_model_file = file_get_contents(app_path() . "/$child_model.php");

        $child_model_file = preg_replace($child_model_edit , "" , $child_model_file);

        file_put_contents(app_path() . "/$child_model.php" , $child_model_file);

        $parent_model_edit = '/public\s*function\s*'. $child_table .'\s*\(\)\s*\n*\{\s*\n*return\s+\$this->hasMany\(.*\);\s*\n*\}/';
        // parend modifing
        $parent_model_file = file_get_contents(app_path() . "/$parent_model.php");

        $parent_model_file = preg_replace($parent_model_edit , "" , $parent_model_file);

        file_put_contents(app_path() . "/$parent_model.php" , $parent_model_file);

    }

}
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

    public function DeleteRelationship($relation_table , $child_table_id , $field_id){
        // get the parent model of the relationship
        $parent_model = a_Tables::where("table" , $relation_table)->first()->module_name;

        $child_model = a_Tables::find($child_table_id)->module_name;
        if ($parent_model && $child_model) {

            $child_table = a_Tables::find($child_table_id)->table;

            $child_model_edit = '/public\s*function\s*' . $relation_table . '\s*\(\)\s*\n*\{\s*\n*return\s+\$this->belongsTo\(.*\);\s*\n*\}/';


            // get the child model content
            try{
                $child_model_file = file_get_contents(app_path() . "/$child_model.php");
            }catch(Exception $e){
                echo "Error while opening the file , The error is : " . $e;
            }

            try{
                $child_model_file = preg_replace($child_model_edit, "", $child_model_file);

                file_put_contents(app_path() . "/$child_model.php", $child_model_file);

            }catch(Exception $e){
                echo "Error while modifing the file , The error is : " . $e;
            }

            $parent_model_edit = '/public\s*function\s*' . $child_table . '\s*\(\)\s*\n*\{\s*\n*return\s+\$this->hasMany\(.*\);\s*\n*\}/';
            // parent modifing
            try{
                $parent_model_file = file_get_contents(app_path() . "/$parent_model.php");
            }catch(Exception $e){
                echo "Error while opening the file , The error is : " . $e;
            }

            try {
                $parent_model_file = preg_replace($parent_model_edit, "", $parent_model_file);

                file_put_contents(app_path() . "/$parent_model.php", $parent_model_file);
            }catch(Exception $e){
                echo "Error while modifing the file , The error is : " . $e;
            }

            $the_field = fields::find($field_id);
            $the_field->relation_table = NULL;
            $the_field->save();

            return response("success :)", 201);
        } else {
            return response("Faild error pro :( , i dont find the files" , 404);
        }

    }

}
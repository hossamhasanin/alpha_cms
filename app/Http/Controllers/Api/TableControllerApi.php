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
        $nullable = $field->nullable;
        $visibility = $field->visibility;
        $default_value = $field->default_value;
        $label_name = $field->label_name;
        //$field->delete();
        return response(["id" => $id,"name" => $name , "type" => $type , "nullable" => $nullable , "visibility" => $visibility , "default_value" => $default_value , "label_name" => $label_name] , 200);
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class TableController extends Controller
{
    public $names;
    public $types;
    
    public function AddNew(Request $request)
    {

      $this->names = $request->name;
      $this->types = $request->type;

        Schema::create('koko', function (Blueprint $table) {
          foreach ($this->types as $type) {
              foreach ($this->names as $name) {
                    $table->$type($name);
              }
          }
        });

    }
}

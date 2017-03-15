<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fields extends Model
{
   	public function a_tables()
   	{
   		return $this->belongsTo("App\\a_Tables" , "table_id");
   	}
}

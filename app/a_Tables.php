<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class a_Tables extends Model
{
    protected $table = "a_tables";


    public function fields()
    {
        return $this->hasMany("App\fields");
    }

}

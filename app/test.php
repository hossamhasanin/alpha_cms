<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class test extends Model
{
    //

                    public function users(){
                        return $this->belongsTo('App\User');
                    }
              }
                
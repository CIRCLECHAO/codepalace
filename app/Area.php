<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function city(){
        return $this->belongsTo('App\City','city_id','city_id');
    }
}

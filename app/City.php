<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function areas(){
        return $this->hasMany('App\Area','city_id','city_id');
    }

    public function province(){
        return $this->belongsTo('App\Province','province_id','province_id');
    }
}

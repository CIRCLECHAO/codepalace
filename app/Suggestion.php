<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    public function user(){
        return  $this->belongsTo('App\User');
    }
    /*每一个建议都有一个回复 是一对一的关系*/
    public function suggestion(){
        return $this->hasOne('App\Suggestion','origin_id','id');
    }

}

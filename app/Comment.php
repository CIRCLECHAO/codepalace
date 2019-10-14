<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function article(){
        return $this->belongsTo('App\Article');
    }

    /*ÿ�����۶�Ӧ�����ظ�*/
    public function comments(){
        return $this->hasMany('App\Comment','id','response_id');
    }

}

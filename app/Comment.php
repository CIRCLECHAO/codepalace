<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function article(){
        return $this->belongsTo('App\Article');
    }

    /*每个评论对应多条回复*/
    public function comments(){
        return $this->hasMany('App\Comment','id','response_id');
    }

}

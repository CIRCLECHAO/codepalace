<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'click,zan,cai,is_top',
    ];
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function dynamic(){
        return $this->hasOne('App\Dynamic','op_user_article_id','id');
    }
}

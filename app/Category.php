<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $primaryKey = 'cat_id';
    protected $table = 'categories';

    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function levels(){
        return $this->hasMany('App\Level');
    }
}

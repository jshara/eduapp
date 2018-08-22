<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $primaryKey = 'ques_id';
    public $table = 'questions';

    public function level(){
        return $this->belongsTo('App\Level');        
    }

    public function answers(){
        return $this->hasMany('App\Answer');
    }
}

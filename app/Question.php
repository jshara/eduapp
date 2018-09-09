<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $primaryKey = 'ques_id';
       public $table = 'questions';

       protected $fillable = ['ques_content', 'ques_num',  'updated_at'];   

    public function level(){
        return $this->belongsTo('App\Level');        
    }

    public function answers(){
        return $this->hasMany('App\Answer','ques_id');
    }
}

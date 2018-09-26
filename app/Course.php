<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $primaryKey = 'c_id';
    protected $table = 'courses';

    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function enrolments(){
        return $this->hasMany('App\Enrolment');
    }
}

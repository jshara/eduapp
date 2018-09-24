<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    public $primaryKey = 'e_id';
    protected $table = 'enrolments';

    
    public function student(){
        return $this->belongsTo('App\Student');
    }
    
    public function course(){
        return $this->belongsTo('App\Course');
    }
}

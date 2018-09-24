<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $primaryKey = 's_id';
    protected $table = 'students';

    public function enrolments(){
        return $this->hasMany('App\Enrolment');
    }
}

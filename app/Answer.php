<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    public $primaryKey = 'ans_id';
    public $table = 'answers';

    public function question(){
        return $this->belongsTo('App\Question');
    }
}

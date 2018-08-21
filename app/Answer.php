<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

{

    public $primaryKey = 'ans_id';
    public $table = 'answers';

    public function question(){
        return $this->belongsTo('App\Question');
    }
}

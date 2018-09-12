<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $primaryKey = 'session_id';
    protected $table = 'sessions';

    public function players(){
        return $this->hasMany('App\Player');
    }
}

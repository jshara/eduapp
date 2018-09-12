<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $primaryKey = 'player_id';
    protected $table = 'players';

    public function session(){
        return $this->belongsTo('App\Session');
    }
}

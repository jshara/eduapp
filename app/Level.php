<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public $primaryKey = 'lev_id';
    protected $table = 'levels';
    
    // protected $fillable = [ 'lev_id'];   


    public function questions(){
        return $this->hasMany('App\Question');
    }
    public function category(){
        return $this->belongsTo('App\Category');
    }
}

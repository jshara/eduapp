<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public $primaryKey = 'lev_id';
    //public $foreignKey = 'cat_id';

    protected $table = 'levels';

    public function category(){
        return $this->belongsTo('App\Category');
    }
}

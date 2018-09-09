<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $primaryKey = 'ans_id';
    public $table = 'answers';

    protected $fillable = ['ans_content', 'ans_num', 'updated_at'];   


    public function question(){
        return $this->belongsTo('App\Question');
    }
}

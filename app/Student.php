<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Model
{
    use HasApiTokens, Notifiable;

    const TOKEN_EXPIRY = 30;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $primaryKey = 's_id';
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'password', 'token', 'expires_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    // public function student() {
    //     return $this->belongsTo(Student::class);
    // }

    public function isTokenExpired() {
        return $this->created_at->diffInSeconds(Carbon::now()) > self::TOKEN_EXPIRY;
    }

    public function getRouteKeyName()
    {
        return 'token';
    }
  
    public function enrolments(){
        return $this->hasMany('App\Enrolment');
    }
}

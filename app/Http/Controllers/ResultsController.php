<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;

class ResultsController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $yo = $user->courses;
        $open = Course::find('1');
        $yo[]= $open;
        return view('result.view')->with('courses',$yo);
    }

    public function displaystats($id){
        return view('result.stats')->with('id',$id);   
    }

    public function perform($id){
        return view('result.perform')->with('id',$id);   
    }
}

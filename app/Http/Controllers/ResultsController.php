<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;
use App\Level;
use App\Session;

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

    public function resultsget($cat_id){
        $levelNums = Level::where('cat_id',$cat_id)->select('lev_num')->get();
       foreach($levelNums as $levelnum){
            $num[]= $levelnum->lev_num;
       }
       
       $scores = Session::where('cat_id',$cat_id)->select('scoreString','s_id')->get();       
       $data;
       foreach($scores as $score){
            $studentScores = explode(',',$score['scoreString']);
            $i =1;
            foreach($studentScores as $studentScore){               
                $data[] = [$i,(int)$studentScore];
                $i++;
            }
       }
        // dd($num);
        // $data = ['score'=>[[1,50],[1,30],[1,100],[1,99],[2,10],[3,100],[4,60]],'num'=>$num];
        $sendingData = ['score'=>$data,'num'=>$num];
        return response()->json($sendingData);
    }

    public function perform($id){
        return view('result.perform')->with('id',$id);   
    }
}

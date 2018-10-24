<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;
use App\Category;
use App\Enrolment;
use App\Student;
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
        $levelNums = Level::where('cat_id',$cat_id)->select('lev_num','max_points')->get();
       foreach($levelNums as $levelnum){
            $num[]= $levelnum->lev_num;
            $max[]= $levelnum->max_points;
       }
       
       $scores = Session::where('cat_id',$cat_id)->select('scoreString')->get();       
       $data;
       foreach($scores as $score){
            $studentScores = explode(',',$score['scoreString']);
            $i =1;
            foreach($studentScores as $studentScore){   
                $insert = ((int)$studentScore/$max[$i])*100;
                $data[] = [$i,$insert];
                $i++;
            }
       }
        // dd($num);
        // $data = ['score'=>[[1,50],[1,30],[1,100],[1,99],[2,10],[3,100],[4,60]],'num'=>$num];
        $sendingData = ['score'=>$data,'num'=>$num];
        return response()->json($sendingData);
    }

    public function perform($cat_id){
        $c_id = Category::where('cat_id',$cat_id)->value('c_id');
        $students = Enrolment::where('c_id',$c_id)->select('s_id')->get();

        $student_ids;
        foreach($students as $student){
            $student_ids[]= Student::where('s_id',$student['s_id'])->value('student_id');
        }       

        $numLevel = Level::where('cat_id',$cat_id)->count();
        return view('result.perform')->with('id',$cat_id)->with('student_ids',$student_ids)->with('numLevel',$numLevel);
    }
}

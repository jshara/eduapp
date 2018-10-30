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
use DB;
use Carbon\Carbon;

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
        //find total participants
        $participants = DB::table('sessions')->where('cat_id',$id)->count();

        //calculate the average total time to complete this category
        $time_difference = DB::select(DB::raw("SELECT AVG(TIME_TO_SEC(updated_at) - TIME_TO_SEC(created_at)) as time
                        FROM `sessions` WHERE `cat_id`= $id"));
        $time_difference = gmdate("H:i:s", $time_difference[0]->time);

        return view('result.stats')->with('id',$id)->with('participants',$participants)->with('time', $time_difference);   
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
                $insert = ((int)$studentScore/$max[$i-1])*100;
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
        return view('result.perform')->with('cat_id',$cat_id)->with('student_ids',$student_ids)->with('numLevel',$numLevel);
    }

    public function loadResults($userId,$cat_id){
        $category = DB::table('categories')->where('cat_id',$cat_id)->value('cat_name');
        $maxScores;
        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

        if(DB::table('sessions')->where('s_id',$sid)->Exists()){

        $totalEarned = DB::table('sessions')->where('s_id',$sid)->where('cat_id',$cat_id)->value('session_score');
        $timeStarted = new Carbon (DB::table('sessions')->where('s_id',$sid)->where('cat_id',$cat_id)->value('created_at'));
        $timeFinished = new Carbon (DB::table('sessions')->where('s_id',$sid)->where('cat_id',$cat_id)->value('updated_at'));
        $totalTime = $timeFinished->diff($timeStarted)->format('%H:%I:%S');

        $scoreString = DB::table('sessions')->where('s_id',$sid)->where('cat_id',$cat_id)->value('scoreString');
        $qString = DB::table('sessions')->where('s_id',$sid)->where('cat_id',$cat_id)->value('questionString');
        $aString = DB::table('sessions')->where('s_id',$sid)->where('cat_id',$cat_id)->value('answerString');

        $numLevels = DB::table('levels')->where('cat_id',$cat_id)->count();


        for ($x = 1; $x <= $numLevels ; $x++){
            $maxScores[$x] = DB::table('levels')->where('cat_id',$cat_id)->where('lev_num',$x)->value('max_points');
        }

        $levIds = DB::table('levels')->where('cat_id',$cat_id)->select('lev_id')->get();

        $scoresPerLevel = explode(',',$scoreString);
        $questionsDone = explode(',',$qString);
        $answersGiven = explode(',',$aString);

        $res;
        $ques;
        $a = 0;
        foreach($scoresPerLevel as $score){
            $x = 0;
            foreach($questionsDone as $question){
                $quesContent= DB::table('questions')->where('lev_id',$levIds[$a]->lev_id)->where('ques_id',$question)->value('ques_content');

                if ($quesContent != null){
                    $correctAns = DB::table('answers')->where('ques_id',$question)->where('ans_correct','1')->value('ans_content');
                    $ansGiven = DB::table('answers')->where('ques_id', $question)->where('ans_id',array_shift($answersGiven))->value('ans_content');
                    $correct = false;
                    if($correctAns == $ansGiven){
                        $correct = true;
                    }
    
                    $ques[$x] = [
                        'number' => ($x+1),
                        'content' => $quesContent,
                        'correctAns' => $correctAns,
                        'givenAns' => $ansGiven,
                        'correct' => $correct
                    ];
                    $x++;
                }

            }
        
            $res[$a] = [
                'MaxScore' => $maxScores[$a+1],
                'ScoreEarned' => $score,
                'Level' => ($a + 1),
                'Questions' => $ques 
            ];

            $a++;
        }

        $percentage = $totalEarned/array_sum($maxScores) * 100;
        $comment;
        if ($percentage >= 80){
            $comment = "Excellent! Keep It Up";
        }
        else if($percentage >= 50){
            $comment = "Good Work. Keep Trying Harder!";
        }
        else{
            $comment = "Better Luck Next Time!";
        }

        $data = [
            'Category' => $category,
            'time' => $totalTime,
            'score' => $totalEarned,
            'Percentage' => $percentage,
            'Comment' => $comment,
            'TotalPossibleScore' => array_sum($maxScores),
            'results' => $res
        ];

        return view('result.studentdetails')->with('cat_id',$cat_id)->with('data',$data);
    }else{
        $data = 0;
        return view('result.studentdetails')->with('cat_id',$cat_id)->with('data',$data);
    }
    }
}

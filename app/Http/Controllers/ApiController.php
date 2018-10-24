<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Student;
use App\Enrolment;
use App\Category;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function credentials($sid, $pass)
    {

        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "http://mlearn.usp.ac.fj/uspmobile/IEP_authenticate/?username=" . $sid . "&password=" . $pass);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        $exploded = explode(':',$output);
        $data = str_replace('}','',$exploded[1]);

        return $data;

    }

    public function login(Request $request)
    {

        $student = Student::where('student_id', $request->student_id)->first();

        if ($student) {

            $has_token = DB::table('students')->where('s_id', $student->s_id)->where('token', null)->doesntExist();
            $expiry_token = DB::table('students')->where('s_id', $student->s_id)->value('expires_at');

            if (Carbon::now() > $expiry_token) {
                $check_token = false;
            } else {
                $check_token = true;
            }
            // dd($check_token);
            if (!$check_token) {

                $student->token;
                $student->delete();

                $response = [
                    'status' => 422,
                    'error' => 'Session Expired, Try Again'
                ];

                return response()->json($response); // Unprocessable Entity

            } else {

                $response = [
                    'status' => 200,
                    'message' => 'Login Attempt Successful'
                ];

                return response()->json($response); // Unprocessable Entity

            }

        } else {

            $response = $this->credentials($request->student_id, $request->password);

            if ($response == '0') {

                $student = new Student([
                    'student_id' => $request->student_id,
                    'token' => $request->access_token,
                    'expires_at' => $request->expires_at
                ]);

                // $tokenResult = $student->createToken('Personal Access Token');
                $tokenResult = Str::random(24) . $request->student_id . Str::random(40);
                // dd($tokenResult);
                // $token = $tokenResult->token;
                // $token->expires_at = Carbon::now()->addDays(10);

                $student->token = $tokenResult;
                $student->expires_at = Carbon::now()->addDays(10);
                $student->save();

                $enrolOpen = new Enrolment();                                                               // Enrol in Open course (default)
                $enrolOpen->s_id = $student->s_id;
                $enrolOpen->c_id = 1;
                $enrolOpen->save();

                // $token->save();

                $response = [
                    'status' => 200,
                    'message' => 'Logged In'
                ];

                return response()->json($response); // Unprocessable Entity

            } else if ($response == '1') {

                $response = [
                    'status' => 422,
                    'error' => 'Incorrect Credentials, Try Again'
                ];
                // return response($response, 422); // Unprocessable Entity
                return response()->json($response); // Unprocessable Entity

                // return response($response, 422); // Unprocessable Entity

            }

        }
    }


    //api that returns a list of all categories.

    public function getCat(){
        $cat = DB::table('categories')->select('cat_id','cat_name')->where('published', 1)->get();  

        return response()->json($cat);
    }
  
    public function getAllCat($userId){
        //find the id associated with the student id
        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');
        $cids = DB::table('enrolments')->select('c_id')->where('s_id',$sid)->get();

        $i = 0;
        foreach($cids as $cid){
            $cats = DB::table('categories')->select('cat_id','cat_name')->where('c_id',$cid->c_id)->where('published', 1)->get();  

            if(!$cats->isEmpty()){
                foreach ($cats as $cat){
                    $list[$i] = [
                        'cat_id' => $cat->cat_id,
                        'cat_name' => $cat->cat_name
                    ]; 
                    $i++;
                }


            }
            
        }

        return response()->json($list);
    }

    public function getCompletedCat($userId){
        //find the id associated with the student id
        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

        $cats = DB::table('sessions')->select('cat_id')->where('s_id',$sid)->where('session_completed','1')->get();
        $i = 0;
        foreach( $cats as $cat){
            // echo $cat->cat_id;
            $list = DB::table('categories')->select('cat_name as Cat')->where('cat_id', $cat->cat_id)->get();

            $data[$i] = [
                'cat_id' => $cat->cat_id,
                'cat_name' => $list[0]->Cat
            ];
        $i++;
        }
        return response()->json($data);
    }

    public function getSavedCat($userId){
        //find the id associated with the student id
        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

        $cats = DB::table('sessions')->select('cat_id')->where('s_id',$sid)->where('session_completed','0')->get();
        $i = 0;
        foreach( $cats as $cat){
            // echo $cat->cat_id;
            $list = DB::table('categories')->select('cat_name as Cat')->where('cat_id', $cat->cat_id)->get();

            $data[$i] = [
                'cat_id' => $cat->cat_id,
                'cat_name' => $list[0]->Cat
            ];
        $i++;
        }
        return response()->json($data);
    }

    

    //check number of levels per category
    //SELECT `categories`.* , count(`levels`.`lev_num`) as NumLevels FROM `categories` LEFT join `levels` on `categories`.cat_id = `levels`.`cat_id` group by `categories`.`cat_id`


    //function that returns first level info by getting category id
    public function getLevel($cat_id){
        $list = DB::table('levels')
            ->where('cat_id', $cat_id)
            ->where('lev_num', 1)
            ->select('lev_location')
            ->get();
            //echo "this is the list:".$list."end of line";
            // var_dump($list);
        $data = explode(",", $list[0]->lev_location);
        $coords = [
            'lat' => $data[0],
            'lng' => $data[1]
        ];
        return response()->json($coords);
    }


    //check the total level in a category
    public function checkHowManyLevel($cat_id){
        $res;

        $numLevels = DB::table('levels')
            ->select(DB::raw('count(`lev_num`) as numLev'))
            ->where('cat_id', $cat_id)
            ->groupBy('cat_id')
            ->get();

        $res = $numLevels;

        return response()->json($res);
    }

    //load the coordinates of next level (if exists)
    public function loadNextLevel($currentLev, $cat_id)
    {
        $list = DB::table('levels')
            ->where('cat_id', $cat_id)
            ->where('lev_num', $currentLev + 1)
            ->select('lev_location')
            ->get();
        //echo "this is the list:".$list."end of line";
        // var_dump($list);
        $data = explode(",", $list[0]->lev_location);
        $coords = [
            'lat' => $data[0],
            'lng' => $data[1]
        ];
        return response()->json($coords);
    }

    //load the coordinates of next level (if exists)
    public function loadLevel($cat_id,$levNum,$userId,$score){
        $list = DB::table('levels')
        ->where('cat_id',$cat_id)
        ->where('lev_num',$levNum)
        ->select('lev_location')
        ->get();

    $data = explode(",", $list[0]->lev_location);
    $coords = [
        'lat' => $data[0],
        'lng' => $data[1]
    ];


    $this->saveGameSession($userId,$cat_id,$levNum,$score);


    return response()->json($coords);
    }


    //load the questions and answers of a chosen level by ID
    public function loadQuestion($lev_num,$cat_id){
        $lev_id = DB::table('levels')              
                ->where('lev_num',$lev_num)
                ->where('cat_id',$cat_id)
                ->value('lev_id');
                $max = DB::table('questions')
                ->where('lev_id',$lev_id)
                ->where('ques_hide','0')
                ->count();
        $num = DB::table('levels')
                ->where('lev_id',$lev_id)
                ->value('numOfQues');
        $result = DB::table('questions')
        ->select('questions.ques_id','questions.ques_num', 'questions.ques_content')
        ->where('questions.lev_id',$lev_id)
        ->where('ques_hide','0')
        ->get();

        $data2=null;
        for($i = 0;$i < $max ; $i++){
            $list = DB::table('answers')
                    -> select ('ans_id','ans_content')
                    ->where('ques_id', $result[$i]->ques_id)
                    ->get();
 

            $data[$i] = [            
                'ID' => $result[$i]->ques_id,
                'Number' => $result[$i]->ques_num,
                'Content' => $result[$i]->ques_content,
                'answers' => $list
                ];
                $data[$i]= json_decode(json_encode($data[$i]), true);
                shuffle($data[$i]['answers'] );
                shuffle($data[$i]['answers'] );
                shuffle($data[$i]['answers'] );            
        }

        shuffle($data);
        $data = array_slice($data, 0, $num);
        return response()->json($data);

    }

    //check whether answers submitted are correct
    public function checkAns($userId,$cid, $lnum, $ans_str = null)
    {
        $resultSet;
        if ($ans_str == null) {
            $data = [
                'score' => 0
            ];

            return response()->json($data);
        } else {
            $ans_id = explode(',', $ans_str);
            $levId = DB::table('levels')
                            ->where('cat_id',$cid)
                            ->where('lev_num',$lnum)
                            ->value('lev_id');
          
            $numQuestions = DB::table('levels')
                            ->where('lev_id',$levId)
                            ->value('numOfQues');
            
            $maxPoints = DB::table('levels')        //maxpoints added
                            ->where('lev_id',$levId)//
                            ->value('max_points');     //          
            $numCorrect = 0;

            $ques_id;
            foreach ($ans_id as $id) {
                $result = DB::table('answers')
                    ->where('ans_id', $id)
                    ->value('ans_correct');
                $ques_id[] = DB::table('answers')
                  ->where('ans_id',$id)
                  ->value('ques_id');
                  

                if ($result == 1) {
                    // echo 'correct ' . $result;
                    $resultSet[] = ($result);
                    $numCorrect++;
                } else {
                    // echo 'wrong '.$result;
                    $resultSet[] = ($result);
                }
            }
            $score = ($numCorrect / $numQuestions) * $maxPoints;//small change here
            $score = number_format((float)$score, 0, '.', '');
            
            $data = [
                'score' => $score
            ];

            $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

            $levId = DB::table('levels')
                ->where('cat_id', $cid)
                ->where('lev_num', $lnum)
                ->value('lev_id');

            $scoreString = DB::table('sessions')
                ->where('s_id', $sid)
                ->where('cat_id', $cid)
                ->value('scoreString');

            $qString = DB::table('sessions')
                ->where('s_id', $sid)
                ->where('cat_id', $cid)
                ->value('questionString');
                

            $aString = DB::table('sessions')
                ->where('s_id', $sid)
                ->where('cat_id', $cid)
                ->value('answerString');

                $ques_id = join(',' , $ques_id);
                
                if ($scoreString == null){
                    $scoreString = $score;
                    // $ques_id = $qString;
                    // $ans_str = $aString;
                }
                else{
                    $scoreString = $scoreString.',' .$score;
                    $ques_id = $qString.','.$ques_id;
                    $ans_str = $aString.','.$ans_str;
                }
               



            DB::table('sessions')
                ->where('s_id', $sid)
                ->where('cat_id', $cid)
                ->update(
                ['lev_id'  => $levId,
                'session_score'  => $score,
                'answerString' => $ans_str,
                'questionString' => $ques_id,
                'scoreString' => $scoreString,
                'updated_at'=> Carbon::now()->toDateTimeString()
                ]
            );

            $val = db::table('students')
            ->where('s_id',$sid)
            ->where('student_id',$userId)
            ->value('scoreTotal');    

            db::table('students')
            ->where('s_id',$sid)
            ->where('student_id',$userId)
            ->update([
                'scoreTotal' => ($val + $score)
            ]);

            return response()->json($data);
        }

    }

    public function getRandomLatLng($values)
    {
        // $array = array();
        $array = [
            '-18.147252, 178.445223',
            '-18.146773, 178.444021',
            '-18.147456, 178.445898',
            '-18.147864, 178.444879',
            '-18.147874, 178.444139',
            '-18.147109, 178.442809',
            '-18.148628, 178.443485',
            '-18.148692, 178.447268',
            '-18.149357, 178.446605',
            '-18.150040, 178.446380',
            '-18.150458, 178.446959',
            '-18.151019, 178.445693',
            '-18.150866, 178.444899',
            '-18.150662, 178.445414',
            '-18.149690, 178.444025',
            '-18.149772, 178.443671',
            '-18.150465, 178.443853',
            '-18.150409, 178.443477',
            '-18.150297, 178.443262',
            '-18.150144, 178.442956',
            '-18.149904, 178.443235'
        ];
        if ($values == 1) {
            $list = $array[array_rand($array, $values)];
            $data = explode(",", $list);
            $coords = [
                'lat' => $data[0],
                'lng' => $data[1]
            ];
            $list = $coords;
        } else {
            $index[] = array_rand($array, $values);
            $c = 0;
            foreach ($index[0] as $i) {
                $list[$c] = [
                    $array[$i]
                ];
                $c++;
            }
            $a = 0;
            foreach ($list as $item) {
                $data = explode(",", $item[0]);
                $coords[$a] = [
                    'lat' => $data[0],
                    'lng' => $data[1]
                ];
                $a++;
            }

            $list = $coords;
        }
        return response()->json($list);
    }


    public function getRandomLatLng2($values){
        // $array = array();
        $array = [
           ' -27.476103, 153.017359',
            '-27.476775, 153.017421',
            '-27.476148, 153.017156',
            '-27.477030, 153.017673',
            '-27.476722, 153.017851',
            '-27.476288, 153.016726'
    ];
        if ($values == 1){
            $list =  $array[array_rand($array,$values)] ;
            $data = explode(",", $list);
            $coords = [
                'lat' => $data[0],
                'lng' => $data[1]
            ];
            $list = $coords;
        }
        else{
            $index[] = array_rand($array,$values);
            $c = 0;
            foreach ($index[0] as $i) {
                $list[$c] = [
                   $array[$i]                   
                ];
            $c++;
            }
            $a = 0;
            foreach($list as $item){
                $data = explode(",",$item[0]);
                $coords[$a] = [
                    'lat' => $data[0],
                    'lng' => $data[1]
                ];
             $a++;                  
            }

            $list = $coords; 
        }
       return response()->json($list); 
    }



    public function shuffle_assoc($list) {
      if (!is_array($list)) return $list;
    
      $keys = array_keys($list);
      shuffle($keys);
      $random = array();
      foreach ($keys as $key)
        $random[$key] = $list[$key];
    
      return $random;
    }

    public function createGameSession($userId,$cid){
        //find the id associated with the student id
        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

        $levId = DB::table('levels')
            ->where('cat_id',$cid)
            ->where('lev_num',1)
            ->value('lev_id');
        DB::table('sessions')->insert([
            // sample syntax ['email' => 'taylor@example.com', 'votes' => 0]
            [
                's_id' => $sid,
                'cat_id' => $cid,
                'lev_id' => $levId,
                'session_score' => '0',
                'scoreString' => null,
                'questionString' => null,
                'answerString' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }

    public function saveGameSession($userId, $cid, $lnum, $score)
    {
        //find the id associated with the student id
        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

        $levId = DB::table('levels')
            ->where('cat_id', $cid)
            ->where('lev_num', $lnum)
            ->value('lev_id');
        DB::table('sessions')
            ->where('s_id', $sid)
            ->where('cat_id', $cid)
            ->update(
            ['lev_id'  => $levId,
             'session_score'  => $score,
             'updated_at'=> Carbon::now()->toDateTimeString()
             ]
        );

        return "Game Saved";
    }

    public function endGameSession($userId,$cid,$lnum,$score){
        //find the id associated with the student id
        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

        $levId = DB::table('levels')
        ->where('cat_id',$cid)
        ->where('lev_num',$lnum)
        ->value('lev_id');
        DB::table('sessions')
            ->where('s_id',$sid)
            ->where('cat_id', $cid)
            ->update(
            ['lev_id'  => $levId,
             'session_score'  => $score,
             'session_completed' => 1,
             'updated_at'=> Carbon::now()->toDateTimeString()
             ]
        );
        return "Game Finished";
    }

    public function loadGameSession($userId, $cid)
    {
        //find the id associated with the student id
        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

        $levId = DB::table('sessions')
            ->where('s_id', $sid)
            ->where('cat_id', $cid)
            ->value('lev_id');
        $score = DB::table('sessions')
            ->where('s_id', $sid)
            ->where('cat_id', $cid)
            ->value('session_score');
        $lnum = DB::table('levels')
            ->where('lev_id', $levId)
            ->value('lev_num');
        $lnum = $lnum - 1;
        $data = [
            'lnum' => $lnum,
            'score' => $score
        ];

        return response()->json($data);
    }

    public function loadResults($userId,$cat_id){

        $category = category::find($cat_id)->value('cat_name');

        $maxScores;

        $sid = DB::table('students')->where('student_id',$userId)->value('s_id');

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
            // $numofQues[$x] = DB::table('levels')->where('cat_id',$cat_id)->where('lev_num',$x)->value('numOfQues');
        }

        // $numQuestions = DB::table('levels')->where('lev_id',$lev_id)->value('numOfQues');
        $levIds = DB::table('levels')->where('cat_id',$cat_id)->select('lev_id')->get();
        // dd($levIds);
        // die();

        $scoresPerLevel = explode(',',$scoreString);
        $questionsDone = explode(',',$qString);
        $answersGiven = explode(',',$aString);

        $res;
        $ques;
        // var_dump($scoresPerLevel);
        // die();

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
                        'ansGiven' => $ansGiven,
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

        return response()->json($data);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function student(Request $request)
    {
        return response()->json($request->student());
    }

    public function validateToken(Request $request, Student $token)
    {

        if ($token->isTokenExpired()) {
            $token->delete();
        }
    }
}

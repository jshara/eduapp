<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Student;

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

        // $res = file_get_contents("http://mlearn.usp.ac.fj/uspmobile/IEP_authenticate/?username=" . $sid . "&password=" . $pass);
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "http://mlearn.usp.ac.fj/uspmobile/IEP_authenticate/?username=" . $sid . "&password=" . $pass);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        // $res = str_replace('{"auth":',null, $res);
        // $res = str_replace('}',null, $res);
        // // dd($res);
        // $res = json_decode(json_encode($res),true);
        // $res = str_replace('ufeff', null, $res);
        // var_dump($res);

        // $output = json_encode($output);
        // var_dump($output);
        // die($output);
        $exploded = explode(':',$output);
        $data = str_replace('}','',$exploded[1]);
        // die($data);

        // die($output);
        return $data;

    }

    public function login(Request $request)
    {

        // $request->validate([
        //     'student_id' => 'required|string',
        //     'password' => 'required|string',
        // ]);

        // $student = new Student([
        //     'student_id' => $request->student_id,
        //     'token' => $request->access_token,
        //     'token_type' => $request->token_type,
        //     'expires_at' => $request->expires_at
        // ]);

        // $student = $request->student();

        $student = Student::where('student_id', $request->student_id)->first();
        // dd($student);
        // if (!$student) {

        //     return response()->json(['status' => 'error', 'message' => 'Student ID Not Found.']);

        // }

        if ($student) {

            $has_token = DB::table('students')->where('id', $student->id)->where('token', null)->doesntExist();
            $expiry_token = DB::table('students')->where('id', $student->id)->value('expires_at');

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
                // return response($response, 422); // Unprocessable Entity
                return response()->json($response); // Unprocessable Entity

                // $tokenResult = $student->createToken('Personal Access Token');
                // // dd($tokenResult->accessToken);
                // $token = $tokenResult->token;
                // $token->expires_at = Carbon::now()->addDays(10);

                // $student->token = $tokenResult->accessToken;
                // $student->token_type = "Bearer";
                // $student->expires_at = Carbon::now()->addDays(10);
                // $student->save();

                // if ($request->remember_me)
                //     $token->expires_at = Carbon::now()->addDays(10);

                // $token->save();

                // return response()->json([
                //     'access_token' => $tokenResult->accessToken,
                //     'token_type' => 'Bearer',
                //     'expires_at' => Carbon::parse(
                //         $tokenResult->token->expires_at
                //     )->toDateTimeString()
                // ]);
            } else {

                $response = [
                    'status' => 201,
                    'message' => 'Login Attempt Successful'
                ];
                // return response($response, 422); // Unprocessable Entity
                return response()->json($response); // Unprocessable Entity

            }
            // if (Carbon::parse($this->attributes['expires_at']) < Carbon::now())
            //if ($request->token !== $check_token)
            //{
            //    dd($token);
            //}
        } else {

            $response = $this->credentials($request->student_id, $request->password);
            // die($response);
            // $data = [
            //     'auth' => $response
            // ];
            // $response = $data['auth'];


            // var_dump($response);
            // die();
            // $response = (int) $response;
            // echo gettype($response);
        //      var_dump
        //      ( $data['auth']
        // );
        // die();


            if ($response == '0') {

                $student = new Student([
                    'student_id' => $request->student_id,
                    'token' => $request->access_token,
                    'token_type' => $request->token_type,
                    'expires_at' => $request->expires_at
                ]);

                $tokenResult = $student->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addDays(10);

                $student->token = $tokenResult->accessToken;
                $student->token_type = "Bearer";
                $student->expires_at = Carbon::now()->addDays(10);
                $student->save();

                if ($request->remember_me)
                    $token->expires_at = Carbon::now()->addDays(10);

                $token->save();

                $response = [
                    'status' => 201,
                    'message' => 'Logged In'
                ];
                // return response($response, 422); // Unprocessable Entity
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
        // dd($student);

        // $request->validate([
        //     'student_id' => 'required|string',
        //     'password' => 'required|string',
        //     'remember_me' => 'boolean'
        // ]);


    }
    //api that returns a list of all categories.
  
    public function getAllCat(){
        $list = DB::table('categories')->select('cat_id','cat_name')->where('published', 1)->get();
        return response()->json($list);
    }

    public function getCompletedCat($userId){
        $cats = DB::table('sessions')->select('cat_id')->where('player_id',$userId)->where('session_completed','1')->get();
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
        $cats = DB::table('sessions')->select('cat_id')->where('player_id',$userId)->where('session_completed','0')->get();
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
    public function checkAns($cid, $lnum, $ans_id = null)
    {
        $resultSet;
        if ($ans_id == null) {
            $data = [
                'score' => 0
            ];

            return response()->json($data);
        } else {
            $ans_id = explode(',', $ans_id);
            $levId = DB::table('levels')
                            ->where('cat_id',$cid)
                            ->where('lev_num',$lnum)
                            ->value('lev_id');
          
            $numQuestions = DB::table('levels')
                            ->where('lev_id',$levId)
                            ->value('numOfQues');
            $numCorrect = 0;
            foreach ($ans_id as $id) {
                $result = DB::table('answers')
                    ->where('ans_id', $id)
                    ->value('ans_correct');
                if ($result == 1) {
                    // echo 'correct ' . $result;
                    $resultSet[] = ($result);
                    $numCorrect++;
                } else {
                    // echo 'wrong '.$result;
                    $resultSet[] = ($result);
                }
            }
            $score = ($numCorrect / $numQuestions) * 100;
            $score = number_format((float)$score, 0, '.', '');
            $data = [
                'score' => $score
            ];

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
        $levId = DB::table('levels')
            ->where('cat_id',$cid)
            ->where('lev_num',1)
            ->value('lev_id');
        DB::table('sessions')->insert([
            // sample syntax ['email' => 'taylor@example.com', 'votes' => 0]
            [
                'player_id' => $userId,
                'cat_id' => $cid,
                'lev_id' => $levId,
                'session_score' => '0',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }

    public function saveGameSession($userId, $cid, $lnum, $score)
    {
        $levId = DB::table('levels')
            ->where('cat_id', $cid)
            ->where('lev_num', $lnum)
            ->value('lev_id');
        DB::table('sessions')
            ->where('player_id', $userId)
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
        $levId = DB::table('levels')
        ->where('cat_id',$cid)
        ->where('lev_num',$lnum)
        ->value('lev_id');
        DB::table('sessions')
            ->where('player_id',$userId)
            ->where('cat_id', $cid)
            ->update(
            ['lev_id'  => $levId,
             'session_score'  => $score,
             'session_completed' => 1,
             'updated_at'=> Carbon::now()->toDateTimeString()
             ]
        );
    }

    public function loadGameSession($userId, $cid)
    {
        $levId = DB::table('sessions')
            ->where('player_id', $userId)
            ->where('cat_id', $cid)
            ->value('lev_id');
        $score = DB::table('sessions')
            ->where('player_id', $userId)
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

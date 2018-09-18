<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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

    public function login(Request $request){
        $sid = $request->sid;
        $pass = $request->pass;

        $res = file_get_contents("http://mlearn.usp.ac.fj/uspmobile/IEP_authenticate/?username=".$sid."&password=".$pass);
            $res = str_replace('{"auth":','',$res);
            $res = str_replace('}','',$res);
        return $res;
    }


    // public function login($sid,$pass){
    //     $res = file_get_contents("http://mlearn.usp.ac.fj/uspmobile/IEP_authenticate/?username=".$sid."&password=".$pass);
    //         $res = str_replace('{"auth":','',$res);
    //         $res = str_replace('}','',$res);
    //     return $res;
    // }
    

    //api that returns a list of all categories.
    public function getAllCat(){
        // $list = Category::select('cat_name')->get();
        // return response()->json($list);
        $list = DB::table('categories')->select('cat_id','cat_name')->where('published', 1)->get();
        return response()->json($list);
    }

    //check number of levels per category
    //SELECT `categories`.* , count(`levels`.`lev_num`) as NumLevels FROM `categories` LEFT join `levels` on `categories`.cat_id = `levels`.`cat_id` group by `categories`.`cat_id`

    //function that returns level info by getting category id
    public function getLevel($cat_id){
        $list = DB::table('levels')
            ->where('cat_id',$cat_id)
            ->where('lev_num',1)
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

    //check if game continues
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
    public function loadNextLevel($currentLev,$cat_id){
        $list = DB::table('levels')
        ->where('cat_id',$cat_id)
        ->where('lev_num',$currentLev + 1)
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

    //load the questions and answers of a chosen level by ID
    public function loadQuestion($lev_num,$cat_id){
        $lev_id = DB::table('levels')              
                ->where('lev_num',$lev_num)
                ->where('cat_id',$cat_id)
                ->value('lev_id');
        $max = DB::table('questions')
                ->select(DB::raw('max(ques_num) as max'))
                ->where('lev_id',$lev_id)
                ->get();
        $result = DB::table('questions')
        ->select('questions.ques_id','questions.ques_num', 'questions.ques_content')
        ->where('questions.lev_id',$lev_id)
        ->get();
        $data2=null;
        for($i = 0;$i < $max[0]->max ; $i++){
            $list = DB::table('answers')
                    -> select ('ans_id','ans_content')
                    ->where('ques_id', $result[$i]->ques_id)
                    ->get();
 
            // shuffle($list); 

        $data[$i] = [
          
            'ID' => $result[$i]->ques_id,
            'Number' => $result[$i]->ques_num,
            'Content' => $result[$i]->ques_content,
            'answers' => $list
            ];
            $data[$i]= json_decode(json_encode($data[$i]), true);
            shuffle($data[$i]['answers'] );
            
        }

        shuffle($data);
        return response()->json($data);

    }

    //check whether answers submitted are correct
    public function checkAns($cid,$lnum, $ans_id = null){
        $resultSet;     
        if($ans_id == null){
            $data = [
                'score' => 0
            ];
    
    
        return response()->json($data);
        }
        else{
            $ans_id = explode(',',$ans_id);
            $levId = DB::table('levels')
                            ->where('cat_id',$cid)
                            ->where('lev_num',$lnum)
                            ->value('lev_id');
            $numQuestions = DB::table('questions')
                            ->where('lev_id',$levId)
                            ->count();
            $numCorrect = 0;
            foreach ($ans_id as $id){
                $result = DB::table('answers')
                        ->where('ans_id',$id)
                        ->value('ans_correct');
                if ($result==1){
                    // echo 'correct ' . $result;
                    $resultSet[] = ($result);
                    $numCorrect ++;
                }
                else 
                {
                    // echo 'wrong '.$result;
                    $resultSet[] = ($result);
                }
            }
            $score = ($numCorrect/$numQuestions)*100;
            $score = number_format((float)$score, 0, '.', ''); 
            $data = [
                'score' => $score
            ];
    
    
        return response()->json($data);
        }
        

}

    public function getRandomLatLng($values){
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

    public function createGameSession($userId,$cid,$lnum){
        $levId = DB::table('levels')
            ->where('cat_id',$cid)
            ->where('lev_num',$lnum)
            ->value('lev_id');
        DB::table('sessions')->insert([
            // sample syntax ['email' => 'taylor@example.com', 'votes' => 0]
            ['player_id' => $userId,
             'cat_id'  => $cid,
             'lev_id'  => $levId,
             'session_score'  => '0',
             'created_at' => Carbon::now()->toDateTimeString(),
             'updated_at'=> Carbon::now()->toDateTimeString()
             ]
        ]);
            
    }

    public function saveGameSession($userId,$cid,$lnum,$score){
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
             'updated_at'=> Carbon::now()->toDateTimeString()
             ]
        );
    }

    public function loadGameSession($userId,$cid){
        $levId = DB::table('sessions')
                ->where('player_id', $userId)
                ->where('cat_id',$cid)
                ->value('lev_id');
        $score = DB::table('sessions')
                ->where('player_id', $userId)
                ->where('cat_id',$cid)
                ->value('session_score');
        $lnum = DB::table('levels')
            ->where('lev_id',$levId)
            ->value('lev_num');
        $data = [
            'lnum' => $lnum,
            'score' => $score
        ];

        return response()->json($data);
    }


    
    
}
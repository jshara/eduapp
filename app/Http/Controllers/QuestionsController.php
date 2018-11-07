<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;
use App\Question;
use App\Answer;
use DB;

class QuestionsController extends Controller
{
    /**
     * Retrieves all the question associated with the level
     * Orders the question in desencending order
     *
     * @param  Level $lid
     * @return \Illuminate\Http\Response
     */
    public function index($lid)
    {
        $questions = Question::where('lev_id',$lid)->orderBy('ques_num','asc')->get();
        return view('question.details')->with('lev_id',$lid)->with('questions',$questions);
    }

    /**
     * Retrieves all the question associated with the level
     * Orders the question in desencending order
     *
     * @param  Level $lid
     * @return \Illuminate\Http\Response
     */
    public function indexdisabled($lid)
    {
        $questions = Question::where('lev_id',$lid)->orderBy('ques_num','asc')->get();
        return view('question.detailsdisabled')->with('lev_id',$lid)->with('questions',$questions);
    }

   /**
     * Create an instance of a questions
     * return with question number
     *
     * @param  Level $lid
     * @return \Illuminate\Http\Response
     */
    public function create($lid)
    {
        $ques_num = DB::table('questions')->where('lev_id',$lid)->max('ques_num');

        if($ques_num == NULL) 
            $ques_num = 1;
        else 
            $ques_num++;

        return view('question.add')->with('lev_id',$lid)->with('ques_num',$ques_num);
    }

    /**
     * Storing a new question.
     * associating it with the level it belongs to
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Level $lid
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lid)
    {
        $this->validate($request,[          // validate the fields to answer no empty response
            'question'=> 'required',
            'ans_1' => 'required',
            'ans_2' => 'required'
        ]);

        $ques = new Question();
        $ques->ques_content = $request->input('question');
        $ques->ques_num = $request->input('ques_num');
        $ques->lev_id = $lid;
        $ques->save(); 
       
        $i =1;
        while(!blank($request->input('ans_'.$i)) && $i < 5){
            $ans = new Answer();
            $ans->ans_content = $request->input('ans_'.$i);
            $ans->ans_num = $i;
            if($i==1)                
                $ans->ans_correct = 1;                
            else                
                $ans->ans_correct =0;                
            
            $ans->ques_id = $ques->ques_id;
            $ans->save();
            $i ++;
        }
      
        if($request->save_exit){
            return redirect('questions/'.$lid)->with('success', 'Question added');
        }
        else
        {
            return redirect('/questions/create/'.$lid)->with('success', 'Question added');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($qid)
    {
        // $question = DB:: select('select * from questions where ques_id =? order by ques_num asc',[$qid]);
       // $question = Question::where('ques_id',$qid)->orderBy('ques_num','acs')->get();
        // dd($question);
        $question = Question::find($qid);
        return view('question.edit')->with('question',$question);
    }

    /**
     * Updating the existing questions and answers
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'question'=> 'required',
            'ans_1' => 'required',
            'ans_2' => 'required'
        ]);

        $question = Question::find($id);
        $question->ques_content = $request->input('question');
        $question->save();  

        $answers = Answer::where('ques_id',$id)->get();
        $i =1;

        foreach ($answers as $answer) {
            if($answer->ans_num == 1){
                $answer->ans_correct = 1;
                $answer->ans_content = $request->input('ans_1');
            } 
            else
            {
                $answer->ans_content = $request->input('ans_'.$i);
            }
            $answer->save();
            $i++;            
        }       

        return redirect('questions/'.$question->lev_id)->with('success', 'Question updated');
    }

    /**
     * Deleting the questions and associated answers
     * This is updated without page reload
     * and return a response to indicate success
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function ajaxdelete(Request $req)
    {
       $allQuestions = Question::where('lev_id',$req->lid)->where('ques_num','>',$req->qnum)->get();
        foreach ($allQuestions as $question){
            --$question->ques_num;
            $question->save();
        }
        $currentQuestion = Question::find($req->id);
        $currentQuestion->delete();

        $level =Level::find($req->lid);
        $unhidden = DB::table('questions')->where('lev_id',$req->lid)->where('ques_hide','0')->count();
        if($unhidden < $level->numOfQues){
            $level->numOfQues = 1;
            $level->save();
        }
        
        return response()->json($currentQuestion);
    }

    /**
     * Allow a question to be in the bank but hidden
     * from the students
     * All response is saved thru ajax without page reload
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function hide(Request $req){  
        
        $bool = "0";
        if($req->checked == "true"){
            $bool = '1';
        }
        // var_dump($bool);        
        $question = Question::find($req->id);       
        $question->ques_hide = $bool;
        $question->save();
        
        $level =Level::find($question->lev_id);
        $unhidden = DB::table('questions')->where('lev_id',$question->lev_id)->where('ques_hide','0')->count();
        if($unhidden < $level->numOfQues /* || $unhidden == 1 */){
            $level->numOfQues = 1;
            // if($unhidden == 0){
            //     $level->numOfQues = 0;
            // }
            $level->save();
        }

        return response()->json($question);
    }
}

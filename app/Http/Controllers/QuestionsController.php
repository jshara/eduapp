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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lid)
    {
        $questions = Question::where('lev_id',$lid)->orderBy('ques_num','asc')->get();
        return view('question.details')->with('lev_id',$lid)->with('questions',$questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lid)
    {
        $ques_num = DB::table('questions')->where('lev_id',$lid)->max('ques_num');

        if($ques_num == NULL) 
            $ques_num = 1;
        else 
            $ques_num++;

        if($ques_num < 6)
            return view('question.add')->with('lev_id',$lid)->with('ques_num',$ques_num);
        else
            return redirect('/questions/'.$lid)->with('error', 'ITS FULL');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lid)
    {
        $this->validate($request,[
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
     * Update the specified resource in storage.
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
        $question->content = $request->input('question');
        $question->save();  
        $i =1;
        while(!blank($request->input('ans_'.$i)) && $i < 5){
            if($question->$answers->ans_num == $i){
                $question->answers->ans_content = $request->input('ans_'.$i);
            }            
            $i ++;
            $question->$answers->save();
        }
             
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

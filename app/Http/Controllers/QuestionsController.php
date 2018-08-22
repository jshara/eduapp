<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;
use App\Question;
use App\Answer;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lid)
    {
        return view('question.details')->with('lev_id',$lid);
    }

    // public function display(Request $request){
    //     $number = count($request->name);
    //     if($number > 0){
    //         for($i=0,$i<$number; $i++){
    //             if(trim($request->name))
    //         }
    //     }else{
            
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            if($i==1){
                $ans->ans_correct = 1;
            }else{
                $ans->ans_correct =0;
            }
            
            $ans->ques_id = $ques->ques_id;
            $ans->save();
            $i ++;
        }
        // switch($request->input['submitbtn']) {
        //     case 'save_exit': 
        //         // $cid = Level::where('lev_id', $lid)->select('cat_id')->get();
        //         // return redirect('/levels/'.$cid[0]->cat_id)->with('success', 'Question added');
        //         return 1;
        //     break;
        
        //     case 'save_next': 
        //         // return redirect('/questions/'.$lid)->with('success', 'Question added');
        //         return 2;
        //     break;

        //     default:
        //     return 3;
        // }

        if($request->save_exit){
            $cid = Level::where('lev_id', $lid)->select('cat_id')->get();
            return redirect('/levels/'.$cid[0]->cat_id)->with('success', 'Question added');
        }
        elseif($request->save_next){
            return redirect('/questions/'.$lid)->with('success', 'Question added');
        }
        else
        return 3;
        // if($_POST['submitbtn'] == 'save_exit'){

        //     // $cid = Level::where('lev_id', $lid)->select('cat_id')->get();
        //     // return redirect('/levels/'.$cid[0]->cat_id)->with('success', 'Question added');
        //     return 1;

        // }elseif($_POST['submitbtn'] == 'save_next'){
        //     // return redirect('/questions/'.$lid)->with('success', 'Question added');
        //     return 2;
        // }else{
        //     return 3;
        // }
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
    public function edit($id)
    {
        //
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
        //
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

@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="col-md-5 nopadding">
            <?php $cid = DB::table('levels')->where('lev_id', $lev_id)->value('cat_id'); ?>
            <a href="/levels/{{$cid}}" class="btn btn-danger">BACK</a>
        </div>
        <div class="col-md-7 text-left">            
            <a class="btn btn-lg"><h2> Level <?php echo DB::table('levels')->where('lev_id', $lev_id)->value('lev_num'); ?></h2></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php 
                $ques_num = DB::table('questions')->where('lev_id', $lev_id)->max('ques_num');
                if($ques_num == NULL){
                    $ques_num = 1;
                }else {
                    $ques_num++;
                }
            ?>
            <a class="btn btn-lg">Question <?php echo $ques_num ?></a>
        </div>
    </div>
    {!! Form::open(['action'=>['QuestionsController@store',$lev_id], 'method'=>'POST'])!!}
        <div class="row">
            <div class="col-md-12">
                {{form::textarea('question','',['style'=>'border-color:blue; background-color:lightsteelblue;', 'class'=>'form-control','rows' => 2, 'placeholder'=>'Enter Question'])}} <br>
                {{ Form::hidden('ques_num', $ques_num) }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {{form::textarea('ans_1','',['style'=>'border-color:green; background-color:lightgreen;', 'class'=>'form-control','rows' => 2, 'placeholder'=>'Enter Correct Answer'])}} <br>
            </div>
            <div class="col-md-6">
                {{form::textarea('ans_2','',['style'=>'border-color:red; background-color:lightpink;', 'class'=>'form-control','rows' => 2, 'placeholder'=>'Other Answers'])}} <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                    {{form::textarea('ans_3','',['style'=>'border-color:red; background-color:lightpink;', 'class'=>'form-control','rows' => 2, 'placeholder'=>'Other Answers'])}} <br>
            </div>
            <div class="col-md-6">
                    {{form::textarea('ans_4','',['style'=>'border-color:red; background-color:lightpink;', 'class'=>'form-control','rows' => 2, 'placeholder'=>'Other Answers'])}} <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                {{Form::submit('SAVE & EXIT',['class'=>'btn btn-success','name' => 'save_exit'])}}
                {{Form::submit('SAVE & NEXT QUESTION',['class'=>'btn btn-success','name' => 'save_next'])}}
            </div>
        </div>
    {!! Form::close() !!}
@endsection
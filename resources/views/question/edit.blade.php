@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-md-12">
            <a class="btn btn-lg"> Editing Question <?php echo $question->ques_num ?></a>
        </div>
    </div>
    {!! Form::open(['action'=>['QuestionsController@update', $question->ques_id], 'method'=>'PUT'])!!}
        <div class="row">
            <div class="col-md-12">
                {{form::textarea('question',$question->ques_content,['style'=>'border-color:blue; background-color:lightsteelblue;',
                'class'=>'form-control','rows' => 2, 'placeholder'=>'Enter Question'])}} <br>
                {{ Form::hidden('ques_num', $question->ques_num) }}
            </div>
        </div>
        <?php $i = 1; ?>
        @foreach($question->answers as $answer)
        <div class="row">        
            @if($answer->ans_correct == 1)
                <div class="col-md-6">
                    {{form::textarea('ans_1',$answer->ans_content,['style'=>'border-color:green; background-color:lightgreen;',
                    'class'=>'form-control','rows' => 2, 'placeholder'=>'Enter Correct Answer'])}} <br>
                </div>
            @else
            <div class="col-md-6">
                    {{form::textarea('ans_'.$i,$answer->ans_content,['style'=>'border-color:red; background-color:lightpink;', 
                    'class'=>'form-control','rows' => 2, 'placeholder'=>'Other Answers'])}} <br>
                </div>
            @endif
        </div>
        <?php $i++; ?>
        @endforeach
       
        <div class="row">
            <div class="col-md-12 text-right">
                {{Form::submit('Update',['class'=>'btn btn-success','name' => 'update'])}}
                {{-- {{Form::submit('Cancel',['class'=>'btn btn-danger','name' => 'cancel'])}} --}}
            </div>
        </div>
    {!! Form::close() !!}
@endsection
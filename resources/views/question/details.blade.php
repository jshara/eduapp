@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="col nopadding">
            <?php $cid = DB::table('levels')->where('lev_id', $lev_id)->value('cat_id'); ?>
            <a href="/levels/{{$cid}}" class="btn btn-danger">BACK</a>
        </div>
        <div class="col text-center">            
            <a class="btn btn-lg"><h2> Level <?php echo DB::table('levels')->where('lev_id', $lev_id)->value('lev_num'); ?></h2></a>
        </div>
        <div class="col text-right">            
        <a href="/questions/create/{{$lev_id}}" class="btn btn-success">Add Question</a>
        </div>
    </div>
    <div class="row">
            <table class ="table table-border table-hover">
                    <thead>
                        <tr>                        
                            <th>#</th>
                            <th>Questions</th>
                            <th>Answers</th>
                            <th></th>
                        </tr>
                    </thead>
                    <body>
                    @if(count($questions) > 0)
                        @foreach($questions as $question)
                        <tr>
                            <td>                           
                                <p class="text-center">{{$question->ques_num}}</p>                            
                            </td>
                            <td>                          
                                <p class="text-center">{!!$question->ques_content!!} </p>                        
                            </td>
                            <td>                               
                                @foreach($question->answers as $answer)
                                    @if($answer->ans_correct == 1)
                                        <li style="list-style-type:none; background-color:lightgreen;">{{$answer->ans_num}}: {{$answer->ans_content}} </li>
                                    @else
                                        <li style="list-style-type:none; background-color:lightpink;">{{$answer->ans_num}}: {{$answer->ans_content}} </li>
                                    @endif
                                
                                @endforeach
                       
                            </td>
                            <td>
                                <div class="input-group">  
                                    <span class="input-group-addon"><a href="/questions/{{$question->ques_id}}/edit" class="btn"><i class="fa fa-pencil fa-lg"></i></a></span>
                                    {{-- {!!Form::open(['action'=>['QuestionsController@destroy', $question->ques_id,$level->lev_num, $cat_id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{-- {{Form::submit('Delete',['class'=> 'fa fa-trash-o fa-lg'])}} -}}
                                        {!! Form::button( '<i class="fa fa-trash-o fa-lg" style="color:#FF0000;"></i>', ['type' => 'submit'] ) !!}
                                    {!!Form::close()!!} --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>Add your first question</td>
                        </tr>
                    @endif
                    </body>
                </table>
    </div>

@endsection
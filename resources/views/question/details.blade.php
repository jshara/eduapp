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
                            <th>Hide</th>
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
                                <p class="text-center">{!!($question->ques_content)!!} </p>                        
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
                                        <button class="btn btn-info" onclick="location.href = '/questions/{{$question->ques_id}}/edit'" style="margin:0 5px 0 5px;">
                                            <span class="fa fa-pencil fa-lg"></span>
                                        </button>
                                    {{-- <span class="form-control"><a href="/questions/{{$question->ques_id}}/edit" class="btn"><i class="fa fa-pencil fa-lg"></i></a></span> --}}
                                    {{-- {!!Form::open(['action'=>['QuestionsController@destroy', $question->ques_id,$level->lev_num, $cat_id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{-- {{Form::submit('Delete',['class'=> 'fa fa-trash-o fa-lg'])}} -}}
                                        {!! Form::button( '<i class="fa fa-trash-o fa-lg" style="color:#FF0000;"></i>', ['type' => 'submit'] ) !!}
                                    {!!Form::close()!!} --}}
                                </div>
                            </td>
                            <td>
                                <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">  
                                @if($question->ques_hide == '0')
                                    <input type="checkbox" name="hide" id="hide" data-id="{{$question->ques_id}}" />
                                @else
                                    <input type="checkbox" name="hide" id="hide" data-id="{{$question->ques_id}}" /checked>
                                @endif                              
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

    <script>
        $(document).on("change", "input[name='hide']", function () {
            console.log('this is the check box');
            var checkbox = $(this);
            var checked = checkbox.prop('checked');
            $.ajax({
                url:"/question/hide",
                type: 'post',
                data: {
                    '_token': $('input[name=_token]').val(),
                    action: 'checkbox-select', 
                    id: checkbox.data('id'), 
                    checked: checked
                        },
                success: function(data) {
                    //alert(data);
                },
                error: function(data) {
                    // alert(data);
                    // Revert
                    checkbox.attr('checked', !checked);
                }
            });
        });
    </script>

@endsection
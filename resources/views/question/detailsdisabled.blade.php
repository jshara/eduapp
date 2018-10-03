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
        <button class="btn btn-success disabled" data-toggle="tooltip" title="Unpublish Category to Add Question">Add Question</button>
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
                            <button class="btn btn-info disabled" style="margin:0 5px 0 5px;" data-toggle="tooltip" title="Unpublish Category to Edit">
                                <span class="fa fa-pencil fa-lg"></span>
                            </button>
                            <button class="btn btn-danger disabled" data-toggle="tooltip" title="Unpublish Category to Delete">
                                <span class="fa fa-trash-o fa-lg"></span>
                            </button>
                        </div>
                    </td>
                    <td>
                        @if($question->ques_hide == '0')
                            <input type="checkbox" name="hide" id="hide" data-id="{{$question->ques_id}}" data-toggle="tooltip" title="Unpublish Category to Hide" /disabled>
                        @else
                            <input type="checkbox" name="hide" id="hide" data-id="{{$question->ques_id}}" data-toggle="tooltip" title="Unpublish Category to Unhide" /checked disabled>
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
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>

@endsection
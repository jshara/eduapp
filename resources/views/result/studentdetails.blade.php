@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-2  nopadding">
        <a href="/perform/{{$cat_id}}" class="btn btn-danger">BACK</a>
    </div>
    <div class="col-md-6 offset-md-2">
        <h2><b>{{$data['Category']}}</b></h2>
    </div>
</div><br>
@if($data != 0)

<div class="row">
    <div class="col-md-4">
        <h4>Overall Score: {{$data['score']}}/{{$data['TotalPossibleScore']}} </h4>
    </div>
    <div class="col-md-4">
        <h4>Percentage: {{$data['Percentage']}}%</h4>
    </div>
    <div class="col-md-4">
        <h4>Total Duration: {{$data['time']}}</h4>
    </div>
</div><br>

<table class="table table-striped table-hover text-left">
    @foreach($data['results'] as $level)
        <tr>
            <td>
               <h5> Level {{$level['Level']}}</h5><br>
               <h5>{{$level['ScoreEarned']}}/{{$level['MaxScore']}} </h5> 
            </td>
            <td>
                <table class="table table-hover text-left">
                    @foreach($level['Questions'] as $Questions)
                        <tr>
                            <td style = "width:45%;">
                                <p><span>Question {{$Questions['number']}}. {!!$Questions['content']!!} </span></p>
                            </td>
                            @if($Questions['correct'])
                                <td style="background-color:lightgreen;">
                                    Selected Answer: {{$Questions['givenAns']}}
                                </td>
                            @else
                                <td style="background-color:pink;">
                                    Selected Answer: {{$Questions['givenAns']}} <br>
                                    Correct Answer: {{$Questions['correctAns']}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>
            
        </tr>
            
        </div>

    @endforeach
</table>
@else
    <h4>This student has not participated in the game.</h4>
@endif
@endsection
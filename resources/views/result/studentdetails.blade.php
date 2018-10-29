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

{{-- <php echo count($data['results']); ?> --}}

<table class="table table-striped table-hover text-left">
    @foreach($data['results'] as $level)
        <tr>
            <td>
               <h5> Level {{$level['Level']}}</h5><br>
               <h5>{{$level['ScoreEarned']}}/{{$level['MaxScore']}} </h5> 
            </td>
            <td>
                <table class="table table-striped table-hover text-left">
                    @foreach($level['Questions'] as $Questions)
                        <tr>
                            <td>
                                <p><span>Question {{$Questions['number']}}. {!!$Questions['content']!!} </span></p>
                            </td>
                            @if($Questions['correct'])
                                <td style="background-color:lightgreen;">
                                    Selected Answer: {{$Questions['givenAns']}}
                                </td>
                            @else
                                <td style="background-color:pink;">
                                    Selected Answer: {{$Questions['givenAns']}}
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

{{--                   
     <ion-item *ngFor="let question of data.Questions">
        <ion-item>
            <span><strong> Question {{question.number}}  </strong><div [innerHTML]="question.content"> </div> </span>
        </ion-item>
        <ion-item>
            <div *ngIf="question.correct == true" class="correct"> Your Answer: {{question.ansGiven}} <ion-icon  name="checkmark"></ion-icon> </div>
            <div *ngIf="question.correct == false" class="inCorrect"> Your Answer: {{question.ansGiven}} <ion-icon  name="close"></ion-icon> </div>
            <div *ngIf="question.correct == false" class="yellow"> Correct Answer: {{question.correctAns}}</div>
--}}
{{-- <php dd ($data['results'][0]['Questions'][0]['content']);?> --}}

@endsection
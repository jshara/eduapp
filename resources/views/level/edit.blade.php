@extends('layouts.app')

@section('content')
    <body>
        <div class="row">
            <div class="col-4">
                <a href="/levels/{{$cat_id}}" class="btn btn-danger">BACK</a>
            </div>
            <div class="col-8 float-left">
                    <h1>Edit Level {{$location->lev_num}}</h1>
            </div>
        </div>       
       
        <p> Drag the marker to change the location where this level spawns. 
        When satisfied with the position, click Update to save the location. </p>
        <p style="color:red !important;"> Please select safe locations for the levels as the 
        players will need to be near these locations to access the levels. </p>

        <?php $data = explode(",",$location->lev_location); ?>
        
        <div  class="container"> 
            <div class="row" style="height:500px;">
                <div id="map" style="height:500px; width:100%;"> </div>
            </div><br><br>

            <div class="row float-right form-inline">
                <div class="form-group ">
                    {!! Form::open(['action' => ['MapsController@updateLevel'],'method'=>'POST']) !!}
                    {{form::label('lev_location', 'Coordinates',['class' => 'form-control', 'for' => 'latlng'])}}                        
                    {{Form::text('lev_location',$location->lev_location,['class' => 'form-control','id' => 'latlng','readonly' =>'true'])}}
                    {{form::hidden('lev_id', $location->lev_id)}}
                    {{Form::hidden('_method','PUT')}}
                    {{Form::submit('Update',['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>

            @include('mapcode');
        </div> 
    </body>

@endsection
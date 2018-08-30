@extends('layouts.app')

@section('content')
        {{-- {!! $map['js'] !!} --}}
    <body>
        <h1>Edit Level {{$location->lev_num}}</h1>
        <p> Drag the marker to change the location where this level spawns. 
        When satisfied with the position, click Update to save the location. </p>
        <p style="color:red !important;"> Please select safe locations for the levels as the 
        players will need to be near these locations to access the levels. </p>
        {{-- <p>{{$location->lev_location}} </p> --}}

        <?php
        $data = explode(",",$location->lev_location); 
        // echo 'lat: ' . $data[0]. 'lng '. $data[1];
        ?>
        <div  class="container">
            <div class="row" style="height:500px;">
        {{-- <div class="container">{!! $map['html'] !!}</div> --}}
        <div id="map"  style="height:500px; width:100%;"> </div>

        {{-- <div ><strong> coords here:</strong> <p id="latlng"> Choose a position </p> </div> --}}
        <div>
            {!! Form::open(['action' => ['MapsController@updateLevel'],'method'=>'POST']) !!}
            <div class="form-group ">
                {{form::label('lev_location', 'Coordinates')}}
                <div style="width:100% !important;" class="col-md-14">
                {{Form::text('lev_location',$location->lev_location,['class' => 'form-control','id' => 'latlng','readonly' =>'true'])}}
                </div>
                {{form::hidden('lev_id', $location->lev_id)}}
         
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Update',['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
        @include('mapcode');

    </div>

    </div> 
    </body>


@endsection
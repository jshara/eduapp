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
        {{-- <p>{{$location->lev_location}} </p> --}}

        <?php
        $data = explode(",",$location->lev_location); 
        // echo 'lat: ' . $data[0]. 'lng '. $data[1];
        ?>
        <div  class="container"> 
            <div class="row" style="height:500px;">
                <!-- {{-- <div class="container">{!! $map['html'] !!}</div> --}} -->
                <div id="map"  style="height:500px; width:100%;"> </div>
            </div><br><br>

        <!-- {{-- <div ><strong> coords here:</strong> <p id="latlng"> Choose a position </p> </div> --}} -->
        <div class="float-right">
            <div class="row ">
                <div class="form-inline">                   
                    <div class="form-group ">
                        <div>
                            {!! Form::open(['action' => ['MapsController@updateLevel'],'method'=>'POST']) !!}
                            {{form::label('lev_location', 'Coordinates',['class' => 'form-control', 'for' => 'latlng'])}}                            

                             {{Form::text('lev_location',$location->lev_location,['class' => 'form-control','id' => 'latlng','readonly' =>'true'])}}
                             {{form::hidden('lev_id', $location->lev_id)}}
                               {{Form::hidden('_method','PUT')}}
                              {{Form::submit('Update',['class'=>'btn btn-primary'])}}
                             {!! Form::close() !!}
                        </div>                               
                    </div>
                </div>   
           </div>  

        </div>      
            
        @include('mapcode');    

    </div> 
    </body>

@endsection
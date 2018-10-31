@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-4">
                <a href="/levels/{{$cat_id}}" class="btn btn-danger">BACK</a>
            </div>
            <div class="col-8 float-left">
                <h1>Create Level </h1>
            </div>
        </div> 
        
        <p> Drag the marker to select the location where this level spawns. 
        When satisfied with the position, click Update to save the location. </p>
        <p style="color:red !important;"> Please select safe locations for the levels as the 
        players will need to be near these locations to access the levels. </p>

        <div class="container">
            <div class="row" style="height:500px;">
                <div id="map" style="height:500px; width:100%;"> </div>
            </div><br>

            {!! Form::open(['action' => ['LevelsController@store',$cat_id],'method'=>'POST']) !!}
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <div class="form-group">
                            {{-- {!! Form::open(['action' => ['LevelsController@store',$cat_id],'method'=>'POST']) !!} --}}
                            {{Form::label('location', 'Location of the level',['class'=> 'form-control', 'for'=>'latlng'])}}  
                            {{Form::text('location','',['class' => 'form-control','placeholder'=>'Move Marker to input','id'=>'latlng','readonly'=>'true'])}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('position', 'Position of the level',['class'=> 'form-control', 'for'=>'position'])}}  
                            {!!Form::selectRange('position',1,$newLevel,['class' => 'form-control',$newLevel,'id'=>'position','style'=>'color:red;size:15;']) !!} 
                        </div>
                    </div>
                </div>
                <div class="row float-right nopadding">
                    {{Form::submit('Add',['class'=>'btn btn-primary'])}}
                    {{-- {!! Form::close() !!} --}}
                </div>
            {!! Form::close() !!}
        </div>         


<script type="text/javascript">
            function initMap() {
                //declarations
                var updatedLoc  = 0;
                 var polyline = 
                 [  new google.maps.LatLng(-18.148307,178.448507),
                    new google.maps.LatLng(-18.146618,178.445160),
                    new google.maps.LatLng(-18.145509,178.442420),
                    new google.maps.LatLng(-18.145531,178.441191),
                    new google.maps.LatLng(-18.146084,178.440446),
                    new google.maps.LatLng(-18.147411,178.440226),
                    new google.maps.LatLng(-18.147581,178.440294),
                    new google.maps.LatLng(-18.147999,178.441077),
                    new google.maps.LatLng(-18.147999,178.441077),
                    new google.maps.LatLng(-18.149375,178.440508),
                    new google.maps.LatLng(-18.149660,178.440723),
                    new google.maps.LatLng(-18.151210,178.440197),
                    new google.maps.LatLng(-18.151491,178.440158),
                    new google.maps.LatLng(-18.153087,178.440490),
                    new google.maps.LatLng(-18.153999,178.441477),
                    new google.maps.LatLng(-18.155138,178.442713),
                    new google.maps.LatLng(-18.156540,178.444924),
                    new google.maps.LatLng(-18.152813,178.447971),
                    new google.maps.LatLng(-18.151447,178.446544),
                    new google.maps.LatLng(-18.149194,178.447424),
                    new google.maps.LatLng(-18.149347,178.448250),
                    new google.maps.LatLng(-18.149347,178.448250)];
                var outBounds = [
                    new google.maps.LatLng(-18.148509, 178.445285),
                    new google.maps.LatLng(-18.148608, 178.445504),
                    new google.maps.LatLng(-18.148707, 178.445444),
                    new google.maps.LatLng(-18.148628, 178.445235),
                    new google.maps.LatLng(-18.148509, 178.445285)                    
                ];

                var coord = {lat: -18.149767 ,lng:  178.443921};
                    var map = new google.maps.Map(document.getElementById('map'), {
                    center: coord,              
                    zoom: 16
                });


                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(-18.149767 ,178.443921),       
                    title: 'Level {{$newLevel}} ',
                    label: '{{$newLevel}}',
                    draggable: true
                });

                marker.setMap(map);
                // map.setCenter(marker.getPosition());
                // document.getElementById("latlng").innerHTML = marker.getPosition().lat()+","+marker.getPosition().lng();

                // Construct the polygon.
                var bounds = new google.maps.Polygon({
                    paths: [polyline,outBounds],
                    strokeColor: '#ff0000',
                    strokeOpacity: 1,
                    fillColor: '#0000ff',
                    fillOpacity: 0                    
                    });
                bounds.setMap(map);


                new google.maps.event.addListener(marker,'dragend',function() {                                       
                    this.updatedLoc = marker.getPosition().lat().toFixed(6)+","+marker.getPosition().lng().toFixed(6);
                    // map.setCenter(marker.getPosition());
                    // document.appendChild("<h1>",this.updatedLoc,"</h1>");
                   // document.getElementById("latlng").innerHTML = this.updatedLoc;
                   console.log(this.updatedLoc);
                      $("#latlng").val(this.updatedLoc) ;   
                }); 

                new google.maps.event.addListener(marker, 'dragend', function (event) { 
                    var result = google.maps.geometry.poly.containsLocation(marker.getPosition(), bounds);
                    if (result == false){
                        marker.setPosition(new google.maps.LatLng(-18.149767 ,178.443921));
                        $("#latlng").val("Move Marker to input") ;
                        map.setCenter(coord);
                        map.setZoom(16);
                    }
                });

                $("#position").on('change',function(){
                    // console.log( $("#position").val());
                    marker.set('label',$("#position").val());
                })
                
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBA1f-kQy07jvdtV3Ix4OQB47oiG3k4MZ4&callback=initMap"
        async defer></script> 

@endsection
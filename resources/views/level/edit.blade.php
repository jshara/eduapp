@extends('layouts.app')

@section('content')
        {{-- {!! $map['js'] !!} --}}
    <body>
        <h1>Laucala Campus Map</h1>
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
                

                var coord = {lat: -18.149767 ,lng:  178.443921};
                    var map = new google.maps.Map(document.getElementById('map'), {
                    center: coord,              
                    zoom: 16
                });


                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng("{{$data[0]}}","{{$data[1]}}"),       
                    title: 'Level {{$location->lev_num}}',
                    label: '{{$location->lev_num}}',
                    draggable: true
                });

                marker.setMap(map);
                // map.setCenter(marker.getPosition());
                document.getElementById("latlng").innerHTML = marker.getPosition().lat()+","+marker.getPosition().lng();

                // Construct the polygon.
                var bounds = new google.maps.Polygon({
                    paths: polyline,
                    strokeColor: '#ff0000',
                    strokeOpacity: 1,
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
                        marker.setPosition(new google.maps.LatLng("{{$data[0]}}","{{$data[1]}}"));
                        $("#latlng").val("{{$data[0]}},{{$data[1]}}") ;
                        map.setCenter(coord);
                        map.setZoom(16);
                    }
                });
                
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTZpMJds--UcfE_WqFDszvnHIskZc2PQ&callback=initMap"
        async defer></script> 

    </div>

    </div> 
    </body>


@endsection
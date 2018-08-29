<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Level;
use FarhanWazir\GoogleMaps\GMaps;

class MapsController extends Controller
{
    public function map($cat_id) {
        $config['center'] = 'USP Laucal Campus';
        $config['zoom'] = '16';
        $config['map_height'] = '500px';
        $config['map_width'] = '100%';
        $config['scrollwheel'] = true;

        $locations =DB::table('levels')
                ->select('lev_location as val')
                ->where('cat_id','=',$cat_id)
                ->get();

    //  Initialize the map with $config properties
        $gmap = new GMaps();
        $gmap->initialize($config);
        $i = 1;

        foreach($locations as $data){
            $marker['position'] = $data->val;
            $marker['label']= $i;
            $gmap->add_marker($marker);
            $i++;
        }

        $map = $gmap->create_map();

        return view('category.map')->with('map', $map);
    }

    public function viewLevel($lev_id){
        $config['center'] = 'USP Laucal Campus';
        $config['zoom'] = '16';
        $config['map_height'] = '500px';
        $config['map_width'] = '100%';
        $config['scrollwheel'] = true;

        $location = Level::find($lev_id);

    //  Initialize the map with $config properties
        $gmap = new GMaps();
        $gmap->initialize($config);
  
        $marker['position']= $location->lev_location;
        $marker['id'] = $lev_num;
        $marker['label']=$location->lev_num;
        $marker['draggable'] = true;   
        $gmap->add_marker($marker);
        // $marker['ondragend'] != "") {
        //     $marker_output .= '
        //     google.maps.event.addListener(marker_'.$marker.', "dragend", function(event) {
        //         '.$marker['ondragend'].'
        //     });
        //     ';

        $map = $gmap->create_map();


        return view('category.map')->with('map', $map)/*->('marker_out',$marker_output)*/;
    }
}

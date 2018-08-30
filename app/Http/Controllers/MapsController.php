<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Level;
use FarhanWazir\GoogleMaps\GMaps;

class MapsController extends Controller
{
    public function map($cat_id) {
        $config['center'] = 'USP Laucala Campus';
        $config['zoom'] = '16';
        $config['map_height'] = '500px';
        $config['map_width'] = '100%';
        $config['scrollwheel'] = true;

        $cat_name = db::table('categories')
                    ->where('cat_id','=',$cat_id)
                    ->value('cat_name');

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
            $marker['title'] = 'Level '.$i;
            $marker['label']= $i;
            $gmap->add_marker($marker);
            $i++;
        }

        $map = $gmap->create_map();

        return view('category.map')->with('map', $map)->with('cat_name',$cat_name);
    }

    public function viewLevel($lev_id){

        $location = Level::find($lev_id);

        return view('level.edit')->with('location',$location);
    }

    public function updateLevel(Request $request){
        $lev= Level::find($request->lev_id);
        $lev->lev_location = $request->lev_location;
        $lev->save();

        $cat_id = DB::table('levels')->where('lev_id','=',$request->lev_id)->value('cat_id');

        return redirect('/levels/'.$cat_id)->with('success', 'Level Updated');
    }
}

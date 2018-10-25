<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use DB;

class refreshCoconuts implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $res;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        DB::table('students')->update([
            'coco1' => 1,
            'coco2' => 1,
            'coco3' => 1
        ]);
        DB::table('coordinates')->update([
            'active' => 0,
            'sequence' => null
        ]);
        $id;
        $id = DB::table('coordinates')->select('id')->get();
        $num = DB::table('coordinates')->count();

        $numbers = range(1,$num);
        shuffle($numbers);
        $ids = array_rand($numbers,3);
        shuffle($ids);


        $x = 0;
        foreach($ids as $i){
            DB::table('coordinates')->where('id',$i+1)->update([
                'active' => 1,
                'sequence' => $x + 1
            ]);

            $loc = DB::table('coordinates')->where('id',$i+1)->value('location');
            $locLL = explode(',', $loc);


            $data[$x] = [
                    'lat' => $locLL[0],
                    'lng' => $locLL[1]
            ];
            $x++;
        }
        // dd($data);
        // return json_encode($data);
        $this->res = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('refresh-coconuts');
    }

    public function broadcastWith(){
        return ['data' => $this->res];
    }
}

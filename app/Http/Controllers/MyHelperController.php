<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use App\Models\Room;
use App\Models\RoomAssignment;
use App\Traits\HttpResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use function Illuminate\Log\log;

class MyHelperController extends Controller
{
    use HttpResponse;
    public static function addPlayerToRoom(Player $player, Event $event)
    {
        
        try {
            //get available room
            $maxRoomSize = config('app.max_room_size');
            $room = Room::where('country', $player->country)
            ->where('event_id', $event->id) //this ensures that players not added to old rooms belonging to old events
            ->where('current_size', '<', $maxRoomSize)
            ->first();
            
            $score_per_level = config('app.score_per_level');
            if (empty($room)) {
                DB::beginTransaction();//Atomicity.this helps ensure that the transaction will be rolled back if any of the queries fail

                //if theres no room available create new room based on country
                $new_room = new Room();
                $new_room->country = $player->country;
                $new_room->current_size = 1;
                $new_room->capacity = $maxRoomSize;
                $new_room->event_id = $event->id;
                $new_room->save();
                
                //assign player to created room
                $roomAssigment = new RoomAssignment();
                $roomAssigment->player_id = $player->id;
                $roomAssigment->room_id = $new_room->id;
                $roomAssigment->event_id = $event->id;
                $roomAssigment->score = $score_per_level;
                $roomAssigment->save();

                DB::commit();

                // RoomAssignment::create([
                //     'player_id' => $player->id,
                //     'room_id' => $new_room->id,
                //     'event_id' => $event->id,
                //     'score' => $score_per_level
                // ]);                    
            }else{
                //assign player to existing  room
                RoomAssignment::create([
                    'player_id' => $player->id,
                    'room_id' => $room->id,
                    'event_id' => $event->id,
                    'score' => $score_per_level
                ]);

                $room->current_size = $room->current_size + 1;
                $room->save();
            }
        } catch (Exception $ex) {
            // log error//add player to room
            DB::rollBack(); //reverse any database transaction
            return HttpResponse::error("Error adding player to room", 500);
        }


        // if (empty($room)) {
        //     $room = new Room();
        //     $room->country = $player->country;
        //     $room->current_size = 1;
        //     $room->capacity = $maxRoomSize;
        //     $room->save();
        // }

        // //add player to room
        // $room->players()->attach($player->id);
    }


    //check if event is active with event id
    public static function isEventActive($event_id)
    {
        $event = Event::find($event_id);
        return $event->is_active === 1;
    }


    //get this weeks current active event
    public static function getCurrentActiveEvent()
    {
        //NOTE VERIFY THIS THAT CARBONS DATE FORMATTING MATCHES WHATS IN DATABASE

        // Get the current week's start and end date
        
        // Query and cache the current active event 60 minutes cashe.
        //caching for 60 minutes with the understanding that there could only be one active event per week
        $currentActiveEvent = Cache::remember('currentActiveEventess', 60, function (){
            $startOfWeek = Carbon::now()->startOfWeek();  // Start of the current week
            $endOfWeek = Carbon::now()->endOfWeek();
            
            return Event::whereBetween('start_date', [$startOfWeek, $endOfWeek])
            ->where('is_active', 1)->first();
        }); 
        
        
        return $currentActiveEvent;
    }


    //get the just end event this will be used to run the reward function
    public static function getJustEndedEvent()
    {
        //NOTE: VERIFY THIS THAT CARBONS DATE FORMATTING MATCHES WHATS IN DATABASE
        $now = Carbon::now();
        $oneWeekAgo = $now->copy()->subWeek();
        $justEndedEvent = Event::where('end_date', '<=', $now)
        ->where('end_date', '>=', $oneWeekAgo) // Within the last week
        ->where('is_active', 1)  
        ->orderBy('end_date', 'desc')  // Get the most recent ended event
        ->first();
            
        return $justEndedEvent ?? [];
    }
}

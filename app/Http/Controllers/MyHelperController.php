<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use App\Models\Room;
use App\Models\RoomAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyHelperController extends Controller
{
    public static function addPlayerToRoom(Player $player, Event $event)
    {
        
        try {
            //get available room
            $maxRoomSize = config('app.max_room_size');
            $room = Room::where('country', $player->country)
            ->where('current_size', '<', $maxRoomSize)
            ->where('status', 'available')
            ->first();
            
            //if theres no room available create new room based on country
            if (empty($room)) {
                $room = new Room();
                $room->country = $player->country;
                $room->current_size = 1;
                $room->capacity = $maxRoomSize;
                $room->save();
                
                //assign player to room
                RoomAssignment::create([
                    'player_id' => $player->id,
                    'room_id' => $room->id,
                    'event_id' => $event->id,
                    'score' => 1
                ]);
                    
            }
        } catch (\Exception $e) {
            // log error//add player to room
        }


        if (empty($room)) {
            $room = new Room();
            $room->country = $player->country;
            $room->current_size = 1;
            $room->capacity = $maxRoomSize;
            $room->save();
        }

        //add player to room
        $room->players()->attach($player->id);
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
        // Get the current week's start and end date
        $startOfWeek = Carbon::now()->startOfWeek();  // Start of the current week
        $endOfWeek = Carbon::now()->endOfWeek();      // End of the current week

        // Query to get rows created within the current week
        $currentActiveEvent = Event::whereBetween('start_date', [$startOfWeek, $endOfWeek])
            ->where('is_active', 1)->first();
        return $currentActiveEvent;
    }
}

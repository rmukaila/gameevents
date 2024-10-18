<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use App\Models\Room;
use App\Models\RoomAssignment;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class RoomAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * tracks the player's level progress and updates the score within the respective room.
     */
    public function levelSuccess(Request $request)
    {

        //HANDLE VALIDATIONS AND TRY CATCH

        $event = MyHelperController::getCurrentActiveEvent();
        $player = Player::find($request->player_id);

        //get player roomAssignment if player is already in a room
        $roomAssignment = RoomAssignment::where('player_id', $player->id)
        ->where('event_id', $event->id)
        ->first();

        //update players score if he is already in a room else create a room for him and add new score
        if (!empty($roomAssignment)) {
            $score_per_level = config('app.score_per_level');
            $roomAssignment->score = $roomAssignment->score + $score_per_level;
            $roomAssignment->save();
        } else {
            MyHelperController::addPlayerToRoom($player, $event);
        }

    }

  
    /**
     * Returns the list of players in a specific room, sorted by their scores in
     * descending order.
     */
    public function EventScoreList(Room $room)
    {

        $event = MyHelperController::getCurrentActiveEvent();
        $roomAssignment = RoomAssignment::where('room_assignments.event_id', $event->id)
        ->where('room_assignments.room_id', $room->id)
        ->join('players', 'room_assignments.player_id', '=', 'players.id')
        ->select('players.name', 'players.id', 'room_assignments.score')
        ->orderBy('room_assignments.score', 'desc')
        ->orderBy('room_assignments.updated_at', 'desc')
        ->get();
        
        return ????????????;
    }

    
    /**
     * Provides a list of all rooms created for the event, along with the total
     * score for each room.
     */
    public function allRoomsScroreList(string $id)
    {

        $event = Event::find($id);
        $allRooms = RoomAssignment::where('event_id', $event->id)
        ->selectRaw('room_assignments.room_id', 'SUM (room_assignments.score) as total_score')
        ->groupBy('room_assignments.room_id')
        ->get();

        return ???????????;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

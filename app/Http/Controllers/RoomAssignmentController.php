<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use App\Models\Room;
use App\Models\RoomAssignment;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use function Laravel\Prompts\select;

class RoomAssignmentController extends Controller
{
    use HttpResponse;

    /**
     * tracks the player's level progress and updates the score within the respective room.
     */
    public function levelSuccess(Request $request)
    {

        //HANDLE VALIDATIONS
        $request->validate([
            'player_id' => 'required|integer',
        ]);
        try {
            
            $event = MyHelperController::getCurrentActiveEvent();
            $player = Player::find($request->player_id);
    
            if (empty($event)) {
                return $this->error('No appropriate event found');
            }
    
            if (empty($player)) {
                return $this->error('Player not found');
            }
    
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
        } catch (Exception $exc) {
            return $this->error("Something went wrong: " . $exc->getMessage());
        }

    }

  
    /**
     * Returns the list of players in a specific room, sorted by their scores in
     * descending order.
     */
    public function EventScoreList($room_id)    
{
        try {
            
            $event = MyHelperController::getCurrentActiveEvent();

            if (empty($event)) {
                return $this->error('No active event found for this week');
            }

            //query and cache for 1 minute
            $roomAssignment = Cache::remember('event_score_list', 1, function () use ($event, $room_id) {
            
                return RoomAssignment::where('room_assignments.event_id', $event->id)
                ->where('room_assignments.room_id', $room_id)
                ->join('players', 'room_assignments.player_id', '=', 'players.id')
                ->select('players.name', 'players.id', 'room_assignments.score')
                ->orderBy('room_assignments.score', 'desc')
                ->orderBy('room_assignments.updated_at', 'desc')
                ->get();
            });            
            return $this->success(['event_score_list' => $roomAssignment, 'room_id' => $room_id]);

        } catch (Exception $exc) {
            return $this->error("Something went wrong: " . $exc->getMessage());
        }
    }

    
    /**
     * Provides a list of all rooms created for the event, along with the total
     * score for each room.
     */
    public function allRoomsScroreList()
    {
        try {
            //code...
            $event = MyHelperController::getCurrentActiveEvent();

            if (empty($event)) {
                return $this->error('No active event found for this week');
            }

            //query and cache for 1 minute
            $allRooms = Cache::remember('event_score_list', 1, function () use ($event) {
            
                return RoomAssignment::where('event_id', $event->id)
                ->selectRaw('room_id, SUM(score) as total_score')
                ->groupBy('room_id')
                ->get();
        });            
            return $this->success(['all_rooms' => $allRooms]);

        } catch (Exception $th) {
            return $this->error("Something went wrong: " . $th->getMessage());
            
        }
    }
}

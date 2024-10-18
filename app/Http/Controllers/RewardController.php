<?php

namespace App\Http\Controllers;

use App\Jobs\InsertRewardsJob;
use App\Models\Event;
use App\Models\Reward;
use App\Models\Room;
use App\Models\RoomAssignment;
use App\Traits\HttpResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    use HttpResponse;
    /**
     * Run once at end of every event to reward players if event is active.
     * this should later be made to be run by a job scheduler in a queue.
     */
    public  function rewardAllPlayers__()
    {
        $endedEvent = MyHelperController::getJustEndedEvent();
        // $endedEvent = MyHelperController::getCurrentActiveEvent();

        if (! empty($endedEvent)) {
        //get all rooms for the event
            $rooms = Room::where('event_id', $endedEvent->id)->get();
            foreach ($rooms as $room) {
                $this->rewardRoom($room->id);
            }

            //deactivate event
            $endedEvent->is_active = false;
            $endedEvent->save();
        }       
    }

    //reward all players
    public function rewardAllPlayers()
    {
        // $now = Carbon::now();
        // $justEndedEvent = Event::where('end_date', '<=', $now)
        // ->where('end_date', '>=', $now->copy()->subWeek())  // Within the last week
        // ->orderBy('end_date', 'desc')  // Get the most recent ended event
        // ->first();
        // return Carbon::now()->copy()->subWeek();
        // $this->rewardAllPlayers__();
        //enqueue job for rewarding playesrs
        InsertRewardsJob::dispatch();

        return $this->success('Player rewarding queued');
    }


    //reward players in a single room
    private function rewardRoom($room_id)
    {
        $rankingCollection = RoomAssignment::where('room_id', $room_id)
        ->orderBy('score', 'desc')
        ->orderBy('updated_at', 'desc')
        ->get();
        
        //loop through first 10 players
        $rankingOfTenCollection = $rankingCollection->take(10); // if lesser than 10 take will simply return all available items without throwing an error or exception
        $preparedReward = [];
        // $rankingOfTenCollection->map(function ($player,$index) {
        foreach ($rankingOfTenCollection as $index => $player) {
        
            $rank = $index + 1;
            
        // Assign rewards based on rank
            if ($rank == 1) {
                $reward = 100;
            } elseif ($rank == 2) {
                $reward = 50;
            } elseif ($rank >= 3 && $rank <= 10) {
                $reward = 20;
            } else {
                $reward = 0; // No reward for players beyond 10th place if any
            }

        $preparedReward[$index] = [
            'rank' => $rank,
            'reward' => $reward,
            'player_id' => $player->player_id,
            'event_id' => $player->event_id,
            'room_id' => $player->room_id,
        ];
    }

    //insert rewards with queueing
    try {
        Reward::insert($preparedReward);
        // InsertRewardsJob::dispatch($preparedReward);
    } catch (Exception $exc) {
        //Log the error here
    }

    }

}

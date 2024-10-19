<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use HttpResponse;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...
            //validate request and make sure dates are of correct type
            $request->validate([
                'name' => 'required',
                'is_active' => 'required|integer|between:0,1',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);

            //to prevent having two active evvents in same week, if request set event active return error
            //return error if theres alreader currently active event
            if ($request->is_active === 1) {
                
                $currentActiveEvent = MyHelperController::getCurrentActiveEvent();
                if (!empty($currentActiveEvent)) {
                    return $this->error('This week already has an active event. Set is_active to 0');
                }
            }

            //create new event
            $event = Event::create($request->all());
            return  $this->success($event);

        } catch (Exception $th) {
            //log this error in the database
            return $this->error("Something went wrong: " . $th->getMessage());  
        }
    }

   

    
}

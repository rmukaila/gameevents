<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    use HttpResponse;
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request and make sure country is small letters
        try {
            $request->validate([
                'name' => 'required',
                'country' => 'required|lowercase',
            ]);
            $player = Player::create($request->all());
            return $this->success(['player' => $player], 'Player created successfully');
        } catch (Exception $th) {
            $this->error("Something went wrong: " . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

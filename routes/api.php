<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\RoomAssignmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//protected routes
Route::group(['middleware'=> ['auth:sanctum']], function(){

});

//unprotected routes
Route::get('/level-success',[RoomAssignmentController::class, 'levelSuccess']);
Route::get('/event-score-list/{room_id}',[RoomAssignmentController::class, 'EventScoreList']);
Route::get('/all-rooms-score-list',[RoomAssignmentController::class, 'allRoomsScroreList']);
Route::get('/get-rewards',[EventController::class, '?????']);
Route::post('/create-event',[EventController::class, 'store']);
Route::post('/create-player',[PlayerController::class, 'store']);
Route::post('/rewar-players',[RewardController::class, 'rewardAllPlayers']);
<?php

use App\Http\Controllers\EventController;
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
Route::post('/level-success',[RoomAssignmentController::class, 'levelSuccess']);
Route::post('/event-score-list/{room_id}',[RoomAssignmentController::class, 'EventScoreList']);
Route::post('/all-rooms-score-list',[RoomAssignmentController::class, 'allRoomsScroreList']);
Route::post('/get-rewards',[EventController::class, '?????']);
Route::post('/create-event',[EventController::class, '?????']);
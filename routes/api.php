<?php

use Illuminate\Support\Facades\Route;
use BamboleeDigital\EventUserManager\Http\Controllers\Api\EventController;

Route::middleware(config('event-user-manager.middleware.api'))->group(function () {
    Route::get('events/past', [EventController::class, 'pastEvents']);
    Route::get('events/future', [EventController::class, 'futureEvents']);
    Route::get('events/status/{status}', [EventController::class, 'eventsByStatus']);
    
    Route::apiResource('events', EventController::class);
    
    Route::post('events/{event}/notes', [EventController::class, 'storeNote']);
    Route::put('events/{event}/notes/{note}', [EventController::class, 'updateNote']);
    Route::delete('events/{event}/notes/{note}', [EventController::class, 'destroyNote']);
});
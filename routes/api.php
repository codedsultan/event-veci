<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::middleware('admin')->group(function () {
    Route::get('/api/users', [UsersController::class, 'index']);
    Route::get('/api/findUsers', [UsersController::class, 'search']);
    Route::delete('/api/users/{id}', [UsersController::class, 'destroy']);

    // Topics Resource Routes
    Route::resource('/api/topics', TopicsController::class);

    // Events Routes
    Route::get('/api/allevents', [EventsController::class, 'allevents']);
    Route::get('/api/eventscount', [EventsController::class, 'eventscount']);
    Route::get('/api/findAllEvents', [EventsController::class, 'admineventsearch']);

    // Ticket Routes
    Route::get('/api/tickets', [TicketController::class, 'index']);
    Route::get('/api/ticketscount', [TicketController::class, 'ticketcount']);
    Route::get('/api/ticketsdelivered', [TicketController::class, 'delivered']);
    Route::delete('/api/ticket/{ticket}', [TicketController::class, 'destroy']);
    Route::get('/api/findtickets', [TicketController::class, 'search']);
    Route::post('/api/ticket/deliver/{ticket}', [TicketController::class, 'deliver']);

    // Dashboard Routes
    Route::get('/api/dashboard', [DashboardController::class, 'index']);
    Route::get('/api/sales', [DashboardController::class, 'sales']);
    Route::get('/api/yearsales', [DashboardController::class, 'yearlysales']);
    Route::get('/api/monthrevenue', [DashboardController::class, 'monthrevenue']);
    Route::get('/api/yearrevenue', [DashboardController::class, 'yearrevenue']);
    Route::get('/api/activities', [DashboardController::class, 'activity']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/events', [EventsController::class ,'events']);

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth\SocialAccountController;
use App\Http\Controllers\DiscussionReplyController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [FrontEndController::class,'index']);
Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home');

//login routes
Route::get('login/{provider}', [SocialAccountController::class,'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialAccountController::class,'handleProviderCallback']);

//profile routes
Route::get('/profile/{user}', [UsersController::class,'show']);

Route::resource('events', EventsController::class);

Route::delete('/profile/{user}/notifications/{notification}', [NotificationsController::class,'destroy']);

Route::get('/profile/{user}/notifications', [NotificationsController::class,'index']);

// reply

Route::get('/events/{event}/replies', 'ReplyController@index');

Route::post('/events/{event}/replies', 'ReplyController@store');

Route::patch('/replies/{reply}', 'ReplyController@update');

Route::delete('/replies/{reply}', 'ReplyController@destroy');
Route::post('/discussion/{reply}', 'DiscussionReplyController@store');
Route::patch('/discussionreply/{discussionreply}', 'DiscussionReplyController@update');
Route::delete('/discussionreply/{discussionreply}', 'DiscussionReplyController@destroy');

Route::prefix('events/{event}')->group(function () {
    Route::get('replies', [ReplyController::class, 'index'])->name('replies.index');
    Route::post('replies', [ReplyController::class, 'store'])->name('replies.store');
});

Route::prefix('replies/{reply}')->group(function () {
    Route::patch('/', [ReplyController::class, 'update'])->name('replies.update');
    Route::delete('/', [ReplyController::class, 'destroy'])->name('replies.destroy');
});

// Group routes related to discussion replies
Route::prefix('discussion')->group(function () {
    Route::post('{reply}', [DiscussionReplyController::class, 'store'])->name('discussionreplies.store');
    Route::prefix('{discussionreply}')->group(function () {
        Route::patch('/', [DiscussionReplyController::class, 'update'])->name('discussionreplies.update');
        Route::delete('/', [DiscussionReplyController::class, 'destroy'])->name('discussionreplies.destroy');
    });
});

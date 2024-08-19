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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home');

//login routes
Route::get('login/{provider}', [SocialAccountController::class,'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialAccountController::class,'handleProviderCallback']);

//profile routes
Route::get('/profile/{user}', [UsersController::class,'show']);


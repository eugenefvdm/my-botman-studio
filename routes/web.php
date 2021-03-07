<?php

use App\Events\NewMessage;
use App\Events\MessagePosted;
use Illuminate\Support\Facades\Log;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bc', function () {
    event(new \App\Events\NewMessage("hello"));
    $reply = "Wow! Tested and it worked.";
    Log::notice("Repling with: \"$reply\"");
    broadcast(new NewMessage($reply))->toOthers();
    return;    
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');

Route::get('/botman/tinker', 'BotManController@tinker');

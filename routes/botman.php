<?php

use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello! How are you?');    
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');

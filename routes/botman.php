<?php

use App\Http\Controllers\BotManController;

use Twilio\Rest\Client;

$botman = resolve('botman');

$botman->hears('help', BotManController::class.'@help');

$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->fallback(function($bot) {    
    ray("in route fallback");
    // BotManController::class . '@test';
    $from="whatsapp:+27823096710";
    ray($bot->getMessage()->getPayload());

    $message = $bot->getMessage()->getPayload()['message'];
    
    sendWhatsAppMessage($message, $from);
        
});

// ray($botman->getMessage());

// $botman->hears('test', BotManController::class.'@test');

// $botman->hears('Hallo', function ($bot) {
//     $bot->reply('Hallo daar! Ag welkom man');    
// });

// $botman->hears('Hi', function ($bot) {
//     $bot->reply('Hello! How are you?');    
// });



function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid            = getenv("TWILIO_SID");
        $auth_token             = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
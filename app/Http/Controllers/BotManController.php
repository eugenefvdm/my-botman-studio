<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;
use App\Conversations\ExampleConversation;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

    public function help(BotMan $bot)
    {
        Log::info("Help was invoked by ");
        Log::debug($bot->getMessage()->getPayload());
        $from="whatsapp:+27823096710";
        ray($bot->getMessage()->getPayload());
        $message = $bot->getMessage()->getPayload()['message'];
        $this->sendWhatsAppMessage("You said: $message", $from);
    }

    public function test(BotMan $bot)
    {
        ray("now in actual fallback");
        $from="whatsapp:+27823096710";
        ray($bot->getMessage()->getPayload());
        $message = $bot->getMessage()()->getPayload()['message'];
        $this->sendWhatsAppMessage("You said: $message", $from);
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid            = getenv("TWILIO_SID");
        $auth_token             = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
}

<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Events\MessagePosted;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

/**
 * https://www.twilio.com/blog/build-whatsapp-chatbot-twilio-whatsapp-api-php-laravel
 */
class WhatsAppController extends Controller
{
    public function listenToReplies(Request $request)
    {
        $from = $request->input('From');
        $body = trim($request->input('Body'));

        ray("Incoming WhatsApp from $from:", $body);
        Log::notice("Incoming $from: \"$body\"");

        switch ($body) {
            case "hi":
            case "hello":
            case "hallo":                                
                event(new \App\Events\NewMessage($body));
                $reply = "Good morning!";
                Log::notice("Replying with: \"$reply\"");
                $this->sendWhatsAppMessage($reply, $from);
                return;
                break;
            case "help":
                event(new \App\Events\NewMessage($body)); // Output user message to front-end
                $reply = "Reply with '1' to speak to an operator, '2' to get more options";
                Log::notice("Replying with: \"$reply\"");
                $this->sendWhatsAppMessage($reply, $from);
                return;
                break;
            case '2' :
                event(new \App\Events\NewMessage($body)); // Output user message to front-end
                $reply = "Type 'usage' to get current usage";
                Log::notice("Replying with: \"$reply\"");
                $this->sendWhatsAppMessage($reply, $from);
                return;
                break;
        }

        Log::notice("Replying with: \"$body\"");
        event(new \App\Events\NewMessage($body));
        
        return;
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
}

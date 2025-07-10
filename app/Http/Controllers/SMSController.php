<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SMSController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'body' => 'required|string',
        ]);

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $messagingServiceSid = env('TWILIO_MESSAGING_SERVICE_SID');

        $twilio = new Client($sid, $token);

        try {
            $message = $twilio->messages->create(
                $request->to, // ← dynamic number from request
                [
                    'messagingServiceSid' => $messagingServiceSid,
                    'body' => $request->body,
                ]
            );

            return response()->json([
                'success' => true,
                'message_sid' => $message->sid,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class user_contact extends Controller
{
    public function sendContactEmail(Request $request)
    {
        // Validate the request
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Send email
            Mail::raw($request->message, function($message) use ($request) {
                $message->from($request->email, $request->firstname . ' ' . $request->lastname)
                        ->to(config('mail.from.address'))
                        ->subject($request->subject);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Your message has been sent successfully!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send message. Please try again later.'
            ], 500);
        }
    }
}
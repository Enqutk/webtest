<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function send(Request $request, $recipient)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::send('emails.contact', $validated, function($mail) use ($validated, $recipient) {
            $mail->to($recipient)
                 ->subject($validated['subject'])
                 ->replyTo($validated['email'], $validated['name']);
        });

        return back()->with('success', 'Your message has been sent!');
    }

}

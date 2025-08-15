<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    protected $contactService;


    public function index()
    {

        return view('contact');
    }

     public function send(Request $request, $recipient)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|numeric',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

       // Send email using HTML template
            Mail::send('emails.contact', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'subject' => $validated['subject'],
                'userMessage' => $validated['message'],
            ], function ($mail) use ($validated, $recipient) {
                $mail->to($recipient)
                    ->subject('New Contact Form Submission: ' . $validated['subject'])
                    ->replyTo($validated['email'], $validated['name']);
            });


        return back()->with('success', 'Your message has been sent!');
    }

}

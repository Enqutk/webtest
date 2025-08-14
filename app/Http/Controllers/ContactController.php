<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ContactService;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        $data = $this->contactService->getContactData();
        return view('contact', compact('data'));
    }

    public function send(Request $request, $recipient = null)
    {
        // Set default recipient if none provided
        if (!$recipient) {
            $recipient = config('mail.from.address', 'contact@veritasafrika.com');
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
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

            // Log successful email
            Log::info('Contact form submitted successfully', [
                'from' => $validated['email'],
                'subject' => $validated['subject']
            ]);

            return back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you soon.');

        } catch (\Exception $e) {
            // Log error
            Log::error('Contact form email failed', [
                'error' => $e->getMessage(),
                'from' => $validated['email']
            ]);

            return back()->with('error', 'Sorry, there was an error sending your message. Please try again or contact us directly.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{


    public function send(Request $request)
{
    $validated = $request->validate([
        'name'    => 'required|string|max:100',
        'from'    => 'required|email|max:255',
        'to'      => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    try {
        Mail::to($validated['to'])
            ->send(new ContactMail(
                $validated['name'],
                $validated['from'],
                $validated['subject'],
                $validated['message']
            ));

        return back()->with('success', 'Email sent successfully!');
    } catch (\Exception $e) {
        // You can log the error for debugging
        // \Log::error('Mail send failed: ' . $e->getMessage());

        return back()->with('error', 'Failed to send email. Please try again later.');
    }
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use App\Models\Smtp;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendBulkMailJob;
use Illuminate\Support\Facades\Artisan;

class ContactController extends Controller
{


    public function home()
    {
        $smtp = Smtp::all();
        return view('welcome', compact('smtp'));
    }


    //     public function send(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name'    => 'required|string|max:100',
    //         'from'    => 'required|email|max:255',
    //         'to'      => 'required',
    //         'subject' => 'required|string|max:255',
    //         'message' => 'required|string|max:5000',
    //     ]);

    //     try {
    //         Mail::to($validated['to'])
    //             ->send(new ContactMail(
    //                 $validated['name'],
    //                 $validated['from'],
    //                 $validated['subject'],
    //                 $validated['message']
    //             ));



    //         return back()->with('success', 'Email sent successfully!');
    //     } catch (\Exception $e) {

    //         return back()->with('error', 'Failed to send email. Please try again later.');
    //     }
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mailer'       => 'required|string',
            'host'         => 'required|string',
            'port'         => 'required|integer',
            'username'     => 'required|string',
            'password'     => 'required|string',
            'encryption'   => 'nullable|string',
            'from_address' => 'required|email',
            'from_name'    => 'required|string',
            'limit'        => 'required|integer'
        ]);

        $smtp = Smtp::create($validated);

        // Store in cache
        storeSmtpInCache($smtp);

        return redirect()->back()->with('success', 'SMTP saved & cached!');
    }




    public function sendBulkMail(Request $request)
    {
        $validated = $request->validate([


            'smtp_id' => 'required|exists:smtps,id',
            'subject' => 'required|string',
            'message' => 'required|string',
            'name' => 'required|string',
            'from' => 'required|email',
            'to' => 'required|string',

        ]);

        // $attachments = [];
        // if ($request->hasFile('attachments')) {
        //     foreach ($request->file('attachments') as $file) {
        //         $attachments[] = $file->getRealPath();
        //     }
        // }
        $smtp = Smtp::find($request->smtp_id);
        if (!$smtp) {
            return;
        }

        // Change mail config dynamically
        config([
            'mail.mailers.smtp.host'       => $smtp->host,
            'mail.mailers.smtp.port'       => $smtp->port,
            'mail.mailers.smtp.encryption' => $smtp->encryption,
            'mail.mailers.smtp.username'   => $smtp->username,
            'mail.mailers.smtp.password'   => $smtp->password,
            'mail.from.address'            => $smtp->from_address,
            'mail.from.name'               => $request->name,
        ]);

        $emails = preg_split('/[\r\n,]+/', $request->to);

        foreach ($emails as $email) {
            $email = trim($email);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                SendBulkMailJob::dispatch(
                    $validated['smtp_id'],
                    $email,

                    $validated['name'],
                    $validated['from'],
                    $validated['subject'],
                    $validated['message'],
                );
            }
        }




        // Artisan::call('queue:work');

        return back()->with('success', 'Emails queued for sending!');
    }
}

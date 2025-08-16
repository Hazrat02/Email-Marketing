<?php

namespace App\Jobs;

use App\Mail\ContactMail;
use App\Models\Smtp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendBulkMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $smtpId;
    protected $to;
    protected $subject;
    protected $body;

    protected $fromName;
    protected $fromEmail;

    public function __construct($smtpId, $to, $fromName, $fromEmail, $subject, $body)
    {


        $this->smtpId = $smtpId;
        $this->to = $to;

        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function handle()
    {
        $smtp = Smtp::find($this->smtpId);
        if (!$smtp) {
            return;
        }
          if ($smtp->limit <= 0) {
        return ;
    }

        // Change mail config dynamically
        config([
            'mail.mailers.smtp.host'       => $smtp->host,
            'mail.mailers.smtp.port'       => $smtp->port,
            'mail.mailers.smtp.encryption' => $smtp->encryption,
            'mail.mailers.smtp.username'   => $smtp->username,
            'mail.mailers.smtp.password'   => $smtp->password,
            'mail.from.address'            => $smtp->from_address,
            'mail.from.name'               => $this->fromName,
        ]);

        try {
            Mail::to($this->to)
                ->send(new ContactMail(
                    $this->fromName,
                    $this->fromEmail,
                    $this->subject,
                    $this->body
                ));

            // ✅ Reduce limit only if mail is sent successfully
            $smtp->decrement('limit');
        } catch (\Exception $e) {
            // You can log the error for debugging
            return;
        }
        app('queue.worker')->stop(0);
    }
}

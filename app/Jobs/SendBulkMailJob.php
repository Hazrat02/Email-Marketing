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
       
        Mail::to($this->to)
            ->send(new ContactMail($this->fromName, $this->fromEmail, $this->subject,$this->body));
    
      app('queue.worker')->stop(0);
    
        }

  
}

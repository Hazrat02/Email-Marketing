<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $fromEmail;
    public $subjectLine;
    public $messageText;

    public function __construct($name, $fromEmail, $subjectLine, $messageText)
    {
        // $this->name = 'hazrat';
        // $this->fromEmail = 'hazratbd80@gmail.com';
        // $this->subjectLine = 'wellcome to our website - hazrat';
        // $this->messageText = 'wellcome to our website - hazrat ali website';
        $this->name = $name;
        $this->fromEmail = $fromEmail;
        $this->subjectLine = $subjectLine;
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->replyTo($this->fromEmail, $this->name)
                    ->view('emails.contact');
    }
}

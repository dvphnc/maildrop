<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $filePath;

    public function __construct($data, $filePath = null)
    {
        $this->data = $data;
        $this->filePath = $filePath;
    }

    public function build()
    {
        $mail = $this->subject('Message from ' . $this->data['name'])
                     ->view('emails.sendmail');

        if ($this->filePath) {
            $mail->attach($this->filePath);
        }

        return $mail;
    }
}
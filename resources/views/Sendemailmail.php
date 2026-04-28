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
    public $originalName;

    public function __construct($data, $filePath = null, $originalName = null)
    {
        $this->data         = $data;
        $this->filePath     = $filePath;
        $this->originalName = $originalName;
    }

    public function build()
    {
        $mail = $this->subject('Message from ' . $this->data['name'])
                     ->view('emails.sendmail');

        if ($this->filePath && $this->originalName) {
            $mail->attach($this->filePath, [
                'as'   => $this->originalName,
                'mime' => mime_content_type($this->filePath),
            ]);
        }

        return $mail;
    }
}
<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject=null;
    public $body=null;
    public $attach=null;
    public $from=null;

    public function __construct($subject, $body, $attach=null, $fromm=null){
        $this->subject  = $subject;
        $this->body     = $body;
        $this->attach   = $attach;
        $this->fromm    = $fromm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $csetting = Setting::where("key", "app_name")->first();
        $app_name = ($csetting) ? $csetting->value : "SimpleERP";
        $mail = $this->subject($this->subject)
            ->markdown('emails.test.mail')
            ->with("subject", $this->subject)
            ->with("app_name", $app_name)
            ->with("body", $this->body);
        if($this->fromm){
            $mail = $mail->from($this->fromm, $app_name);
        }
        if($this->attach and is_array($this->attach)){
            foreach ($this->attach as $attach)
                $mail = $mail->attach(storage_path("app/".$attach));
        }

        return $mail;
    }
}

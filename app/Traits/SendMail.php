<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait SendMail
{

    public function send($receiver, $mailable)
    {
        Mail::to($receiver)->send($mailable);
    }
}

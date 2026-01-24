<?php

namespace App\Events\System;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemError
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $details;

    public function __construct($message, $details = null)
    {
        $this->message = $message;
        $this->details = $details;
    }
}

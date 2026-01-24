<?php

namespace App\Events\Contact;

use App\Models\Contact;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contactName;
    public $deletedBy;

    /**
     * Create a new event instance.
     */
    public function __construct($contactName, $deletedBy = null)
    {
        $this->contactName = $contactName;
        $this->deletedBy = $deletedBy;
    }
}

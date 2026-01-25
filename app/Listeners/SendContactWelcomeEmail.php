<?php

namespace App\Listeners;

use App\Events\Contact\ContactCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendContactWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactCreated $event): void
    {
        $contact = $event->contact;
        $owner = $contact->owner;

        // Check if the owner (creator) is a Commercial
        if ($owner && $owner->isCommercial() && $contact->email) {
            \Illuminate\Support\Facades\Mail::to($contact->email)->send(new \App\Mail\ContactWelcomeMail($contact));
        }
    }
}

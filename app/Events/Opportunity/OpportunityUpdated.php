<?php

namespace App\Events\Opportunity;

use App\Models\Opportunity;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OpportunityUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $opportunity;

    public function __construct(Opportunity $opportunity)
    {
        $this->opportunity = $opportunity;
    }
}

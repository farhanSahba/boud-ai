<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TapLifetimeEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $status;

    public $orderIds;

    public function __construct($status, $orderIds)
    {
        $this->status = $status;
        $this->orderIds = $orderIds;
    }
}

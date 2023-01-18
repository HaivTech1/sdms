<?php

namespace App\Events;

use App\Models\MidTerm;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ResultEvent
{
    use SerializesModels;

    public $result;

    public function __construct(MidTerm $result)
    {
        $this->result = $result;
    }
}

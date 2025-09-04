<?php

namespace App\Jobs;

use App\Services\ExpoPushService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendExpoPushJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messages;

    public function __construct(array $messages)
    {
        $this->messages = $messages;
    }

    public function handle(ExpoPushService $expo)
    {
        if (empty($this->messages)) {
            return;
        }

        try {
            $expo->send($this->messages);
        } catch (\Exception $e) {
            // optionally log the error. Keep it silent to avoid breaking app.
            logger()->error('Expo push send failed: '.$e->getMessage());
        }
    }
}

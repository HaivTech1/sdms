<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExpoPushService;
use App\Models\User;

class SendTestPush extends Command
{
    protected $signature = 'push:send {--user_id=} {--type=*} {title="Test"} {body="Hello from server"}';

    protected $description = 'Send a test Expo push to a user or broadcast to types';

    public function handle(ExpoPushService $expo)
    {
        $userId = $this->option('user_id');
        $types = $this->option('type');
        $title = $this->argument('title') ?? 'Test';
        $body = $this->argument('body') ?? 'Hello from server';

        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error('User not found');
                return 1;
            }

            if (empty($user->device_token)) {
                $this->error('User has no device_token');
                return 1;
            }

            $msg = $expo->makeMessage($user->device_token, $title, $body, []);
            $expo->send([$msg]);
            $this->info('Sent');
            return 0;
        }

        if (!empty($types)) {
            $expo->sendToUserTypes($types, $title, $body, []);
            $this->info('Dispatched broadcast');
            return 0;
        }

        $this->error('Provide --user_id or --type');
        return 1;
    }
}

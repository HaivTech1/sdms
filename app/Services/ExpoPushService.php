<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\User;
use App\Jobs\SendExpoPushJob;

class ExpoPushService
{
    protected $client;
    protected $endpoint = 'https://exp.host/--/api/v2/push/send';

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client(['timeout' => 10]);
    }

    /**
     * Send a batch of messages to Expo push service.
     * Each message should be an array with keys: to, title, body, data
     * Returns the decoded response or throws on HTTP error.
     */
    public function send(array $messages)
    {
        // Expo recommends batching up to 100 messages per request
        $batches = array_chunk($messages, 100);
        $responses = [];

        foreach ($batches as $batch) {
            $payload = $batch;

            $res = $this->client->post($this->endpoint, [
                'json' => $payload,
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-encoding' => 'gzip, deflate'
                ]
            ]);

            $body = (string) $res->getBody();
            $responses[] = json_decode($body, true);
        }

        return $responses;
    }

    /**
     * Build a single message array for Expo
     */
    public function makeMessage(string $to, string $title, string $body, array $data = []) : array
    {
        $message = [
            'to' => $to,
            'title' => $title,
            'body' => $body,
            'data' => $data,
            'sound' => 'default'
        ];

        return $message;
    }

    /**
     * Send a notification to all users of given types (e.g., admins, teachers).
     * This will find users with non-empty device_token and dispatch a job.
     */
    public function sendToUserTypes(array $types, string $title, string $body, array $data = [])
    {
        $users = User::whereIn('type', $types)->whereNotNull('device_token')->where('device_token', '!=', '')->get();

        $messages = [];
        foreach ($users as $u) {
            $messages[] = $this->makeMessage($u->device_token, $title, $body, $data);
        }

        if (!empty($messages)) {
            SendExpoPushJob::dispatch($messages);
        }
    }
}

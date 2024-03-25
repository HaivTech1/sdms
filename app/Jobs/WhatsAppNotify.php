<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Throwable;

class WhatsAppNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $maxExceptions = 2;
    public $timeout = 120;
    public $failOnTimeout = true;
    protected $data;

    public function __construct($data)
    {
        $this->onConnection('database');
        $this->data = $data;
    }

    public function middleware()
    {
        return [
            (new ThrottlesExceptions(2, 1))->backoff(1),
            (new WithoutOverlapping($this->data['receiver']))->releaseAfter(10)
        ];
    }

    public function retryUntil()
    {
        return now()->addMinutes(1);
    }

    public function handle()
    {
        $data = $this->data;
        $receiver = $data['receiver'];
        $message = $data['message'];
        $apiurl = env('IMPRESSION_URL ').'/send/single';
        try {
            $request = [
                'contact'  => $receiver,
                'message'   => $message,
                "device" => ENV('IMPRESSION_SENDER'),
                "token" => ENV('IMPRESSION_TOKEN')
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
            curl_setopt($ch, CURLOPT_URL, $apiurl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response, true);
        } catch (\Exception $e) {
            $this->release(4);
            $res[] = [
                'message' => $e->getMessage(),
            ];
            info(json_encode($res));
        }
    }

    public function failed(Throwable $exception)
    {
        // send error message to a webhook or email
    }
}

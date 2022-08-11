<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class CreateResult implements ShouldQueue
{
    use Dispatchable;

    private $tags;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        array $tags = []
    )
    {
        $this->tags = $tags;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
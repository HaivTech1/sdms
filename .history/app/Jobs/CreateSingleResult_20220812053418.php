<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateSingleResult implements ShouldQueue
{
    use Dispatchable;

    private $author;
    private $period;
    private $term;
    private $grade;
    private $subject;
    private $student;
    private $ca1;
    private $ca2;
    private $ca3;
    private $exam;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
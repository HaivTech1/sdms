<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Result;
use App\Http\Requests\StoreResultRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class CreateResult implements ShouldQueue
{
    use Dispatchable;

    private $author;
    private $period;
    private $term;
    private $grade;
    private $subject;
    private $student;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $author,
        array $period = [],
    )
    {
        $this->period = $period;
    }

    public static function fromRequest(StoreResultRequest $request): self
    {
        return new static(
            $request->period(),
        );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Result
    {
        //
    }
}
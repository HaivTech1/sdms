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
    private $ca1;
    private $ca2;
    private $ca3;
    private $exam;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $author,
        array $period = [],
        array $term = [],
        array $grade = [],
        array $subject = [],
        array $student = [],
        array $ca1 = [],
        array $ca2 = [],
        array $ca3 = [],
        array $exam = [],

    )
    {
        $this->author = $author;
        $this->period = $period;
        $this->term = $term;
        $this->grade = $grade;
        $this->subject = $subject;
        $this->student = $student;
        $this->ca1 = $ca1;
        $this->ca2 = $ca2;
        $this->ca3 = $ca3;
        $this->exam = $exam;
    }

    public static function fromRequest(StoreResultRequest $request): self
    {
        return new static(
            $request->author(),
            $request->period(),
            $request->term(),
            $request->grade(),
            $request->subject(),
            $request->student(),
            $request->ca1(),
            $request->ca2(),
            $request->ca3(),
            $request->exam(),
        );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Result
    {
        foreach ($this->student as $key => $result) {
            
        }
    }
}
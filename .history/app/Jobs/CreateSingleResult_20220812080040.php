<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Result;
use App\Http\Requests\SingleResultRequest;
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
    public function __construct(
        User $author,
        string $period,
        string $term,
        string $grade,
        string $subject,
        string $student,
        ?string $ca1,
        ?string $ca2,
        ?string $ca3,
        ?string $exam
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

    public static function fromRequest(SingleResultRequest $request): self
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
        $result = new Result([
            'period_id'     => $this->period,
            'term_id'       => $this->term,
            'grade_id'      => $this->grade,
            'subject_id'        => $this->subject,
            'student_id'        => $this->student,
            'ca1'       => $this->ca1,
            'ca2'       => $this->ca2,
            'ca3'       => $this->ca3,
            'exam'      => $this->exam,
        ]);

        $result->authoredBy($this->author);
        $result->save();

        return $result; 
    }
}
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
        ?array $subject,
        string $student,
        ?array $ca1,
        ?array $ca2,
        ?array $exam
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
        
        for ($i=0; $i < count($this->subject); $i++) { 
            // dd($this->period);
            $result = new Result([
                'period_id'     => $this->period,
                'term_id'       => $this->term,
                'grade_id'      => $this->grade,
                'subject_id'        => $this->subject[$i],
                'student_id'        => $this->student,
                'ca1'       => $this->ca1[$i],
                'ca2'       => $this->ca2[$i],
                'exam'      => $this->exam[$i],
            ]);

            $result->authoredBy($this->author);
            $result->save();
        }

        return $result; 
    }
}
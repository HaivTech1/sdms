<?php

namespace App\Jobs;

use App\Models\Subject;
use App\Jobs\CreateSubject;
use Illuminate\Bus\Queueable;
use App\Http\Requests\SubjectRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateSubject implements ShouldQueue
{
    use Dispatchable;

    private $title;
    private $grades;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $title,
        array $grades = []
    )
    {
        $this->title = $title;
        $this->grades = $grades;
    }

    public function fromRequest(SubjectRequest $request): self
    {
        return new static(
            $request->title(),
            $request->grades(),
        );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Subject
    {
        $subject = new Subject([
            'title' => $this->title
        ]);
        $subject->save();
        $subject->grades()->sync($this->grades, []);
        return $subject;
    }
}

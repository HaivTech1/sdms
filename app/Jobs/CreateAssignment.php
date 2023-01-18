<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Http\Requests\AssignmentRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateAssignment implements ShouldQueue
{
    use Dispatchable;

    private $author;
    private $title;
    private $content;
    private $grade;
    private $subject;
 
    public function __construct(
        User $author,
        string $title,
        string $content,
        string $grade,
        string $subject,
    )
    {
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->grade = $grade;
        $this->subject = $subject;
    }

    public static function fromRequest(AssignmentRequest $request): self
    {
        return new static(
            $request->author(),
            $request->title(),
            $request->content(),
            $request->grade(),
            $request->subject(),
        );
    }

    public function handle(): Assignment
    {
        $assignment = new Assignment([
            'title' => $this->title,
            'content' => $this->content,
            'grade_id' => $this->grade,
            'subject_id' => $this->subject,
        ]);

        $assignment->authoredBy($this->author);
        $assignment->save();

        return $assignment;
    }
}

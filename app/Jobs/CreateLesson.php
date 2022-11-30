<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Requests\StoreLessonRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateLesson implements ShouldQueue
{
    use Dispatchable;

    private $author;
    private $title;
    private $description;
    private $grade;
    private $subject;
    private $video;

    public function __construct(
        User $author,
        string $title,
        string $description,
        string $grade,
        string $subject,
        ?string $video
    )
    {
        $this->author = $author;
        $this->title = $title;
        $this->description = $description;
        $this->grade = $grade;
        $this->subject = $subject;
        $this->video = $video;
    }

    public static function fromRequest(StoreLessonRequest $request): self
    {
        return new static(
            $request->author(),
            $request->title(),
            $request->description(),
            $request->grade(),
            $request->subject(),
            $request->video(),
        );
    }

    public function handle(): Lesson
    {
        $lesson = new Lesson([
            'title' => $this->title,
            'description' => $this->description,
            'grade_id' => $this->grade,
            'subject_id' => $this->subject,
        ]);
        dd($this->video);


        $fileName = $this->video->getClientOriginalName();
        $filePath = 'videos/' . $fileName;
        $fileMimeType = $this->video->getMimeType(); 
        dd($fileMimeType);
        $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($this->video));

        // File URL to access the video in frontend
        $url = Storage::disk('public')->url($filePath);

        if ($isFileUploaded) {
            $lesson->type = $fileMimeType;
            $lesson->path = $filePath;
            $lesson->save();
        }


        return $lesson;
    }
}

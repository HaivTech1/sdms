<?php

namespace App\Jobs;

use App\Http\Requests\FeeRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateFee implements ShouldQueue
{
    use Dispatchable;

    private $title;
    private $grades

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

    public function fromRequest(FeeRequest $request): self
    {
        return new static(
            $request->title(),
            $request->grades(),
        );
    }

    public function handle(): Fee
    {
        $subject = new Subject([
            'title' => $this->title
        ]);
        $subject->save();
        $subject->grades()->sync($this->grades, []);
        return $subject;
    }
}
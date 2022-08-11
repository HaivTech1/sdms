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

    public static function fromRequest(StoreResultRequest $request): self
    {
        return new static(
            $request->title(),
            $request->description(),
            $request->image(),
            $request->publishedAt(),
            $request->type(),
            $request->photoCreditText(),
            $request->photoCreditLink(),
            $request->author(),
            $request->isCommentable(),
            $request->category(),
            $request->tags(),
        );
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
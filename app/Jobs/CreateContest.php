<?php

namespace App\Jobs;

use App\Models\Contest;
use Illuminate\Bus\Queueable;
use App\Http\Requests\ContestRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateContest implements ShouldQueue
{
    use Dispatchable;

    private $title;
    private $theme;
    private $start;
    private $end;
    private $budget;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $title,
        string $theme,
        string $start,
        string $end,
        string $budget
    )
    {
        $this->title = $title;
        $this->theme = $theme;
        $this->start = $start;
        $this->end = $end;
        $this->budget = $budget;
    }

    public static function fromRequest(ContestRequest $request){
        return new static(
            $request->title(),
            $request->theme(),
            $request->start(),
            $request->end(),
            $request->budget(),
        );
    }
    
    public function handle(): Contest
    {
        $contest = new Contest([
            'title'             => $this->title,
            'theme'              => $this->theme,
            'start'              => $this->start,
            'end'              => $this->end,
            'budget'           => $this->budget
        ]);

        $contest->save();
        return $contest;
    }
}
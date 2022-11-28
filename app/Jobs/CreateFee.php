<?php

namespace App\Jobs;

use App\Models\Fee;
use App\Models\User;
use App\Http\Requests\FeeRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateFee implements ShouldQueue
{
    use Dispatchable;

    private $author;
    private $title;
    private $price;
    private $grade;
    private $term;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $author,
        string $title,
        int $price,
        int $grade,
        int $term,
    )
    {
        $this->author = $author;
        $this->title = $title;
        $this->price = $price;
        $this->grade = $grade;
        $this->term = $term;
    }

    public static function fromRequest(FeeRequest $request): self
    {
        return new static(
            $request->author(),
            $request->title(),
            $request->price(),
            $request->grade(),
            $request->term(),

        );
    }

    public function handle(): Fee
    {
        $fee = new Fee([
            'title' => $this->title,
            'price' => $this->price,
            'grade_id' => $this->grade,
            'term_id' => $this->term,
        ]);
        $fee->authoredBy($this->author);
        $fee->save();
        return $fee;
    }
}
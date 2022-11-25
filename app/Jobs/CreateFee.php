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
    private $grades;
    private $term;
    private $period;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $author,
        string $title,
        int $price,
        array $grades = [],
        int $term,
        int $period,
    )
    {
        $this->author = $author;
        $this->title = $title;
        $this->price = $price;
        $this->grades = $grades;
        $this->term = $term;
        $this->period = $period;
    }

    public static function fromRequest(FeeRequest $request): self
    {
        return new static(
            $request->author(),
            $request->title(),
            $request->price(),
            $request->grades(),
            $request->term(),
            $request->period(),

        );
    }

    public function handle(): Fee
    {
        $fee = new Fee([
            'title' => $this->title,
            'price' => $this->price,
            'term_id' => $this->term,
            'period_id' => $this->period,
        ]);
        $fee->authoredBy($this->author);
        $fee->save();
        $fee->grades()->sync($this->grades, []);
        return $fee;
    }
}
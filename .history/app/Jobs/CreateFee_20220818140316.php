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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $author,
        string $title,
        int $price,
        array $grades = []
    )
    {
        $this->author = $author;
        $this->title = $title;
        $this->price = $price;
        $this->grades = $grades;
    }

    public function fromRequest(FeeRequest $request): self
    {
        return new static(
            $request->author(),
            $request->title(),
            $request->price(),
            $request->grades(),
        );
    }

    public function handle(): Fee
    {
        $fee = new Fee([
            'title' => $this->title,
            'price' => $this->price,
        ]);
        $fee->authorBy($this->author);
        $fee->save();
        $fee->grades()->sync($this->grades, []);
        

        return $fee;
    }
}
<?php

namespace App\Jobs;

use App\Models\Fee;
use App\Http\Requests\FeeRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateFee implements ShouldQueue
{
    use Dispatchable;

    private $title;
    private $price;
    private $grades;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $title,
        int $price,
        array $grades = []
    )
    {
        $this->title = $title;
        $this->price = $price;
        $this->grades = $grades;
    }

    public function fromRequest(FeeRequest $request): self
    {
        return new static(
            $request->title(),
            $request->price(),
            $request->grades(),
        );
    }

    public function handle(): Fee
    {
        $fee = new Fee([
            'title' => $this->title,
            'price' => $this->price
        ]);
        $fee->save();
        $fee->grades()->sync($this->grades, []);
        $fee->authorBy($this->author);
        return $fee;
    }
}
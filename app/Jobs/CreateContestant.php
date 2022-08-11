<?php

namespace App\Jobs;

use App\Models\Contest;
use App\Models\Contestant;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Http\Requests\ContestantRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Requests\StoreContestantRequest;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateContestant implements ShouldQueue
{
    use Dispatchable;

    private $name;
    private $email;
    private $mobile_no;
    private $dob;
    private $state;
    private $height;
    private $waist;
    private $description;
    private $image;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $email,
        string $mobile_no,
        string $dob,
        string $state,
        string $height,
        string $waist,
        string $description,
        array $image = [],
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobile_no = $mobile_no;
        $this->dob = $dob;
        $this->state = $state;
        $this->height = $height;
        $this->waist = $waist;
        $this->description = $description;
        $this->image = $image;
    }

    public static function fromRequest(ContestantRequest $request): self
    {
        return new static(
            $request->name(),
            $request->email(),
            $request->mobile_no(),
            $request->dob(),
            $request->state(),
            $request->height(),
            $request->waist(),
            $request->description(),
            $request->image(),
        );

    }
    
    public function handle(): Contestant
    {

        $contest = Contest::where('isAvailable', true)->first();
        
        $contestant = new contestant([
            'name' => $this->name,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'dob' => $this->dob,
            'state' => $this->state,
            'height' => $this->height,
            'waist' => $this->waist,
            'description' => $this->description,
            'contest_id'        => $contest->id(),
        ]);
                
        if($this->image)
        {
            foreach($this->image as $file)
            {
                $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
                $path = storage_path('app/public/contestants/') ;
                $file->move($path, $name);
                $Imgdata[] = $name;
            }
        }
        else
        {
            $Imgdata = 'noimg';
        }

        $contestant->image = json_encode($Imgdata);

        $contestant->save();

        return $contestant;
    }
}
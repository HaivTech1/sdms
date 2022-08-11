<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PropertyRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\SaveImageServiceMultiple;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateProperty implements ShouldQueue
{
    use Dispatchable;
    
    private $title;
    private $price;
    private $built;
    private $bedroom;
    private $bathroom;
    private $category;
    private $purpose;
    private $address;
    private $latitude;
    private $longitude;
    private $frequency;
    private $description;
    private $furnish;
    private $fence;
    private $wifi;
    private $park;
    private $conditioning;
    private $pool;
    private $tiles;
    private $image;
    private $video;
    private $author;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $title,
        string $price,
        string $built,
        string $bedroom,
        string $bathroom,
        string $category,
        string $purpose,
        string $address,
        ?string $latitude,
        ?string $longitude,
        string $frequency,
        string $description,
        bool $furnish,
        bool $fence,
        bool $wifi,
        bool $park,
        bool $conditioning,
        bool $pool,
        bool $tiles,
        array $image = [],
        ?string $video,
        User $author

    )
    {
        $this->title = $title;
        $this->price = $price;
        $this->built = $built;
        $this->bedroom = $bedroom;
        $this->bathroom = $bathroom;
        $this->category = $category;
        $this->purpose = $purpose;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->frequency = $frequency;
        $this->description = $description;
        $this->furnish = $furnish;
        $this->fence = $fence;
        $this->wifi = $wifi;
        $this->park = $park;
        $this->conditioning = $conditioning;
        $this->pool = $pool;
        $this->tiles = $tiles;
        $this->image = $image;
        $this->video = $video;
        $this->author = $author;
    }

    public static function fromRequest(PropertyRequest $request): self
    {
        return new static(
            $request->title(),
            $request->price(),
            $request->built(),
            $request->bedroom(),
            $request->bathroom(),
            $request->category(),
            $request->purpose(),
            $request->address(),
            $request->latitude(),
            $request->longitude(),
            $request->frequency(),
            $request->description(),
            $request->furnish(),
            $request->fence(),
            $request->wifi(),
            $request->park(),
            $request->conditioning(),
            $request->pool(),
            $request->tiles(),
            $request->image(),
            $request->video(),
            $request->author()
        );
    }
    
    public function handle(): Property
    {
        $property = new Property([
            'title' => $this->title,
            'price' => $this->price,
            'built' => $this->built,
            'purpose' => $this->purpose,
            'frequency' => $this->frequency,
            'bedroom' => $this->bedroom,
            'bathroom' => $this->bathroom,
            'address' => $this->address,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'property_category_id' => $this->category,
            'description' => $this->description,
            'furnish' => $this->furnish ? true : false,
            'fence' => $this->fence ? true : false,
            'pool' => $this->pool ? true : false,
            'wifi' => $this->wifi ? true : false,
            'conditioning' => $this->conditioning ? true : false,
            'tiles' => $this->tiles ? true : false,
            'park' => $this->park ? true : false,
        ]);

       
        $property->authoredBy($this->author);


        if($this->image)
        {
            foreach($this->image as $file)
            {
                $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
                $path = storage_path('app/public/properties/') ;
                $file->move($path, $name);
                $Imgdata[] = $name;
            }
        }
        else
        {
            $Imgdata = 'noimg';
        }

        $property->image = json_encode($Imgdata);

        $property->save();

        return $property;
    }
}
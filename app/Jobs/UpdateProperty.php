<?php

namespace App\Jobs;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use App\Http\Requests\PropertyRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\SaveImageServiceMultiple;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateProperty implements ShouldQueue
{
    use Dispatchable;

    private $property;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        Property $property,
        string $title,
        string $price,
        ?string $built,
        ?string $bedroom,
        ?string $bathroom,
        string $category,
        string $purpose,
        ?string $address,
        ?string $latitude,
        ?string $longitude,
        ?string $frequency,
        string $description,
        bool $furnish,
        bool $fence,
        bool $wifi,
        bool $park,
        bool $conditioning,
        bool $pool,
        bool $tiles,
        ?array $image = [],
        ?string $video
    )
    {
        $this->property = $property;
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
    }

    public static function fromRequest(Property $property, PropertyRequest $request): self
    {
        return new static(
            $property,
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
            
        );
    }
    
    public function handle(): Property
    {
        $this->property->update([
            'title'                     => $this->title,
            'price'                     => $this->price,
            'built'                     => $this->built,
            'bedroom'                   => $this->bedroom,
            'bathroom'                  => $this->bathroom,
            'property_category_id'      => $this->category,
            'purpose'                   => $this->purpose,
            'address'                   => $this->address,
            'latitude'                  => $this->latitude,
            'longitude'                 => $this->longitude,
            'frequency'                 => $this->frequency,
            'description'               => $this->description,
            'furnish'                   => $this->furnish ? true : false,
            'fence'                     => $this->fence ? true : false,
            'wifi'                      => $this->wifi ? true : false,
            'park'                      => $this->park ? true : false,
            'conditioning'              => $this->conditioning ? true : false,
            'pool'                      => $this->pool ? true : false,
            'tiles'                     => $this->tiles ? true : false,
        ]);

        if(!is_null($this->image))
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
        
        return $this->property;
    }
}
<?php

namespace App\Repositories;

use App\Models\Property;
use App\Events\PropertyCreated;
use Illuminate\Support\Facades\DB;
use App\Services\SaveImageServiceMultiple;

class PropertyRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            
            $property = Property::query()->create([
                'title'                     => data_get($attributes, 'title'),
                'price'                     => data_get($attributes, 'price'),
                'built'                     => data_get($attributes, 'built'),
                'bedroom'                   => data_get($attributes, 'bedroom'),
                'bathroom'                  => data_get($attributes, 'bathroom'),
                'property_category_id'      => data_get($attributes, 'property_category_id'),
                'purpose'                   => data_get($attributes, 'purpose'),
                'address'                   => data_get($attributes, 'address'),
                'latitude'                  => data_get($attributes, 'latitude'),
                'longitude'                 => data_get($attributes, 'longitude'),
                'frequency'                 => data_get($attributes, 'frequency'),
                'description'               => data_get($attributes, 'description'),
                'fence'                     => data_get($attributes, 'fence') ? true : false,
                'furnish'                   => data_get($attributes, 'furnish') ? true : false,
                'tiles'                     => data_get($attributes, 'tiles') ? true : false,
                'pool'                      =>  data_get($attributes, 'pool') ? true : false,
                'conditioning'              => data_get($attributes, 'conditioning') ? true : false,
                'park'                      =>  data_get($attributes, 'park') ? true : false,
                'wifi'                      => data_get($attributes, 'wifi') ? true : false,
                'video'                     => data_get($attributes, 'video'),
                'author_id'                 => auth()->id(),
            ]);      
                return $property;
            });
    }

    public function update($model, array $attributes)
    {
        
    }

    public function forceDelete($model)
    {
        
    }
}
<?php

namespace App\Http\Resources\v1;

use App\Models\Term;
use App\Models\Period;
use App\Http\Resources\v1\TermResource;
use App\Http\Resources\v1\SessionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => application('name'),
            'alias' => application('alias'),
            'motto' => application('motto'),
            'slogan' => application('slogan'),
            'address' => application('address'),
            'phone_number' => application('line1'),
            'website' => application('website'),
            'term' => new TermResource(Term::where('status', true)->first()),
            'session' => new SessionResource(Period::where('status', true)->first()),
        ];
    }
}

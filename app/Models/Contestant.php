<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contestant extends Model
{
    use HasFactory;
    use HasUuid;

    const TABLE = 'contestants';

    protected $table = self::TABLE;

    protected $fillable = [
       'uuid',
       'name', 
       'email', 
       'dob', 
       'state', 
       'mobile_no', 
       'image', 
       'height', 
       'waist', 
       'description',
       'contest_id'
    ];

    
    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }

    public function name(): string
    {
        return (string) $this->name;
    }

    public function email(): string
    {
        return (string) $this->email;
    }

    public function state(): string
    {
        return (string) $this->state;
    }

    public function mobile(): string
    {
        return (string) $this->mobile_no;
    }

    public function height(): string
    {
        return (string) $this->height;
    }

    public function waist(): string
    {
        return (string) $this->waist;
    }

    public function image(): array
    {
        return json_decode($this->image, true);
    }

    public function description(): string
    {
        return (string) $this->description;
    }
    
    public function excerpt (int $limit = 100): string
    {
        return Str::limit(strip_tags($this->description()) , $limit);
    }

    public function dob(): string
    {
        return (string) $this->dob->format('M, d Y');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('name', 'like', $term)
                    ->orWhere('uuid', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->inRandomOrder()
            ->paginate($count);
    }

}
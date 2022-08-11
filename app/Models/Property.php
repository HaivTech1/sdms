<?php

namespace App\Models;

use App\Cast\TitleCast;
use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use App\Traits\HasReviews;
use Illuminate\Support\Str;
use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;
    use HasAuthor;
    use ModelHelpers;
    use HasUuid;

    const TABLE = 'properties';
    protected $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'price',
        'built',
        'bedroom',
        'bathroom',
        'purpose',
        'address',
        'latitude',
        'longitude',
        'frequency',
        'description',
        'fence',
        'pool',
        'wifi',
        'park',
        'conditioning',
        'tiles',
        'furnish',
        'laundry',
        'isAvailable',
        'isVerified',
        'image',
        'video',
        'property_category_id',
        'author_id',
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $casts = [
        'title'  =>  TitleCast::class,
        'frequency'  =>  TitleCast::class,
        'built' => 'datetime',
        'laundry' => 'boolean',
        'fence'         => 'boolean',
        'pool'          => 'boolean',
        'wifi'          => 'boolean',
        'park'          => 'boolean',
        'conditioning'          => 'boolean',
        'tiles'         => 'boolean',
        'furnish'           => 'boolean',
        'isAvailable'  => 'boolean',
        'isVerified'  => 'boolean',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'property_uuid');
    }

    public function reviewCount()
    {
        return $this->reviews->count();
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category_id');
    }

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function price(): string
    {
        return $this->price;
    }

    public function excerpt(int $limit = 250): string
    {
        return Str::limit(strip_tags($this->description()), $limit);
    }

    public function description(): string
    {
        return $this->description;
    }

    public function createdAt()
    {
        return $this->created_at->format('M, d Y');
    }

    public function purpose(): string
    {
        return $this->purpose;
    }

    public function frequency(): string
    {
        return $this->frequency;
    }

    public function built(): string
    {
        return $this->built->format('Y');
    }

    public function bedroom(): ?string
    {
        return $this->bedroom;
    }

    public function bathroom(): ?string
    {
        return $this->bathroom;
    }

    public function address(): ?string
    {
        return $this->address;
    }

    public function latitude(): ?string
    {
        return $this->latitude;
    }

    public function longitude(): ?string
    {
        return $this->longitude;
    }

    public function image(): array
    {
        return json_decode($this->image, true);
    }

    public function video(): ?string
    {
        return $this->video;
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function laundry(): bool
    {
        return $this->laundry;
    }

    public function fence(): ?bool
    {
        return $this->fence;
    }

    public function tiles(): bool
    {
        return $this->tiles;
    }

    public function furnish(): bool
    {
        return $this->furnish;
    }

    public function pool(): bool
    {
        return $this->pool;
    }

    public function wifi(): bool
    {
        return $this->wifi;
    }

    public function conditioning(): bool
    {
        return $this->conditioning;
    }

    public function park(): bool
    {
        return $this->park;
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('isVerified', true);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('isAvailable', true);
    }

    public function scopeSearchResults($query)
    {
        return $query->verified()->available()
            ->when(request()->filled('search'), function($query) {
                $query->where(function($query) {
                    $search = request()->input('search');
                    $query->where('title', 'LIKE', "%$search%");    
                });
            })
            ->when(request()->filled('bedroom'), function($query) {
                $query->where('bedroom', request()->input('bedroom'));
            })
            ->when(request()->filled('bathroom'), function($query) {
                $query->where('bathroom', request()->input('bathroom'));
            })
            ->when(request()->filled('frequency'), function($query) {
                $query->where('frequency', request()->input('frequency'));
            })
            ->when(request()->filled('purpose'), function($query) {
                $query->where('purpose', request()->input('purpose'));
            })
            ->when(request()->filled('minPrice') && request()->filled('maxPrice'), function($query) {
                $query->whereBetween('price', [request()->input('minPrice'), request()->input('maxPrice')]);
            })
            ->when(request()->filled('sort'), function($query) {
                $query->orderBy('created_at', request()->input('sort'));
            })
            ->when(request()->filled('categoryExternalID'), function($query) {
                $query->whereHas('category', function($query) {
                    $query->where('id', request()->input('categoryExternalID'));
                });
            });
    }


    public function getVerifyBadgeAttribute()
    {

        $verify = [
            '0' => 'Pending',
            '1' => 'Accepted',
        ];

        return $verify[$this->isVerified];
    }

    public function getAvailableBadgeAttribute()
    {

        $available = [
            '0' => 'Not paid',
            '1' => 'Paid',
        ];

        return $available[$this->isAvailable];
    }
}
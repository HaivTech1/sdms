<?php

namespace App\Models;

use App\Cast\PriceCast;
use App\Cast\TitleCast;
use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use HasUuid;
    use HasAuthor;

    const TABLE = 'products';

    protected $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'title',
        'type',
        'slug',
        'price',
        'discount',
        'brand',
        'qty',
        'image',
        'description',
        'product_category_id',
        'isAvailable',
        'isVerified',
        'author_id'
    ];

    protected $casts = [
        'title' => TitleCast::class,
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function price(): string
    {
        return $this->price;
    }

    public function discount(): ?string
    {
        return $this->discount;
    }

    public function brand(): string
    {
        return $this->brand;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function quantity(): string
    {
        return $this->qty;
    }

    public function image(): ?array
    {
        return json_decode($this->image,true);
    }    

    public function description(): ?string
    {
        return $this->description;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function excerpt(int $limit = 250): string
    {
        return Str::limit(strip_tags($this->description()), $limit);
    }


    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->latest()
            ->paginate($count);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('isVerified', true);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('isAvailable', true);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('uuid', 'like', $term);
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

        $verify = [
            '0' => 'Not Available',
            '1' => 'Available',
        ];

        return $verify[$this->isAvailable];
    }

    public function getRouteKeyName()
    {
        return 'slug';
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
            ->when(request()->filled('minPrice') && request()->filled('maxPrice'), function($query) {
                $query->whereBetween('price', [request()->input('minPrice'), request()->input('maxPrice')]);
            })
            ->when(request()->filled('sort'), function($query) {
                $query->orderBy('created_at', request()->input('sort'));
            })
            ->when(request()->filled('type'), function($query) {
                $query->where('type', request()->input('type'));
            })
            ->when(request()->filled('categoryExternalID'), function($query) {
                $query->whereHas('category', function($query) {
                    $query->where('id', request()->input('categoryExternalID'));
                });
            });
    }

}
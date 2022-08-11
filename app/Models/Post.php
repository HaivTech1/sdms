<?php

namespace App\Models;

use App\Cast\TitleCast;
use App\Traits\HasTags;
use App\Traits\HasUuid;
use App\Traits\HasLikes;
use App\Traits\HasAuthor;
use App\Traits\HasComments;
use Illuminate\Support\Str;
use App\Contracts\CommentAble;
use Illuminate\Support\Strppo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model implements CommentAble
{
    use HasTags;
    use HasLikes;
    use HasFactory;
    use HasAuthor;
    use HasUuid;
    use HasComments;

    const STANDARD = 'standard';
    const PREMIUM = 'premium';
    
    const TABLE = 'posts';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'description',
        'is_commentable',
        'image',
        'published_at',
        'type',
        'author_id',
        'photo_credit_text',
        'photo_credit_link',
        'post_category_id',
        'isAvailable',
        'isVerified',
    ];

     //eagerload with relationship
     protected $with = [
        'tagsRelation', 'authorRelation', 'commentsRelation', 'category'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'title' => TitleCast::class,
        'description' => TitleCast::class,
        'is_commentable' => 'boolean',
        'isAvailable' => 'boolean',
        'isVerified' => 'boolean',
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

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

    public function PhotoCreditText(): ?string
    {
        return $this->photo_credit_text;
    }

    public function PhotoCreditLink(): ?string
    {
        return $this->photo_credit_link;
    }

     public function description(): string
    {
        return $this->description;
    }

    public function publishedAt(): string
    {
        return $this->published_at->format('d F Y');
    }

    public function type(): string
    {
        return $this->type;
    }

    public function getCreatedDateAttribute()
    {
        return $this->published_at->format('M, d Y');
    }

    public function image(): string
    {
        return $this->image;
    }

    public function isCommentable(): bool
    {
        return $this->is_commentable;
    }


    public function excerpt (int $limit = 250): string
    {
        return Str::limit(strip_tags($this->description()) , $limit);
    }

    public function scopeForTag(Builder $query, string $tag): Builder
    {
        return $query->published()
            ->verified()
            ->whereHas('tagsRelation', function ($query) use ($tag) {
            $query->where('tags.slug', $tag);
        });
    }

    public function commentType(): string
    {
        return 'posts';
    }

    public function commentAbleTitle(): string
    {
        return $this->title();
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('isVerified', true);
    }
    
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('isAvailable', true);
    }

    public function isPremium(): bool
    {
        return $this->type() == 'premium';
    }

    public function readTime()
    {
        $minutes = round(str_word_count(strip_tags($this->description())) / 200);

        return  $minutes == 0 ? 1 : $minutes;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function delete()
    {
        $this->removeTags();
        parent::delete();
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->whereNotNull('published_at')
            ->inRandomOrder()
            ->paginate($count);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', new \DateTime());
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('title', 'like', $term)
                    ->orWhere('uuid', 'like', $term);
        });
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}
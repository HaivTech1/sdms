<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasComments;
use App\Contracts\CommentAble;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model implements Viewable, CommentAble
{
    use HasFactory,  HasAuthor, InteractsWithViews, HasComments;

    const TABLE = 'assignments';
    protected $table = self::TABLE;

    protected $fillable = [
        'title',
        'grad_id',
        'subject_id',
        'grade_id',
        'content',
        'type',
        'path',
        'status',
        'author_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function cover(): string
    {
        return (string) $this->cover;
    }

    public function transcript(): string
    {
        return (string) $this->transcript;
    }

    public function video(): string
    {
        return (string) $this->path;
    }

    public function createdAt()
    {
        return $this->created_at->format('M, d Y');
    }

    public function verification(): bool
    {
        return (bool) $this->status;
    }

    public function getVerifyBadgeAttribute()
    {

        $verify = [
            '0' => 'Pending',
            '1' => 'Accepted',
        ];

        return $verify[$this->status];
    }

    public function type(): string
    {
        return $this->type;
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('title', 'like', $term)
            ->orWhere('description', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4, $orderBy, $sortBy)
    {
        return $query->orderBy($orderBy, $sortBy)
        ->paginate($count);
    }

    public function isCommentable(): bool
    {
        return $this->is_commentable;
    }

    
    public function commentAbleTitle(): string
    {
        return $this->title();
    }
}

<?php

namespace App\Models;

use App\Cast\TitleCast;
use App\Traits\HasAuthor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Mpociot\Teamwork\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    use UsedByTeams;
    use HasAuthor;

    protected $fillable = [
        'author_id', 
        'team_id', 
        'name',
        'description',
        'start',
        'end',
        'budget',
        'status',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'description' => TitleCast::class,
    ];

    public function id(): string
    {
        return (string) $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function budget(): string
    {
        return $this->budget;
    }

    public function excerpt (int $limit = 250): string
    {
        return Str::limit(strip_tags($this->description()) , $limit);
    }

    public function startDate(): string
    {
        return $this->start->format('d F Y');
    }

    public function endDate(): string
    {
        return $this->end->format('d F Y');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('name', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->latest()
            ->paginate($count);
    }

    public function scopeWaiting(Builder $query, $count = 4)
    {
        return $query->where('status', 0)->paginate($count);
    }

    public function scopeApproved(Builder $query, $count = 4)
    {
        return $query->where('status', 1)->paginate($count);
    }

    public function scopeCompleted(Builder $query, $count = 4)
    {
        return $query->where('status', 2)->paginate($count);
    }

    public function getStatusBadgeAttribute()
    {

        $verify = [
            '0' => 'Waiting',
            '1' => 'Approved',
            '2' => 'Completed',
        ];

        return $verify[$this->status];
    }
}
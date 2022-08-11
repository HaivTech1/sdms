<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use HasUuid;

    const TABLE = 'students';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'other_name',
        'gender',
        'dob',
        'nationality',
        'state_of_origin',
        'local_government',
        'address',
        'prev_school',
        'prev_class',
        'image',
        'medical_history',
        'allergics',
        'image',
        'grade_id',
        'status',
    ];

    protected $casts = [
        'dob' => 'datetime',
        'status' => 'boolean',
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function firstName(): string
    {
        return (string) $this->first_name;
    }

    public function lastName(): string
    {
        return (string) $this->last_name;
    }

    public function otherName(): string
    {
        return (string) $this->other_name;
    }

    public function gender(): string
    {
        return (string) $this->gender;
    }

    public function dob(): string
    {
        return (string) $this->dob;
    }

    public function nationality(): string
    {
        return (string) $this->nationality;
    }

    public function stateOfOrigin(): string
    {
        return (string) $this->state_of_origin;
    }

    public function localGovernment(): string
    {
        return (string) $this->local_government;
    }

    public function address(): string
    {
        return (string) $this->address;
    }

    public function medical(): string
    {
        return (string) $this->medical_history;
    }

    public function allergics(): string
    {
        return (string) $this->allergics;
    }

    public function image(): string
    {
        return (string) $this->image;
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
    public function guardian(): HasOne
    {
        return $this->hasOne(Guardian::class, 'student_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('first_name', 'like', $term)
            ->orWhere('last_name', 'like', $term)
            ->orWhere('other_name', 'like', $term)
            ->orWhere('uuid', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4, $orderBy, $sortBy)
    {
        return $query->orderBy($orderBy, $sortBy)
        ->paginate($count);
    }

}
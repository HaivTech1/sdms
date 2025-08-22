<?php

namespace App\Models;

use App\Cast\TitleCast;
use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    const TABLE = 'registrations';
    protected $table = self::TABLE;

    protected $fillable = [
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
        'grade_id',
        'religion',
        'denomination',
        'blood_group',
        'genotype',
        'speech_development',
        'sight',
        'status',
        'father_name',
        'father_email',
        'father_phone',
        'father_occupation',
        'father_office_address',
        'mother_name',
        'mother_email',
        'mother_phone',
        'mother_occupation',
        'mother_office_address',
        'guardian_full_name',
        'guardian_email',
        'guardian_phone_number',
        'guardian_occupation',
        'guardian_office_address',
        'guardian_home_address',
        'guardian_relationship',
        'state'
    ];

    protected $casts = [
        'dob' => 'date',
        'status' => 'boolean',
        'first_name' => TitleCast::class,
        'last_name' => TitleCast::class,
        'other_name' => TitleCast::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public function id(): string
    {
        return (string) $this->id;
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

    public function code(): string
    {
        return (string) $this->reg_no;
    }

    public function gender(): string
    {
        return (string) $this->gender;
    }

    public function dob(): string
    {
        return (string) $this->dob->format('d F Y');;
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

    public function prevSchool(): ?string
    {
        return (string) $this->prev_school;
    }

    public function prevClass(): ?string
    {
        return (string) $this->prev_class;
    }

    public function image(): ?string
    {
        return (string) $this->image;
    }

    public function status(): ?bool
    {
        return (bool) $this->status;
    }

    public function state(): ?string
    {
        return (string) $this->state;
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function father(): HasOne
    {
        return $this->hasOne(Father::class);
    }

    public function mother(): HasOne
    {
        return $this->hasOne(Mother::class);
    }

    public function createdAt()
    {
        return $this->created_at->format('M, d Y');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('first_name', 'like', $term)
            ->orWhere('last_name', 'like', $term)
            ->orWhere('other_name', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4, $orderBy, $status, $sortBy)
    {
        return $query->when($status, function($query, $status) {
            return $query->whereStatus($status);
        })
        ->orderBy($orderBy, $sortBy)
        ->paginate($count);
    }
}

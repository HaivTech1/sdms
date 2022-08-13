<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;
    use HasUuid;
    use HasAuthor;

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
        'author_id'
    ];

    protected $casts = [
        'dob' => 'datetime',
        'status' => 'boolean',
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $with = [
        'authorRelation'
    ];

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

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
    
    public function guardian(): HasOne
    {
        return $this->hasOne(Guardian::class, 'student_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'student_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
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
            ->orWhere('other_name', 'like', $term)
            ->orWhere('uuid', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4, $orderBy, $sortBy)
    {
        return $query->orderBy($orderBy, $sortBy)
        ->paginate($count);
    }

    public function totalCA1(): int
    {
        return (int) $this->results->sum('ca1');
    }

    public function totalCA2(): int
    {
        return (int) $this->results->sum('ca2');
    }

    public function totalCA3(): int
    {
        return (int) $this->results->sum('ca3');
    }

    public function totalExam(): int
    {
        return (int) $this->results->sum('exam');
    }

    public function totalSubjects(): int
    {
        return (int) $this->subjects->count();
    }

    public function totalRecordedSubjects(): int
    {
        return (int) $this->results->count();
    }

    public function grandTotal(): int
    {
        return (int) $this->totalCA1() + $this->totalCA2() + $this->totalCA3() + $this->totalExam();
    }

    public function grandTotalObtainable(): int
    {
        return (int) $this->totalSubjects() *  100;
    }

    public function resultPercentage(): int
    {
        return (int) $tipslastmonth =  divnum($this->grandTotal() , $this->grandTotalObtainable()) * 100;
    }

}
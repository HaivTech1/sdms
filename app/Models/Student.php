<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Authenticatable
{
    use HasFactory;
    use HasUuid;
    use HasAuthor;
    use Notifiable;

    protected $guard = 'student';

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
        'house_id',
        'club_id',
        'status',
        'user_id',
        'author_id',
        'religion',
        'denomination',
        'blood_group',
        'genotype',
        'speech_development',
        'sight'
    ];

    protected $casts = [
        'dob' => 'datetime',
        'status' => 'boolean',
    ];

    protected $hidden = [
        'password',
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $with = [
        'authorRelation'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function fullName(): string
    {
        return (string) $this->first_name . ' ' . $this->last_name;
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

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
    
    public function guardian(): HasOne
    {
        return $this->hasOne(Guardian::class, 'student_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'student_id');
    }

    public function primaryResults(): HasMany
    {
        return $this->hasMany(PrimaryResult::class, 'student_id');
    }

    public function midTermResults(): HasMany
    {
        return $this->hasMany(MidTerm::class, 'student_id');
    }

    public function psychomotors(): hasMany
    {
        return $this->hasMany(psychomotor::class);
    }

    public function affectives(): hasMany
    {
        return $this->hasMany(Affective::class);
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

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_uuid');
    }

    public function hasPaid()
    {
        return $this->payments->where('period_id', period('status'))->where('term_id', term('status'));
    }


    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'schedule_students', 'student_uuid', 'schedule_id');
    }

    public function check()
    {
        return $this->hasMany(Check::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leave()
    {
        return $this->hasMany(Leave::class);
    }

}
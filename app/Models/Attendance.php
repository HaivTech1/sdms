<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attendance extends Model
{
    use HasFactory, HasAuthor;
    
    const TABLE = 'attendances';

    protected $table = self::TABLE;

    protected $fillable = [
        'section',
        'date', 
        'grade_id',
        'term_id',
        'period_id',
        'status',
        'author_id',
    ];

    public function id(): string
    {
        return $this->id;
    }

    public function date(): string
    {
        return $this->date;
    }

    public function status(): bool
    {
        return $this->status;
    }

    public function section(): string
    {
        return $this->section;
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'attendance_student', 'attendance_id', 'student_id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function scopeCalendarByRole($query)
    {
        return  $query->when(auth()->user()->isTeacher(), function ($query) {
            $query->where('author_id', auth()->user()->id());
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceStudent extends Model
{
    use HasFactory;
    use SoftDeletes;

    const TABLE = 'attendance_students';

    protected $table = self::TABLE;

    protected $fillable = [
        'period_id',
        'term_id',
        'attendance_id',
        'student_id',
        'grade_id',
        'morning',
        'afternoon',
    ];

    protected $casts = [
        'morning'  => 'boolean',
        'afternoon'  => 'boolean',
    ];

    public function id(): string
    {
        return $this->id;
    }

    public function morning(): ?string
    {
        return (string) $this->morning;
    }

    public function afternoon(): ?string
    {
        return (string) $this->afternoon;
    }

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
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
}
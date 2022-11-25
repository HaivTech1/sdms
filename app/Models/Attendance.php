<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    const TABLE = 'attendances';

    protected $table = self::TABLE;

    protected $fillable = [
        'state', 
        'type', 
        'attendance_time',
        'attendance_date',
        'student_uuid', 
        'student_uuid', 
        'grade_id',
        'term_id',
        'period_id',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function id(): string
    {
        return $this->id;
    }
}

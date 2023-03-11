<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;
    use HasUuid;
    use HasAuthor;
    
    const TABLE = 'results';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'period_id',
        'term_id',
        'grade_id',
        'subject_id',
        'student_id',
        'ca1',
        'ca2',
        'ca3',
        'exam',
        'author_id',
        'published',
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $with = [
        'authorRelation'
    ];

    protected $casts = [
        'published' => 'boolean',
        'ca1' => 'float',
        'ca2' => 'float',
        'ca3' => 'float',
        'pr' => 'float',
        'exam' => 'float',
    ];

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function firstCA()
    {
        return  $this->ca1;
    }

    public function secondCA()
    {
        return  $this->ca2;
    }

    public function thirdCA()
    {
        return  $this->ca2;
    }

    public function exam()
    {
        return  $this->exam;
    }

    public function eTotal()
    {
        return  $this->ca1 + $this->ca2 + $this->ca3 + $this->exam;
    }

    public function createdAt(): string
    {
        return $this->created_at->format('d F Y');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function gradeRemark()
    {
        $currentGrade = $this->eTotal();

        if ($currentGrade >= 70) {
            return 'A';
        }

        if ($currentGrade >= 60) {
            return 'B';
        }

        if ($currentGrade >= 50) {
            return 'C';
        }

        if ($currentGrade >= 45) {
            return 'D';
        }

        if ($currentGrade >= 35) {
            return 'E';
        }

        if ($currentGrade >= 20) {
            return 'F';
        }
    }

    public function remark()
    {
        $currentGrade = $this->eTotal();

        if ($currentGrade >= 70) {
            return 'Distinction';
        }

        if ($currentGrade >= 60) {
            return 'V-Good';
        }

        if ($currentGrade >= 50) {
            return 'Credit';
        }

        if ($currentGrade >= 45) {
            return 'Pass';
        }

        if ($currentGrade >= 35) {
            return 'Poor';
        }

        if ($currentGrade >= 20) {
            return 'Fail';
        }
    }
}
<?php

namespace App\Models;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use App\Models\Subject;
use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrimaryResult extends Model
{
    use HasFactory;
    use HasUuid;
    use HasAuthor;
    
    const TABLE = 'primary_results';

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
        'pr',
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
        'published' => 'boolean'
    ];

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function firstCA(): ?int
    {
        return (int) $this->ca1;
    }

    public function secondCA(): ?int
    {
        return (int) $this->ca2;
    }

    public function thirdCA(): ?int
    {
        return (int) $this->ca2;
    }

    public function project(): ?int
    {
        return (int) $this->pr;
    }

    public function exam(): ?int
    {
        return (int) $this->exam;
    }

    public function eTotal(): int
    {
        return (int) $this->ca1 + $this->ca2 + $this->ca3 + $this->pr + $this->exam;
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

        if ($currentGrade >= 80) {
            return 'A';
        }

        if ($currentGrade >= 70) {
            return 'B';
        }

        if ($currentGrade >= 60) {
            return 'C';
        }

        if ($currentGrade >= 55) {
            return 'D';
        }

        if ($currentGrade >= 45) {
            return 'E';
        }

        if ($currentGrade >= 30) {
            return 'F';
        }
    }

    public function remark()
    {
        $currentGrade = $this->eTotal();

        if ($currentGrade >= 80) {
            return 'EXCELLENT';
        }

        if ($currentGrade >= 70) {
            return 'VERY GOOD';
        }

        if ($currentGrade >= 60) {
            return 'GOOD';
        }

        if ($currentGrade >= 55) {
            return 'PASS';
        }

        if ($currentGrade >= 45) {
            return 'FAIR';
        }

        if ($currentGrade >= 30) {
            return 'FAIL';
        }
    }
}
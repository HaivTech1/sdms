<?php

namespace App\Models;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use App\Models\Subject;
use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use App\Scopes\HasPublishScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrimaryResult extends Model
{
    use HasFactory;
    use HasUuid;
    use HasAuthor;
    use SoftDeletes;
    
    const TABLE = 'primary_results';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'period_id',
        'term_id',
        'grade_id',
        'subject_id',
        'student_id',
        'author_id',
        'published',
        'first_term_cummulative',
        'second_term_cummulative',
        'third_term_cummulative',
        'position_in_class_subject',
        'position_in_grade_subject',
    ];

    public function getFillable()
    {
        $fillable = $this->fillable;

        $examFormat = get_settings('exam_format');
        if (is_array($examFormat)) {
            $dynamicKeys = array_keys($examFormat);
            $fillable = array_merge($fillable, $dynamicKeys);
        }

        $midtermFormat = get_settings('midterm_format');
        if (is_array($midtermFormat)) {
            $dynamicKeys = array_keys($midtermFormat);
            $fillable = array_merge($fillable, $dynamicKeys);
        }

        return $fillable;
    }

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $with = [
        'authorRelation',
        'subject'
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HasPublishScope);
    }

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function total(): ?float
    {
        $midtermFormat = get_settings('midterm_format');
        $sum = 0;

        if (is_array($midtermFormat)) {
            foreach ($midtermFormat as $key => $value) {
                if (isset($this->$key)) {
                    $sum += $this->$key;
                }
            }
        }

        return $sum;
    }

    public function getTotalScore(){
        $midtermFormat = get_settings('midterm_format');
        $examFormat = get_settings('exam_format');

        $total = 0;

        foreach ($midtermFormat as $key => $value) {
            if (isset($this->$key)) {
                $total += $this->$key;
            }
        }

        foreach ($examFormat as $key => $value) {
            if (isset($this->$key)) {
                $total += $this->$key;
            }
        }

        return $total;
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
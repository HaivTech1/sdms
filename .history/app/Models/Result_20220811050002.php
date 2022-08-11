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
        'author_id'
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function firstCA(): int
    {
        return (int) $this->ca1;
    }

    public function secondCA(): int
    {
        return (int) $this->ca2;
    }

    public function thirdCA(): int
    {
        return (int) $this->ca2;
    }

    public function exam(): int
    {
        return (int) $this->exam;
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
        return $this->belongsTo(Student::class);
    }
}
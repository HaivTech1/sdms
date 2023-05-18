<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MidTerm extends Model
{
    use HasFactory;
    use HasUuid;
    use HasAuthor;
    
    const TABLE = 'mid_terms';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'period_id',
        'term_id',
        'grade_id',
        'subject_id',
        'student_id',
        'entry_1',
        'entry_2',
        'first_test',
        'ca',
        'class_activity',
        'project',
        'author_id',
        'published'
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $with = [
        'authorRelation'
    ];

    protected $casts = [
        'published' => 'boolean',
        'entry_1' => 'float',
        'entry_2' => 'float',
        'first_test' => 'float',
        'ca' => 'float',
        'class_activity' => 'float',
        'project' => 'float',
    ];

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function entry1(): ?float
    {
        return  $this->entry_1;
    }

    public function entry2(): ?float
    {
        return  $this->entry_2;
    }

    public function firstTest(): ?float
    {
        return  $this->first_test;
    }

    public function ca(): ?float
    {
        return  $this->ca;
    }

    public function classActivity(): ?float
    {
        return  $this->class_activity;
    }

    public function project(): ?float
    {
        return  $this->project;
    }

    public function total(): ?float
    {
        return  $this->entry1() + $this->entry2() + $this->firstTest() + $this->ca() + $this->project();
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
}

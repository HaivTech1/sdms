<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasAuthor;
use App\Scopes\HasPublishScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MidTerm extends Model
{
    use HasFactory;
    use HasUuid;
    use HasAuthor;
    use SoftDeletes;
    
    const TABLE = 'mid_terms';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'period_id',
        'term_id',
        'grade_id',
        'subject_id',
        'student_id',
        'author_id',
        'published'
    ];

    public function getFillable()
    {
        $fillable = $this->fillable;

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
        'authorRelation'
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
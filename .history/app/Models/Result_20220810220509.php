<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;
    use HasUuid;
    
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
        'exam'
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }
}
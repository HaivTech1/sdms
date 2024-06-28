<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TermSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'term_id',
        'period_id',
        'resumption_date',
        'vacation_date',
        'no_school_opened',
        'next_term_resumption'
    ];

    protected $casts = [
        'resumption_date' => 'date',
        'vacation_date' => 'date',
        'next_term_resumption' => 'date',
    ];

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }
}

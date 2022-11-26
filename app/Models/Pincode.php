<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pincode extends Model
{
    use HasFactory;
    use HasAuthor;

    const TABLE = 'pincodes';
    protected $table = self::TABLE;

    protected $fillable = [
        'code', 
        'count',
        'status',
        'student_id',
        'term_id',
        'period_id',
        'author_id',
    ];

    protected $casts = [
        'status'  => 'boolean', 
    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function user(): BelongsTo
    {
       return $this->belongsTo(User::class, 'student_id');
    }

    public function code(): ?string
    {
        return (string) $this->code;
    }

    public function usedTimes(): ?int
    {
        return (int) $this->count;
    }
}

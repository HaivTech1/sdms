<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    const TABLE = 'payments';

    protected $table = self::TABLE;

    protected $fillable = [
        'period_id',
        'term_id',
        'student_uuid',
        'amount',
        'balance',
        'payable',
        'type',
        'status'
    ];

    protected $casts = [
        'status'  => 'boolean', 
    ];

    public function id(): string
    {
        return $this->id;
    }

    public function status(): bool
    {
        return $this->status;
    }

    public function amount(): int
    {
        return (int) $this->amount;
    }

    public function balance(): ?int
    {
        return (int) $this->balance;
    }

    public function payable(): ?int
    {
        return (int) $this->payable;
    }

    public function type(): int
    {
        return (int) $this->type;
    }

    public function students(): BelongsTo
    {
        return $this->belongsToMany(Student::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
}
<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, HasAuthor;

    const TABLE = 'payments';

    protected $table = self::TABLE;

    protected $fillable = [
        'period_id',
        'term_id',
        'student_uuid',
        'paid_by',
        'amount',
        'balance',
        'payable',
        'type',
        'status',
        'author_id'
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

    public function paidBy(): string
    {
        return (string) $this->paid_by;
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

    public function type(): string
    {
        return (string) $this->type;
    }

    public function createdAt()
    {
        return $this->created_at->format('d-m-Y');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_uuid');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->paginate($count);
    }
}
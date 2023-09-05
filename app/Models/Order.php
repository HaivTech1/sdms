<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, HasAuthor;

    const TABLE = 'orders';
    protected $table = self::TABLE;

    protected $fillable = [
        'user_id',
        'items',
        'paid',
        'trxref',
        'status'
    ];

    protected $casts = [
        'items' => 'array',
    ];


    public function id(): string
    {
        return (string) $this->id;
    }

    public function paid(): int
    {
        return (int) $this->paid;
    }

    public function ref(): string
    {
        return (string) $this->trxref;
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getOrderStatusAttribute()
    {

        $status = [
            '1' => 'Pending',
            '2' => 'Processing',
            '3' => 'Delivered',
        ];
        return $status[$this->status];
    }
}
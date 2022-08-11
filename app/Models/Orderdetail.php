<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Orderdetail extends Model
{
    use HasFactory;
    use HasTimestamps;

    const TABLE = 'order_details';
    protected $table = self::TABLE;

    protected $fillable = [
        'order_id',
        'product_uuid',
        'tracking_code',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function price(): string
    {
        return $this->price;
    }

    public function trackingCode(): ?string
    {
        return $this->tracking_code;
    }

    public function createdAt(): string
    {
        return $this->created_at->format('d F Y');
    }

}
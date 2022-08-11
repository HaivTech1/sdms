<?php

namespace App\Models;

use App\Models\Status;
use App\Traits\HasAuthor;
use App\Models\OrderDetail;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use HasTimestamps;
    use HasAuthor;

    const TABLE = 'orders';
    protected $table = self::TABLE;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'orderItems',
        'shippingAddress',
        'total',
        'taxPrice',
        'totalPrice',
        'shippingPrice',
        'paymentMethod',
        'isPaid',
        'isDelivered',
        'paidAt',
        'deliveredAt',
        'paymentResult',
        'author_id'
    ];


    protected $casts = [

        'isPaid'               => 'boolean',
        'isDelivered'          => 'boolean',
    ];
    
    public function id(): string
    {
        return $this->uuid;
    }

    public function items(): array
    {
        return json_decode($this->orderItems, true);
    }

    public function shippingAddress(): array
    {
        return json_decode($this->shippingAddress, true);
    }

    public function tax(): string
    {
        return $this->taxPrice;
    }

    public function total(): string
    {
        return $this->total;
    }

    public function grandTotal(): string
    {
        return $this->totalPrice;
    }

    public function shipping(): string
    {
        return $this->shippingPrice;
    }

    public function payment(): string
    {
        return $this->paymentMethod;
    }

    public function createdAt(): string
    {
        return $this->created_at->format('d F Y');
    }

    public function paid(): bool
    {
        return $this->isPaid;
    }

    public function delivered(): bool
    {
        return $this->isDelivered;
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->inRandomOrder()
            ->paginate($count);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('uuid', 'like', $term);
        });
    }
}
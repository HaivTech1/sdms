<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    const TABLE = 'carts';
    protected $table = self::TABLE;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeDetail extends Model
{
    use HasFactory;

    const TABLE = 'fee_details';

    protected $table = self::TABLE;

    protected $fillable = [
        'fee_id',
        'title', 
        'price', 
    ];


    public function id(): string
    {
        return  (string) $this->id;
    }

    public function title(): string
    {
        return (string) $this->title;
    }

    public function price(): int
    {
        return (int) $this->price;
    }

    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

}

<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payslip extends Model
{
    use HasFactory, HasAuthor;


    protected $fillable = [
        'worker_id',
        'items',
        'month',
        'year',
        'author_id'
    ];

    protected $casts = [
        'items' => 'array',
    ];

    
    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id');
    }
}

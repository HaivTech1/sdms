<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Father extends Model
{
    use HasFactory;

    const TABLE = 'fathers';

    protected $table = self::TABLE;

    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'occupation',
        'office_address',
        'student_id'
    ];


    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
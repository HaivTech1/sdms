<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use HasUuid;

    const TABLE = 'students';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'other_name',
        'sex',
        'first_name',
        'grade_id'
        'isAvailable',
        'isVerified',
    ];
}

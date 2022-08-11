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
        'gender',
        'dob',
        'nationality',
        'state_of_origin',
        'local_government',
        'address',
        'image',
        'grade_id'
        'isAvailable',
        'isVerified',
    ];

    protected $casts = [
        'dob' => 'datetime',
        'is_commentable' => 'boolean',
        'isAvailable' => 'boolean',
        'isVerified' => 'boolean',
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function id(): string
    {
        return (string) $this->uuid;
    }

}

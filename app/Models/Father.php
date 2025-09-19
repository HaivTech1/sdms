<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Father extends Authenticatable
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
        'student_uuid'
    ];

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function fullName(): string
    {
        return (string) $this->name;
    }

    public function email(): ?string
    {
        return (string) $this->email;
    }

    public function phoneNumber(): string
    {
        return (string) $this->phone;
    }

    public function occupation(): ?string
    {
        return (string) $this->occupation;
    }

    public function officeAddress(): ?string
    {
        return (string) $this->office_address;
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_uuid');
    }
}

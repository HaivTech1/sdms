<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardian extends Model
{
    use HasFactory;
    use HasUuid;

    const TABLE = 'guardians';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'full_name',
        'email',
        'phone_number',
        'occupation',
        'office_address',
        'home_address',
        'relationship',
        'student_uuid'
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function fullName(): string
    {
        return (string) $this->full_name;
    }

    public function email(): string
    {
        return (string) $this->email;
    }

    public function phoneNumber(): string
    {
        return (string) $this->phone_number;
    }

    public function occupation(): string
    {
        return (string) $this->occupation;
    }

    public function officeAddress(): string
    {
        return (string) $this->office_address;
    }

    public function homeAddress(): string
    {
        return (string) $this->home_address;
    }

    public function relationship(): string
    {
        return (string) $this->relationship;
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('full_name', 'like', $term)
            ->orWhere('phone_number', 'like', $term)
            ->orWhere('email', 'like', $term)
            ->orWhere('uuid', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->paginate($count);
    }
}
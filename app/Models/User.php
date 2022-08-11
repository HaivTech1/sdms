<?php

namespace App\Models;

use App\Traits\HasPoints;
use App\Traits\HasFollows;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use UserHasTeams; 
    use HasPoints;
    use HasFollows;

    const TABLE = 'users';
    protected $table = self::TABLE;

    const SUPERADMIN = 1;
    const ADMIN = 2;
    const STAFF = 3;
    const STUDENT = 4;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'google_id', 'type', 'isAvailable'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isAvailable' => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'author_id');
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function image(): string
    {
        return $this->profile_photo_path;
    }

    public function type(): int
    {
        return (int) $this->type;
    }

    public function isSuperAdmin(): bool
    {
        return $this->type() === self::SUPERADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->type() === self::ADMIN;
    }

    public function isStaff(): bool
    {
        return $this->type() === self::STAFF;
    }

    public function isStudent(): bool
    {
        return $this->type() === self::STUDENT;
    }


    public function getAvailableBadgeAttribute()
    {

        $verify = [
            '0' => 'Not Available',
            '1' => 'Available',
        ];

        return $verify[$this->isAvailable];
    }

    public function scopeLoad(Builder $query, $count = 5)
    {
        return $query->inRandomOrder()
            ->paginate($count);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('name', 'like', $term);
        });
    }

    public function getUserTypeAttribute()
    {

        $state = [
            '1' => 'Administrator',
            '2' => 'Manager',
            '3' => 'Writer',
            '4' => 'Agent',
            '5' => 'Default',
        ];

        return $state[$this->type];
    }
}
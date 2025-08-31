<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDaily extends Model
{
    use HasFactory;
    use HasAuthor;

    protected $fillable = [
        'period_id',
        'term_id',
        'type',
        'user_id',
        'date', 
        'am_check_in_at',
        'pm_check_out_at',
        'am_status',
        'pm_status',
        'author_id',
        'note',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'am_check_in_at' => 'datetime',
        'pm_check_out_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'am_check_in_at',
        'pm_check_out_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Attendance types
    public const TYPE_STUDENT = 'student';
    public const TYPE_STAFF = 'staff';

    public function isStudent(): bool
    {
        return $this->type === self::TYPE_STUDENT;
    }

    public function isStaff(): bool
    {
        return $this->type === self::TYPE_STAFF;
    }

    public function typeLabel(): string
    {
        return $this->type ? ucfirst((string) $this->type) : '';
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}

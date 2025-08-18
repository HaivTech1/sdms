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
        'student_id',
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

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'uuid');
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

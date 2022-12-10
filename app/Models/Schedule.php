<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Schedule extends Model
{
    use HasFactory;

    const TABLE = 'schedules';

    protected $table = self::TABLE;

    protected $fillable = [
        'slug', 
        'time_in', 
        'time_out',
    ];

    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime'
    ];

    public function getTimeInFormatAttribute()
    {
        return Carbon::createFromFormat('H:i:s', $this->attributes['time_in']);
    } 

    public function getTimeOutFormatAttribute()
    {
        return Carbon::createFromFormat('H:i:s', $this->attributes['time_out']);
    } 

    public function id(): string
    {
        return (string) $this->id;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class,  'schedule_students', 'schedule_id', 'student_uuid');
    }
}

<?php

namespace App\Models;

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

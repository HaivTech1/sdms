<?php

namespace App\Models;

use Illuminate\Support\Arr;
use App\Scopes\HasActiveScope;
use App\Scopes\AssignedGradesScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExcludeLastRecordService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Grade extends Model
{
    use HasFactory;

    const TABLE = 'grades';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'status'
    ];

    protected $with = [
     'students'
    ];

    protected $casts = [
        'status'  => 'boolean', 
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
        static::addGlobalScope(new AssignedGradesScope);
        static::addGlobalScope(new ExcludeLastRecordService());
    }

    public static function getAllIdsExceptLast()
    {
        $ids = self::pluck('id')->toArray();
        return Arr::except($ids, count($ids) - 1);
    }

    public function scopeGradeIds($query, $gradeIds)
    {
        return $query->whereIn('id', $gradeIds);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function status(): bool
    {
        return $this->status;
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'grade_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('title', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->paginate($count);
    }

    public function gradeClassTeacher(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'grade_user');
    }

    public function fee(): hasMany
    {
        return $this->hasMany(Fee::class);
    }

    public function SubGrade(): hasMany
    {
        return $this->hasMany(SubGrade::class);
    }
}
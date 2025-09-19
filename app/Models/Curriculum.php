<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuthor;

class Curriculum extends Model
{
    use HasFactory, HasAuthor;

    const TABLE = 'curriculums';
    protected $table = self::TABLE;

    protected $fillable = [
        'name','grade_id','subject_id','period_id','term_id','description','author_id'
    ];

    public function grade() {
        return $this->belongsTo(Grade::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function period() {
        return $this->belongsTo(Period::class);
    }

    public function term() {
        return $this->belongsTo(Term::class);
    }

    public function topics() {
        return $this->hasMany(CurriculumTopic::class);
    }

    public function weeks() {
        return $this->hasManyThrough(Week::class, CurriculumTopic::class);
    }
}


<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cummulative extends Model
{
    use HasFactory;
    use HasAuthor;
    
    const TABLE = 'cummulatives';

    protected $table = self::TABLE;

    protected $fillable = [
        'subject_id', 
        'grade_id',
        'student_uuid', 
        'score', 
        'period_id',
        'term_id',
        'author_id'
    ];

    public function id(): string
    {
        return  (string) $this->id;
    }

    public function score(): int
    {
        return (string) $this->score;
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_uuid');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

}

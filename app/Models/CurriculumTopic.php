<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuthor;

class CurriculumTopic extends Model
{
    use HasFactory;

    use HasAuthor;

    protected $fillable = [
        'curriculum_id','week_id','title','objectives','bloom_level','resources','author_id'
    ];

    public function curriculum() {
        return $this->belongsTo(Curriculum::class);
    }

    public function week() {
        return $this->belongsTo(Week::class);
    }

    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class, 'curriculum_topic_id');
    }
}

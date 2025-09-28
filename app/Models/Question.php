<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasAuthor;

    protected $fillable = [
        'curriculum_id','curriculum_topic_id','author_id','question','options','correct_index','difficulty','bloom_level','explanation','meta'
    ];

    protected $casts = [
        'options' => 'array',
        'meta' => 'array',
    ];

    public function topic()
    {
        return $this->belongsTo(CurriculumTopic::class, 'curriculum_topic_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

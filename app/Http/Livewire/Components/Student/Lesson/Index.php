<?php

namespace App\Http\Livewire\Components\Student\Lesson;

use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $count = 5;
    public $sortBy = 'asc';
    public $orderBy = 'title';
    public $grade;
    public $subject;
    public $search = '';


    protected $queryString = [
        'search' => ['except' => ''],
        'grade' => ['except' => ''],
        'subject' => ['except' => ''],
    ];

    public function getLessonsProperty()
    {
        return Lesson::where('status', 1)
            ->when($this->grade, function($query, $grade) {
                $query->whereHas('grade', function($query) use ($grade){
                $query->where('id', $grade);
                });
            })
            ->when($this->subject, function($query, $subject){
                $query->whereHas('subject', function($query) use ($subject){
                        $query->where('id', $subject);
                 });
            })->search(trim($this->search))->loadLatest($this->count, $this->orderBy, $this->sortBy); 
    }

    public function updatedGrade($grade)
    {
        $this->grade = $grade;
    }

    public function updatedSubject($subject)
    {
        $this->subject = $subject;
    }

    public function render()
    {
        return view('livewire.components.student.lesson.index',[
            'lessons' => $this->lessons,
            'grades' => Grade::all(),
            'subjects' => Subject::all()
        ]);
    }
}

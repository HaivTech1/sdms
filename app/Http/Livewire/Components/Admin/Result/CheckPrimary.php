<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use Livewire\Component;
use App\Models\Cognitive;
use App\Models\Cummulative;
use App\Models\Psychomotor;
use Livewire\WithPagination;
use App\Models\PrimaryResult;
use Illuminate\Support\Facades\DB;
use App\Traits\NotifiableParentsTrait;

class CheckPrimary extends Component
{

    use WithPagination;

    public $count = 10;
    public $period_id;
    public $term_id;
    public $grade_id;

    public $subjects = [];
    public $search = '';
    public $psych = [];
    public $sortBy = 'asc';
    public $orderBy = 'last_name';
    public $result;

    protected $queryString = [
        'period_id' => ['except' => ''],
        'term_id' => ['except' => ''],
        'grade_id' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    public function fetchResult()
    {
        $this->validate([
            'period_id' => ['required'],
            'term_id' => ['required'],
            'grade_id' => ['required'],
        ],[
            'period_id.required' => 'Please select Session',
            'term_id.required' => 'Please select Term',
            'grade_id.required' => 'Please select Class',
        ]);
        
        $this->period_id = $this->period_id;
        $this->term_id = $this->term_id;
        $this->grade_id = $this->grade_id;
    }

    public function getStudentsProperty()
    {
        return Student::when($this->grade_id, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            })
            ->when($this->period_id, function($query, $period){
                $query->whereHas('primaryResults', function($query) use ($period){
                    $query->whereHas('period', function ($query) use ($period){
                        $query->where('id', $period);
                    });
                 });
            })
            ->when($this->term_id, function($query, $term){
                $query->whereHas('primaryResults', function($query) use ($term){
                    $query->whereHas('term', function ($query) use ($term){
                        $query->where('id', $term);
                    });
                });
            });
        })->orderBy('last_name', 'asc')->search(trim($this->search))->loadLatest($this->count, $this->orderBy, $this->sortBy);        
    }

    public function deleteResult($student)
    {
        $this->result = $student;
    }

    public function destroyResult()
    {
        $results = PrimaryResult::where([
            'student_id' => $this->result,
            'period_id' => $this->period_id,
            'term_id' => $this->term_id,
        ])->get();

        foreach($results as $result){
            $result->delete();
        }

        $this->dispatchBrowserEvent('success',[ 'message' => 'Result deleted successfully!']);
        $this->dispatchBrowserEvent('close-modal');
    }

    // public function publishResult()
    // {
        
    //     DB::transaction(function () use ($request) {
    //         $students = Student::whereIn('id', $this->selectedRows)->get();

    //         foreach ($students as $key => $student) {
    //             $results = PrimaryResult::where('student_id', $student->id())->where('term_id', $request->term_id)->where('period_id', $request->period_id)->where('grade_id', $request->grade_id)->get();
    //             $idNumber = $student->user->code();
    //             $password = 'password123';
    //             $name = $student->last_name." ".$student->first_name. " ".$student->other_name;
    //             $message = "<p> $name's examination result is now available on his/her portal. Please visit the school's website on " . application('website') . " to access the result with these credentials: Id Number: ".$idNumber." and password: ".$password." or password1234</p>";
    //             $subject = 'Evaluation Report Sheet';
        
    //             foreach($results as $result){
    //                 $result->update(['published' => true]);
    //             }
                
    //             NotifiableParentsTrait::notifyParents($student, $message, $subject);
        
    //             $check = Cummulative::where('student_uuid', $request->student_id)->where('term_id', $request->term_id)->where('period_id', $request->period_id)->where('grade_id', $request->grade_id)->get();
        
    //             if(count($check) > 0){
    //                 foreach($check as $value){
    //                     $value->delete();
    //                 }

    //                 $cum = array();
    //                 foreach($results as $result){
    //                     $cummulative = new Cummulative([
    //                         'subject_id' => $result['subject_id'],
    //                         'score' => calculateResult($result), 
    //                         'student_uuid' => $result['student_id'], 
    //                         'period_id' => $result['period_id'],
    //                         'term_id' => $result['term_id'], 
    //                         'grade_id' => $result['grade_id'], 
    //                         'author_id' => auth()->id()
    //                     ]);
    //                     $cummulative->save();
    //                 }
    //             }else{
    //                 $cum = array();
    //                 foreach($results as $result){
    //                     $cummulative = new Cummulative([
    //                         'subject_id' => $result['subject_id'],
    //                         'score' => calculateResult($result), 
    //                         'student_uuid' => $result['student_id'], 
    //                         'period_id' => $result['period_id'],
    //                         'term_id' => $result['term_id'], 
    //                         'grade_id' => $result['grade_id'], 
    //                         'author_id' => auth()->id()
    //                     ]);
    //                     $cummulative->save();
    //                 }
            
    //             }
    //         }
    //     });
    // }
    
    public function render()
    {
        $grades = Grade::get();

        return view('livewire.components.admin.result.check-primary',[
            'students' => $this->students,
            'grades' => $grades,
            'periods' => Period::all(),
            'terms' => Term::all(),
            'psychomotors' => Psychomotor::where('term_id', $this->term_id)->where('period_id', $this->period_id)->get(),
            'cognitives' => Cognitive::where('term_id', $this->term_id)->where('period_id', $this->period_id)->get(),
        ]);
    }
}

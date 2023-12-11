<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Week;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use Livewire\Component;
use App\Models\Cognitive;
use App\Models\Cummulative;
use App\Models\PrimaryResult;

class ViewResult extends Component
{
    public $grade_id;
    public $student_id;
    public $period_id;
    public $term_id;

    public $students = [];
    public $sortBy = 'asc';
    public $orderBy = 'last_name';

    public $results = [];
    public $student_data;
    public $period_data;
    public $term_data;
    public $average;
    public $psychomotors;
    public $affectives;
    public $studentAttendance;
    public $aggregate;
    public $gradeStudents;
    public $marksObtained;
    public $markObtainable;

    protected $queryString = [
        'grade_id' => ['except' => ''],
        'student_id' => ['except' => ''],
        'period_id' => ['except' => ''],
        'term_id' => ['except' => ''],
    ];

    public function fetchResult()
    {
        $this->validate([
            'grade_id' => ['required'],
            'student_id' => ['required'],
            'period_id' => ['required'],
            'term_id' => ['required'],
        ],[
            'grade_id.required' => 'Please select Class',
            'student_id.required' => 'Please select Student',
            'period_id.required' => 'Please select Session',
            'term_id.required' => 'Please select Term',
        ]);
        
        $this->grade_id = $this->grade_id;
        $this->student_id = $this->student_id;
        $this->period_id = $this->period_id;
        $this->term_id = $this->term_id;

        $this->getStudentResult($this->grade_id, $this->student_id, $this->period_id, $this->term_id);
    }

    public function updatedGradeId()
    {
       $this->students = Student::where('grade_id', $this->grade_id)->orderBy($this->orderBy)->get()->toArray();
    }

    private function getStudentResult($grade_id, $student_id, $period_id, $term_id)
    {
        $grade = Grade::findOrFail($grade_id);
        $student = Student::findOrFail($student_id);
        $period = Period::findOrFail($period_id);
        $term = Term::findOrFail($term_id);
        
        $psychomotors = $student->psychomotors->where('period_id', $period->id())
        ->where('term_id', $term->id());

        $affectives = $student->affectives->where('period_id', $period->id())
        ->where('term_id', $term->id());

        $studentAttendance = Cognitive::where('period_id', $period->id())
                                        ->where('term_id', $term->id())
                                        ->where('student_uuid', $student->id())->first();

        $first_term = 1;
        $second_term = 2;
        $midtermFormat = get_settings('midterm_format');
        $examFormat = get_settings('exam_format');
        
        $first_term_cumm = Cummulative::where('term_id', $first_term)->where('student_uuid', $student->id())->where('period_id', $period->id)->get();
        $second_term_cumm = Cummulative::where('term_id', $second_term)->where('student_uuid', $student->id())->where('period_id', $period->id)->get();
        $studentResults = $student->primaryResults->where('term_id', $term->id())->where('period_id', $period->id)->toArray();

        $newFirst = array();
        foreach ($first_term_cumm as $key => $value) {
            $newFirst[] = [
                'first_term' => $value->score,
                'subject_id' => $value->subject_id,
                'grade_id' => $value->grade_id,
                'term_id' => $value->term_id,
                'period_id' => $value->period_id,
            ];
        }

        $newSecond = array();
        foreach ($second_term_cumm as $key => $value) {
            $newSecond[] = [
                'second_term' => $value->score,
                'subject_id' => $value->subject_id,
                'grade_id' => $value->grade_id,
                'term_id' => $value->term_id,
                'period_id' => $value->period_id,
            ];
        }

        $newResult = [];
        foreach ($studentResults as $key => $value) {
            $resultItem = [
                'subject_id' => $value['subject']['id'],
                'subject' => $value['subject']['title'],
                'position_in_class_subject' => $value['position_in_class_subject'],
                'position_in_grade_subject' => $value['position_in_grade_subject'],
            ];

            if (is_array($midtermFormat)) {
                foreach ($midtermFormat as $midtermKey => $midtermValue) {
                    if (isset($value[$midtermKey])) {
                        $resultItem[$midtermKey] = $value[$midtermKey];
                    } else {
                        $resultItem[$midtermKey] = "";
                    }
                }
            }

            if (is_array($examFormat)) {
                foreach ($examFormat as $examKey => $examValue) {
                    if (isset($value[$examKey])) {
                        $resultItem[$examKey] = $value[$examKey];
                    } else {
                        $resultItem[$examKey] = "";
                    }
                }
            }

            $newResult[] = $resultItem;
        }

        $firstTermResult = $newResult;
        $secondTermResult = $this->custom_array_merge($newFirst, $newResult);
        $thirdTermResult = $this->custom_array_merge($secondTermResult, $newSecond);

        if($term->id() === '1'){
            $results = $firstTermResult;
        }elseif ($term->id() === '2') {
            $results = $secondTermResult;
        }elseif($term->id() === '3'){
            $results = $thirdTermResult;
        }
        
        $marksObtained = 0;
        $numSubjects = count($results);
        $grand = $numSubjects * 100;

        foreach($results as $result){
            if ($term->id() === '2') {
                $total = calculateResult($result) + $result['first_term'] / 2;
            } elseif ($term->id() === '3') {
                $total = secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2);
            } else {
                $total = calculateResult($result);
            }
            $marksObtained += $total;
        }

        $aggregate = $marksObtained / $grand * 100;

        $studentGrade = get_grade($student->grade->title());
        $gradeStudents = Student::whereHas('grade', function($query) use ($studentGrade){
            $query->where('title', 'like', $studentGrade .'%');
        })->count(); 
        
        
        usort($results, function ($a, $b) {
            $mathematicsEnglish = ['Mathematics', 'English Language'];
    
            if (in_array($a['subject'], $mathematicsEnglish) && !in_array($b['subject'], $mathematicsEnglish)) {
                return -1;
            } elseif (!in_array($a['subject'], $mathematicsEnglish) && in_array($b['subject'], $mathematicsEnglish)) {
                return 1;
            } else {
                return strcmp($a['subject'], $b['subject']);
            }
        });

        $this->results = $results;
        $this->student_data = $student;
        $this->psychomotors = $psychomotors;
        $this->affectives = $affectives;
        $this->period_data = $period;
        $this->term_data = $term;
        $this->gradeStudents = $gradeStudents;
        $this->aggregate = $aggregate;
        $this->studentAttendance = $studentAttendance;
        $this->marksObtained = $marksObtained ;
        $this->markObtainable = $grand;
    }

    private function custom_array_merge($newResult, $newFirst) {
        $result = Array();
        foreach ($newResult as $key_1 => $value_1) {
            foreach ($newFirst as $key_1 => $value_2) {
                if($value_1['subject_id'] ==  $value_2['subject_id']) {
                    $result[] = array_merge($value_1,$value_2);
                }
            }
    
        }
        return $result;
    }

    public function render()
    {
        return view('livewire.components.admin.result.view-result',[
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}
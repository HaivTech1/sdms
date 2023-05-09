<?php

namespace App\Http\Livewire\Components\Admin\Attendance;

use App\Models\Student;
use Livewire\Component;
use App\Models\Attendance;
use Livewire\WithPagination;

class Stat extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
    public $search = '';
    public $session = '';
    public $term = '';
    public $grade = '';
    public $totalStudents;
    public $totalAttendances;

    protected $queryString = [
        'search' => ['except' => ''],
        'session' => ['except' => ''],
        'term' => ['except' => ''],
        'grade' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->attendances->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function fetchStat()
    {
        $this->validate([
            'session' => ['required'],
            'term' => ['required'],
            'grade' => ['required'],
        ],[
            'session.required' => 'Please select session',
            'grade.required' => 'Please select grade',
            'term.required' => 'Please select term',
        ]);

        $this->session = $this->session;
        $this->term = $this->term;
        $this->grade = $this->grade;
    }

    public function getAttendancesProperty()
    {
        $attendanceData = [];

        $attendance = Attendance::when($this->grade, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade) {
                $query->where('id', $grade);
            })
            ->when($this->session, function($query, $session) {
                $query->whereHas('session', function($query) use ($session) {
                    $query->where('id', $session);
                });
            })
            ->when($this->term, function($query, $term) {
                $query->whereHas('term', function($query) use ($term) {
                    $query->where('id', $term);
                });
            });
        })->get();

        $students = Student::where('grade_id', $this->grade)
        ->when($this->search, function ($query, $search) {
            $query->where('last_name', 'like', '%'.$search.'%')
            ->orWhere('first_name', 'like', '%'.$search.'%')
            ->orWhere('other_name', 'like', '%'.$search.'%');
        })->get();

        $this->totalAttendances = $attendance->count();
        $this->totalStudents = $students->count();

        foreach ($students as $student) {
            $presentCount = $student->attendances( function ($query) {
                 $query->where('period_id', $this->session)->where('term_id', $this->term)->where('grade_id', $this->grade);
            })->count();

            $attendanceData[] = [
                'name' => $student->lastName() . ' ' . $student->firstName() . ' ' . $student->otherName(),
                'total_attendance' => $this->totalAttendances,
                'present_count' => $presentCount,
            ];
        }

        return $attendanceData;
    }

    public function render()
    {
        return view('livewire.components.admin.attendance.stat',[
            'attendances' => $this->attendances
        ]);
    }
}

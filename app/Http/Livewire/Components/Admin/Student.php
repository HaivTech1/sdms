<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;
use App\Traits\NotifiableParentsTrait;
use App\Traits\NumberBroadcast;
use App\Models\Student as ClientStudent;

class Student extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
    public $search = '';
    public $gender = '';
    public $sortBy = 'asc';
    public $orderBy = 'last_name';
    public $grade = '';
    public $student_details;
    public $subjects = [];
    public $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'gender' => ['except' => ''],
        'grade' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshData' => 'refresh',
    ];

    public function mount()
    {
        $this->subjects = Subject::orderBy('title')->get();
    }

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->students->pluck('uuid')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function refresh()
    {
        $this->reset();
    }

    public function getStudentsProperty()
    {
        return ClientStudent::withoutGlobalScope(new HasActiveScope)->when($this->grade, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            });
        })
        ->search(trim($this->search))->loadLatest($this->per_page, $this->orderBy, $this->sortBy, $this->status, $this->gender);
    }

    public function deleteAll()
    {
        ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected students
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function activateAll()
    {
        $student = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->update([
            'status' => true,
        ]);


        $this->dispatchBrowserEvent('success', ['message' => 'All selected students
            were activated']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function promoteAll()
    {
        $toBePromoted = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->get();

        foreach ($toBePromoted as $value) {
            $newGrade = $value->grade_id +1;
            $value->update(['grade_id' => $newGrade]);
        }

        $this->dispatchBrowserEvent('success', ['message' => 'All selected students
            were promoted successfully!']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function repeatAll()
    {
        $toBePromoted = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->get();

        foreach ($toBePromoted as $value) {
            $newGrade = $value->grade_id -1;
            $value->update(['grade_id' => $newGrade]);
        }

        $this->dispatchBrowserEvent('success', ['message' => 'All selected students
            were repeated successfully!']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function studentDetails(ClientStudent $student)
    {
        $this->student_details = $student;
        $this->dispatchBrowserEvent('show-details');
    }

    public function sendDetails($student)
    {
        try {
            $student = ClientStudent::withoutGlobalScope(new HasActiveScope)->where('uuid', $student)->first();
            $idNumber = $student->user->code();
            $name = $student->last_name." ".$student->first_name. " ".$student->other_name;
            $message = "<p>Your child: $name login credential is: Id Number: ".$idNumber." and password: password123 or password1234</p>";
            $subject = 'Portal Login Credentials';

            $watMessage = "{business.name}\\{business.address}\\{business.phone_number} \\ \\Your child: $name login credential is: \\ \\*Id Number:* ".$idNumber." \\*Password:* password123 or password1234 \\ \\Kind Regards, \\Management.";
            
            try {
                NotifiableParentsTrait::notifyParents($student, $message, $subject);
            } catch (\Throwable $th) {
                info($th->getMessage());
            }

            try {
                NumberBroadcast::notify($student, $watMessage);
            } catch (\Throwable $th) {
               info($th->getMessage());
            }
            
            $this->dispatchBrowserEvent('success', ['message' => 'Credentials have been sent successfully!']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('error', ['message' => $th->getMessage()]);
        }
    }

    public function sendAllDetails()
    {
        try {
            $students = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->get();
            foreach ($students as $student) {
                $idNumber = $student->user->code();
                $name = $student->last_name." ".$student->first_name. " ".$student->other_name;
                $message = "<p>Your child: $name login credentials are: Id Number: ".$idNumber." and password: password123 or password1234</p>";
                $subject = 'Portal Login Credentials';

                $watMessage = "{business.name}\\{business.address}\\{business.phone_number} \\ \\Your child: $name login credential is: \\ \\*Id Number:* ".$idNumber." \\*Password:* password123 or password1234 \\ \\Kind Regards, \\Management.";
            
                try {
                    NotifiableParentsTrait::notifyParents($student, $message, $subject);
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }

                try {
                    NumberBroadcast::notify($student, $watMessage);
                } catch (\Throwable $th) {
                info($th->getMessage());
                }
            }
            $this->dispatchBrowserEvent('success', ['message' => 'Credentials have been sent successfully!']);
            $this->reset(['selectedRows', 'selectPageRows']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('error', ['message' => $th->getMessage()]);
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function syncRole()
    {
        $students = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->get();
        foreach ($students as $key => $student) {
           $student->user->roles()->sync(5);
        }
        
        $this->dispatchBrowserEvent('success', ['message' => 'Roles Activated successfully!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.student', [
            'students' => $this->students,
            'grades' => Grade::orderBy('title', 'asc')->get(),
            'periods' => Period::all()->pluck('title', 'id'),
            'terms' => Term::all()->pluck('title', 'id'),
        ]);
    }
}
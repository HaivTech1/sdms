<?php

namespace App\Http\Livewire\Manager;

use App\Models\Grade;
use App\Models\Pincode;
use App\Models\Student;
use Livewire\Component;
use App\Services\SaveCode;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class Generate extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $search = '';
    public $students = [];
    public $grade;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->pins->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function loadMore()
    {
        $this->count += 4;
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function getPinsProperty()
    {
        return Pincode::paginate($this->per_page);
    }

    public function updatedGrade($id)
    {
        $this->students = Student::whereGrade_id($id)->get();
    }

    public function generateSinglePin(Student $student)
    {
        $pincode = new Pincode([
            'student_id' => $student->user->id()
        ]);

        $code = SaveCode::GeneratorPin(7, 'code', $pincode);
        $pincode->code = Hash::make($code);
        $pincode->authoredBy(auth()->user());
        $pincode->save();

        $student->user->update(['pincode' => $code]);

        $this->dispatchBrowserEvent('success', ['message' => 'Pin code generated successfully!']);
    }

    public function generatePin()
    {
        $students = Student::whereIn('id', $this->selectedRows)->delete();

        $pincode = new Pincode([
            'student_id' => $student->user->id()
        ]);

        $code = SaveCode::GeneratorPin(7, 'code', $pincode);
        $pincode->code = Hash::make($code);
        $pincode->authoredBy(auth()->user());
        $pincode->save();

        $student->user->update(['pincode' => $code]);

        $this->dispatchBrowserEvent('success', ['message' => 'Pin code generated successfully!']);
    }

   
    public function render()
    {
        return view('livewire.manager.generate',[
            'pins' => $this->pins,
            'grades' => Grade::all()
        ]);
    }
}

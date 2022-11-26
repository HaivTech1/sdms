<?php

namespace App\Http\Livewire\Manager;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
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
            $this->selectedRows = $this->students->pluck('uuid')->map(function ($id) {
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
        $pin = Pincode::where('student_id', $student->user->id())->first();
        $term = Term::whereStatus(1)->select('id')->first();
        $period = Period::whereStatus(1)->select('id')->first();

        if($pin){
            $code = SaveCode::GeneratorPin(7, 'code', $pin);
            $pin->update(['code' => Hash::make($code)]);
            $student->user->update(['pincode' => $code]);
        }else{
            $pincode = new Pincode([
                'student_id' => $student->user->id(),
                'term_id' => $term,
                'period_id' => $period,
            ]);
    
            $code = SaveCode::GeneratorPin(7, 'code', $pincode);
            $pincode->code = Hash::make($code);
            $pincode->authoredBy(auth()->user());
            $pincode->save();
    
            $student->user->update(['pincode' => $code]);
        }

        $this->dispatchBrowserEvent('success', ['message' => 'Pin code generated successfully!']);
    }

    public function regenerateSinglePin(Student $student)
    {
        
        $pin = Pincode::where('student_id', $student->user->id())->first();
        $code = SaveCode::GeneratorPin(7, 'code', $pin);
        $pin->update(['code' => Hash::make($code), 'count' => 0]);
        $student->user->update(['pincode' => $code]);

        $this->dispatchBrowserEvent('success', ['message' => 'Pin code regenerated successfully!']);
    }

    public function generatePin()
    {
        $students = Student::whereIn('uuid', $this->selectedRows)->get();
        $term = Term::whereStatus(1)->select('id')->first();
        $period = Period::whereStatus(1)->select('id')->first();

        foreach ($students as $value) {
            $pincode = new Pincode([
                'student_id' => $value->user->id(),
                'term_id' => $term['id'],
                'period_id' => $period['id'],
            ]);
    
            $code = SaveCode::GeneratorPin(7, 'code', $pincode);
            $pincode->code = Hash::make($code);
            $pincode->authoredBy(auth()->user());
            $pincode->save();
    
            $value->user->update(['pincode' => $code]);
        }

        $this->dispatchBrowserEvent('success', ['message' => 'Pin code generated successfully!']);
        $this->reset();
    }

    public function regeneratePin()
    {
        $students = Student::whereIn('uuid', $this->selectedRows)->get();

        foreach ($students as $value) {
            $pin = Pincode::where('student_id', $value->user->id())->first();
            $code = SaveCode::GeneratorPin(7, 'code', $pin);
            $pin->update(['code' => Hash::make($code), 'count' => 0]);
            $value->user->update(['pincode' => $code]);
        }
        $this->dispatchBrowserEvent('success', ['message' => 'All students pin code regenerated successfully!']);
        $this->reset();
    }

    public function deleteAll()
    {
        $students = Student::whereIn('uuid', $this->selectedRows)->get();

        foreach ($students as $value) {
            Pincode::whereStudent_id($value->user->id())->delete();
            $value->user->update(['pincode' => null ]);
        }

        $this->dispatchBrowserEvent('success', ['message' => 'All selected pins were deleted']);
        $this->reset();
    }
   
    public function render()
    {
        return view('livewire.manager.generate',[
            'pins' => $this->pins,
            'grades' => Grade::all()
        ]);
    }
}

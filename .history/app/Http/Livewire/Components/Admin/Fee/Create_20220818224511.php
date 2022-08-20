<?php

namespace App\Http\Livewire\Components\Admin\Fee;

use App\Models\Grade;
use App\Models\Payment;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;

    public $count; 
    public $selectedRows = [];
    public $selectPageRows = false;
    public $students = []; 
    
    public $grade;
    public $payable;
    public $amount;
    public $balance;
    public $type;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->payments->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }
    
    public function updatedGrade($value)
    {
        $this->students = Student::where('grade_id', $value)->get();
        $getPayable = Grade::where('id', $value)->first();
        $this->payable = $getPayable->fee->sum('price');
    }

    public function updatedAmount($value)
    {
        $this->balance = $this->payable - $value;
    }
    
    public function getPaymentsProperty()
    {
        return Payment::loadLatest($this->count);
    }

    public function render()
    {
        return view('livewire.components.admin.fee.create',[
            'payments' => $this->payments,
            'grades' => Grade::all()
        ]);
    }
}
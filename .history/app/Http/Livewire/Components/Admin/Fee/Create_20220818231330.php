<?php

namespace App\Http\Livewire\Components\Admin\Fee;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
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
    public $period;
    public $term;

    public $grade;
    public $payable;
    public $amount;
    public $balance;
    public $student;
    public $type;
    public $paid_by;

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

    public function createPayment()
    {
       $payment = new Payment([
        'paid_by'  => $this->paid_by,
        'amount'   => $this->amount,
        'balance'   => $this->balance,
        'payable'   => $this->payable,
        'type'   => $this->type,
        'student_uuid' => $this->student
       ]);
       $payment->authoredBy(auth()->user());
       $payment->save();

       $this->reset();
       $this->dispatchBrowserEvent('success', [
           'message'     => 'Payment submitted successfully!',
       ]);
    }

    public function updatedAmount($value)
    {
        $this->balance = $this->payable - $value;
    }
    
    public function getPaymentsProperty()
    {
        return Payment::when($this->period, function($query, $period) {
                    $query->whereHas('period', function($query) use ($period){
                    $query->where('id', $period);
                })
            })
            ->loadLatest($this->count);
    }

    public function render()
    {
        return view('livewire.components.admin.fee.create',[
            'payments' => $this->payments,
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}
<?php

namespace App\Http\Livewire\Components\Admin\Fee;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Payment;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\SaveCodeService;

class Create extends Component
{
    use WithPagination;

    public $count; 
    public $selectedRows = [];
    public $selectPageRows = false;
    public $students = []; 
    public $period;
    public $term;
    public $showBalance = false;

    public $grade;
    public $payable;
    public $amount;
    public $balance;
    public $student;
    public $type;
    public $paid_by;
    public $period_id;
    public $term_id;

    
    public $fields_validation = [
        'paid_by' => 'required',
        'student' => 'required',
        'type' => 'required',
        'amount' => 'required',
        'period_id' => 'required',
        'term_id' => 'required',
    ];

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
        $this->payable = $getPayable->fee->where('status', true)->where('term_id', term('id'))->sum('price');
        $this->amount = $getPayable->fee->where('status', true)->where('term_id', term('id'))->sum('price');
    }

    public function updatedStudent($value)
    {
        $check = Payment::where('student_uuid', $value)->where('period_id', period('id'))->where('term_id', term('id'))->first();
        
        if($check){
            $amount = $check->amount;
            $balance = $check->balance;
            $this->amount = $balance;
        }
    }

    public function updatedAmount($value)
    {
        $check = Payment::where('student_uuid', $this->student)->where('period_id', period('id'))->where('term_id', term('id'))->first();

        if ($check) {
            $this->balance = $check->balance - $value;
        }else{
            $this->balance = $this->payable - $value;
        }

        if ($this->amount != $this->payable) {
            $this->showBalance = true;
        }else{
            $this->showBalance = false;
        }
    }

    public function createPayment()
    {
        $this->validate($this->fields_validation);

        $hasPaid = Student::where('uuid', $this->student)->first();
        // dd($check->hasPaid());
        $check = Payment::where('student_uuid', $this->student)->where('period_id', period('id'))->where('term_id', term('id'))->first();

        // dd($check);

        if ($check && $check->type === 'full') {
            $this->reset();
            $this->dispatchBrowserEvent('info', [
                'message'     => 'This student is not owing for ' .period('title') . ' - ' .term('title'),
            ]);
        } elseif($check && $check->type === 'partial') {
            $current = $check->amount + $this->amount;
            $check->update(['amount' => $current, 'type' => $this->type, 'balance' => $this->balance]);
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message'     => 'Payment updated successfully',
            ]);
        }else{
        
            $payment = new Payment([
             'paid_by'  => $this->paid_by,
             'amount'   => $this->amount,
             'balance'   => $this->balance,
             'payable'   => $this->payable,
             'period_id'   => $this->period_id,
             'term_id'   => $this->term_id,
             'author_id'   => auth()->id(),
             'type'   => $this->type,
             'student_uuid' => $this->student
            ]);

            $payment->trans_id = SaveCodeService::IDGenerator(new Payment(), $payment, 'trans_id', 5, 'TRX');
            $payment->ref_id = SaveCodeService::IDGenerator(new Payment(), $payment, 'ref_id', 7, 'REF');
            $payment->save();
     
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message'     => 'Payment submitted successfully!',
            ]);
        }
    }
    
    public function getPaymentsProperty()
    {
        return Payment::when($this->period, function($query, $period) {
                    $query->whereHas('period', function($query) use ($period){
                    $query->where('id', $period);
                });
            })
                ->when($this->term, function($query, $term) {
                    $query->whereHas('term', function($query) use ($term){
                    $query->where('id', $term);
                });
            })
            ->search(trim($this->search))->loadLatest($this->count);
    }

    public function deleteAll()
    {
        Payment::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected payments
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
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
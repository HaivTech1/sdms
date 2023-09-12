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
    public $category;

    public $grade;
    public $payable;
    public $amount;
    public $description;
    public $balance;
    public $student;
    public $type;
    public $paid_by;
    public $period_id;
    public $grade_id;
    public $term_id;
    public $student_id;
    public $outstanding;
    public $check;
    
    public $fields_validation = [
        'paid_by' => 'required',
        'student' => 'required',
        'type' => 'required',
        'amount' => 'required',
        'period_id' => 'required',
        'term_id' => 'required',
        'description' => 'required',
    ];

    public $outstanding_validation = [
        'grade_id' => 'required',
        'student_id' => 'required',
        'term_id' => 'required',
        'period_id' => 'required',
        'outstanding' => 'required',
    ];

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'term' => ['except' => ''],
        'period' => ['except' => ''],
        'category' => ['except' => ''],
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

    public function updatedGradeId($grade_id)
    {
        $class = Grade::where('id', $grade_id)->first();
        $this->students = $class->students->where('status', true)->sortBy('last_name');
        $this->grade_id = $grade_id;
    }

    public function updatedStudentId($student_id)
    {
        $student = Student::where('uuid', $student_id)->first();
        $this->check = $student;
        $out = $student->outstanding;
        if ($out !== null) {
            $this->term_id = $out['term_id'];
            $this->period_id = $out['period_id'];
            $this->outstanding = $out['outstanding'];
        }
    }

    public function createPayment()
    {
        $this->validate($this->fields_validation);

        $hasPaid = Student::where('uuid', $this->student)->first();
        $check = Payment::where('student_uuid', $this->student)->where('period_id', period('id'))->where('term_id', term('id'))->first();

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
             'initial'  => $this->amount,
             'payable'  => $this->amount,
             'amount'   => $this->amount,
             'balance'   => $this->balance,
             'description'   => $this->description,
             'method' => 'cash',
             'period_id'   => $this->period_id,
             'term_id'   => $this->term_id,
             'author_id'   => auth()->id(),
             'type'   => $this->type,
             'student_uuid' => $this->student
            ]);

            $payment->trans_id = 'TRX'.rand(0000,9999);
            $payment->ref_id = 'REF'.rand(0000,9999);
            $payment->save();
     
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message'     => 'Payment submitted successfully!',
            ]);
        }
    }

    public function addOutstanding()
    {
        $this->validate($this->outstanding_validation);

        $student = Student::where('uuid', $this->student_id)->first();
        $array = [ 
            'grade_id' => $this->grade_id, 
            'student_id' => $this->student_id, 
            'term_id' => $this->term_id, 
            'period_id' => $this->period_id, 
            'outstanding' => $this->outstanding
        ];

        $student->update([
            'outstanding' => $array,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('success', [
            'message'     => 'Outstanding submitted successfully!',
        ]);
    }
    

    public function deleteOutstanding()
    {
        $student = Student::findOrFail($this->student_id);
        $student->update([
            'outstanding' => null,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('success', ['message' => 'Outstanding deleted successfully!']);
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
             ->when($this->category, function($query, $category) {
                    $query->where('payment_category', $category);
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
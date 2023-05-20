<?php

namespace App\Http\Livewire\Components\Admin\Registration;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use App\Services\SaveCode;
use App\Models\Registration;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;
use App\Mail\SendAdmissionMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Traits\NotifiableParentsTrait;

class Index extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
    public $search = '';
    public $gender = '';
    public $sortBy = 'asc';
    public $orderBy = 'created_at';
    public $grade = '';
    public $status = '';
    public $subjects = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'gender' => ['except' => ''],
        'grade' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshData' => 'refresh',
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->registrations->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getRegistrationsProperty()
    {
        return Registration::withoutGlobalScope(new HasActiveScope)->when($this->grade, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            })
            ->when($this->gender, function($query, $gender) {
                return $query->where('gender', $gender);
            });
        })
        ->search(trim($this->search))->loadLatest($this->per_page, $this->orderBy, $this->status, $this->sortBy);
    }

    public function deleteAll()
    {
        Registration::withoutGlobalScope(new HasActiveScope)->whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'All selected registrations were deleted']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function acceptAll()
    {
        try {
            DB::transaction(function(){
                $registrations = Registration::withoutGlobalScope(new HasActiveScope)->whereIn('id', $this->selectedRows)->get();
                foreach ($registrations as $key => $value) {
                    if ($value->update(['status' => true])) {

                            $randomNumbers;

                            for ($i = 0; $i < 4; $i++) {
                                $randomNumbers = rand(0, 9999);
                            }

                            $user = new User([
                                'title' => 'student',
                                'name' => $value->lastName(). ' '. $value->firstName(). ' '. $value->otherName(),
                                'email' => $value->lastName(). $value->firstName().$randomNumbers.'@gmail.com',
                                'phone_number' => '',
                                'password' => Hash::make('password123'),
                                'type' => '4'
                            ]);
                    
                            $code = SaveCode::Generator(application('alias').'/', 4, 'reg_no', $user);
                            $user->reg_no = $code;
                            $user->profile_photo_path = $value->image;
                            $user->save();
                    
                            $student = new Student([
                                'first_name'  => $value->first_name,
                                'last_name'  => $value->last_name,
                                'other_name'  => $value->other_name,
                                'gender'  => $value->gender,
                                'dob'  => $value->dob,
                                'nationality'  => $value->nationality,
                                'state_of_origin'  => $value->state_of_origin,
                                'local_government'  => $value->local_government,
                                'address'  => $value->address,
                                'prev_school'  => $value->prev_school,
                                'prev_class'  => $value->prev_class,
                                'medical_history'  => $value->medical_history,
                                'allergics'  => $value->allergics,
                                'religion'  => $value->religion,
                                'denomination'  => $value->denomination,
                                'blood_group'  => $value->blood_group,
                                'genotype'  => $value->genotype,
                                'speech_development'  => $value->speech_development,
                                'sight'  => $value->sight,
                                'grade_id'  => $value->grade_id,
                                'house_id'  => 1,
                                'club_id'  => 1,
                                'user_id' => $user->id()
                            ]);
            
                            $student->authoredBy(auth()->user());
                            $student->save();

                            if($value->father_name !== null){
                                $father = new Father([
                                    'student_uuid'  => $student->id(),
                                    'name'  => $value->father_name,
                                    'email' =>  $value->father_email,
                                    'phone' =>  $value->father_phone,
                                    'occupation'  => $value->father_occupation,
                                    'office_address' =>  $value->father_office_address,
                                ]);
                                $father->save();
                            }

                            if($value->mother_name !== null){
                                $mother = new Mother([
                                    'student_uuid'  => $student->id(),
                                    'fname'  => $value->mother_name,
                                    'email' =>  $value->mother_email,
                                    'phone' =>  $value->mother_phone,
                                    'occupation'  => $value->mother_occupation,
                                    'office_address' =>  $value->mother_office_address,
                                ]);
                                $mother->save();
                            }

                            if($value->guardian_full_name !== null){
                                $guardian = new Guardian([
                                    'student_id'  => $student->id(),
                                    'full_name'  => $value->guardian_full_name,
                                    'email' =>  $value->guardian_email,
                                    'phone_number' =>  $value->guardian_phone_number,
                                    'occupation'  => $value->guardian_occupation,
                                    'office_address' =>  $value->guardian_office_address,
                                    'home_address' =>  $value->guardian_home_address,
                                    'relationship' =>  $value->guardian_relationship,
                                ]);
                                $guardian->save();
                            }
                            
                            $student->schedules()->sync(1);
                            $message = "<p>
                                We are pleased to inform your that your child: 
                                " . $value->first_name. " " .$value->last_name.
                                " has been granted admission into " .$value->grade->title(). 
                                ". Proceed to the school to make necessary payments so as to retain this admission. 
                                Please hold a copy of your child's birth certificate (photocopy) and/or '
                                Baptisimal Card photocopy (Catholics only) with latest school report (if applicable).'
                                </p>";
                            $subject = 'Admission Status from ' . application('name');

                            NotifiableParentsTrait::notifyParents($student, $message, $subject);

                            // if($value->mother_email !== null){
                            //     Mail::to($value->mother_email)->send(new SendAdmissionMail($message, $subject));
                            // }elseif($value->father_email !== null ){
                            //     Mail::to($value->father_email)->send(new SendAdmissionMail($message, $subject));
                            // }else{
                            //     Mail::to($value->guardian_email)->send(new SendAdmissionMail($message, $subject));
                            // }
            
                    }
                }
            });

            $this->dispatchBrowserEvent('success', ['message' => 'Student admitted successfully!']);
            $this->reset(['selectedRows', 'selectPageRows']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('error', ['message' => $th->getMessage()]);
        }
       
    }

    public function refresh()
    {
        $this->reset();
    }
    
    public function render()
    {
        return view('livewire.components.admin.registration.index', [
            'registrations' => $this->registrations,
            'grades' => Grade::all(),
            'todayRegistrations' => Registration::withoutGlobalScope(new HasActiveScope)->whereDate('created_at', '>=', Carbon::today())->get(),
            'admittedRegistrations' => Registration::withoutGlobalScope(new HasActiveScope)->where('status', true)->get(),
            'unadmittedRegistrations' => Registration::withoutGlobalScope(new HasActiveScope)->where('status', false)->get(),
        ]);
    }
}

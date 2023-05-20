<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Student;
use App\Models\Guardian;
use App\Services\SaveCode;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Scopes\HasActiveScope;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Traits\NotifiableParentsTrait;
use App\Http\Resources\v1\RegistrationResource;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $grade = $request->grade;
        $search = $request->search;

        $registrations = Registration::withoutGlobalScope(new HasActiveScope)->when($grade, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            });
        })
        ->where('status', false)
        ->search(trim($search))->get();
    
        return response()->json(['status' => true, 'registrations' => RegistrationResource::collection($registrations)]);
    }

    public function single($id)
    {
        $registration = Registration::withoutGlobalScope(new HasActiveScope)->findOrFail($id);
        return response()->json(['status' => true, 'registration' => new RegistrationResource($registration)], 200);
    }

    public function activate(Request $request)
    {
       try{

            DB::transaction(function () use ($request) {
                $registrationId = $request->registration_id;
                $status = $request->status;
                $registration = Registration::withoutGlobalScope(new HasActiveScope)->findOrFail($registrationId);
                
                if ($status === true) {
                    $registration->update(['status' => 1]);
                    $randomNumbers;
        
                    for ($i = 0; $i < 4; $i++) {
                        $randomNumbers = rand(0, 9999);
                    }
        
                    $user = new User([
                        'title' => 'student',
                        'name' => $registration->lastName(). ' '. $registration->firstName(). ' '. $registration->otherName(),
                        'email' => $registration->lastName(). $registration->firstName().$randomNumbers.'@gmail.com',
                        'phone_number' => '',
                        'password' => Hash::make('password123'),
                        'type' => '4'
                    ]);
        
                    $code = SaveCode::Generator(application('alias').'/', 4, 'reg_no', $user);
                    $user->reg_no = $code;
                    $user->profile_photo_path = $registration->image;
                    $user->save();
        
                    $student = new Student([
                        'first_name'  => $registration->first_name,
                        'last_name'  => $registration->last_name,
                        'other_name'  => $registration->other_name,
                        'gender'  => $registration->gender,
                        'dob'  => $registration->dob,
                        'nationality'  => $registration->nationality,
                        'state_of_origin'  => $registration->state_of_origin,
                        'local_government'  => $registration->local_government,
                        'address'  => $registration->address,
                        'prev_school'  => $registration->prev_school,
                        'prev_class'  => $registration->prev_class,
                        'medical_history'  => $registration->medical_history,
                        'allergics'  => $registration->allergics,
                        'religion'  => $registration->religion,
                        'denomination'  => $registration->denomination,
                        'blood_group'  => $registration->blood_group,
                        'genotype'  => $registration->genotype,
                        'speech_development'  => $registration->speech_development,
                        'sight'  => $registration->sight,
                        'grade_id'  => $registration->grade_id,
                        'house_id'  => 1,
                        'club_id'  => 1,
                        'user_id' => $user->id()
                    ]);
        
                    $student->authoredBy(auth()->user());
                    $student->save();
        
                    if($registration->father_name !== null){
                        $father = new Father([
                            'student_uuid'  => $student->id(),
                            'name'  => $registration->father_name,
                            'email' =>  $registration->father_email,
                            'phone' =>  $registration->father_phone,
                            'occupation'  => $registration->father_occupation,
                            'office_address' =>  $registration->father_office_address,
                        ]);
                        $father->save();
                    }
        
                    if($registration->mother_name !== null){
                        $mother = new Mother([
                            'student_uuid'  => $student->id(),
                            'name'  => $registration->mother_name,
                            'email' =>  $registration->mother_email,
                            'phone' =>  $registration->mother_phone,
                            'occupation'  => $registration->mother_occupation,
                            'office_address' =>  $registration->mother_office_address,
                        ]);
                        $mother->save();
                    }
        
                    if($registration->guardian_full_name !== null){
                        $guardian = new Guardian([
                            'student_id'  => $student->id(),
                            'full_name'  => $registration->guardian_full_name,
                            'email' =>  $registration->guardian_email,
                            'phone_number' =>  $registration->guardian_phone_number,
                            'occupation'  => $registration->guardian_occupation,
                            'office_address' =>  $registration->guardian_office_address,
                            'home_address' =>  $registration->guardian_home_address,
                            'relationship' =>  $registration->guardian_relationship,
                        ]);
                        $guardian->save();
                    }
                    
                    $student->schedules()->sync(1);
                    $message = "<p>
                        We are pleased to inform your that your child: 
                        " . $registration->last_name. " " .$registration->first_name.
                        " has been granted admission into " .$registration->grade->title(). 
                        ". Proceed to the school to make necessary payments so as to retain this admission. 
                        Please hold a copy of your child's birth certificate (photocopy) and/or '
                        Baptisimal Card photocopy (Catholics only) with latest school report (if applicable).'
                        </p>";
                    $subject = 'Admission Status from ' . application('name');
        
                    NotifiableParentsTrait::notifyParents($student, $message, $subject);
                }else{
                    $registration->update(['status' => 0]);
                }
            });

            return response()->json(['status' => true, 'message' => 'Student Activated successfully!'], 200);

       }catch(Exception $th){
            DB::rollback();
            return response()->json(['status' => true, 'errors' => $th->getMessage()], 500);
       }
    }
}

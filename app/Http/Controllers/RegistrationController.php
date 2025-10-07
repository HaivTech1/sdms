<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Grade,
    Father,
    Mother,
    Student,
    Guardian,
    Registration
};
use App\Services\SaveCode;
use App\Traits\NotifiableParentsTrait;
use Illuminate\Http\Request;
use App\Scopes\HasActiveScope;
use App\Mail\SendAdmissionMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewRegistrationMail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RegistrationRequest;
use Carbon\Carbon;
use PDF;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $gender = $request->query('gender');
        $grade_id = $request->query('grade_id');
        $status = $request->query('status');

        // Start a new query without the global scope
        $query = Registration::withoutGlobalScope(new HasActiveScope)->newQuery();

        // Apply filters based on query parameters
        if (!empty($gender)) {
            $query->where('gender', $gender);
        }

        if (!empty($grade_id)) {
            $query->where('grade_id', $grade_id);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Get the filtered registrations with pagination
        $registrations = $query->orderBy('created_at', 'desc')->paginate(100);

        // Fetch grades and other registration statistics
        $grades = Grade::all();
        $todayRegistrations = Registration::withoutGlobalScope(new HasActiveScope)
            ->whereDate('created_at', Carbon::today())
            ->get();

        $admittedRegistrations = Registration::withoutGlobalScope(new HasActiveScope)
            ->where('status', true)
            ->get();

        $unadmittedRegistrations = Registration::withoutGlobalScope(new HasActiveScope)
            ->where('status', false)
            ->get();

        // Return the view with data
        return view('admin.registration.index', [
            'registrations' => $registrations,
            'grades' => $grades,
            'todayRegistrations' => $todayRegistrations,
            'admittedRegistrations' => $admittedRegistrations,
            'unadmittedRegistrations' => $unadmittedRegistrations
        ]);
    }


    public function show($id)
    {
        $checking = Registration::withoutGlobalScope(new HasActiveScope)->findOrFail($id);
       return view('admin.registration.show', [
        'registration' => $checking
       ]);
    }

    public function store(RegistrationRequest $request)
    {
        try {
            $student = DB::transaction(function () use ($request) {
                $student = new Registration([
                    'first_name'  => $request->first_name,
                    'last_name'  => $request->last_name,
                    'other_name'  => $request->other_name,
                    'gender'  => $request->gender,
                    'dob'  => $request->dob,
                    'nationality'  => $request->nationality,
                    'state_of_origin'  => $request->state_of_origin,
                    'local_government'  => $request->local_government,
                    'address'  => $request->address,
                    'prev_school'  => $request->prev_school,
                    'prev_class'  => $request->prev_class,
                    'medical_history'  => $request->medical_history,
                    'religion'  => $request->religion,
                    'denomination'  => $request->denomination,
                    'blood_group'  => $request->blood_group,
                    'genotype'  => $request->genotype,
                    'speech_development'  => $request->speech_development,
                    'sight'  => $request->sight,
                    'allergics'  => $request->allergics,
                    'grade_id'  => $request->grade_id,
                    'father_name' => $request->father_name,
                    'father_email' => $request->father_email,
                    'father_phone' => $request->father_phone,
                    'father_occupation' => $request->father_occupation,
                    'father_office_address' => $request->father_office_address,
                    'mother_name' => $request->mother_name,
                    'mother_email' => $request->mother_email,
                    'mother_phone' => $request->mother_phone,
                    'mother_office_address' => $request->mother_office_address,
                    'mother_occupation' => $request->mother_occupation,
                    'guardian_full_name'  => $request->guardian_full_name,
                    'guardian_email'  => $request->guardian_email,
                    'guardian_phone_number'  => $request->guardian_phone_number,
                    'guardian_occupation'  => $request->guardian_occupation,
                    'guardian_office_address'  => $request->guardian_office_address,
                    'guardian_home_address'  => $request->guardian_home_address,
                    'guardian_relationship'  => $request->guardian_relationship,
                ]);

                if ($request->hasFile('image')) {
                    $fileName = time() . '-' . $request->image->getClientOriginalName();
                    $filePath = 'registrations/' . $fileName;
                    Storage::disk('public')->put($filePath, file_get_contents($request->image));
                    $student->image = $filePath;
                }

                $student->save();

                // Notify admins
                $message = "<p>A new student registration form has just been completed! Please visit the school's portal for review.</p>";
                $subject = 'New Student Registration';
                $watMessage = "{business.name}\\{business.address}\\{business.phone_number} \\ \\A new student registration form has just been completed! Please visit the school's portal for review.";

                $admins = User::whereType(2)->where('isAvailable', 1)->get();
                foreach ($admins as $admin) {
                    try {
                        Mail::to($admin->email)->send(new SendNewRegistrationMail($message, $subject));
                    } catch (\Throwable $th) {
                        info("Mail error: " . $th->getMessage());
                    }

                    try {
                        sendWaMessage($admin->phone_number, $watMessage);
                    } catch (\Throwable $th) {
                        info("WhatsApp error: " . $th->getMessage());
                    }
                }

                return $student;
            });

            $pdf = Pdf::loadView('generate.registration', ['data' => $student]);
            $pdfPath = 'registrations/registration_' . $student->id . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());
            $pdfUrl = asset('storage/' . $pdfPath);
            
            return response()->json([
                'status' => true,
                'message' => 'Registration completed successfully!',
                'pdf_url' => $pdfUrl,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $registration = Registration::withoutGlobalScope(new HasActiveScope)->whereId($id)->first();
        $registration->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Registration deleted successfully!'
        ], 200);
    }

    public function compare()
    {
        try{

                $registrations = Registration::withoutGlobalScope(new HasActiveScope)->get();
                $students = Student::withoutGlobalScope(new HasActiveScope)->get();

                $newDataArray = [];
                foreach ($registrations as $registration) {
                    $exists = false;
                
                    foreach ($students as $student) {
                        if ($registration->first_name == $student->first_name && $registration->last_name == $student->last_name && $registration->other_name == $student->other_name) {
                            $exists = true;
                            break;
                        }
                    }
                
                    if (!$exists) {
                        $newDataArray[] = $registration;
                    }
                }
                // dd($newDataArray);

            return response()->json([
                'status' => true,
                'data' => $newDataArray,
                'message' => 'The following students have been registered but have not been accepted as students!'
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage()
            ],);
        }
    }

    public function accept($id)
    {
        $registration = Registration::withoutGlobalScope(new HasActiveScope)->where('id', $id)->first();
        
        try {
            if ($registration->update(['status' => true])) {

                $randomNumbers = "";

                for ($i = 0; $i < 4; $i++) {
                    $randomNumbers = rand(0, 9999);
                }

                $user = new User([
                    'title' => 'student',
                    'name' => $registration->lastName(). ' '. $registration->firstName(). ' '. $registration->otherName(),
                    'email' => $registration->lastName(). $registration->firstName().$randomNumbers.'@gmail.com',
                    'phone_number' => '',
                    'password' => Hash::make('password1234'),
                    'type' => '4'
                ]);
        
                $code = SaveCode::Generator(application('alias').'/', 4, 'reg_no', $user);
                $user->reg_no = $code;
                $user->profile_photo_path = $registration->image;
                $user->save();
                $user->roles()->sync(5);
        
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
                    'user_id' => $user->id(),
                    'status' => 1,
                    'category' => $registration->category
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
                $student->user->roles()->attach([5]);
                $name = $student->fullName();

                $qrcode = $this->generateQrcode($name, $code);
                $student->qrcode = $qrcode;
                $student->save();

                $grade = Grade::findOrFail($registration->grade_id);

                $subjectIds = $grade->subjects()->pluck('subjects.id')->all();
                if(count($subjectIds) > 0){
                    $student->subjects()->sync($subjectIds);
                }

                $message = "<p>
                    We are pleased to inform your that your child: 
                    " . $registration->first_name. " " .$registration->last_name.
                    " has been granted admission into " .$registration->grade->title(). 
                    ". Proceed to the school to make necessary payments so as to retain this admission. 
                    Please hold a copy of your child's birth certificate (photocopy) and/or '
                    Baptisimal Card photocopy (Catholics only) with latest school report (if applicable).'
                    </p>";
                $subject = 'Admission Status from ' . application('name');
                        
                Mail::to($registration->mother_email)->send(new SendAdmissionMail($message, $subject));

                try {
                    $watMessage = "{business.name}\\{business.address}\\{business.phone_number} \\ \\
                    We are pleased to inform you that your child: 
                    " . $student->first_name. " " .$student->last_name. " " .$student->other_name.
                    " has been granted admission into " .$student->grade->title(). 
                    ". \\Proceed to the school to make necessary payments and the following douments:. 
                    \\ \\ 1. A copy of your child's birth certificate (photocopy) and/or '
                    Baptisimal Card photocopy (Catholics only) \\2.Last term school report sheet from previous school.";
                    
                    if ($father) {
                        sendWaMessage($father->phone, $watMessage);
                    } 

                    if ($mother) {
                        sendWaMessage($mother->phone, $watMessage);
                    }
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }

                return response()->json([
                    'status' => true,
                    'message' => "Student admitted successfully!",
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function acceptAll(Request $request)
    {
        try {
            $ids =  $request->input('ids');
            $registrations = Registration::withoutGlobalScope(new HasActiveScope)->whereIn('id', $ids)->get();

            $randomNumbers = "";

            for ($i = 0; $i < 4; $i++) {
                $randomNumbers = rand(0, 9999);
            }

            foreach ($registrations as $key => $value) {
                if ($value->update(['status' => true])) {
                        $user = new User([
                            'title' => 'student',
                            'name' => $value->lastName(). ' '. $value->firstName(). ' '. $value->otherName(),
                            'email' => $value->lastName(). $value->firstName().$randomNumbers.'@gmail.com',
                            'phone_number' => '',
                            'password' => Hash::make('password123'),
                            'type' => '4'
                        ]);
                
                        // Determine appType based on student category
                        $appType = appType('appType');
                        if (isset($value->category) && $value->category) {
                            $appType = appType($value->category);
                        }
                        $code = SaveCode::Generator($appType['code'] . '/', 4, 'reg_no', $user);
                        $user->reg_no = $code;
                        $user->profile_photo_path = $value->image;
                        $user->save();

                        $student = new Student([
                            'first_name' => $value->first_name,
                            'last_name' => $value->last_name,
                            'other_name' => $value->other_name,
                            'gender' => $value->gender,
                            'dob' => $value->dob,
                            'nationality' => $value->nationality,
                            'state_of_origin' => $value->state_of_origin,
                            'local_government' => $value->local_government,
                            'address' => $value->address,
                            'prev_school' => $value->prev_school,
                            'prev_class' => $value->prev_class,
                            'medical_history' => $value->medical_history,
                            'allergics' => $value->allergics,
                            'religion' => $value->religion,
                            'denomination' => $value->denomination,
                            'blood_group' => $value->blood_group,
                            'genotype' => $value->genotype,
                            'speech_development' => $value->speech_development,
                            'sight' => $value->sight,
                            'grade_id' => $value->grade_id,
                            'house_id' => 1,
                            'club_id' => 1,
                            'user_id' => $user->id(),
                            'status' => 1,
                            'category' => $value->category
                        ]);

                        $student->authoredBy(auth()->user());
                        $student->save();

                        if ($value->father_name !== null) {
                            $father = new Father([
                                'student_uuid' => $student->id(),
                                'name' => $value->father_name,
                                'email' => $value->father_email,
                                'phone' => $value->father_phone,
                                'occupation' => $value->father_occupation,
                                'office_address' => $value->father_office_address,
                            ]);
                            $father->save();
                        }

                        if ($value->mother_name !== null) {
                            $mother = new Mother([
                                'student_uuid' => $student->id(),
                                'fname' => $value->mother_name,
                                'email' => $value->mother_email,
                                'phone' => $value->mother_phone,
                                'occupation' => $value->mother_occupation,
                                'office_address' => $value->mother_office_address,
                            ]);
                            $mother->save();
                        }

                        if ($value->guardian_full_name !== null) {
                            $guardian = new Guardian([
                                'student_id' => $student->id(),
                                'full_name' => $value->guardian_full_name,
                                'email' => $value->guardian_email,
                                'phone_number' => $value->guardian_phone_number,
                                'occupation' => $value->guardian_occupation,
                                'office_address' => $value->guardian_office_address,
                                'home_address' => $value->guardian_home_address,
                                'relationship' => $value->guardian_relationship,
                            ]);
                            $guardian->save();
                        }

                        $student->schedules()->sync(1);
                        $student->user->roles()->attach([5]);
                        $name = $student->fullName();

                        $controller = new \App\Http\Controllers\StudentController();
                        $qrcode = $controller->generateQrcode($name, $code);
                        $student->qrcode = $qrcode;
                        $student->save();

                        $grade = Grade::findOrFail($value->grade_id);

                        $subjectIds = $grade->subjects()->pluck('subjects.id')->all();
                        if(count($subjectIds) > 0){
                            $student->subjects()->sync($subjectIds);
                        }

                        $message = "<p>
                                    We are pleased to inform your that your child: 
                                    " . $value->first_name . " " . $value->last_name .
                            " has been granted admission into " . $value->grade->title() .
                            ". Proceed to the school to make necessary payments so as to retain this admission. 
                                    Please hold a copy of your child's birth certificate (photocopy) and/or '
                                    Baptisimal Card photocopy (Catholics only) with latest school report (if applicable).'
                                    </p>";
                        $subject = 'Admission Status from ' . application('name');

                        NotifiableParentsTrait::notifyParents($student, $message, $subject);
                }
            }

            return response()->json([
                'status' => true,
                'message' => "Students admitted successfully!",
            ], 200);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false,
                'message' => "There was a accepting the registration. Please try again.",
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function syncParent()
    {
        try{

            $registrations = Registration::withoutGlobalScope(new HasActiveScope)->get();
            $students = Student::withoutGlobalScope(new HasActiveScope)->get();

            $newDataArray = [];
            foreach ($students as $student) {
                $exists = false;
            
                foreach ($registrations as $registration) {
                    if ($registration->first_name === $student->first_name 
                        && $registration->last_name === $student->last_name 
                        && $registration->other_name === $student->other_name 
                        && !isset($student->mother)
                        && !isset($student->father)
                        ) {
                        $exists = true;
                        break;
                    }
                }
            
                if ($exists) {
                    $newDataArray[] = $student;
                }
            }
            // dd($newDataArray);

        return response()->json([
            'status' => true,
            'data' => $newDataArray,
            'message' => 'These are all the students registered!'
        ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],);
        }
    }
    public function resyncParent($id)
    {
        $student = Student::withoutGlobalScope(new HasActiveScope)->where('uuid', $id)->first();
        
        try {
            if ($student) {
                $registration = Registration::withoutGlobalScope(new HasActiveScope)->where('first_name', $student->first_name)->where('last_name', $student->last_name)->where('other_name', $student->other_name)->first();
                if($registration->father_name !== null && !isset($student->father)){
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

                if($registration->mother_name !== null  && !isset($student->mother)){
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

                if($registration->guardian_full_name !== null  && !isset($student->guardian)){
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
                
                return response()->json([
                    'status' => true,
                    'message' => "Process successful!",
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function syncAll(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $selected = $request->input('selected');
                $array = explode(",", $selected);
                $students = Student::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $array)->get();


                foreach ($students as $key => $value) {
                    $registration = Registration::withoutGlobalScope(new HasActiveScope)->where('first_name', $value->first_name)->where('last_name', $value->last_name)->where('other_name', $value->other_name)->first();

                    if($registration->father_name !== null){
                        $father = new Father([
                            'student_uuid'  => $value->id(),
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
                            'student_uuid'  => $value->id(),
                            'fname'  => $registration->mother_name,
                            'email' =>  $registration->mother_email,
                            'phone' =>  $registration->mother_phone,
                            'occupation'  => $registration->mother_occupation,
                            'office_address' =>  $registration->mother_office_address,
                        ]);
                        $mother->save();
                    }

                    if($registration->guardian_full_name !== null){
                        $guardian = new Guardian([
                            'student_id'  => $value->id(),
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
                        
                }
                return response()->json([
                    'status' => true,
                    'message' => "Process successful!",
                ], 200);
            });
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function pending()
    {
        $new_registration = Registration::withoutGlobalScope(new HasActiveScope)->where('status', false)->count();
        return response()->json([
            'status' => true,
            'data' => ['new_registration' => $new_registration],
        ], 200);
    }

    public function deleteAll(Request $request)
    {
        try{
            $ids = $request->input('ids');
            $registrations = Registration::withoutGlobalScope(new HasActiveScope)->whereIn('id', $ids)->get();

            foreach ($registrations as $registration) {
                $registration->delete();
            }

            return response()->json(['status' => true, 'message' => "Registrations Deleted successfully!"], 200);

        }catch(\Throwable $th){
            info($th);
            return response()->json(['status' => false, 'message' => "There was an error deleting the registrations"], 400);
        }
    }
}
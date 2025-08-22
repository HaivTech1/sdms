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
use App\Jobs\NotifyParentsJob;
use App\Jobs\SendWhatsappJob;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\StudentController;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $grade = $request->query('grade');
        $search = $request->query('search');
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 200);

        $registrations = Registration::withoutGlobalScope(new HasActiveScope)
            ->when($grade, function ($query, $grade) {
                $query->whereHas('grade', function ($query) use ($grade) {
                    $query->where('id', $grade);
                });
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
                });
            })
            ->where('status', false)
            ->where('state', 'pending')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => RegistrationResource::collection($registrations),
            'meta' => [
                'current_page' => $registrations->currentPage(),
                'per_page' => $registrations->perPage(),
                'total' => $registrations->total(),
                'last_page' => $registrations->lastPage(),
            ],
            'links' => [
                'next' => $registrations->nextPageUrl(),
                'prev' => $registrations->previousPageUrl(),
            ],
        ]);
    }

    public function single($id)
    {
        $registration = Registration::withoutGlobalScope(new HasActiveScope)->findOrFail($id);
        return response()->json(['status' => true, 'registration' => new RegistrationResource($registration)], 200);
    }

    public function accept($id)
    {
       try{
            DB::transaction(function () use ($id) {
                $registration = Registration::withoutGlobalScope(new HasActiveScope)->findOrFail($id);
                
                $registration->update(['status' => 1, 'state' => 'approved']);
                $randomNumbers = null;

                for ($i = 0; $i < 4; $i++) {
                    $randomNumbers = rand(0, 9999);
                }
                $password = "123456";

                $user = new User([
                    'title' => 'student',
                    'name' => $registration->lastName(). ' '. $registration->firstName(). ' '. $registration->otherName(),
                    'email' => $registration->lastName(). $registration->firstName().$randomNumbers.'@gmail.com',
                    'phone_number' => '',
                    'password' => Hash::make($password),
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

                $controller = app()->make(StudentController::class);
                $path = $controller->generateQrcode($student->fullName(), $code);

                $student->authoredBy(auth()->user());
                $student->qrcode = $path;
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
                    </p><br />
                    <p>Additionally your child's portal credentials has been created please login with: <br />
                        <b>Student ID:</b>$code<br /><b>Password:</b>$password</p>";

                $watMessage = "*Admission Status*\\ \\We are pleased to inform your that your child:
                    " . $registration->last_name. " " .$registration->first_name.
                    " has been granted admission into " .$registration->grade->title().
                    ".\\Please proceed to the school to make necessary payments so as to retain this admission. Make sure to hold a copy of your child's birth certificate (photocopy) and/or 'Baptisimal Card photocopy (Catholics only) with latest school report (if applicable).'\\ \\Additionally your child's portal credentials has been created please login with:\\*Student ID:* $code\\*Password:* $password";

                $subject = 'Admission Status from ' . application('name');

                $emailJob = new NotifyParentsJob($student, $message, $subject);
                $whatsappJob = new SendWhatsappJob($student, $watMessage, "parent");
                Bus::chain([
                    $emailJob,
                    $whatsappJob,
                ])->dispatch();
            });

            return response()->json(['status' => true, 'message' => 'Student Activated successfully!'], 200);
       }catch(\Exception $th){
            DB::rollback();
            return response()->json(['status' => true, 'errors' => $th->getMessage()], 500);
       }
    }

    public function reject($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $registration = Registration::withoutGlobalScope(new HasActiveScope)->findOrFail($id);

                $registration->update([
                    'status' => 0, 
                    'state' => 'rejected'
                ]);

                $message = "<p>
                    We regret to inform you that your child's admission application for 
                    <strong>{$registration->last_name} {$registration->first_name}</strong> 
                    has been <span style='color:red'>REJECTED</span>.
                    " . (!empty($reason) ? "<br/><br/><strong>Reason:</strong> {$reason}" : "") . "
                    <br/><br/>For further enquiries, kindly contact the school administration.
                </p>";

                $subject = 'Admission Status from ' . application('name');
                NotifiableParentsTrait::notifyParents($registration, $message, $subject);
            });

            return response()->json(['status' => true, 'message' => 'Registration rejected successfully!'], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }
}

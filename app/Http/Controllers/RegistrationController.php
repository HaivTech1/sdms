<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Scopes\HasActiveScope;
use App\Services\SaveImageService;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewRegistrationMail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.registration.index');
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

        $fileName = $request->image->getClientOriginalName();
        $filePath = 'registrations/' . $fileName;
        $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->image));
  
        if ($isFileUploaded) {
            $student->image = $filePath;
        }

        if($student->save()){

            $message = "<p>A new student registration form has just been completed! Please visit the school's portal for review.</p>";
            $subject = 'New Student Registration';

            $admins = User::whereType(2)->get();

            foreach($admins as $admin){
                Mail::to($admin->email())->send(new SendNewRegistrationMail($message, $subject));
            }
            return response()->json(['status' => 'success', 'message' => 'Registration completed successfully!'], 200);
        }else{
            return response()->json(['status' => 'error', 'message' => 'There was an error submiting the form! Please try again later'], 400);
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
}

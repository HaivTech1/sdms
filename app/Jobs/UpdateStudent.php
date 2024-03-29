<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Student;
use App\Services\SaveImageService;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreStudentRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class UpdateStudent implements ShouldQueue
{
    use Dispatchable;

    private $student;
    private $firstName;
    private $lastName;
    private $otherName;
    private $gender;
    private $dob;
    private $nationality;
    private $stateOfOrigin;
    private $localGovernment;
    private $address;
    private $prevSchool;
    private $prevClass;
    private $medical;
    private $allergics;
    private $image;
    private $grade;
    private $house;
    private $type;
    private $schedule;
    // private $phoneNumber;
    // private $occupation;
    // private $officeAddress;
    // private $homeAddress;
    // private $relationship;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        Student $student,
        string $firstName,
        string $lastName,
        ?string $otherName,
        string $gender,
        string $dob,
        string $nationality,
        string $stateOfOrigin,
        string $localGovernment,
        string $address,
        ?string $prevSchool,
        ?string $prevClass,
        ?string $medical,
        ?string $allergics,
        ?string $image,
        ?string $grade,
        ?string $house,
        ?string $type,
        ?int $schedule
        // string $phoneNumber,
        // string $occupation,
        // string $officeAddress,
        // string $homeAddress,
        // string $relationship
    )
    {
        $this->student = $student;
        $this->firstName     = $firstName;
        $this->lastName     =  $lastName;
        $this->otherName     = $otherName;
        $this->gender     = $gender;
        $this->dob     = $dob;
        $this->nationality     = $nationality;
        $this->stateOfOrigin     = $stateOfOrigin;
        $this->localGovernment     = $localGovernment;
        $this->address     = $address;
        $this->$prevSchool     = $prevSchool;
        $this->$prevClass     = $prevClass;
        $this->medical     = $medical;
        $this->allergics     = $allergics;
        $this->image     = $image;
        $this->grade     = $grade;
        $this->house     = $house;
        $this->type     = $type;
        $this->schedule     = $schedule;
        // $this->phoneNumber     = $phoneNumber;
        // $this->occupation     = $occupation;
        // $this->officeAddress     = $officeAddress;
        // $this->homeAddress     = $homeAddress;
        // $this->relationship = $relationship;
    }

    public static function fromRequest(Student $student, StoreStudentRequest $request): self
    {
        return new static(
            $student,
            $request->firstName(),
            $request->lastName(),
            $request->otherName(),
            $request->gender(),
            $request->dob(),
            $request->nationality(),
            $request->stateOfOrigin(),
            $request->localGovernment(),
            $request->address(),
            $request->prevSchool(),
            $request->prevClass(),
            $request->medical(),
            $request->allergics(),
            $request->image(),
            $request->grade(),
            $request->house(),
            $request->type(),
            $request->schedule(),
            // $request->phoneNumber(),
            // $request->occupation(),
            // $request->officeAddress(),
            // $request->homeAddress(),
            // $request->relationship()
        );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Student
    {
        $this->student->update([
            'first_name'  => $this->firstName,
            'last_name'  => $this->lastName,
            'other_name'  => $this->otherName,
            'gender'  => $this->gender,
            'dob'  => $this->dob,
            'nationality'  => $this->nationality,
            'state_of_origin'  => $this->stateOfOrigin,
            'local_government'  => $this->localGovernment,
            'address'  => $this->address,
            'prev_school'  => $this->prevSchool,
            'prev_class'  => $this->prevClass,
            'medical_history'  => $this->medical,
            'allergics'  => $this->allergics,
            'grade_id'  => $this->grade,
            'house_id'  => $this->house,
            'type'  => $this->type,
        ]);

        if($this->schedule){
            $this->student->schedules()->attach($this->schedule);
        }

        if (!is_null($this->image)) {
            File::delete(storage_path('app/' . $this->student->user->profile_photo_path));
            SaveImageService::UploadImage($this->image, $this->student->user, User::TABLE, 'profile_photo_path');
        }

        // $this->student->guardian->update([
        //     'full_name'  => $this->fullName,
        //     'email' =>  $this->email,
        //     'phone_number' =>  $this->phoneNumber,
        //     'occupation'  => $this->occupation,
        //     'office_address' =>  $this->officeAddress,
        //     'home_address' =>  $this->homeAddress,
        //     'relationship' =>  $this->relationship,
        // ]);

        return $this->student;
    }
}
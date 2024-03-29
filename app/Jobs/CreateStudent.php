<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Student;
use App\Models\Guardian;
use App\Services\SaveCode;
use Illuminate\Bus\Queueable;
use App\Services\SaveImageService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Requests\StoreStudentRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateStudent implements ShouldQueue
{
    use Dispatchable;

    private $author;
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
    private $club;
    private $schedule;
    private $fullName;
    private $email;
    private $phoneNumber;
    private $occupation;
    private $officeAddress;
    private $homeAddress;
    private $relationship;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $author,
        string $firstName,
        string $lastName,
        string $otherName,
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
        string $grade,
        string $house,
        string $club,
        string $schedule,
        string $fullName,
        ?string $email,
        string $phoneNumber,
        ?string $occupation,
        ?string $officeAddress,
        ?string $homeAddress,
        ?string $relationship
    )
    {
        $this->author     = $author;
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
        $this->club     = $club;
        $this->schedule     = $schedule;
        $this->fullName     = $fullName;
        $this->email     = $email;
        $this->phoneNumber     = $phoneNumber;
        $this->occupation     = $occupation;
        $this->officeAddress     = $officeAddress;
        $this->homeAddress     = $homeAddress;
        $this->relationship = $relationship;
    }

    public static function fromRequest(StoreStudentRequest $request): self
    {
        return new static(
            $request->author(),
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
            $request->club(),
            $request->schedule(),
            $request->fullName(),
            $request->email(),
            $request->phoneNumber(),
            $request->occupation(),
            $request->officeAddress(),
            $request->homeAddress(),
            $request->relationship()
        );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Student
    {

        
        $user = new User([
            'title' => 'student',
            'name' => $this->lastName. ' '. $this->firstName. ' '. $this->otherName,
            'email' => $this->lastName. $this->firstName.'@gmail.com',
            'phone_number' => '',
            'password' => Hash::make('password123'),
            'type' => '4'
        ]);

        $code = SaveCode::Generator(application('alias').'/', 4, 'reg_no', $user);
        $user->reg_no = $code;
        if (!is_null($this->image)) {
            SaveImageService::UploadImage($this->image, $user, User::TABLE, 'profile_photo_path');
        }else {
            $user->save();
        }

        $student = new Student([
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
            'club_id'  => $this->club,
            'user_id' => $user->id()
        ]);
        $student->authoredBy($this->author);
        $student->save();

        $guardian = new Guardian([
            'student_id'  => $student->id(),
            'full_name'  => $this->fullName,
            'email' =>  $this->email,
            'phone_number' =>  $this->phoneNumber,
            'occupation'  => $this->occupation,
            'office_address' =>  $this->officeAddress,
            'home_address' =>  $this->homeAddress,
            'relationship' =>  $this->relationship,
        ]);
        $guardian->save();
        $student->schedules()->sync($this->schedule);
        return $student;
    }
}
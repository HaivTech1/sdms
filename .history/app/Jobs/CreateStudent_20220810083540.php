<?php

namespace App\Jobs;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Requests\StoreStudentRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateStudent implements ShouldQueue
{
    use Dispatchable;

    private $firstName;
    private $lastName;
    private $otherName;
    private $gender;
    private $dob;
    private $nationality;
    private $stateOfOrigin;
    private $localGovernment;
    private $address;
    private $medical;
    private $allergics;
    private $image;
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
        string $firstName,
        string $lastName,
        string $otherName,
        string $gender,
        string $dob,
        string $nationality,
        string $stateOfOrigin,
        string $localGovernment,
        string $address,
        string $medical,
        string $allergics,
        string $image,
        string $fullName,
        string $email,
        string $phoneNumber,
        string $occupation,
        string $officeAddress,
        string $homeAddress,
        string $relationship
    )
    {
        $this->firstName     => $firstName;
        $this->lastName     => $lastName;
        $this->otherName     => $otherName;
        $this->gender     => $gender;
        $this->dob     => $dob;
        $this->nationality     => $nationality;
        $this->stateOfOrigin     => $stateOfOrigin;
        $this->localGovernment     => $localGovernment;
        $this->address     => $address;
        $this->medical     => $medical;
        $this->allergics     => $allergics;
        $this->image     => $image;
        $this->fullName     => $fullName;
        $this->email     => $email;
        $this->phoneNumber     => $phoneNumber;
        $this->occupation     => $occupation;
        $this->officeAddress     => $officeAddress;
        $this->homeAddress     => $homeAddress;
        $this->relationship => $relationship
    }

    public static function fromRequest(StoreStudentRequest $request): self
    {
        return new static(
            $request->firstName(),
            $request->lastName(),
            $request->otherName(),
            $request->gender(),
            $request->dob(),
            $request->nationality(),
            $request->stateOfOrigin(),
            $request->localGovernment(),
            $request->address(),
            $request->medical(),
            $request->allergics(),
            $request->image(),
            $request->fullName(),
            $request->email(),
            $request->phoneNumber(),
            $request->occupation(),
            $request->officeAddress(),
            $request->homeAddress(),
            $request->relationship()
        )
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): Student
    {
        $student = new Student([
            'first_name'  => $this->title,
            'last_name'  => $this->title,
            'other_name'  => $this->title,
            'gender'  => $this->title,
            'dob'  => $this->title,
            'nationality'  => $this->title,
            'state_of_origin'  => $this->title,
            'local_government'  => $this->title,
            'address'  => $this->title,
            'prev_school'  => $this->title,
            'prev_class'  => $this->title,
            'image'  => $this->title,
            'medical_history'  => $this->title,
            'allergics'  => $this->title,
            'image'  => $this->title,
            'grade_id'  => $this->title,
        ])

        $student->save()

        $student->associate()->guardian->create([
            'full_name'   $this->fullname,
            'email'   $this->email,
            'phone_number'   $this->phoneNumber,
            'occupation'   $this->occupation,
            'office_address'   $this->officeAddress,
            'home_address'   $this->homeAddress,
            'relationship'   $this->relationship,
        ])

        return $student
    }
}
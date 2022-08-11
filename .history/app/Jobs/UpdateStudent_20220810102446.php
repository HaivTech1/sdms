<?php

namespace App\Jobs;

use App\Models\Student;
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
        Student $student,
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
        string $fullName,
        string $email,
        string $phoneNumber,
        string $occupation,
        string $officeAddress,
        string $homeAddress,
        string $relationship
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
        $this->fullName     = $fullName;
        $this->email     = $email;
        $this->phoneNumber     = $phoneNumber;
        $this->occupation     = $occupation;
        $this->officeAddress     = $officeAddress;
        $this->homeAddress     = $homeAddress;
        $this->relationship = $relationship;
    }

    public static function fromRequest(Student $student, StoreStudentRequest $request): self
    {
        return new static(
            $post,
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
    public function handle()
    {
        //
    }
}
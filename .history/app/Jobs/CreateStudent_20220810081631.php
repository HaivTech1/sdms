<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        string $firstName;
        string $lastName;
        string $otherName;
        string $gender;
        string $dob;
        string $nationality;
        string $stateOfOrigin;
        string $localGovernment;
        string $address;
        string $medical;
        string $allergics;
        string $image;
        string $fullName;
        string $email;
        string $phoneNumber;
        string $occupation;
        string $officeAddress;
        string $homeAddress;
        string $relationship; 
    )
    {
        //
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
<x-app-layout>
    @section('title', "Registration Form: ". $registration->firstName() . ' '. $registration->lastName())
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">
            <a href="{{ url('index/registration') }}">Registrations</a>
        </h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $registration->firstName() }} {{ $registration->lastName() }}</li>
            </ol>
        </div>
    </x-slot>

     <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-2">
                    <div class='panel panel-primary'>
                        <div class='panel-body'>
                            <div class='parent'>
                                <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                                    <img class='img-rounded img-responsive' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' />
                                </div>

                                 <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                                    <h1 style="font-size: 35px; font-weight: bold; text-decoration: uppercase"> {{
                                        application('name') }}</h1>
                                        
                                        <p style='font-size: 15px; font-family: Arial, Helvetica, sans-serif'>
                                            {{ application('address') }}
                                        </p>
                                </div>

                                <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                                    <img src='{{  asset('storage/'.$registration->image()) }}' class='img-rounded
                                    img-responsive' alt='{{ $registration->firstName()}}' />
                                </div>
                            </div>
                            <hr style="margin-top: 5px"/>
                        </div>

                        <div style="flex: 1">
                            <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Basic Information</legend>
                                    <blockquote><b>Surname</b>: {{ $registration->lastName()}}<p>
                                    <blockquote><b>First Name</b>: {{ $registration->firstName()}}</blockquote>
                                    <blockquote><b>Other Name</b>: {{ $registration->otherName()}}</blockquote>
                                    <blockquote><b>Gender</b>: {{ $registration->gender()}}</blockquote>
                                    <blockquote><b>State of Origin</b>: {{ $registration->stateOfOrigin()}}</blockquote>
                                    <blockquote><b>Nationality</b>: {{ $registration->nationality()}}</blockquote>
                                    <blockquote><b>Local Government</b>: {{ $registration->localGovernment()}}</blockquote>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Others</legend>
                                    <blockquote><b>DOB</b>: {{ $registration->dob()}}</blockquote>
                                    <blockquote>
                                        <?php
                                            $year = Carbon\Carbon::parse($registration->dob)->age
                                        ?>
                                     <b>Age</b>: {{$year}}
                                    </p>
                                    <blockquote><b>Address</b>: {{ $registration->address()}}</blockquote>
                                    <blockquote><b>Previous School</b>: {{ $registration->prevSchool()}}</blockquote>
                                    <blockquote><b>Previous Class</b>: {{ $registration->prevClass()}}</blockquote>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Academics</legend>
                                    <blockquote><b>Class</b>: {{ $registration?->grade?->title() ?? ''}}</blockquote>
                                </div>
                            </div>

                            <hr />

                            <div class="parent">
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Father's Details</legend>
                                    <blockquote><b>Name</b>: {{ $registration->father_name}}</blockquote>
                                    <blockquote><b>Office Address</b>: {{ $registration->father_office_address}}</blockquote>
                                    <blockquote><b>Email</b>: {{ $registration->father_email}}</blockquote>
                                    <blockquote><b>Phone Number</b>: {{ $registration->father_phone}}</blockquote>
                                    <blockquote><b>Occupation</b>: {{ $registration->father_occupation}}</blockquote>
                                </div>

                                <div class='col-xs-4 col-md-4'>
                                    <legend>Mother's Details</legend>
                                    <blockquote><b>Name</b>: {{ $registration->mother_name}}</blockquote>
                                    <blockquote><b>Office Address</b>: {{ $registration->mother_office_address}}</blockquote>
                                    <blockquote><b>Email</b>: {{ $registration->mother_email}}</blockquote>
                                    <blockquote><b>Phone Number</b>: {{ $registration->mother_phone}}</blockquote>
                                    <blockquote><b>Occupation</b>: {{ $registration->mother_occupation}}</blockquote>
                                </div>

                                <div class='col-xs-4 col-md-4'>
                                    <legend>Guardian Details</legend>
                                    <blockquote><b>Home Address</b>: {{ $registration->guardian_home_address ?? ''}}</blockquote>
                                    <blockquote><b>Office Address</b>: {{ $registration->guardian_office_address}}</blockquote>
                                    <blockquote><b>Email</b>: {{ $registration->guardian_email}}</blockquote>
                                    <blockquote><b>Phone Number</b>: {{ $registration->guardian_phone_number}}</blockquote>
                                    <blockquote><b>Occupation</b>: {{ $registration->guardian_occupation}}</blockquote>
                                    <blockquote><b>Relationship</b>: {{ $registration->guardian_relationship}}</blockquote>
                                </div>
                            </div>

                            <hr />

                            <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Medical Details</legend>
                                    <blockquote><b style="margin-bottom: 5px">Genotype: </b> {{ $registration->genotype}} <blockquote>
                                    <blockquote><b style="margin-bottom: 5px">Blood Group: </b> {{ $registration->blood_group}} <blockquote>
                                    <blockquote><b style="margin-bottom: 5px">Allergics: </b> {{ $registration->allergics()}} <blockquote>
                                    <blockquote><b style="margin-bottom: 5px">Sight: </b> {{ $registration->sight}} <blockquote>
                                    <blockquote><b style="margin-bottom: 5px">Speech development: </b> {{ $registration->speech_development}} <blockquote>
                                    <blockquote><b>Medical Health Condition:</b> {{ $registration->medical()}}</blockquote>
                                </div>
                               
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Registered</legend>
                                    <blockquote><b>Date</b>: {{ $registration->createdAt()}}</blockquote>
                                </div>
                            </div>
                        </div>

                        <br />
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
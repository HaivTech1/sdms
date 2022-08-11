<x-app-layout>
    @section('title', application('name') . ' | Student Page')

    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Student</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Show | {{ $student->firstName()}}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class='panel panel-primary'>
                        <div class='panel-body'>
                            <div class='parent'>
                                <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                                    <img class='img-rounded img-responsive' src='{{  asset('storage/application/'.application('image')) }}' alt='{{ application('name')}}'/>
                                </div>
                    
                                <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                                    <h3> {{ application('name') }}</h3>
                                    <p class='text-danger'>
                                    {{ application('address') }}<br/>
                                    </p>
                                </div>
                    
                                <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'> 
                                    <img src='{{  asset('storage/students/'.$student->image()) }}' class='img-rounded img-responsive' alt='{{ $student->firstName()}}' />
                                </div>
                            </div>
                            <hr />
                    
                            <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Basic Information</legend>
                                    <p>Surname: {{ $student->lastName()}} <p>
                                    <p>First Name: {{ $student->firstName()}}</p>
                                    <p>Other Name: {{ $student->otherName()}}</p>
                                    <p>Gender: {{ $student->gender()}}</p>
                                    <p>State of Origin: {{ $student->stateOfOrigin()}}</p>
                                    <p>Nationality: {{ $student->nationality()}}</p>
                                    <p>Local Government: {{ $student->localGovernment()}}</p>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Others</legend>
                                    <p>dob: {{ $student->dob()}}</p>
                                    <p>Address: {{ $student->address()}}</p>
                                    <p>Previous School: {{ $student->prevSchool()}}</p>
                                    <p>Previous Class: {{ $student->prevClass()}}</p>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Guardian Details</legend>
                                    <p>Home Address: {{ $student->guardian->homeAddress()}}</p>
                                    <p>Office Address: {{ $student->guardian->officeAddress()}}</p>
                                    <p>Email: {{ $student->guardian->email()}}</p>
                                    <p>Phone Number: {{ $student->guardian->phoneNumber()}}</p>
                                    <p>Occupation: {{ $student->guardian->occupation()}}</p>
                                    <p>Relationship: {{ $student->guardian->relationship()}}</p>
                                </div>
                            </div>
                            <br />
                    
                            <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Academics</legend>
                                    <p>Class: {{ $student->grade->title()}}</p>
                                    <p>Password: knafkasnfkjnfa</p>
                                    <p>Class: ljfksnflnks</p>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Sponsor:</legend>
                                    <p>Name: kafnklfnlknl</p>
                                    <p>Phone: knsafkzanfkns</p>
                                    <p>Relationship: ,nkf zsjnflkns</p>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Registered</legend>
                                    <p>Date: {{ $student->createdAt()}}</p>
                                </div>
                            </div>

                            <div class='parent'>
                                
                            </div>
                        </div>
                        <br/>
                        <hr/>
                
                        <div class='row'>
                            <div class='col-xs-12 col-md-12 text-center'>
                                <em>
                                    <strong>NOTE:</strong> Print this slip and keep it safe, you will require this for effective service of your school portal. 
                                    We are always ready to asisst in any way we can. 
                                    <br/>
                                    <span class='fa fa-phone'></span> {{ application('line1') }},&nbsp;&nbsp;
                                    <span class='fa fa-envelope'></span> {{ application('email') }} &nbsp;&nbsp;
                                </em>
                            </div>
                        </div>
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                            <a href="javascript: void(0);" class="btn btn-primary w-md waves-effect waves-light">Send</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

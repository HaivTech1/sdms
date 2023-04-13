<x-app-layout>
    @section('title', application('name') . ' | Student Page')
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Student</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Edit | {{ $student->firstName()}}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card" x-data="{ currentTab: $persist('general')}">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li @click.prevent="currentTab = 'student'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'student' ? 'active' : ''" data-bs-toggle="tab" href="#home" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Student Details</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'mother'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'mother' ? 'active' : ''" data-bs-toggle="tab" href="#profile" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Mother Details</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'father'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'father' ? 'active' : ''" data-bs-toggle="tab" href="#messages" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Father Details</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'guardian'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'guardian' ? 'active' : ''" data-bs-toggle="tab" href="#settings" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Guardian Details</span>    
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane" :class="currentTab === 'student' ? 'active' : ''" id="student" role="tabpanel">
                            <h4 class="card-title">Basic Information</h4>
                            <p class="card-title-desc">Update {{ $student->firstName()}} Information</p>

                            <form action="{{ route('student.update', $student) }}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="first_name" value="{{ __('First Name') }}" />
                                                <x-form.input id="first_name" class="block w-full mt-1" type="text" name="first_name"
                                                    :value="old('first_name', $student->firstName())" id="first_name" placeholder="First Name" autofocus />
                                                <x-form.error for="first_name" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="last_name" value="{{ __('Last Name') }}" />
                                                <x-form.input id="last_name" class="block w-full mt-1" type="text" name="last_name"
                                                    :value="old('last_name', $student->lastName())" id="last_name" placeholder="Last Name" autofocus />
                                                <x-form.error for="last_name" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="other_name" value="{{ __('Other Name') }}" />
                                                <x-form.input id="other_name" class="block w-full mt-1" type="text" name="other_name"
                                                    :value="old('other_name', $student->otherName())" id="other_name" placeholder="Other Name" autofocus />
                                                <x-form.error for="other_name" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="gender" value="{{ __('Gender') }}" />
                                                <select class="form-control select2" name="gender" :value="old('purpose')">
                                                    <option>Select</option>
                                                    <option value="male"  @if($student->gender() === 'male') selected
                                                        @endif>Male</option>
                                                    <option value="female" @if($student->gender() === 'female') selected
                                                        @endif>Female</option>
                                                    <option value="other" @if($student->gender() === 'other') selected
                                                        @endif>Other</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="type" value="{{ __('Type') }}" />
                                                <select class="form-control select2" name="type" :value="old('type')">
                                                    <option>Select</option>
                                                    <option value="n" @if($student->type() === 'n') selected
                                                        @endif>Normal</option>
                                                    <option value="s" @if($student->type() === 's') selected
                                                        @endif>Staff Ward</option>
                                                    <option value="scholarship" @if($student->type() === 'scholarship') selected
                                                        @endif>On Scholarship</option>
                                                </select>
                                            </div>


                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="grade_id" value="{{ __('Class') }}" />
                                                <select class="form-control" name="grade_id">
                                                    <option>Select</option>
                                                    @foreach ($grades as $grade)
                                                    <option value="{{ $grade->id() }}" @if($grade->id() === $student->grade->id()) selected @endif>{{ $grade->title() }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="house_id" value="{{ __('Sport House') }}" />
                                                <select class="form-control" name="house_id">
                                                    <option>Select</option>
                                                    @foreach ($houses as $house)
                                                    <option value="{{ $house->id() }}" @if($house->id() === $student->house->id()) selected @endif>{{ $house->title() }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="dob" value="{{ __('Date of Birth') }}" />
                                                <x-form.input id="dob" class="block w-full mt-1" type="date" name="dob"
                                                    id="dob" value="{{ old('dob', \Carbon\Carbon::parse($student->dob())->format('Y-m-d')) }}" autofocus />
                                                <x-form.error for="dob" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="nationality" value="{{ __('Nationality') }}" />
                                                <x-form.input class="block w-full mt-1" placeholder="Nigerian"
                                                    type="text" name="nationality" :value="old('nationality', $student->nationality())" autofocus />
                                                <x-form.error for="nationality" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="state_of_origin" value="{{ __('State of Origin') }}" />
                                                <x-form.input class="block w-full mt-1" placeholder="Osun State"
                                                    type="text" name="state_of_origin" :value="old('state_of_origin', $student->stateOfOrigin())" autofocus />
                                                <x-form.error for="state_of_origin" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="local_government" value="{{ __('Local Government') }}" />
                                                <x-form.input class="block w-full mt-1" placeholder="Osun West"
                                                    type="text" name="local_government" :value="old('local_government', $student->localGovernment())" autofocus />
                                                <x-form.error for="local_government" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="address" value="{{ __('Residential Address') }}" />
                                                <x-form.input class="block w-full mt-1" placeholder="Address"
                                                    type="text" name="address" :value="old('address', $student->address())" autofocus />
                                                <x-form.error for="address" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="prev_school" value="{{ __('Last Attended School') }}" />
                                                <x-form.input class="block w-full mt-1" placeholder="St.Annes Grammar School"
                                                    type="text" name="prev_school" :value="old('prev_school', $student->prevSchool())" autofocus />
                                                <x-form.error for="prev_school" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="prev_class" value="{{ __('Previous Class') }}" />
                                                <x-form.input class="block w-full mt-1" placeholder="Basic 1"
                                                    type="text" name="prev_class" :value="old('prev_class', $student->prevClass())" autofocus />
                                                <x-form.error for="prev_class" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="image" value="{{ __('Passport Photography') }}" />
                                                <x-form.input id="image" class="block w-full mt-1" placeholder="image" type="file"
                                                    name="image"/>
                                                <x-form.error for="image" />
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="medical_history" value="{{ __('Medical History') }}" />
                                                <textarea class="form-control" id="medical_history" rows="5" name="medical_history"
                                                    placeholder="Medical History">{{ old('medical_history', $student->medical()) }}</textarea>
                                            </div>
            
                                            <div class="col-sm-6 mb-3">
                                                <x-form.label for="allergics" value="{{ __('Allergics') }}" />
                                                <textarea class="form-control" id="allergics" rows="5" name="allergics"
                                                    placeholder="Allergics">{{ old('allergics', $student->allergics()) }}</textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Update
                                        Student</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" :class="currentTab === 'mother' ? 'active' : ''" id="mother" role="tabpanel">
                            <h4 class="card-title">Mother's Information</h4>

                            @if(isset($student->mother))
                                <form id="motherUpdate">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="row">

                                                <input class="d-none" type="text" name="student_id" value="{{ $student->id() }}" />
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="full_name" value="{{ __('Full Name') }}" />
                                                    <x-form.input id="full_name" class="block w-full mt-1" placeholder="Full Name"
                                                        type="text" name="full_name" :value="old('full_name', $student->mother->fullName())" autofocus />
                                                    <x-form.error for="full_name" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="email" value="{{ __('Email') }}" />
                                                    <x-form.input id="email" class="block w-full mt-1" placeholder="Email"
                                                        type="email" name="email" :value="old('email', $student->mother->email())" autofocus />
                                                    <x-form.error for="email" />
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="phone_number" value="{{ __('Phone Number') }}" />
                                                    <x-form.input id="phone_number" class="block w-full mt-1" placeholder="Phone Number"
                                                        type="tel" name="phone_number" :value="old('phone_number', $student->mother->phoneNumber())" autofocus />
                                                    <x-form.error for="phone_number" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="occupation" value="{{ __('Occupation') }}" />
                                                    <x-form.input id="occupation" class="block w-full mt-1" placeholder="Occupation"
                                                        type="occupation" name="occupation" :value="old('occupation', $student->mother->occupation())" autofocus />
                                                    <x-form.error for="occupation" />
                                                </div>
                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="office_address" value="{{ __('Office Address') }}" />
                                                    <x-form.input id="office_address" class="block w-full mt-1" placeholder="Office Address"
                                                        type="text" name="office_address" :value="old('office_address', $student->mother->officeAddress())" autofocus />
                                                    <x-form.error for="office_address" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button id="motherBtn" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Update</button>
                                    </div>
                                </form>
                            @else
                                <form id="motherUpdate">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="row">

                                                <input class="d-none" type="text" name="student_id" value="{{ $student->id() }}" />
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="full_name" value="{{ __('Full Name') }}" />
                                                    <x-form.input id="full_name" class="block w-full mt-1" placeholder="Full Name"
                                                        type="text" name="full_name" :value="old('full_name')" autofocus />
                                                    <x-form.error for="full_name" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="email" value="{{ __('Email') }}" />
                                                    <x-form.input id="email" class="block w-full mt-1" placeholder="Email"
                                                        type="email" name="email" :value="old('email')" autofocus />
                                                    <x-form.error for="email" />
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="phone_number" value="{{ __('Phone Number') }}" />
                                                    <x-form.input id="phone_number" class="block w-full mt-1" placeholder="Phone Number"
                                                        type="tel" name="phone_number" :value="old('phone_number')" autofocus />
                                                    <x-form.error for="phone_number" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="occupation" value="{{ __('Occupation') }}" />
                                                    <x-form.input id="occupation" class="block w-full mt-1" placeholder="Occupation"
                                                        type="occupation" name="occupation" :value="old('occupation')" autofocus />
                                                    <x-form.error for="occupation" />
                                                </div>
                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="office_address" value="{{ __('Office Address') }}" />
                                                    <x-form.input id="office_address" class="block w-full mt-1" placeholder="Office Address"
                                                        type="text" name="office_address" :value="old('office_address')" autofocus />
                                                    <x-form.error for="office_address" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button id="motherBtn" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="tab-pane" :class="currentTab === 'father' ? 'active' : ''" id="father" role="tabpanel">
                            <h4 class="card-title">Father's Information</h4>

                            @if(isset($student->father))
                                <form id="fatherUpdate">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="row">

                                                <input class="d-none" type="text" name="student_id" value="{{ $student->id() }}" />
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="full_name" value="{{ __('Full Name') }}" />
                                                    <x-form.input id="full_name" class="block w-full mt-1" placeholder="Full Name"
                                                        type="text" name="full_name" :value="old('full_name', $student->father->fullName())" autofocus />
                                                    <x-form.error for="full_name" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="email" value="{{ __('Email') }}" />
                                                    <x-form.input id="email" class="block w-full mt-1" placeholder="Email"
                                                        type="email" name="email" :value="old('email', $student->father->email())" autofocus />
                                                    <x-form.error for="email" />
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="phone_number" value="{{ __('Phone Number') }}" />
                                                    <x-form.input id="phone_number" class="block w-full mt-1" placeholder="Phone Number"
                                                        type="tel" name="phone_number" :value="old('phone_number', $student->father->phoneNumber())" autofocus />
                                                    <x-form.error for="phone_number" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="occupation" value="{{ __('Occupation') }}" />
                                                    <x-form.input id="occupation" class="block w-full mt-1" placeholder="Occupation"
                                                        type="occupation" name="occupation" :value="old('occupation', $student->father->occupation())" autofocus />
                                                    <x-form.error for="occupation" />
                                                </div>
                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="office_address" value="{{ __('Office Address') }}" />
                                                    <x-form.input id="office_address" class="block w-full mt-1" placeholder="Office Address"
                                                        type="text" name="office_address" :value="old('office_address', $student->father->officeAddress())" autofocus />
                                                    <x-form.error for="office_address" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button id="fatherBtn" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Update</button>
                                    </div>
                                </form>
                            @else
                                <form id="fatherUpdate">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="row">

                                                <input class="d-none" type="text" name="student_id" value="{{ $student->id() }}" />
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="full_name" value="{{ __('Full Name') }}" />
                                                    <x-form.input id="full_name" class="block w-full mt-1" placeholder="Full Name"
                                                        type="text" name="full_name" :value="old('full_name')" autofocus />
                                                    <x-form.error for="full_name" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="email" value="{{ __('Email') }}" />
                                                    <x-form.input id="email" class="block w-full mt-1" placeholder="Email"
                                                        type="email" name="email" :value="old('email')" autofocus />
                                                    <x-form.error for="email" />
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="phone_number" value="{{ __('Phone Number') }}" />
                                                    <x-form.input id="phone_number" class="block w-full mt-1" placeholder="Phone Number"
                                                        type="tel" name="phone_number" :value="old('phone_number')" autofocus />
                                                    <x-form.error for="phone_number" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="occupation" value="{{ __('Occupation') }}" />
                                                    <x-form.input id="occupation" class="block w-full mt-1" placeholder="Occupation"
                                                        type="occupation" name="occupation" :value="old('occupation')" autofocus />
                                                    <x-form.error for="occupation" />
                                                </div>
                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="office_address" value="{{ __('Office Address') }}" />
                                                    <x-form.input id="office_address" class="block w-full mt-1" placeholder="Office Address"
                                                        type="text" name="office_address" :value="old('office_address')" autofocus />
                                                    <x-form.error for="office_address" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button id="fatherBtn" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="tab-pane" :class="currentTab === 'guardian' ? 'active' : ''" id="guardian" role="tabpanel">
                            <h4 class="card-title">Guardian's Information</h4>

                            @if(isset($student->guardian))
                                <form id="guardianUpdate">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="row">

                                                <input class="d-none" type="text" name="student_id" value="{{ $student->id() }}" />
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="full_name" value="{{ __('Full Name') }}" />
                                                    <x-form.input id="full_name" class="block w-full mt-1" placeholder="Full Name"
                                                        type="text" name="full_name" :value="old('full_name', $student->guardian->fullName())" autofocus />
                                                    <x-form.error for="full_name" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="email" value="{{ __('Email') }}" />
                                                    <x-form.input id="email" class="block w-full mt-1" placeholder="Email"
                                                        type="email" name="email" :value="old('email', $student->guardian->email())" autofocus />
                                                    <x-form.error for="email" />
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="phone_number" value="{{ __('Phone Number') }}" />
                                                    <x-form.input id="phone_number" class="block w-full mt-1" placeholder="Phone Number"
                                                        type="tel" name="phone_number" :value="old('phone_number', $student->guardian->phoneNumber())" autofocus />
                                                    <x-form.error for="phone_number" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="occupation" value="{{ __('Occupation') }}" />
                                                    <x-form.input id="occupation" class="block w-full mt-1" placeholder="Occupation"
                                                        type="occupation" name="occupation" :value="old('occupation', $student->guardian->occupation())" autofocus />
                                                    <x-form.error for="occupation" />
                                                </div>
                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="office_address" value="{{ __('Office Address') }}" />
                                                    <x-form.input id="office_address" class="block w-full mt-1" placeholder="Office Address"
                                                        type="text" name="office_address" :value="old('office_address', $student->guardian->officeAddress())" autofocus />
                                                    <x-form.error for="office_address" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button id="guardianBtn" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Update</button>
                                    </div>
                                </form>
                            @else
                                <form id="guardianUpdate">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="row">

                                                <input class="d-none" type="text" name="student_id" value="{{ $student->id() }}" />
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="full_name" value="{{ __('Full Name') }}" />
                                                    <x-form.input id="full_name" class="block w-full mt-1" placeholder="Full Name"
                                                        type="text" name="full_name" :value="old('full_name')" autofocus />
                                                    <x-form.error for="full_name" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="email" value="{{ __('Email') }}" />
                                                    <x-form.input id="email" class="block w-full mt-1" placeholder="Email"
                                                        type="email" name="email" :value="old('email')" autofocus />
                                                    <x-form.error for="email" />
                                                </div>
                                                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="phone_number" value="{{ __('Phone Number') }}" />
                                                    <x-form.input id="phone_number" class="block w-full mt-1" placeholder="Phone Number"
                                                        type="tel" name="phone_number" :value="old('phone_number')" autofocus />
                                                    <x-form.error for="phone_number" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="occupation" value="{{ __('Occupation') }}" />
                                                    <x-form.input id="occupation" class="block w-full mt-1" placeholder="Occupation"
                                                        type="occupation" name="occupation" :value="old('occupation')" autofocus />
                                                    <x-form.error for="occupation" />
                                                </div>
                
                                                <div class="col-sm-6 mb-3">
                                                    <x-form.label for="office_address" value="{{ __('Office Address') }}" />
                                                    <x-form.input id="office_address" class="block w-full mt-1" placeholder="Office Address"
                                                        type="text" name="office_address" :value="old('office_address')" autofocus />
                                                    <x-form.error for="office_address" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button id="guardianBtn" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('alpine-plugins')
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    @endpush

    @section('scripts')
        <script>

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
            
            $('#motherUpdate').on('submit', function (e) {
                e.preventDefault();
               toggleAble('#motherBtn', true, 'Submitting...')
               var data = $('#motherUpdate').serializeArray();
               var url = '/student/update/mother';

               $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    if(res.status) {
                        toggleAble('#motherBtn', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#motherUpdate');
                        window.location.reload();
                    }else{
                        toggleAble('#motherBtn', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#motherBtn', false);
                });
            });

            $('#fatherUpdate').on('submit', function (e) {
                e.preventDefault();
               toggleAble('#fatherBtn', true, 'Submitting...')
               var data = $('#fatherUpdate').serializeArray();
               var url = '/student/update/father';

               $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    if(res.status) {
                        toggleAble('#fatherBtn', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#fatherUpdate');
                        window.location.reload();
                    }else{
                        toggleAble('#fatherBtn', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#fatherBtn', false);
                });
            });

            $('#guardianUpdate').on('submit', function (e) {
                e.preventDefault();
               toggleAble('#guardianBtn', true, 'Submitting...')
               var data = $('#guardianUpdate').serializeArray();
               var url = '/student/update/guardian';

               $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    if(res.status) {
                        toggleAble('#guardianBtn', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#guardianUpdate');
                        window.location.reload();
                    }else{
                        toggleAble('#guardianBtn', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#guardianBtn', false);
                });
            });
        </script>
    @endsection

</x-app-layout>

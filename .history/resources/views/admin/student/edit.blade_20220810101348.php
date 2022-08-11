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
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Update {{ $student->firstName()}} Information</p>

                    <form action="{{ route('student.update',$student) }}" method="post" enctype="multipart/form-data">
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
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
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
                                        <x-form.label for="dob" value="{{ __('Date of Birth') }}" />
                                        <x-form.input id="dob" class="block w-full mt-1" type="date" name="dob"
                                            id="dob" value="{{ old('dob', $student->dob()) }}" autofocus />
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

                            <div class="col-md-12 mt-2">
                                <h3>Guardian Details</h3>

                                <div class="row">
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
                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="home_address" value="{{ __('Home Address') }}" />
                                        <x-form.input id="home_address" class="block w-full mt-1" placeholder="Home Address"
                                            type="text" name="home_address" :value="old('home_address', $student->guardian->homeAddress())" autofocus />
                                        <x-form.error for="home_address" />
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="relationship" value="{{ __('Relationship') }}" />
                                        <x-form.input id="relationship" class="block w-full mt-1" placeholder="Relationship"
                                            type="text" name="relationship" :value="old('relationship', $student->guardian->relationship())" autofocus />
                                        <x-form.error for="relationship" />
                                    </div>
                                </div>

                               
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save
                                Student</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>

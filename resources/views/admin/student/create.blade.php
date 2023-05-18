<x-app-layout>
    @section('title', application('name') . ' | Student Page')
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Student</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                    <div class="modalErrorr"></div>
                    <form id="createStudent" action="{{ route('student.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin: 10px 0">
                            <div style="margin-right: 10px; padding: 5px">
                                <x-form.label for="image" value="{{ __('Passport Photograph') }}" />
                                <x-form.input id="image" class="block w-full mt-1" type="file" name="image" style="display: none;"/>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center">
                                <canvas style="border-radius: 5px; margin: 5px; width: 150px; height: 150px" id="img-show" class="img-thumbnail img-response"></canvas>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                
                                <div class="row">
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="first_name" value="{{ __('First Name') }}" />
                                        <x-form.input id="first_name" class="block w-full mt-1" type="text" name="first_name"
                                            :value="old('first_name')" id="first_name" placeholder="First Name" autofocus />
                                        <x-form.error for="first_name" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="last_name" value="{{ __('Last Name') }}" />
                                        <x-form.input id="last_name" class="block w-full mt-1" type="text" name="last_name"
                                            :value="old('last_name')" id="last_name" placeholder="Last Name" autofocus />
                                        <x-form.error for="last_name" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="other_name" value="{{ __('Other Name') }}" />
                                        <x-form.input id="other_name" class="block w-full mt-1" type="text" name="other_name"
                                            :value="old('other_name')" id="other_name" placeholder="Other Name" autofocus />
                                        <x-form.error for="other_name" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="gender" value="{{ __('Gender') }}" />
                                        <select class="form-control select2" name="gender" :value="old('purpose')">
                                            <option>Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="grade_id" value="{{ __('Class') }}" />
                                        <select class="form-control" name="grade_id">
                                            <option>Select</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="sub_grade_id" value="{{ __('Sub Class') }}" />
                                        <select class="form-control" name="sub_grade_id">
                                            
                                        </select>
                                    </div>

                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="house_id" value="{{ __('Sport House') }}" />
                                        <select class="form-control" name="house_id">
                                            <option>Select</option>
                                            @foreach ($houses as $house)
                                            <option value="{{ $house->id() }}">{{ $house->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="club_id" value="{{ __('Club') }}" />
                                        <select class="form-control" name="club_id">
                                            <option>Select</option>
                                            @foreach ($clubs as $club)
                                            <option value="{{ $club->id() }}">{{ $club->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="schedule_id" value="{{ __('Schedule') }}" />
                                        <select class="form-control" name="schedule_id">
                                            <option>Select</option>
                                            @foreach ($schedules as $schedule)
                                            <option value="{{ $schedule->id() }}">{{ $schedule->slug() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="dob" value="{{ __('Date of Birth') }}" />
                                        <x-form.input id="dob" class="block w-full mt-1" type="date" name="dob"
                                            id="dob" autofocus />
                                        <x-form.error for="dob" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="nationality" value="{{ __('Nationality') }}" />
                                        <x-form.input class="block w-full mt-1" placeholder="Nigerian"
                                            type="text" name="nationality" :value="old('nationality')" autofocus />
                                        <x-form.error for="nationality" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="state_of_origin" value="{{ __('State of Origin') }}" />
                                        <x-form.input class="block w-full mt-1" placeholder="Osun State"
                                            type="text" name="state_of_origin" :value="old('state_of_origin')" autofocus />
                                        <x-form.error for="state_of_origin" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="local_government" value="{{ __('Local Government') }}" />
                                        <x-form.input class="block w-full mt-1" placeholder="Osun West"
                                            type="text" name="local_government" :value="old('local_government')" autofocus />
                                        <x-form.error for="local_government" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="address" value="{{ __('Residential Address') }}" />
                                        <x-form.input class="block w-full mt-1" placeholder="Address"
                                            type="text" name="address" :value="old('address')" autofocus />
                                        <x-form.error for="address" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="prev_school" value="{{ __('Last Attended School') }}" />
                                        <x-form.input class="block w-full mt-1" placeholder="St.Annes Grammar School"
                                            type="text" name="prev_school" :value="old('prev_school')" autofocus />
                                        <x-form.error for="prev_school" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="prev_class" value="{{ __('Previous Class') }}" />
                                        <x-form.input class="block w-full mt-1" placeholder="Basic 1"
                                            type="text" name="prev_class" :value="old('prev_class')" autofocus />
                                        <x-form.error for="prev_class" />
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="medical_history" value="{{ __('Medical History') }}" />
                                        <textarea class="form-control" id="medical_history" rows="5" name="medical_history"
                                            value="{{ old('medical_history') }}" placeholder="Medical History"></textarea>
                                    </div>
    
                                    <div class="col-sm-3 mb-3">
                                        <x-form.label for="allergics" value="{{ __('Allergics') }}" />
                                        <textarea class="form-control" id="allergics" rows="5" name="allergics"
                                            value="{{ old('allergics') }}" placeholder="Allergics"></textarea>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <br />
                                    <h3 style="margin-bottom: 10px">Parent's Section</h3>
                                    <hr/>
                                    <br />
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-sm-6">
                                            <h3>Father's Details</h3>

                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="father_name" value="{{ __('Full Name') }}" />
                                                    <x-form.input id="father_name" class="block w-full mt-1" type="text"
                                                        name="father_name" :value="old('father_name')" />
                                                    <x-form.error for="father_name" />
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="father_email" value="{{ __('Email') }}" />
                                                    <x-form.input id="father_email" class="block w-full mt-1" type="email" name="father_email"
                                                        :value="old('father_email')" />
                                                    <x-form.error for="father_email" />
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="father_phone" value="{{ __('Phone Number') }}" />
                                                    <x-form.input id="father_phone" class="block w-full mt-1" type="tel"
                                                        name="father_phone" :value="old('father_phone')" />
                                                    <x-form.error for="father_phone" />
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="father_occupation" value="{{ __('Occupation') }}" />
                                                    <x-form.input id="father_occupation" class="block w-full mt-1"
                                                        type="father_occupation" name="father_occupation" :value="old('father_occupation')" />
                                                    <x-form.error for="father_occupation" />
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="father_office_address" value="{{ __('Office Address') }}" />
                                                    <x-form.input id="father_office_address" class="block w-full mt-1"
                                                        type="text" name="father_office_address" :value="old('father_office_address')" />
                                                    <x-form.error for="father_office_address" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <h3>Mother's Details</h3>

                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="mother_name" value="{{ __('Full Name') }}" />
                                                    <x-form.input id="mother_name" class="block w-full mt-1" type="text"
                                                        name="mother_name" :value="old('mother_name')" />
                                                    <x-form.error for="mother_name" />
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="mother_email" value="{{ __('Email') }}" />
                                                    <x-form.input id="mother_email" class="block w-full mt-1" type="mother_email" name="mother_email"
                                                        :value="old('mother_email')" />
                                                    <x-form.error for="mother_email" />
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="mother_phone" value="{{ __('Phone Number') }}" />
                                                    <x-form.input id="mother_phone" class="block w-full mt-1" type="tel"
                                                        name="mother_phone" :value="old('mother_phone')" />
                                                    <x-form.error for="mother_phone" />
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="mother_occupation" value="{{ __('Occupation') }}" />
                                                    <x-form.input id="mother_occupation" class="block w-full mt-1"
                                                        type="mother_occupation" name="mother_occupation" :value="old('mother_occupation')" />
                                                    <x-form.error for="mother_occupation" />
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <x-form.label for="mother_office_address" value="{{ __('Office Address') }}" />
                                                    <x-form.input id="mother_office_address" class="block w-full mt-1"
                                                        type="text" name="mother_office_address" :value="old('mother_office_address')" />
                                                    <x-form.error for="mother_office_address" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save
                                Student</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    @section('scripts')
        <script>
            $('#img-show').click(function() {
                $('#image').click();
            });

            var input = document.querySelector('input[type=file]');
            input.onchange = function () {
                var file = input.files[0];
                drawOnCanvas(file);   // see Example 6
                // displayAsImage(file); // see Example 7
            };

            function drawOnCanvas(file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var dataURL = e.target.result,
                        c = document.querySelector('#img-show'), // see Example 4
                        ctx = c.getContext('2d'),
                        img = new Image();

                    $('#img-show-container').show()

                    img.onload = function() {
                    c.width = img.width;
                    c.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    };
                    img.src = dataURL;
                };
                reader.readAsDataURL(file);
            }

            $(document).on('submit', '#createStudent', function (e) {
                e.preventDefault();
                let formData = new FormData($('#createStudent')[0]);
                toggleAble('#submit', true, 'Submitting...');
                var url = $(this).attr('action');

                $.ajax({
                    method: "POST",
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble('#submit', false);
                        toastr.success(res.message, 'Success!');
                        $('#img-show-container').hide();
                    }else{
                        toggleAble('#submit', false);
                        toastr.error(res.message, 'Success!');
                    }
                    resetForm('#createStudent')
                }).fail((err) => {
                    toggleAble('#submit', false);
                    let allErrors = Object.values(err.responseJSON.errors)
                        .map(el => `<li>${el}</li>`)
                        .reduce((prev, next) => prev + next, '');

                    const setErrors = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>${allErrors}</ul>
                        </div>
                    `;

                    $('.modalErrorr').html(setErrors);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });
        </script>
    @endsection
    
</x-app-layout>

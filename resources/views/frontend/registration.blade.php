<x-base-layout>
    <x-slot name="header">
        <p>{{ $title }}</p>
    </x-slot>
    @registrationLinkEnabled
        <section class="counter_area mt-80 pt-10 pb-60">
            <div class="container">
                <div class="modalErrorr"></div>
                <form id="registration" enctype="multipart/form-data">
                    @csrf

                    <div style="margin: 10px 0">
                        <h5 style="margin-bottom: 10px">Child's personal data</h5>
                        <p>Please fill in appropriate details.</p>
                    </div>

                    <div class="row" style="display: flex; justify-content: center; align-items: center">
                            <div style="margin-right: 10px; padding: 5px">
                                <x-form.label for="image" value="{{ __('Passport Photograph') }}" />
                                <x-form.input id="image" class="block w-full mt-1" type="file" name="image" style="display: none"/>
                            </div>
                            <div style="">
                                <canvas style="border-radius: 5px; margin: 5px; width: 150px; height: 150px" id="img-show" class="img-thumbnail img-response"></canvas>
                            </div>
                    </div>

                    <div class="row" style="margin-top: 20px">

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="first_name" value="{{ __('First Name') }}" />
                            <x-form.input id="first_name" class="block w-full mt-1" type="text" name="first_name"
                                :value="old('first_name')" id="first_name"  />
                            <x-form.error for="first_name" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="last_name" value="{{ __('Last Name') }}" />
                            <x-form.input id="last_name" class="block w-full mt-1" type="text" name="last_name"
                                :value="old('last_name')" id="last_name" />
                            <x-form.error for="last_name" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="other_name" value="{{ __('Other Name') }}" />
                            <x-form.input id="other_name" class="block w-full mt-1" type="text" name="other_name"
                                :value="old('other_name')" id="other_name" />
                            <x-form.error for="other_name" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="dob" value="{{ __('Date of Birth') }}" />
                            <x-form.input id="dob" class="block w-full mt-1" type="date" name="dob" id="dob" />
                            <x-form.error for="dob" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="nationality" value="{{ __('Nationality') }}" />
                            <x-form.input class="block w-full mt-1" type="text" name="nationality"
                                :value="old('nationality')" />
                            <x-form.error for="nationality" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="state_of_origin" value="{{ __('State of Origin') }}" />
                            <x-form.input class="block w-full mt-1" type="text" name="state_of_origin"
                                :value="old('state_of_origin')" />
                            <x-form.error for="state_of_origin" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="local_government" value="{{ __('Local Government') }}" />
                            <x-form.input class="block w-full mt-1" type="text" name="local_government"
                                :value="old('local_government')" />
                            <x-form.error for="local_government" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="address" value="{{ __('Residential Address') }}" />
                            <x-form.input class="block w-full mt-1" type="text" name="address"
                                :value="old('address')" />
                            <x-form.error for="address" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="prev_school" value="{{ __('Last School Attended') }}" />
                            <x-form.input class="block w-full mt-1" type="text"
                                name="prev_school" :value="old('prev_school')" />
                            <x-form.error for="prev_school" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="prev_class" value="{{ __('Previous Class') }}" />
                            <x-form.input class="block w-full mt-1" type="text" name="prev_class"
                                :value="old('prev_class')" />
                            <x-form.error for="prev_class" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="religion" value="{{ __('Religion') }}" />
                            <br />
                            <select class="form-control" name="religion" :value="old('religion')">
                                <option>Select</option>
                                <option value="Christianity">Christianity</option>
                                <option value="Islam">Islam</option>
                                <option value="African Traditional Religion">African Traditional Religion</option>
                            </select>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="denomination" value="{{ __('Denomination') }}" /> 
                            <!-- <span style="color: red; font-size: 10px">(if Catholic)</span> -->
                            <x-form.input class="block w-full mt-1" type="text" name="denomination"
                                :value="old('denomination')" />
                            <x-form.error for="denomination" />
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="gender" value="{{ __('Gender') }}" />
                            <br />
                            <select class="form-control" name="gender" :value="old('gender')">
                                <option>Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="category" value="{{ __('Category') }}" />
                            <br />
                            <select class="form-control" name="category" :value="old('category')">
                                <option>Select</option>
                                <option value="primary">Primary</option>
                                <option value="secondary">Secondary</option>
                            </select>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="gender" value="{{ __('Gender') }}" />
                            <br />
                            <select class="form-control" name="gender" :value="old('gender')">
                                <option>Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="grade_id" value="{{ __('Class') }}" />
                            <br />
                            <select class="form-control" name="grade_id">
                                <option>Select</option>
                                @foreach ($grades as $grade)
                                <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <h5 style="margin-bottom: 10px">Medical Details</h5>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="blood_group" value="{{ __('Blood Group') }}" />
                                    <br />
                                    <select class="form-control" name="blood_group" :value="old('blood_group')">
                                        <option>Select</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="genotype" value="{{ __('Genotype') }}" />
                                    <br />
                                    <select class="form-control" name="genotype" :value="old('genotype')">
                                        <option>Select</option>
                                        <option value="AA">AA</option>
                                        <option value="AS">AS</option>
                                        <option value="AC">AC</option>
                                        <option value="SS">SS</option>
                                        <option value="SC">SC</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="speech_development" value="{{ __('Speech Development') }}" />
                                    <br />
                                    <select class="form-control" name="speech_development" :value="old('speech_development')">
                                        <option>Select</option>
                                        <option value="Average">Average</option>
                                        <option value="Slow">Slow</option>
                                        <option value="Fast">Fast</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="sight" value="{{ __('Sight') }}" />
                                    <br />
                                    <select class="form-control" name="sight" :value="old('sight')">
                                        <option>Select</option>
                                        <option value="Total Blindness">Total Blindness</option>
                                        <option value="Partial Blindness">Partial Blindness</option>
                                        <option value="Clear Vision">Clear Vision</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="medical_history" value="{{ __('Medical History') }}" />
                                    <textarea class="form-control" id="medical_history" rows="5" name="medical_history"
                                        value="{{ old('medical_history') }}"></textarea>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="allergics" value="{{ __('Allergics') }}" />
                                    <textarea class="form-control" id="allergics" rows="5" name="allergics"
                                        value="{{ old('allergics') }}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5 style="margin-bottom: 10px">Parent's Section</h5>
                            <hr/>
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col-sm-6">
                                    <h5>Father's Details</h5>

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
                                    <h5>Mother's Details</h5>

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

                    <div class="row">
                        <div class="col-md-12">
                            <p><span style="color: red; font-size: 10px">If child is living with a relative complete the information below.</span></p>
                            <h5 style="">Guardian Section</h5>
                            <hr />

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="guardian_full_name" value="{{ __('Full Name') }}" />
                                    <x-form.input id="guardian_full_name" class="block w-full mt-1" type="text"
                                        name="guardian_full_name" :value="old('guardian_full_name')" />
                                    <x-form.error for="guardian_full_name" />
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="guardian_email" value="{{ __('Email') }}" />
                                    <x-form.input id="guardian_email" class="block w-full mt-1" type="guardian_email" name="guardian_email"
                                        :value="old('guardian_email')" />
                                    <x-form.error for="guardian_email" />
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="guardian_phone_number" value="{{ __('Phone Number') }}" />
                                    <x-form.input id="guardian_phone_number" class="block w-full mt-1" type="tel"
                                        name="guardian_phone_number" :value="old('guardian_phone_number')" />
                                    <x-form.error for="guardian_phone_number" />
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="guardian_occupation" value="{{ __('Occupation') }}" />
                                    <x-form.input id="guardian_occupation" class="block w-full mt-1"
                                        type="guardian_occupation" name="guardian_occupation" :value="old('guardian_occupation')" />
                                    <x-form.error for="guardian_occupation" />
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="guardian_office_address" value="{{ __('Office Address') }}" />
                                    <x-form.input id="guardian_office_address" class="block w-full mt-1"
                                        type="text" name="guardian_office_address" :value="old('guardian_office_address')" />
                                    <x-form.error for="guardian_office_address" />
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="guardian_home_address" value="{{ __('Home Address') }}" />
                                    <x-form.input id="guardian_home_address" class="block w-full mt-1" type="text"
                                        name="guardian_home_address" :value="old('guardian_home_address')" />
                                    <x-form.error for="guardian_home_address" />
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="guardian_relationship" value="{{ __('Relationship') }}" />
                                    <x-form.input id="guardian_relationship" class="block w-full mt-1" type="text"
                                        name="guardian_relationship" :value="old('guardian_relationship')" />
                                    <x-form.error for="guardian_relationship" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5 style="">Declaration</h5>
                            <div class="col-sm-12 mb-3">
                                <input type="checkbox" id="agreement" />
                                <x-form.label class="text-danger" for="agree" value="{{ __('I hereby confirm that the information provided above is correct.') }}" />
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                        <button disabled="disabled" id="submit" type="submit" class="btn btn-secondary block waves-effect waves-light pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    @else
    <section class="counter_area mt-80 pt-10 pb-60">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="mt-50">
                        <img src="{{ asset('images/maintenance.svg') }}" alt="Not available">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about_content_4">
                        <div class="section_title mt-40">
                            <h3 class="main_title">Registration closed!</h3>
                            <p>Registration is not available for now. please contact the school for further information.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endregistrationLinkEnabled

    <div class="modal fade" id="pdfDownloadModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Registration Complete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Your registration was successful. You can now download your registration summary PDF and proceed to the school for submission with a receipt for payment.
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary download-btn" target="_blank">Download PDF</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
        <script>

            $('#img-show').click(function() {
                $('#image').click();
            });
            
            var cherker = document.getElementById('agreement');
            var sendBtn = document.getElementById('submit');

            cherker.onchange = function(){
                if(this.checked){
                    sendBtn.disabled = false;
                }else{
                    sendBtn.disabled = true;
                }
            }
            var input = document.querySelector('input[type=file]'); // see Example 4
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $(document).on('submit', '#registration', function (e) {
                e.preventDefault();
                let formData = new FormData($('#registration')[0]);
                toggleAble('#submit', true, 'Submitting...');
                var url = "pre-student/registration";

                $.ajax({
                    method: "POST",
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    if (res.status === true) {
                        toggleAble('#submit', false);
                        toastr.success(res.message, 'Success!');
                        $('#img-show-container').hide();

                        if (res.pdf_url) {
                            $('#pdfDownloadModal .download-btn').attr('href', res.pdf_url);
                            $('#pdfDownloadModal').modal('show');
                        }

                        resetForm('#registration');
                    } else {
                        toggleAble('#submit', false);
                        toastr.error(res.message, 'Error!');
                    }

                    resetForm('#registration')
                }).fail((err) => {
                    console.log(err);
                    toggleAble('#submit', false);
                    let allErrors = Object.values(err.responseJSON.errors).map(el => (
                            el = `<li>${el}</li>`
                        )).reduce((next, prev) => ( next = prev + next ));

                    const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul>${allErrors}</ul>
                                        </div>
                                        `;

                    $('.modalErrorr').html(setErrors);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });
        </script>
    @endsection
</x-base-layout>

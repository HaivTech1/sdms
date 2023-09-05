<x-app-layout>
    @section('title', application('name')." | Playgroup Result Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Create Playgroup Result</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Upload</li>
                </ol>
            </div>
        </x-slot>

        @php
            $students = App\Models\Student::whereHas('grade', function($query){
               $query->where('title', 'like', 'Primary 1');
            })->get();

            $periods = App\Models\Period::all();
            $terms = App\Models\Term::all();
        @endphp
    
        @examUploadEnabled
        <div class="row">
            <div class="col-sm-12">
                <div class="card-body">            
                    <form id='createResult'>
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control" id="selected_student">
                                    <option value=''>Select Student</option>
                                    @foreach ($students as $student)
                                    <option value="{{  $student->id() }}">
                                        {{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control" name="period_id" id="period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                    <x-form.error for="period_id" />
                                </select>

                            </div>

                            <div class="col-lg-3">
                                <select class="form-control" name="term_id" id="term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                    <x-form.error for="term_id" />
                                </select>

                            </div>

                            <div class="col-lg-3">
                                <div class="d-flex justify-content-center align-self-center">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i> Generate Sheet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class='row mt-4'>
                        @php
                            $exam_format = get_settings('exam_format');
                        @endphp
                       
                        <form id="uploadPlaygroupResult" action="{{ route('result.playgroup.store') }}" method="POST">
                            @csrf
                        
                                <div class='table-responsive'>
                                    <table class="table align-middle table-nowrap" id="student-data">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Subjects</th>
                                                <th>Activity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm 12 d-flex justify-content-center flex-wrap gap-2">
                                    <button type="submit" id="upload_playgroup_btn"
                                        class="btn btn-primary block waves-effect waves-light pull-right">
                                        Upload Result
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="row justify-content-center mt-5">
                        <div class="col-sm-4">
                            <div class="maintenance-img">
                                <img src="{{ asset('images/coming-soon.svg') }}" alt="" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <h4 class="mt-5">Uploadng disabled</h4>
                    <p class="text-muted">Please contact the administrator to gain access to this.</p>
                </div>
            </div>
        </div>
    @endexamUploadEnabled

    @section('scripts')
        <script>
            $('#selected_student').on('change', function(){
                var id = $(this).val();
                
                $.ajax({
                    method: 'GET',
                    url: '{{ route('result.student.subjects', ["student_id" => ":student_id"]) }}'.replace(':student_id', id),
                }).done((response) => {
                    
                    var subjects = response;
                    var html = '';

                    var numeracy = { 'counting': 'Counting' };
                    var work = { 'recognition': 'Recognition' };
                    var literacy = {
                    'writing': 'Writing',
                    'recognition': 'Recognition',
                    'reading_of_letters': 'Reading of Letters',
                    'letter_sounds': 'Letter sounds'
                    };

                    var subjectsWithRemarks = [];

                    $.each(subjects, function(index, subject) {
                        html += '<tr>';
                        html += '<td style="width: 5%">';
                        html += '<p class="text-left">' + subject.name + '</p>';
                        html += '</td>';
                        html += '<td>';
                        html += '<input type="hidden" value="' + subject.id + '" name="subject_id[]" />';
                        html += '<input type="text" name="remark[' + subject.id + ']" class="form-control block w-full mt-1" style="height: 60px" value="" placeholder="Teacher remark..." />'; // Use the subject ID as the key for remarks
                        html += '</td>';
                        html += '</tr>';

                        subjectsWithRemarks.push({ id: subject.id, remark: '' });
                    });


                    $('#student-data tbody').html(html);
                }).fail((error) => {
                    console.log(error.responseJSON.message);
                });
            });

            $(document).on('submit', '#uploadPlaygroupResult', function(e){
                e.preventDefault();
                
                var button = "#upload_playgroup_btn"
                toggleAble(button, true, 'Submitting Result...');
                var data = $(this).serializeArray();
                var url = $(this).attr('action');

                var period = $('#period_id').val();
                var term = $('#term_id').val();
                var student = $('#selected_student').val();

                data.push({name: 'period_id', value: period}); 
                data.push({ name: 'term_id', value: term});
                data.push({ name: 'student_id', value: student});

                if(period && term){
                    $.ajax({
                        method: 'POST',
                        url,
                        data
                    }).done((response) => {
                        toggleAble(button, false);
                        resetForm($(this));
                        toastr.success(response.message, 'Submitted Successfully!')
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                }else {
                    toggleAble(button, false);
                    toastr.info("The session, term and student must be selected", 'Note!')
                }
            });
        </script>
    @endsection
    </x-app-layout>
<div>
    <x-loading />

    
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-6">
                    <x-search />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="">
                        <button class="btn btn-sm btn-secondary" 
                            data-bs-toggle="modal"
                            data-bs-target=".excelResultModal" 
                        >
                            <i class="bx bxs-file-doc"></i> 
                            Upload Excel Result
                        </button>
                        {{-- <button class="btn btn-sm btn-danger" 
                            data-bs-toggle="modal"
                            data-bs-target=".generatePdfResultModal" 
                        >
                            <i class="bx bxs-file-pdf"></i> 
                            Generate PDF Result
                        </button> --}}
                    </div>
                    <div class="mt-2">
                        <form wire:submit.prevent="fetchResult">
                            <div class="row">
                                <div class="col-lg-3">
                                    <select class="form-control" wire:model.defer="grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-lg-3">
                                    <select class="form-control " wire:model.defer="period_id">
                                        <option value=''>Select Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="period_id" />
                                </div>

                                <div class="col-lg-3">
                                    <select class="form-control select2" wire:model.defer="term_id">
                                        <option value=''>Select Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="term_id" />
                                </div>
                                <div class="col-lg-3">
                                    <div class="d-flex justify-content-center align-self-center">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                            <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if ($grade_id)
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 py-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-nowrap mb-0">
                                        @if (count($students) > 0)
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Name of Student</th>
                                                    <th scope="col" class="text-center">
                                                        Recorded Subjects
                                                    </th>

                                                    <th scope="col" class="text-center" id="action">
                                                        Action
                                                    </th>
                                                    
                                                </tr>
                                            </thead>
                                        @endif

                                            <tbody>
                                                @forelse ($students as $student)
                                                    @if ($student->midTermResults->where('grade_id', $student->grade->id())->where('term_id', $term_id)->where('period_id', $period_id)->count())
                                                        <tr>
                                                            <td class='text-center'>{{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}</td>
                                                            <td class='text-center'>
                                                                {{ $student->midTermResults->where('grade_id', $student->grade->id())->where('term_id', $term_id)->where('period_id', $period_id)->count() }}
                                                            </td>
                                                            
                                                            <td class='d-flex justify-content-center align-items-center gap-2'>
                                                                <button 
                                                                    wire:key='{{ $student->id() }}'
                                                                    class="btn btn-sm btn-secondary recorded"
                                                                    data-student="{{ $student->id() }}"
                                                                    data-grade="{{ $grade_id }}"
                                                                    data-period="{{ $period_id }}"
                                                                    data-term="{{ $term_id }}"
                                                                >
                                                                    <i class="fa fa-cogs"></i> View Recorded
                                                                </button>

                                                                <a href="{{ route('result.midterm.show', $student) }}?grade_id={{$grade_id}}&period_id={{$period_id}}&term_id={{$term_id}}"
                                                                    type="button"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Click to view result"
                                                                    class="btn btn-sm btn-success"
                                                                    >
                                                                    <i class="fa fa-eye"></i> View Result
                                                                </a>
                                                                @admin
                                                                    @if (publishMidState($student->id(), $period_id, $term_id))
                                                                        <div class="d-flex gap-2">
                                                                            <button type="button" id='cummulative{{ $student->id() }}' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                                                <span class="badge bg-success">Published</span>
                                                                            </button>
                                                                            <form action="{{ route('result.midterm.pdf') }}" method="POST">
                                                                                @csrf

                                                                                <input type="hidden" name="student_id" value="{{ $student->id() }}" />
                                                                                <input type="hidden" name="grade_id" value="{{ $student->grade->id() }}" />
                                                                                <input type="hidden" name="period_id" value="{{ $period_id }}" />
                                                                                <input type="hidden" name="term_id" value="{{ $term_id }}" />

                                                                                <button class="btn btn-sm btn-info" type="submit">
                                                                                   <i class="bx bxs-file-pdf"></i> PDF
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    @else
                                                                        <button class="btn btn-sm btn-primary" type="button" id='cummulative{{ $student->id() }}' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                                            <i class="mdi mdi-upload d-block font-size-16"></i> Publish
                                                                        </button>
                                                                    @endif
                                                                @endadmin
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <div class="noresult py-2">
                                                        <div class="text-center">
                                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px"></lord-icon>
                                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $students->links('pagination::custom-pagination')}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade generatePdfResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate pdf result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="pdfResultDownload">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="grade_id" id="pdf_grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-lg-4">
                                    <select class="form-control" name="period_id" id="pdf_period_id">
                                        <option value=''>Select Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="period_id" />
                                </div>

                                <div class="col-lg-4">
                                    <select class="form-control" name="term_id" id="pdf_term_id">
                                        <option value=''>Select Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="term_id" />
                                </div>
                            </div>

                            <div class="progress mb-4 mt-2">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    0%
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="generate-pdf-btn" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    <i class="bx bx-cloud-download"></i>
                                    Download Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download pdf results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="downloadLinksList"></ul>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade excelResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload excel result sheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="excelResultUpload" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-lg-2">
                                    <select class="form-control" name="grade_id" id="excel_grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-lg-2 student-select">
                                    <select class="form-control" name="student_id">
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <select class="form-control " name="period_id">
                                        <option value=''>Select Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="period_id" />
                                </div>

                                <div class="col-lg-2">
                                    <select class="form-control select2" name="term_id">
                                        <option value=''>Select Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="term_id" />
                                </div>

                                <div class="col-lg-2">
                                    <x-form.input id="excel" class="block w-full" type="file" name="excel_file"/>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="excel_upload_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Upload Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade previewResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Result Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <button data-student-id="" class="btn btn-sm btn-secondary addResult" ><i class="bx bx-plus"></i> Add Result</button>
                            </div>
                        </div>

                        <input name="result_id" id="result_id" type="hidden" />

                        <div class="col-sm-12 mb-2">
                            @php
                                $midtermForm = get_settings('midterm_format');
                            @endphp
                            <div class="table-responsive">
                                <table id="students-result" class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            @foreach ($midtermForm as $key => $value)
                                                <th>{{ $value['full_name'] }}</th>
                                            @endforeach
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Score</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" id="scoreInput" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveScoreBtn">Save</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade addResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="resultUpload" method="POST">
                            @csrf
                            <input name="student_id" id="add_student_id" type="hidden" />
                            <input name="period_id" value="{{ $period_id }}" type="hidden" />
                            <input name="term_id" value="{{ $term_id }}" type="hidden" />

                            @php
                                $midtermForm = get_settings('midterm_format');
                                $subjects = \App\Models\Subject::all();
                            @endphp

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="subject_id">
                                        <option value=''>Subject</option>
                                        @foreach ($subjects as $subject)
                                        <option value="{{  $subject->id() }}">{{  $subject->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select id="format-select" class="form-control">
                                        <option value="">Select test type</option>
                                        @foreach ($midtermForm as $key => $value)
                                            <option value="{{ $key }}">{{ $value['full_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <x-form.input style='width: 70px' class="text-center required midterm-input" type='number'
                                        name='' value="" step="0.01" onblur="validateInput(this)" disabled/>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="submit_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Upload Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
        <script>

            $(document).ready(function(){
                $('.midterm-input').prop('disabled', true);
                {{-- $('#progress-bar').css('display', 'none'); --}}

                $('#format-select').on('change', function() {
                    var selectedFormat = $(this).val();
                    $('.midterm-input').prop('disabled', true);
                    
                    if (selectedFormat !== '') {
                        $('.midterm-input').prop('disabled', false);
                        $('.midterm-input').attr('name', selectedFormat);
                        } else {
                        $('.midterm-input').attr('name', '');
                    }
                });

                $('.recorded').on('click', function(){
                    var button = $(this);
                    toggleAble(button, true)

                    var id = $(this).data('student');
                    var classId = $(this).data('grade');
                    var sessionId = $(this).data('period');
                    var termId = $(this).data('term');

                    $.ajax({
                        url: '{{ route("result.fetch.midterm", ["student_id" => ":student_id",  "period_id" => ":period_id", "term_id" => ":term_id", "grade_id" => ":grade_id"]) }}'.replace(':student_id', id).replace(':period_id', sessionId).replace(':term_id', termId).replace(':grade_id', classId),
                        type: 'GET',
                        dataType: 'json',
                    }).done((response) => {
                        toggleAble(button, false);
                        var results = response.results;

                        var html = '';
                        $.each(results, function(index, result) {
                        html += '<tr>';
                        html += '<td>' + result.subject_name + '</td>';

                        var resultScores = results;
                        var midtermFormat = JSON.parse('<?php echo json_encode($midtermForm); ?>');

                        $.each(midtermFormat, function(midtermKey, midtermValue) {
                            var score = '-';
                            if (midtermKey in result) {
                                score = result[midtermKey];
                            }
                            html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-midterm-key="' + midtermKey + '">' + score + '</td>';
                        });

                        html += '<td><button class="btn btn-sm btn-danger btn-rounded waves-effect waves-light mb-2 me-2 remove" data-id="' + result.result_id + '"><i class="bx bx-trash"></button></td>';
                        html += '</tr>';
                        });

                        $('#students-result tbody').html(html);
                        $('.addResult').data('student-id', id)
                        $('.previewResultModal').modal('toggle');

                        $('.score-cell').click(function() {
                            var resultId = $(this).data('result-id');
                            var subjectId = $(this).data('subject-id');
                            var midtermKey = $(this).data('midterm-key');
                            var currentScore = $(this).text();
                            $('#scoreInput').val(currentScore);
                            $('#saveScoreBtn').data('result-id', resultId);
                            $('#saveScoreBtn').data('subject-id', subjectId);
                            $('#saveScoreBtn').data('midterm-key', midtermKey);
                            $('#editModal').modal('show');
                        });

                        $('#saveScoreBtn').click(function() {
                            var button = $(this);
                            toggleAble(button, true, 'Updating...');
                            var resultId = $(this).data('result-id');
                            var subjectId = $(this).data('subject-id');
                            var midtermKey = $(this).data('midterm-key');
                            var editedScore = $('#scoreInput').val();

                            Swal.fire({
                                title: 'Confirm Submission',
                                text: 'Are you sure you want to update the score?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#502179',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Update'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                    });
                            
                                    $.ajax({
                                        url: '{{ route('result.update.midterm') }}',
                                        type: 'POST',
                                        data: {result_id: resultId, subject_id: subjectId, field: midtermKey, score: editedScore},
                                    }).done((response) => {
                                        toggleAble(button, false);
                                        Swal.fire('Updated!', response.message, 'success');
                                        $('.score-cell[data-subject-id="' + subjectId + '"][data-midterm-key="' + midtermKey + '"]').text(editedScore);
                                        $('#editModal').modal('toggle');
                                    }).fail((error) => {
                                        toggleAble(button, false);
                                        console.log(error);
                                        toastr.error(error.responseJSON.message, 'Failed!');
                                    });
                                }else{
                                    toggleAble(button, false);
                                }
                            });
                        });

                        $('.addResult').click(function(){
                            $('.previewResultModal').modal('toggle');
                            var student = $(this).data('student-id');
                            document.getElementById('add_student_id').value = student;
                            $('.addResultModal').modal('toggle');
                        });

                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                        console.log(error);
                    });
                });
            });

            function validateInput(input) {
                var selectedFormat = $('#format-select').val();
                var marks = JSON.parse('{!! json_encode($midtermForm) !!}');
                var mark = parseFloat(marks[selectedFormat].mark);
                var value = parseFloat(input.value);

                if (value > mark) {
                    input.classList.add('is-invalid');
                    input.nextElementSibling.textContent = 'Value cannot be greater than ' + mark;
                } else {
                    input.nextElementSibling.textContent = '';
                    input.classList.remove('is-invalid');
                }
            }

            function publish(student){
                var data = student.split(",");
                var student_id = data[0];
                var period_id = data[1];
                var term_id = data[2];
                var grade_id = data[3];
                toggleAble('#cummulative'+student_id, true);

                $.ajax({
                    url: '{{ route('result.midterm.publish') }}' ,
                    method: 'GET',
                    data: {student_id, period_id, term_id, grade_id }
                }).done((res) => {
                        if(res.status === true) {
                            toggleAble('#cummulative'+student_id, false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#cummulative'+student_id, false);
                            toastr.error(res.message, 'Success!');
                        }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#cummulative'+student_id, false);
                });
            }

            $(document).on('click', '.remove', function(e) {
                e.preventDefault();
                var button = $(this);
                toggleAble(button, true);
                var resultId = $(this).data('id');
                var row = $(this).closest('tr');

                Swal.fire({
                    title: 'Confirm Deletion',
                    text: 'Are you sure you want to delete this item?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#502179',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        });

                        $.ajax({
                            url: "{{ route('result.delete.midterm', ["result_id" => ":result_id"]) }}".replace(':result_id', resultId),
                            method: 'DELETE',
                            success: function(response) {
                                toggleAble(button, false);
                                Swal.fire('Deleted!', response.message, 'success');
                                row.remove();
                                setTimeout(function(){
                                    window.location.reload();
                                },1000)
                            },
                            error: function(response) {
                                toggleAble(button, false);
                                console.log(response.responseJSON.message);
                            }
                        });
                        
                    }else{
                        toggleAble(button, false);
                    }
                });

            });

            $('#resultUpload').on('submit', function(event) {
                event.preventDefault();
                var button = $('#submit_button')
                toggleAble(button, true, 'Submitting...');
                var selectedFormat = $('#format-select').val();

                if (selectedFormat === '') {
                    toastr.info('Please select the score type', 'Note!');
                    toggleAble(button, false);
                    return;
                }else{
                    let inputs = $('.midterm-input.required');
                    let invalid = false;

                    inputs.each(function() {
                        if (!$(this).val()) {
                            $(this).addClass('is-invalid');
                            $(this).siblings('.invalid-feedback').html('This field is required.');
                            invalid = true;
                        }
                    });

                    if (invalid) {
                        toggleAble(button, false);
                        toastr.error('Please fill in all required fields.', 'Validation Error!');
                        return;
                    }

                    var url = "{{ route('result.add.midterm') }}";
                    var data = $('#resultUpload').serializeArray();
                    data.push({ name: 'format', value: selectedFormat });

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#resultUpload');
                    }).fail((err) => {
                        toggleAble(button, false);
                        let allErrors = Object.values(err.responseJSON).map(el => (
                        el = `<li>${el}</li>`
                        )).reduce((next, prev) => (next = prev + next));

                        const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul>${allErrors}</ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>`;

                        $('.modalErrorr').html(setErrors);
                    });
                }
            });

            $(document).on('submit', '#excelResultUpload', function (e) {
                e.preventDefault();
                var button = $('#excel_upload_button')
                let formData = new FormData($('#excelResultUpload')[0]);
                toggleAble(button, true, 'Uploading Result...');

                Swal.fire({
                    title: 'Confirm Uploading of Result',
                    text: 'Are you sure you want to upload the file?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#502179',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Upload'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        });

                        $.ajax({
                            method: "POST",
                            url: "{{ route('result.excel.midterm.upload') }}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                        }).done((res) => {
                            toggleAble(button, false);
                            {{-- resetForm('#excelResultUpload') --}}
                            {{-- $('.excelResultModal').modal('toggle'); --}}
                            Swal.fire('Uploaded!', res.message, 'success');
                        }).fail((err) => {
                            console.log(err);
                            toggleAble(button, false);
                            toastr.error(err.responseJSON.message, 'Failed!');
                        });
                    }else{
                        toggleAble(button, false);
                    }
                });
            });

            $('#excel_grade_id').change(function(){
                var grade = $(this).val();
                var select = $('.student-select select');
                select.empty();

                $.ajax({
                    url: "{{ route("result.get.students",["grade_id" => ":grade_id"]) }}".replace(':grade_id', grade),
                    method: 'GET',
                    success: function(response) {
                        var students = response;
                        select.empty();
                        $.each(students, function (index, student) {
                            var option = $('<option>');
                            option.attr('value', student.uuid);
                            option.text(student.last_name + ' ' + student.first_name + ' ' + student.other_name);
                            select.append(option);
                        });

                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message);
                    }
                });
            });

            $(document).ready(function() {
                $('#pdfResultDownload').on('submit', function(e) {
                    e.preventDefault();
                    var button = $('#generate-pdf-btn');
                    toggleAble(button, true, 'Generating...');
                    var progressBar = $('#progress-bar');

                    progressBar.css('width', '0%');
                    progressBar.text('0%');

                    var gradeId = $('#pdf_grade_id').val();
                    var sessionId = $('#pdf_period_id').val();
                    var termId = $('#pdf_term_id').val();

                    $.ajax({
                        url: "{{ route('result.generate-pdf.midterm', ["grade_id" => ":grade_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}".replace(':grade_id', gradeId).replace(':period_id', sessionId).replace(':term_id', termId),
                        xhr: function() {
                           var xhr = new window.XMLHttpRequest();

                            xhr.upload.addEventListener('progress', function(event) {
                                if (event.lengthComputable) {
                                    var percentComplete = (event.loaded / event.total) * 100;
                                    progressBar.css('width', percentComplete + '%');
                                    progressBar.text(percentComplete.toFixed(0) + '%');
                                }
                            }, false);

                            return xhr;
                        },
                    }).done((response) => {
                        console.log(response.links);
                        toggleAble(button, false);
                        progressBar.css('width', '100%');
                        progressBar.text('100%');

                        {{-- var downloadLinks = response.downloadLinks;
                        console.log(downloadLinks);
                        var downloadLinksList = $('#downloadLinksList');
                        downloadLinksList.empty();
                        
                        for (var i = 0; i < downloadLinks.length; i++) {
                            var link = downloadLinks[i];
                            var listItem = $('<li>').html('<a href="' + link + '" download>Download File ' + (i + 1) + '</a>');
                            downloadLinksList.append(listItem);
                        } --}}
                        
                        $('#downloadModal').modal('toggle')
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error);
                        toastr.error(error.responseJSON.message);
                    });
                });
            });

            function extractProgressValue(response) {
                console.log(response);
                // Extract the progress value from the response using a regular expression or any other method
                // Parse the progress value and return it as a number
                // If the progress value cannot be extracted, return null
                // Example:
                // var progress = response.match(/Progress: (\d+)/);
                // return progress ? parseFloat(progress[1]) : null;
                // Modify this function according to your response structure and extraction method
            }

            function generatePDF(student){
                var data = student.split(",");
                var student_id = data[0];
                var period_id = data[1];
                var term_id = data[2];
                var grade_id = data[3];
                toggleAble('#generatePDF'+student_id, true);

                $.ajax({
                    url: '{{ route('result.midterm.pdf') }}' ,
                    method: 'GET',
                    data: {student_id, period_id, term_id, grade_id }
                }).done((res) => {
                    toggleAble('#generatePDF'+student_id, false);
                    toastr.success(res.message, 'Success!');
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#generatePDF'+student_id, false);
                });
            }
        </script>
    @endsection

</div>

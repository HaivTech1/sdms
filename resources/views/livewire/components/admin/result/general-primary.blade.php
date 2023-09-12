<div>
    <x-loading />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="mt-2">
                            <form id="fetchResultForm">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <select class="form-control getStudents" id="grade_id" name="grade_id">
                                            <option value=''>Class</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <select class="form-control" id="student_id" name="student_id">
                                            <option value=''>Student</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <select class="form-control" id="period_id" name="period_id">
                                            <option value=''>Select Session</option>
                                            @foreach ($periods as $period)
                                            <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="period_id" />
                                    </div>

                                    <div class="col-lg-2">
                                        <select class="form-control" id="term_id" name="term_id">
                                            <option value=''>Select Term</option>
                                            @foreach ($terms as $term)
                                            <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="term_id" />
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="d-flex justify-content-center align-item-center">
                                            <button type="submit" id="fetchResultButton" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                                Fetch
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 py-4">
                            <div class="table-responsive">
                                <table id="result-data" class="table table-bordered table-striped table-nowrap mb-0">
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

                                    <tbody>
                                        
                                    </tbody>

                                    {{-- <tbody wire:ignore>
                                        @foreach ($students as $student)
                                        <tr>
                                            <td class='text-center'>{{ $student->firstName() }} {{ $student->lastName() }}</td>
                                            <td class='text-center'>
                                                {{ $student->primaryResults->where('term_id', $term_id)->where('period_id', $period_id)->count() }}
                                            </td>
                                            @php
                                                $comments = \App\Models\Cognitive::where([
                                                    'student_uuid' => $student->id(),
                                                    'term_id' => $term_id,
                                                    'period_id' => $period_id
                                                ])->first()
                                            @endphp
                                            
                                            <td class='d-flex justify-content-center align-items-center gap-2'>
                                                
                                                <button 
                                                    wire:key="{{ $student->id() }}"
                                                    type="button"
                                                    class="btn btn-sm btn-secondary recorded"
                                                    data-student="{{ $student->id() }}"
                                                    data-grade="{{ $grade_id }}"
                                                    data-period="{{ $period_id }}"
                                                    data-term="{{ $term_id }}"
                                                >
                                                    <i class="fa fa-cogs"></i> View Recorded
                                                </button>
                                                <button 
                                                            wire:key="{{ $student->id() }}"
                                                            type="button"
                                                            wire:ignore class="btn btn-sm btn-info editCom"
                                                            data-id="{{$student->id()}}" 
                                                            data-term="{{$term_id}}"
                                                            data-period="{{$period_id}}"
                                                            data-total="{{$comments->attendance_duration ?? ''}}"
                                                            data-present="{{$comments->attendance_present ?? ''}}"
                                                            data-comment="{{$comments->comment ?? ''}}"
                                                    >
                                                        Comment
                                                </button>
                                                @if (affectives($student, $term_id, $period_id) === false)
                                                    <button 
                                                        wire:key="{{ $student->id() }}"
                                                        type="button" class="btn btn-sm btn-secondary uploadAffective" 
                                                        data-student="{{ $student->id() }}"
                                                        data-period="{{ $period_id }}"
                                                        data-term="{{ $term_id }}"
                                                    >
                                                        <i class="fas fa-compress-arrows-alt"></i>
                                                        Affective
                                                    </button>
                                                @endif
                                                @if (psychomotors($student, $term_id, $period_id) === false)
                                                    <button 
                                                        wire:key="{{ $student->id() }}"
                                                        type="button" 
                                                        class="btn btn-sm btn-secondary uploadPsychomotor"
                                                        data-student="{{ $student->id() }}"
                                                        data-period="{{ $period_id }}"
                                                        data-term="{{ $term_id }}"
                                                    >
                                                        <i class="fas fa-compress-arrows-alt"></i>
                                                        Psychomotor
                                                    </button>
                                                @endif
                                                <a class="btn btn-sm btn-success" href="{{ route('result.primary.show', $student) }}?grade_id={{$grade_id}}&period_id={{$period_id}}&term_id={{$term_id}}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Click to view result">
                                                    <i class="bx bx-show"></i>
                                                    Show
                                                </a>
                                                @admin
                                                    @if (publishExamState($student->id(), $period_id, $term_id))
                                                        <div class="d-flex gap-2">
                                                            <button type="button" id='cummulative{{ $student->id() }}' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                                <span class="badge bg-success"><i class="bx bx-upload"></i> Published</span>
                                                            </button>
                                                            <form action="{{ route('result.exam.pdf') }}" method="POST">
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
                                                        <button type="button" class="btn btn-sm btn-primary" id='cummulative{{ $student->id() }}' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                            <i class="bx bx-upload"></i> Publish
                                                        </button>
                                                    @endif
                                                    <button 
                                                        wire:key="{{ $student->id() }}"
                                                        type="button" 
                                                        class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteResultModal"
                                                        wire:click="deleteResult('{{ $student->id() }}')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                @endadmin
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')

    {{-- <script>
        $('#fetchResultForm').on('submit', function(e){
            e.preventDefault();
            var button = $('#fetchResultButton');
            toggleAble(button, true, 'Fetching...');

            var grade = $('#grade_id').val();
            var period = $('#period_id').val();
            var term = $('#term_id').val();

            $.ajax({
                url: '{{ route("result.check.exam", ["period_id" => ":period_id", "term_id" => ":term_id", "grade_id" => ":grade_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':grade_id', grade),
                type: 'GET',
                dataType: 'json',
            }).done((response) => {
                toggleAble(button, false);
                var students = response.students;

                var html = '';
                if (response.grade_name === 'Playgroup') {

                    $.each(students, function(index, student) {
                        html += '<tr>';
                        html += '<td class="text-center">' + student.name + '</td>';
                        html += '<td class="text-center">' + student.recorded_subjects + '</td>';
                        html += '<td>';
                        html += '<button class="btn btn-sm btn-info editCom" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '" target="_blank"><i class="bx bx-conversation"></i> Comment</button>';
                        html += '<button class="btn btn-sm btn-danger editPlayResult" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '"><i class="bx bx-edit"></i> Edit</button>';
                        html += '<?php if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->gradeClassTeacher()->exists()): ?>';                   
                        html += '<button class="btn btn-sm btn-primary uploadAffective gap-2" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '">';
                        html += '<i class="fas fa-compress-arrows-alt"></i> Affective';
                        html += '</button>';
                        html += '<?php endif; ?>';
                        html += '<a target="_blank" href="{{ route('result.playgroup.show', ['student' => ':student']) }}'.replace(':student', student.id) + '?grade_id=' + response.grade + '&period_id=' + response.period + '&term_id=' + response.term + '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view result" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Result</a>';
                        html += '<div class="d-flex gap-2">';
                        html += '<?php if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()): ?>';
                        html += '<?php if (publishMidState(' + student.id + ', ' + response.period + ', ' + response.term + ')): ?>';
                        html += '<button type="button" class="btn-sm btn-warning" id="cummulative' + student.id + '" onClick="publish(\'' + student.id + ',' + response.period + ',' + response.term + ',' + response.grade + '\')">';
                        html += '<span>Publish</span>';
                        html += '</button>';
                        html += '<form action="{{ route('result.playgroup.pdf') }}" method="POST">';
                        html += '@csrf';
                        html += '<input type="hidden" name="student_id" value="' + student.id + '" />';
                        html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                        html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                        html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                        html += '<button class="btn btn-sm btn-info" type="submit">';
                        html += '<i class="bx bxs-file-pdf"></i> PDF';
                        html += '</button>';
                        html += '</form>';
                        html += '<?php else: ?>';
                        html += '<button type="button" class="btn-sm btn-warning" id="cummulative' + student.id + '" onClick="publish(\'' + student.id + ',' + response.period + ',' + response.term + ',' + response.grade + '\')">';
                        html += '<i class="mdi mdi-upload d-block font-size-16"></i> Publish';
                        html += '</button>';
                        html += '<?php endif; ?>';
                        html += '<?php endif; ?>';
                        html += '</div>';
                        html += '</td>';
                        html += '</tr>';
                    });

                } else {
                    $.each(students, function(index, student) {
                        html += '<tr>';
                        html += '<td class="text-center">' + student.name + '</td>';
                        html += '<td class="text-center">' + student.recorded_subjects + '</td>';
                        html += '<td>';
                        html += '<button class="btn btn-sm btn-secondary recorded" data-grade="'+response.grade+'" data-period="'+response.period+'" data-term="'+response.term+'" data-student="' + student.id + '"><i class="fa fa-cogs"></i> View Recorded</button>';
                        html += '<button class="btn btn-sm btn-info editCom" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '" target="_blank"><i class="bx bx-conversation"></i> Comment</button>';
                        html += '<a target="_blank" href="{{ route('result.primary.show', ['student' => ':student']) }}'.replace(':student', student.id) + '?grade_id=' + response.grade + '&period_id=' + response.period + '&term_id=' + response.term + '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view result" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Result</a>';
                        html += '<?php if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->gradeClassTeacher()->exists()): ?>';                   
                        html += '<button class="btn btn-sm btn-secondary uploadAffective" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '">';
                        html += '<i class="fas fa-compress-arrows-alt"></i> Affective';
                        html += '</button>';
                        html += '<button class="btn btn-sm btn-secondary uploadPsychomotor gap-2" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '">';
                        html += '<i class="fas fa-compress-arrows-alt"></i> Psychomotor';
                        html += '</button>';
                        html += '<?php endif; ?>';
                        html += '<?php if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->gradeClassTeacher()->exists()): ?>';                   
                        html += '<button class="btn btn-sm btn-danger editPrincipalCom" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '" target="_blank"><i class="bx bx-conversation"></i> Principal Comment</button>';
                        html += '<?php endif; ?>';
                        html += '<div class="d-flex gap-2">';
                        html += '<?php if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()): ?>';
                        html += '<?php if (publishMidState(' + student.id + ', ' + response.period + ', ' + response.term + ')): ?>';
                        html += '<button type="button" class="btn-sm btn-warning" id="cummulative' + student.id + '" onClick="publish(\'' + student.id + ',' + response.period + ',' + response.term + ',' + response.grade + '\')">';
                        html += '<span>Publish</span>';
                        html += '</button>';
                        html += '<form action="{{ route('result.exam.pdf') }}" method="POST">';
                        html += '@csrf';
                        html += '<input type="hidden" name="student_id" value="' + student.id + '" />';
                        html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                        html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                        html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                        html += '<button class="btn btn-sm btn-info" type="submit">';
                        html += '<i class="bx bxs-file-pdf"></i> PDF';
                        html += '</button>';
                        html += '</form>';
                        html += '<?php else: ?>';
                        html += '<button type="button" class="btn-sm btn-warning" id="cummulative' + student.id + '" onClick="publish(\'' + student.id + ',' + response.period + ',' + response.term + ',' + response.grade + '\')">';
                        html += '<i class="mdi mdi-upload d-block font-size-16"></i> Publish';
                        html += '</button>';
                        html += '<?php endif; ?>';
                        html += '<?php endif; ?>';
                        html += '</div>';
                        html += '<?php if (auth()->user()->isSuperAdmin()): ?>';                   
                        html += '<button class="btn btn-sm btn-danger studentPositionSync" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '" target="_blank"><i class="bx bx-cog"></i> Cummulate Position</button>';
                        html += '<button class="btn btn-sm btn-danger studentSinglePositionSync" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '" target="_blank"><i class="bx bx-cog"></i> Cummulate Single Position</button>';
                        html += '<?php endif; ?>';
                        html += '</td>';
                        html += '</tr>';
                    });
                }

                $('#result-data tbody').html(html);

                $(".studentPositionSync").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.student.sync.position', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        console.log(response);
                        toastr.success(response.message, "Successfully.");
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(".studentSinglePositionSync").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.student.sync.single.position', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        console.log(response);
                        toastr.success(response.message, "Successfully.");
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $('.recorded').on('click', function(e){
                    var button = $(this);
                    toggleAble(button, true)

                    var id = $(this).data('student');
                    var classId = $(this).data('grade');
                    var sessionId = $(this).data('period');
                    var termId = $(this).data('term');

                    $.ajax({
                        url: '{{ route("result.fetch.exam", ["student_id" => ":student_id",  "period_id" => ":period_id", "term_id" => ":term_id", "grade_id" => ":grade_id"]) }}'.replace(':student_id', id).replace(':period_id', sessionId).replace(':term_id', termId).replace(':grade_id', classId),
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
                        var examFormat = JSON.parse('<?php echo json_encode($examForm); ?>');

                        $.each(examFormat, function(examKey, examValue) {
                            var score = '-';
                            if (examKey in result) {
                                score = result[examKey];
                            }
                            html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="' + examKey + '">' + score + '</td>';
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
                            var examKey = $(this).data('exam-key');
                            var currentScore = $(this).text();
                            $('#scoreInput').val(currentScore);
                            $('#saveScoreBtn').data('result-id', resultId);
                            $('#saveScoreBtn').data('subject-id', subjectId);
                            $('#saveScoreBtn').data('exam-key', examKey);
                            $('#editModal').modal('show');
                        });

                        $('#saveScoreBtn').click(function() {
                            var button = $(this);
                            toggleAble(button, true, 'Updating...');
                            var resultId = $(this).data('result-id');
                            var subjectId = $(this).data('subject-id');
                            var examKey = $(this).data('exam-key');
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
                                        url: '{{ route('result.update.exam') }}',
                                        type: 'POST',
                                        data: {result_id: resultId, subject_id: subjectId, field: examKey, score: editedScore},
                                    }).done((response) => {
                                        toggleAble(button, false);
                                        Swal.fire('Updated!', response.message, 'success');
                                        $('.score-cell[data-subject-id="' + subjectId + '"][data-exam-key="' + examKey + '"]').text(editedScore);
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

                $(".editCom").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.student.comment', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        console.log(response.comment);
                        if(response.comment != undefined || response.comment != null){
                            var total = response.comment.total;
                            var present = response.comment.present;
                            var comment = response.comment.comment;

                            document.getElementById('attendance_duration').value=total;
                            document.getElementById('attendance_present').value=present;
                            document.getElementById('attendance_comment').value=comment;
                        }else{
                            document.getElementById('attendance_duration').value = '';
                            document.getElementById('attendance_present').value = '';
                            document.getElementById('attendance_comment').value = '';
                        }

                        document.getElementById("student").value=id;
                        document.getElementById('periodC').value=period;
                        document.getElementById('termC').value=term;
                        $("#createCommentModal").modal('toggle');

                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(".editPrincipalCom").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.student.principalComment', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        var results = response.results;
                        
                        if(response.comment != undefined || response.comment != null || response.comment != []){
                            var comment = response.comment.principal_comment;
                            var promotion_comment = response.comment.promotion_comment;
                            document.getElementById('attendance_principal_comment').value = comment;
                            document.getElementById('attendance_promotion_comment').value = promotion_comment;
                        }else{
                            document.getElementById('attendance_principal_comment').value = '';
                            document.getElementById('attendance_promotion_comment').value = '';
                        }

                        document.getElementById("student_principal").value = id;
                        document.getElementById('period_principal').value = period;
                        document.getElementById('term_principal').value = term;

                        var html = '';
                        $.each(results, function (index, result){
                            html += '<tr>';
                            html += '<td>' + result.subject + '</td>';   
                            var midtermFormat = JSON.parse('<?php echo json_encode($midtermForm); ?>');
                            $.each(midtermFormat, function(midtermKey, midtermValue) {
                                var score = '-';
                                if (midtermKey in result) {
                                    score = result[midtermKey];
                                }
                                html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-midterm-key="' + midtermKey + '">' + score + '</td>';
                            });
                            
                            var examFormat = JSON.parse('<?php echo json_encode($examForm); ?>');
                            $.each(examFormat, function(examKey, examValue) {
                                var score = '-';
                                if (examKey in result) {
                                    score = result[examKey];
                                }
                                html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="' + examKey + '">' + score + '</td>';
                            });

                            html += '<td>' + result.total + '</td>';
                            html += '<td>' + result.position + '</td>'; 
                            html += '<td>' + result.position_grade + '</td>'; 
                            html += '<td>' + result.average + '</td>'; 
                            html += '<td>' + result.remark + '</td>'; 
                            html += '</tr>';
                        });

                        document.getElementById('aggregate-span').innerHTMl = response.knowAggregateResults

                        $('#principal-result-data tbody').html(html);
                        $("#createPrincipalCommentModal").modal('toggle');



                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(".uploadAffective").click(function(e) {
                    e.preventDefault();

                    var student = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $("#createAffectiveModal").modal('toggle');

                    document.getElementById("affective_student_id").value = student;
                    document.getElementById('affective_period_id').value = period;
                    document.getElementById('affective_term_id').value = term;
                });

                $(".uploadPsychomotor").click(function(e) {
                    e.preventDefault();

                    var student = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $("#createPsychomotorModal").modal('toggle');

                    document.getElementById("psychomotor_student_id").value = student;
                    document.getElementById('psychomotor_period_id').value = period;
                    document.getElementById('psychomotor_term_id').value = term;
                });

                $('.editPlayResult').click(function(e){
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.playgroup.student', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        var results = response.results;
                        var html = '';

                        $.each(results, function(index, result) {
                            if (typeof result.remark !== 'string') {
                                var formattedRemark = [];

                                for( var key in result.remark) {
                                    if(result.remark.hasOwnProperty(key)){
                                        formattedRemark.push(key + ': ' + result.remark[key]);
                                    }
                                }

                                result.remark   = formattedRemark.join('. ');

                            }

                            html += '<tr>';
                            html += '<td style="width: 5%">';
                            html += '<p class="text-left">' + result.subject_name + '</p>';
                            html += '</td>';
                            html += '<td>';
                            html += '<input type="hidden" value="' + result.subject_id + '" name="subject_id[]" />';
                            html += '<input type="text" name="remark[' + result.subject_id + ']" class="form-control block w-full mt-1" style="height: 60px" value="'+ result.remark+'" />';
                            html += '</td>';
                            html += '</tr>';

                        });

                        document.getElementById('edit_playgroup_student').value = response.student_id;
                        document.getElementById('edit_playgroup_period').value = response.period_id;
                        document.getElementById('edit_playgroup_term').value = response.term_id;

                        $('#edit-play-result tbody').html(html);
                        $(".editPlayModal").modal('toggle');
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                })

            }).fail((error) => {
                toggleAble(button, false);
                toastr.error(error.responseJSON.message);
                console.log(error);
            });
        });

        $(document).on('submit', '#uploadPlaygroupResult', function(e){
            e.preventDefault();
            
            var button = "#upload_playgroup_btn"
            toggleAble(button, true, 'Submitting Result...');
            var data = $(this).serializeArray();
            var url = $(this).attr('action');

            $.ajax({
                method: 'POST',
                url,
                data
            }).done((response) => {
                toggleAble(button, false);
                resetForm($(this));
                toastr.success(response.message, 'Submitted Successfully!');
                $('.editPlayModal').modal('toggle');
            }).fail((error) => {
                toggleAble(button, false);
                console.log(error.responseJSON.message);
            });
           
        });

        $(document).ready(function(){
            $('.exam-input').prop('disabled', true);

            $('#format-select').on('change', function() {
                var selectedFormat = $(this).val();
                $('.exam-input').prop('disabled', true);
                
                if (selectedFormat !== '') {
                    $('.exam-input').prop('disabled', false);
                    $('.exam-input').attr('name', selectedFormat);
                    } else {
                    $('.exam-input').attr('name', '');
                }
            });
        });

        function validateInput(input) {
            var selectedFormat = $('#format-select').val();
            var marks = JSON.parse('{!! json_encode($examForm) !!}');
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
    </script> --}}

    <script>
        $(document).ready(function() {
            var student_uuid = $("input[name=student_uuid]").val();
            var period_id = $("input[name=period_id]").val();
            var term_id = $("input[name=term_id]").val();
            
            $('#createAffective').submit((e) => {
                e.preventDefault();
                toggleAble('#affective_button', true, 'Submitting...');

                var data = $('#createAffective').serializeArray();
                var url = "{{ route('result.affective.upload') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data,
                }).done((res) => {
                    toggleAble('#affective_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createAffective');
                     $("#createAffectiveModal").modal('toggle');

                    setTimeout(()=> {
                        window.location.reload();
                    }, 1000)
                }).fail((res) => {
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#affective_button', false);
                });
            });

            $('#createPsychomotor').submit((e) => {
                e.preventDefault();
                toggleAble('#psychomotor_button', true, 'Submitting...');

                var data = $('#createPsychomotor').serializeArray();
                var url = "{{ route('result.psychomotor.upload') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble('#psychomotor_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createPsychomotor');
                    $("#createPsychomotorModal").modal('toggle');

                    setTimeout(()=> {
                        window.location.reload();
                    }, 1000)
                }).fail((res) => {
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#psychomotor_button', false);
                });

                
            });

            $('#createComment').submit((e) => {
                e.preventDefault();
                toggleAble('#submit_comment', true, 'Submitting...');

                var data = $('#createComment').serializeArray();
                var url = '/result/cognitive/upload';
                var type = $(this).attr('method')

                $.ajax({
                    type: 'POST',
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble('#submit_comment', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createComment');
                        $("#createCommentModal").modal('toggle');
                        {{-- setTimeout(function(){
                            window.location.reload();
                        }, 1000); --}}
                    }
                }).fail((res) => {
                    toggleAble('#submit_comment', false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            });

            $('#createPrincipalComment').submit((e) => {
                e.preventDefault();
                var button = "#submit_principal_comment";
                toggleAble(button, true, 'Submitting...');

                var data = $('#createPrincipalComment').serializeArray();
                var url = '{{ route('result.principal.comment.upload') }}';

                $.ajax({
                    type: 'POST',
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createComment');
                        $("#createPrincipalCommentModal").modal('toggle');
                    }
                }).fail((res) => {
                    toggleAble(button, false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            });

            $.ajax({
                type: "GET",
                url: "{{ route('result.psychomotor.get') }}",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                psy = data
                if(data.length > 0){
                    $("#psychomoting").css("display", "none");
                }
            });

            $.ajax({
                type: "GET",
                url: "{{ route('result.affective.get') }}",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                if(data.length > 0){
                    $("#affecting").css("display", "none");
                }
            })

            $.ajax({
                type: "GET",
                url: "{{ route('result.cummulative.get') }}",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                if(data.length > 0){
                    $("#cummulative").css("display", "none");
                }
            })
            
        });
    </script>

    <script>
       
        $('.getStudents').on('change', function() {
            var id = $(this).val();
            
            $.ajax({
                url: "{{ route('') }}",
                method: 'GET',
                data: { levelId: levelId, attendanceId: attendanceId },
                success: function(response) {
                    var students = response.students;
                    console.log(students)
                },
                error: function(response) {
                    toastr.error(response.responseJSON.message);
                }
            });
        });
    </script>
    @endsection

</div>

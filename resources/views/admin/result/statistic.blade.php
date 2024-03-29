<x-app-layout>
    @section('title', application('name')." | Result Statistic Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Grade Result</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Statistic</li>
                </ol>
            </div>
        </x-slot>
        
        <div class="row">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <div class="my-2 text-center">
                                    <h1 class="card-title">Students class ranking</h1>
                                </div>
                            </div>

                            <div class="row">
                                <form id="class-performance">
                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label for="class-select">Class</label>
                                            <select class="form-control" id="class-performance-grade" name="grade_id">
                                                <option value="">Select Class</option>
                                                @foreach($grades as $class)
                                                    <option value="{{ $class->id }}">{{ $class->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                            <label for="session-select">Session</label>
                                            <select class="form-control" id="class-performance-period" name="period_id">
                                                <option value="">Select Session</option>
                                                @foreach($sessions as $session)
                                                    <option value="{{ $session->id() }}">{{ $session->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 my-4">
                                            <button id="class-performance-btn" type="submit" class="btn btn-primary btn-sm">
                                                <i class="bx bx-search-alt"></i> Generate Sheet
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="">
                                    <div class='table-responsive'>
                                        <table class="table align-middle table-nowrap" id="class-data">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th class="text-center">1st term</th>
                                                    <th class="text-center">2nd term</th>
                                                    <th class="text-center">3rd term</th>
                                                    <th class="text-center">Total</th>
                                                    <th class="text-center">Position in Grade</th>
                                                </tr>
                                            </thead>
                                            <form action="{{ route('result.download.class.statistic') }}" method="POST">
                                                @csrf

                                                <input type="hidden" name="grade_id" id="download_class_grade_id" />
                                                <input type="hidden" name="subject_id" id="download_class_subject_id" />
                                                <input type="hidden" name="period_id" id="download_class_period_id" />

                                                <div>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </div>

                                                <div class="row">
                                                    <button type="submit" class="btn btn-sm btn-primary">Download</button>
                                                </div>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <div class="my-2 text-center">
                                    <h1 class="card-title">Students ranking per grade</h1>
                                </div>
                            </div>

                            <div class="row">
                                <form id="grade-performance">
                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label for="class-select">Class</label>
                                            <select class="form-control" id="grade-performance-grade" name="grade_id">
                                                <option value="">Select Class</option>
                                                @foreach($grades as $class)
                                                    <option value="{{ $class->id }}">{{ $class->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                            <label for="session-select">Session</label>
                                            <select class="form-control" id="grade-performance-period" name="period_id">
                                                <option value="">Select Session</option>
                                                @foreach($sessions as $session)
                                                    <option value="{{ $session->id() }}">{{ $session->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4 my-4">
                                            <button id="grade-performance-btn" type="submit" class="btn btn-primary btn-sm">
                                                <i class="bx bx-search-alt"></i> Generate Sheet
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="">
                                    <div class='table-responsive'>
                                        <table class="table align-middle table-nowrap" id="student-data">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th class="text-center">1st term</th>
                                                    <th class="text-center">2nd term</th>
                                                    <th class="text-center">3rd term</th>
                                                    <th class="text-center">Total</th>
                                                    <th class="text-center">Position in Grade</th>
                                                </tr>
                                            </thead>
                                            <form action="{{ route('result.download.grade.statistic') }}" method="POST">
                                                @csrf

                                                <input type="hidden" name="grade_id" id="download_grade_grade_id" />
                                                <input type="hidden" name="subject_id" id="download_grade_subject_id" />
                                                <input type="hidden" name="period_id" id="download_grade_period_id" />

                                                <div>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </div>

                                                <div class="row">
                                                    <button type="submit" class="btn btn-sm btn-primary">Download</button>
                                                </div>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <div class="my-2 text-center">
                                    <h1 class="card-title">Students ranking per subject in grade</h1>
                                </div>
                            </div>

                            <div class="row">
                                <form id="subject-performance">
                                    <div class="row">
                                        <div class="col-sm-3 form-group">
                                            <label for="subject-performance-grade">Class</label>
                                            <select class="form-control" id="subject-performance-grade" name="grade_id">
                                                <option value="">Select Class</option>
                                                @foreach($grades as $class)
                                                    <option value="{{ $class->id }}">{{ $class->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="subject_id">Subject</label>
                                            <select class="form-control" id="subject-performance-subject" name="subject_id">
                                                <option>Select Subject</option>
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="subject-performance-period">Session</label>
                                            <select class="form-control" id="subject-performance-period" name="period_id">
                                                <option value="">Select Session</option>
                                                @foreach($sessions as $session)
                                                    <option value="{{ $session->id() }}">{{ $session->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 my-4">
                                            <button id="subject-performance-btn" type="submit" class="btn btn-primary btn-sm">
                                                <i class="bx bx-search-alt"></i> Generate sheet
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="">
                                    <div class='table-responsive'>
                                        <table class="table align-middle table-nowrap" id="subject-data">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th class="text-center">1st term</th>
                                                    <th class="text-center">2nd term</th>
                                                    <th class="text-center">3rd term</th>
                                                    <th class="text-center">Total</th>
                                                    <th class="text-center">Position in Grade</th>
                                                </tr>
                                            </thead>
                                            <form action="{{ route('result.download.subject.statistic') }}" method="POST">
                                                @csrf

                                                <input type="hidden" name="grade_id" id="download_grade_id" />
                                                <input type="hidden" name="subject_id" id="download_subject_id" />
                                                <input type="hidden" name="period_id" id="download_period_id" />

                                                <div>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </div>

                                                <div class="row">
                                                    <button type="submit" class="btn btn-sm btn-primary">Download</button>
                                                </div>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @section('scripts')
            <script>
                $(document).on('submit', '#class-performance', function (e) {
                    e.preventDefault();
                    var button = "#class-performance-btn"
                    toggleAble(button, true, 'Generating stat...');

                    var grade = $('#class-performance-grade').val();
                    var period = $('#class-performance-period').val();


                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.statistic.class.generate', ["grade_id" => ":grade_id", "period_id" => ":period_id"]) }}'.replace(':grade_id', grade).replace(':period_id', period),
                    }).done((response) => {
                        toggleAble(button, false);
                        var students = response.students;
                        var html = '';

                        $.each(students, function(index, student) {
                            html += '<tr>';
                            html += '<td class="text-left">' + (index + 1) + '</td>';
                            html += '<td class="text-left">' + student.student_name + '</td>';
                            html += '<td class="text-center">' + parseInt(student.first_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.second_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.third_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.total) + '</td>';
                            html += '<td class="text-center">' + student.position + '</td>';
                            html += '<td>';
                        });

                        document.getElementById('download_class_grade_id').value = grade;
                        document.getElementById('download_class_period_id').value = period;

                        $('#class-data tbody').html(html);
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(document).on('submit', '#grade-performance', function (e) {
                    e.preventDefault();
                    var button = "#grade-performance-btn"
                    toggleAble(button, true, 'Generating stat...');

                    var grade = $('#grade-performance-grade').val();
                    var period = $('#grade-performance-period').val();


                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.statistic.grade.generate', ["grade_id" => ":grade_id", "period_id" => ":period_id"]) }}'.replace(':grade_id', grade).replace(':period_id', period),
                    }).done((response) => {
                        toggleAble(button, false);
                        var students = response.students;
                        var html = '';

                        $.each(students, function(index, student) {
                            html += '<tr>';
                            html += '<td class="text-left">' + (index + 1) + '</td>';
                            html += '<td class="text-left">' + student.student_name + '</td>';
                            html += '<td class="text-center">' + parseInt(student.first_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.second_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.third_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.total) + '</td>';
                            html += '<td class="text-center">' + student.position + '</td>';
                            html += '<td>';
                        });

                        document.getElementById('download_grade_grade_id').value = grade;
                        document.getElementById('download_grade_period_id').value = period;

                        $('#student-data tbody').html(html);
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(document).on('submit', '#subject-performance', function (e) {
                    e.preventDefault();
                    var button = "#subject-performance-btn"
                    toggleAble(button, true, 'Generating stat...');

                    var grade = $('#subject-performance-grade').val();
                    var period = $('#subject-performance-period').val();
                    var subject = $('#subject-performance-subject').val();


                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.statistic.subject.generate', ["grade_id" => ":grade_id", "period_id" => ":period_id", "subject_id" => ":subject_id"]) }}'.replace(':grade_id', grade).replace(':period_id', period).replace(':subject_id', subject),
                    }).done((response) => {
                        toggleAble(button, false);
                        var students = response.students;
                        var html = '';

                        $.each(students, function(index, student) {
                            html += '<tr>';
                            html += '<td class="text-left">' + (index + 1) + '</td>';
                            html += '<td class="text-left">' + student.student_name + '</td>';
                            html += '<td class="text-center">' + parseInt(student.first_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.second_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.third_term_total) + '</td>';
                            html += '<td class="text-center">' + parseInt(student.total) + '</td>';
                            html += '<td class="text-center">' + student.position + '</td>';
                            html += '<td>';
                        });

                        document.getElementById('download_grade_id').value = grade;
                        document.getElementById('download_subject_id').value = subject;
                        document.getElementById('download_period_id').value = period;

                        $('#subject-data tbody').html(html);
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });
            </script>
        @endsection
    </x-app-layout>
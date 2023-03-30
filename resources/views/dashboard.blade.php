<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">{{ $user->user_type}}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </x-slot>

    @php
        $results = \App\Models\MidTerm::where('grade_id', 5)->select('subject_id', 'entry_1', 'entry_2', 'first_test', 'ca', 'project')->get();
        $labels = $results->pluck('subject_id')->unique()->values()->toArray(); // array of unique subject IDs

        $datasets = [];
        $datasets[] = [
            'label' => 'First Entry',
            'data' => $results->pluck('entry_1')->toArray(),
            'backgroundColor' => 'rgba(255, 99, 132, 0.2)', // set a color for the dataset
            'borderColor' => 'rgba(255, 99, 132, 1)', // set the border color
            'borderWidth' => 1 // set the border width
        ];
        $datasets[] = [
            'label' => 'Second Entry',
            'data' => $results->pluck('entry_2')->toArray(),
            'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
            'borderColor' => 'rgba(54, 162, 235, 1)',
            'borderWidth' => 1
        ];
        $datasets[] = [
            'label' => 'First Test',
            'data' => $results->pluck('first_test')->toArray(),
            'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
            'borderColor' => 'rgba(255, 206, 86, 1)',
            'borderWidth' => 1
        ];
        $datasets[] = [
            'label' => 'Continuous Assessment',
            'data' => $results->pluck('ca')->toArray(),
            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
            'borderColor' => 'rgba(75, 192, 192, 1)',
            'borderWidth' => 1
        ];
        $datasets[] = [
            'label' => 'Project',
            'data' => $results->pluck('project')->toArray(),
            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
            'borderColor' => 'rgba(75, 192, 192, 1)',
            'borderWidth' => 1
        ];

    @endphp

    <div class="row">
        <div class="col-xl-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Welcome Back to !</h5>
                                        <p>{{ application('name') }}</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-8">
                                    <div class="avatar-md profile-user-wid">
                                        <img src="{{ asset('storage/'.$user->image()) }}" alt="" class="img-thumbnail rounded-circle avatar-sm">
                                    </div>
                                    <div>
                                        <h5><span class="badge badge-soft-info">Name:</span> {{  $user->name() }}</h5>
                                        <p class="text-muted mb-1"><span class="badge badge-soft-info">Reg No.:</span> {{ $user->code() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    @php
                        $news = \App\Models\News::all();
                        $hairstyles = \App\Models\Hairstyle::all();
                    @endphp
                    <button type="button" class="btn btn-primary waves-effect waves-light" 
                    data-bs-toggle="modal" data-bs-target=".newsModal">Create school news ({{ $news->count() }})</button>
                    <button type="button" class="btn btn-success waves-effect waves-light" 
                    data-bs-toggle="modal" data-bs-target=".hairstyleModal">Create Hairstyle ({{ $hairstyles->count() }})</button>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
             <div class="row">
                <div class="col-lg-12">
                    <div class="p-4">
                        <p style="font-weight: bold; font-size: 20px">{{ application('name') }}</p>
                        <div class="mt-2">
                            <div class="onoffswitch3">
                                <input type="checkbox" name="onoffswitch3" class="onoffswitch3-checkbox" id="myonoffswitch3" checked>
                                <label class="onoffswitch3-label" for="myonoffswitch3">
                                    <span class="onoffswitch3-inner">
                                        <span class="onoffswitch3-active">
                                            <marquee class="scroll-text">
                                                @foreach($events as $event)
                                                    <span>{{ $event->title()}}: {{ strip_tags($event->description())}}</span> 
                                                    <span class="bx bx-caret-right"></span> 
                                                @endforeach
                                            </marquee>
                                            <span class="onoffswitch3-switch">BREAKING NEWS <span class="bx bx-x"></span></span>
                                        </span>
                                        <span class="onoffswitch3-inactive"><span class="onoffswitch3-switch">SHOW BREAKING NEWS</span></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @bursal
            <div class="row p-4">
                <x-card.slot title="Paystack Balance" amount="$balance" iconClass="bx bx-money"></x-card.slot>
            </div>
            @endbursal
            
            @admin
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 align-self-center">
                                        <div class="text-lg-center mt-4 mt-lg-0">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Session</p>
                                                        <h5 class="mb-0">{{ $session?->title() ?? 'Not set'}}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Term</p>
                                                        <h5 class="mb-0">{{ $term?->title() ?? 'Not set'}}</h5>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endadmin
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                     <div class="card-header">
                        <div class="my-2 text-center">
                            <h1 class="card-title">Students ranking per class</h1>
                        </div>

                        <form id="rankingForm">
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="class-select">Class</label>
                                    <select class="form-control" id="grade-select" name="class_id">
                                        <option value="">Select Class</option>
                                        @foreach($grades as $class)
                                            <option value="{{ $class->id }}">{{ $class->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="term-select">Term</label>
                                    <select class="form-control" id="term" name="term">
                                        <option value="">Select Term</option>
                                        @foreach($terms as $term)
                                            <option value="{{ $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="session-select">Session</label>
                                    <select class="form-control" id="session" name="session">
                                        <option value="">Select Session</option>
                                        @foreach($sessions as $session)
                                            <option value="{{ $session->id() }}">{{ $session->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 my-4">
                                    <button id="rankingBtn" type="submit" class="btn btn-primary btn-sm">
                                        <i class="bx bx-search-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                   <canvas id="ranking"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                     <div class="card-header">
                        <div class="my-2 text-center">
                            <h1 class="card-title">Student's performance in all subjects</h1>
                        </div>

                        <form id="performance">
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="class-select">Class</label>
                                    <select class="form-control" id="class-select" name="class_id">
                                        <option value="">Select Class</option>
                                        @foreach($grades as $class)
                                            <option value="{{ $class->id }}">{{ $class->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="student-select">Student</label>
                                    <select class="form-control" id="student-select" name="student_id">
                                        <option>Select Student</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="term-select">Term</label>
                                    <select class="form-control" id="term-select" name="term">
                                        <option value="">Select Term</option>
                                        @foreach($terms as $term)
                                            <option value="{{ $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="session-select">Session</label>
                                    <select class="form-control" id="session-select" name="session">
                                        <option value="">Select Session</option>
                                        @foreach($sessions as $session)
                                            <option value="{{ $session->id() }}">{{ $session->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1 my-4">
                                    <button id="submit" type="submit" class="btn btn-primary btn-sm">
                                        <i class="bx bx-search-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                   <canvas id="resultChat"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                  <canvas id="studentsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade newsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create school news</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="news" action="{{ route('news.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="title" value="{{ __('Title') }}" />
                                <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                    :value="old('title')" id="title" autofocus />
                                <x-form.error for="title" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="description" value="{{ __('Content') }}" />
                                        <textarea class="form-control" name="description" id="summernote">{{ old('content') }}</textarea>
                                <x-form.error for="description" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Make news public</label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                                <button id="newBtn" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade hairstyleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new hairstyle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="hairstyleForm" action="{{ route('hairstyle.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="title" value="{{ __('Title') }}" />
                                <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                    :value="old('title')" id="title" />
                                <x-form.error for="title" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="description" value="{{ __('Note') }}" />
                                <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                                <x-form.error for="description" />
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="side_view_input" class="form-label">Side View:</label>
                                    <input type="file" id="side_view_input" class="form-control" name="side_view" accept="image/*" onchange="previewImage('side_view_input', 'side_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="side_view_preview" src="#" alt="Side view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="front_view_input" class="form-label">Front View:</label>
                                    <input type="file" id="front_view_input" class="form-control" name="front_view" accept="image/*" onchange="previewImage('front_view_input', 'front_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="front_view_preview" src="#" alt="Front view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="back_view_input" class="form-label">Back View:</label>
                                    <input type="file" id="back_view_input" class="form-control" name="back_view" accept="image/*" onchange="previewImage('back_view_input', 'back_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="back_view_preview" src="#" alt="Back view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Activate</label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                                <button id="createHair" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')

         <script>
            $(document).ready(function() {
                // Populate student dropdown based on class selection
                $('#class-select').on('change', function() {
                    var classId = $(this).val();
                    $.ajax({
                        url: '/student/students-by-class',
                        method: 'GET',
                        data: {class: classId},
                    }).done((data) => {
                        $('#student-select').empty();
                        $.each(data, function(index, student) {
                            $('#student-select').append('<option value="' + student.uuid + '">' + student.last_name + ' ' + student.first_name + ' ' + student.other_name + '</option>');
                        });
                    }).fail((err) => {
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                });

                // Update chart based on student selection
                $(document).on('submit', '#performance', function(e) {
                    var existingChart = Chart.getChart("resultChat");

                    e.preventDefault();

                    toggleAble('#submit', true, 'Fetching...');
                    var classId = $('#class-select').val();
                    var studentId = $('#student-select').val();
                    var term = $('#term-select').val();
                    var session = $('#session-select').val();
                    $.ajax({
                        url: '/student/performance-by-student',
                        method: 'GET',
                        data: {classId: classId, studentId: studentId, term: term, session: session},
                    }).done((data) => {
                        toggleAble('#submit', false);

                            var subjects = [];
                            var scores = [];

                            $.each(data, function(index, result) {
                                var totalScore = result.ca1 + result.ca2 + result.project + result.exam;
                                subjects.push(result.subject);
                                scores.push(totalScore);
                            });

                            if (existingChart) {
                                existingChart.destroy();
                            }

                            var chartData = {
                                labels: subjects,
                                datasets: [
                                    {
                                        label: 'Total Score',
                                        data: scores,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            };

                            var ctx = $('#resultChat');
                            var chart = new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                    }).fail((err) => {
                        toggleAble('#submit', false);
                        console.log(err);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                });

                 $(document).on('submit', '#news', function(e) {
                    e.preventDefault();
                    toggleAble('#newBtn', true, 'Creating...');

                    var url = $(this).attr('action');
                    var data = $(this).serializeArray();
                    var method = $(this).attr('method');
                    
                    $.ajax({
                        url,
                        method,
                        data
                    }).done((res) => {
                        if(res.status === true) {
                            toggleAble('#newBtn', false);
                            toastr.success(res.message, 'Success!');
                            resetForm('#news')
                            $('.newsModal').modal('toggle');
                        }
                    }).fail((err) => {
                        toggleAble('#newBtn', false);
                        console.log(err);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                });

            });
        </script>

        <script>

            var audio = document.getElementById("myAudio");

            function playAudio() {
                audio.play();
            }

            function pauseAudio() {
                audio.pause();
            }

            @if(auth()->check() && auth()->user()->isAdmin() || auth()->check() && auth()->user()->isSuperAdmin())
                setInterval(function () {
                    $.get({
                        url: '{{ route('pending.registration') }}',
                        dataType: 'json',
                        success: function (response) {
                            if(response.status){
                                let data = response.data;
                                new_registration = data.new_registration;
                                if (new_registration > 0) {
                                    playAudio();
                                    $('#popup-modal').appendTo("body").modal('show');
                                }
                            }
                        },
                    });
                }, 10000);
            @endif
            
            function check_registration() {
                window.location.href = "/index/registration";
            }
        </script>

        <script>
            var studentsData = {!! json_encode($studentsData) !!};

            var years = [];
            var totals = [];

            studentsData.forEach(function(item) {
                years.push(item.year);
                totals.push(item.total);
            });

            var ctx = document.getElementById('studentsChart').getContext('2d');
            var studentsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: years,
                    datasets: [{
                        label: 'Total Students per Year',
                        data: totals,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                               
                            }
                        }]
                    }
                }
            });
        </script>
        
        <script>
              $(document).on('submit', '#rankingForm', function(e) {

                    e.preventDefault();
                    var existingRanking = Chart.getChart("ranking");

                    toggleAble('#rankingBtn', true, 'Fetching...');

                    var classId = $('#grade-select').val();
                    var term = $('#term').val();
                    var session = $('#session').val();

                    $.ajax({
                        url: '/student/class-ranking-student',
                        method: 'GET',
                        data: {classId: classId, term: term, session: session},
                    }).done((response) => {
                        if(response.status){
                            toggleAble('#rankingBtn', false);

                            var labels = [];
                            var data = [];

                            response.data.forEach(function(result) {
                                labels.push(result.name);
                                data.push(result.score);
                            });

                            if (existingRanking) {
                                existingRanking.destroy();
                            }

                            var ctx = document.getElementById('ranking').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Total Score',
                                        data: data,
                                        borderColor: 'rgb(75, 192, 192)',
                                        fill: false
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });

                        }
                    }).fail((err) => {
                        console.log(err);
                        toggleAble('#rankingBtn', false);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                });
        </script>

        <script>
            function previewImage(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.setAttribute('src', e.target.result);
                        preview.style.display = 'block';
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.setAttribute('src', '#');
                    preview.style.display = 'none';
                }
            }
        </script>

        {{-- <script>
            $('#hairstyleForm').on('submit', function(e){
                e.preventDefault();
                toggleAble('#createHair', true, 'Creating...');

                var url = $(this).attr('action');
                let formData = new FormData($('#hairstyleForm')[0]);
                var method = $(this).attr('method');

                $.ajax({
                    url,
                    method,
                    data: formData,
                }).done((response) => {
                    if(response.status){
                        toggleAble('#createHair', false);
                        toastr.success(response.message, 'Success!');
                        resetForm('#hairstyleForm')
                        $('.hairstyleModal').modal('toggle');

                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                    }
                }).fail((err) => {
                    console.log(err);
                    toggleAble('#createHair', false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            })
        </script> --}}
    @endsection
</x-app-layout>
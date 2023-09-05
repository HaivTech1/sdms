<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">{{ $user->user_type}}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-4">
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
                                <h5><span class="badge badge-soft-info">Name:</span> {{  $user->student->fullName() }}</h5>
                                <p class="text-muted mb-1"><span class="badge badge-soft-info">Reg No.:</span> {{ $user->code() }}</p>
                                <p class="text-muted mb-0"><span class="badge badge-soft-info">Class:</span> {{ $user->student->grade->title() }}</p>
                                     
                                {{-- <ul>
                                    @foreach ($user->student->grade->gradeClassTeacher as $key => $teacher)
                                        <li><span class="badge badge-soft-info">{{ $key+1 }}. Class Teacher:</span> {{ $teacher->title() }}. {{ $teacher->name() }}</li>
                                    @endforeach
                                </ul> --}}
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="btn-group dropend">
                                            <div type="button" class="btn waves-effect waves-light">
                                                <span class="badge badge-soft-success">Subjects: </span> {{ $user->student->totalSubjects() }} 
                                            </div>
                                            {{-- <div class="dropdown-menu">
                                                @foreach ($user->student->subjects as $subject)
                                                    <p class="dropdown-item">{{ $subject->title() }}</p>
                                                @endforeach
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="{{ asset('storage/'.application('image')) }}" alt="" class="avatar-md rounded-circle img-thumbnail">
                                        </div>
                                        <div class="flex-grow-1 align-self-center">
                                            @if (isset($user->student->guardian))
                                                <div class="text-muted">
                                                    <p class="mb-2">{{ $user->student->guardian->fullName()}}</p>
                                                    <p class="mb-2">{{ $user->student->guardian->email()}}</p>
                                                    <p class="mb-0">{{ $user->student->guardian->relationship()}}</p>
                                                    <p class="mb-0">{{ $user->student->guardian->phoneNumber()}}</p>
                                                </div>
                                            @elseif (isset($user->student->father))
                                                <div class="text-muted">
                                                    <p class="mb-2">{{ $user->student->father->fullName()}}</p>
                                                    <p class="mb-2">{{ $user->student->father->email()}}</p>
                                                    <p class="mb-0">{{ $user->student->father->phoneNumber()}}</p>
                                                </div>
                                            @elseif (isset($user->student->mother))
                                                <div class="text-muted">
                                                    <p class="mb-2">{{ $user->student->mother->fullName()}}</p>
                                                    <p class="mb-2">{{ $user->student->mother->email()}}</p>
                                                    <p class="mb-0">{{ $user->student->mother->phoneNumber()}}</p>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-4 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Session</p>
                                                    <h5 class="mb-0">{{ period('title')}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Term</p>
                                                    <h5 class="mb-0">{{ term('title')}}</h5>
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
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
             <div class="card">
                <div class="card-body">
                     <div class="card-header">
                        <div class="my-2 text-center">
                            <h1 class="card-title">This term's exam</h1>
                        </div>
                    </div>
                   <canvas id="thisTerm"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
             <div class="card">
                <div class="card-body">
                     <div class="card-header">
                        <div class="my-2 text-center">
                            <h1 class="card-title">Last term's exam</h1>
                        </div>
                    </div>
                   <canvas id="lastTerm"></canvas>
                </div>
            </div>
        </div>
    </div>



    @section('scripts')
        <script>
            $(document).ready(function() {
                var existingChart = Chart.getChart("thisTerm");

                var classId = @json(auth()->user()->student->grade->id());
                var studentId = @json(auth()->user()->student->id());
                var term = @json(term('id'));
                var session = @json(period('id'));

                $.get({
                    url: '/student/performance-by-student',
                    method: 'GET',
                    data: {classId: classId, studentId: studentId, term: term, session: session},
                }).done((data) => {
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

                    var ctx = $('#thisTerm');
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
                })
            });
        </script>

         <script>
            $(document).ready(function() {
                var existingChart = Chart.getChart("lastTerm");

                var classId = @json(auth()->user()->student->grade->id());
                var studentId = @json(auth()->user()->student->id());
                var term = @json(term('id') - 1);
                var session = @json(period('id'));

                $.get({
                    url: '/student/performance-by-student',
                    method: 'GET',
                    data: {classId: classId, studentId: studentId, term: term, session: session},
                }).done((data) => {
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

                    var ctx = $('#lastTerm');
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
                    console.log(err);
                })
            });
        </script>
    @endsection
</x-app-layout>
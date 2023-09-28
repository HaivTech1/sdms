<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                @can('setting_access')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-wrench"></i>
                            <span key="t-ecommerce">Site Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('user_management_access')
                                <li><a href="{{ route('user.index') }}" key="t-products">Users</a></li>
                            @endcan
                            {{-- <li><a href="{{ route('teams.index') }}" key="t-products">Team</a></li> --}}
                            @can('permission_access')
                                <li><a href="{{ route('permission.index') }}" key="t-products">Permissions</a></li>
                            @endcan
                            @can('role_access')
                                <li><a href="{{ route('role.index') }}" key="t-products">Roles</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('scratchcard_access')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-devices"></i>
                            <span key="t-ecommerce">Scratch Card</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="{{ route('user.generatePin') }}" key="t-products">Generate Pins</a>
                            </li>
                            <li><a href="{{ route('user.pins') }}" key="t-products">Print Pins</a></li>
                        </ul>
                    </li> 
                @endcan

                @include('partials.nav.admin')

                @can('result_access')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-folder-open"></i>
                            <span key="t-ecommerce">Result Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @can('result_create')
                                <li><a href="{{ route('result.batch.midterm.upload') }}" key="t-products">Subject Mid-term Upload </a></li>
                                <li><a href="{{ route('result.create') }}" key="t-products">Subject Exam Upload</a></li>
                                @can('playgroup_result_access')
                                    <li><a href="{{ route('result.playgroup.upload') }}" key="t-products">Playgroup Result Upload </a></li>
                                @endcan
                                <li><a href="{{ route('result.midterm.upload') }}" key="t-products">Student Mid-term Upload </a></li>
                                <li><a href="{{ route('result.singleUpload') }}" key="t-products">Student Exam Upload</a></li>
                            @endcan

                            @can('broadsheet_access')
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Broadsheet</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ route('result.subject.broadsheet') }}">View Subject</a></li>
                                        <li><a href="{{ route('result.class.broadsheet') }}">View Class</a></li>
                                    </ul>
                                </li>
                            @endcan
                            
                            @can('statistic_access')
                                <li>
                                    <a href="{{ route('result.statistic.show') }}" key="t-products">
                                        Score Statistics
                                    </a>
                                </li>
                            @endcan
                            @can('result_show')
                                <li>
                                    <a href="{{ route('result.view.results') }}" key="t-products">
                                        View Results
                                    </a>
                                </li>
                            @endcan
                            <li><a href="{{ route('result.midterm') }}" key="t-products">Check Mid-term Scores</a></li>
                            <li><a href="{{ route('result.primary') }}" key="t-products">Check Exam Scores</a></li>
                        </ul>
                    </li>
                @endcan

                @include('partials.nav.bursal')

                @include('partials.nav.teacher')

                @can('student_fee_access')
                    <li>
                        <a href="{{ route('student.fees') }}" class="waves-effect">
                            <i class="bx bx-credit-card"></i>
                            <span key="t-chat">Fee</span>
                        </a>
                    </li>
                @endcan

                @can('student_result_access')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-right-indent"></i>
                            <span key="t-ecommerce">Result</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('student_midterm_access')
                                <li><a href="{{ route('result.midtermIndex') }}" key="t-products">Mid-Term Result</a></li>
                            @endcan
                            @can('student_exam_access')
                                <li><a href="{{ route('result.index') }}" key="t-products">Exam Result</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('student_assignment_access')
                    <li>
                        <a href="{{ route('assignment.get') }}" class="waves-effect">
                            <i class="bx bx-right-indent"></i>
                            <span key="t-chat">Assignment</span>
                        </a>
                    </li>
                @endcan

                @can('student_lesson_access')
                    <li>
                        <a href="{{ route('lesson.index') }}" class="waves-effect">
                            <i class="bx bx-video"></i>
                            <span key="t-chat">Visual Class</span>
                        </a>
                    </li>
                @endcan

            
                @can('student_market_access')
                    <li>
                        <a class="waves-effect" href="{{ route('user.product.index') }}">
                            <i class="bx bx-store-alt"></i> 
                            <span key="t-chat">Market</span>
                        </a>
                    </li>
                @endcan

                @can('timetable_access')
                    <li>
                        <a href="{{ route('timetable.index') }}" class="waves-effect">
                            <i class="mdi mdi-clock-outline"></i>
                            <span key="t-chat">Timetable</span>
                        </a>
                    </li>
                @endcan
                @can('calendar_access')
                    <li>
                        <a class="waves-effect" href="{{ route('calendar.index') }}">
                            <i class="bx bx-calendar"></i> 
                            <span key="t-chat">School Calender</span>
                        </a>
                    </li>
                @endcan
                {{-- <li>
                    <a class="waves-effect" href="{{ route('calendar.index') }}">
                        <i class="bx bx-notepad"></i> 
                        <span key="t-chat">Edu Jobs</span>
                    </a>
                </li> --}}
                @can('schoolbus_access')
                    <li>
                        <a class="waves-effect" href="{{ route('user.schoolbus.index') }}">
                            <i class="bx bx-car"></i> 
                            <span key="t-chat">School Bus</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
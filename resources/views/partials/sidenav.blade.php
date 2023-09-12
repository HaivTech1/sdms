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
                @include('partials.nav.super')
                @include('partials.nav.admin')
                @if (!auth()->user()->isStudent())
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-folder-open"></i>
                            <span key="t-ecommerce">Result Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="{{ route('result.batch.midterm.upload') }}" key="t-products">Subject Mid-term Upload </a></li>
                            <li><a href="{{ route('result.create') }}" key="t-products">Subject Exam Upload</a></li>
                            <li><a href="{{ route('result.playgroup.upload') }}" key="t-products">Playgroup Result Upload </a></li>
                            @classTeacher
                                <li><a href="{{ route('result.midterm.upload') }}" key="t-products">Student Mid-term Upload </a></li>
                                <li><a href="{{ route('result.singleUpload') }}" key="t-products">Student Exam Upload</a></li>
                            @endclassTeacher

                            <li>
                                <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Broadsheet</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ route('result.subject.broadsheet') }}">Generate Subject List</a></li>
                                    <li><a href="{{ route('result.subject.broadsheet') }}">Generate Class List</a></li>
                                </ul>
                            </li>
                            @admin
                                <li>
                                    <a href="{{ route('result.statistic.show') }}" key="t-products">
                                        Score Statistics
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('result.view.results') }}" key="t-products">
                                        View Results
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('result.general') }}" key="t-products">
                                        General Results
                                    </a>
                                </li>
                            @endadmin
                            <li><a href="{{ route('result.midterm') }}" key="t-products">Check Mid-term Scores</a></li>
                            <li><a href="{{ route('result.primary') }}" key="t-products">Check Exam Scores</a></li>
                        </ul>
                    </li>
                @endif 
                @include('partials.nav.bursal')
                @include('partials.nav.teacher')
                @include('partials.nav.student')

                @if (auth()->user()->isStudent())
                    <li>
                        <a class="waves-effect" href="{{ route('user.product.index') }}">
                            <i class="bx bx-store-alt"></i> 
                            <span key="t-chat">Market</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('timetable.index') }}" class="waves-effect">
                            <i class="mdi mdi-clock-outline"></i>
                            <span key="t-chat">Timetable</span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect" href="{{ route('calendar.index') }}">
                            <i class="bx bx-calendar"></i> 
                            <span key="t-chat">School Calender</span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect" href="{{ route('calendar.index') }}">
                            <i class="bx bx-notepad"></i> 
                            <span key="t-chat">Edu Jobs</span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect" href="{{ route('user.schoolbus.index') }}">
                            <i class="bx bx-car"></i> 
                            <span key="t-chat">School Bus</span>
                        </a>
                    </li>
                @endif 
            </ul>
        </div>
    </div>
</div>
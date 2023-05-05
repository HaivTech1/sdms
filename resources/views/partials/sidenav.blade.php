<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                
                @include('partials.nav.super')
                @include('partials.nav.admin')
                @if (!auth()->user()->isStudent())
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-folder-open"></i>
                            <span key="t-ecommerce">Result Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="{{ route('result.midterm.upload') }}" key="t-products">Upload Mid-term Scores </a></li>
                            <li><a href="{{ route('result.singleUpload') }}" key="t-products">Upload Exam Scores(p)</a></li>
                            {{-- <li><a href="{{ route('result.secondary.upload') }}" key="t-products">Exam Upload(s)</a></li> --}}
                            <li><a href="{{ route('result.midterm') }}" key="t-products">Check Mid-term Scores</a></li>
                            <li><a href="{{ route('result.primary') }}" key="t-products">Check Exam Scores(p)</a></li>
                            {{-- <li><a href="{{ route('result.secondary') }}" key="t-products">Check Exam Scores(s)</a></li> --}}
                        </ul>
                    </li>
                @endif 
                @include('partials.nav.bursal')
                @include('partials.nav.teacher')
                @include('partials.nav.student')
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
            </ul>
        </div>
    </div>
</div>
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                
                @include('partials.nav.super')
                @include('partials.nav.admin')
                @include('partials.nav.bursal')
                @include('partials.nav.teacher')
                <li>
                    <a href="{{ route('timetable.index') }}" class="waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-chat">Timetable</span>
                    </a>
                </li>
                @include('partials.nav.student')
            </ul>
        </div>
    </div>
</div>
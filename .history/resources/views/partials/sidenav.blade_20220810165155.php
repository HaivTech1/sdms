<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @superadmin
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-store"></i>
                            <span key="t-ecommerce">Site Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('setting.index') }}" key="t-products">Setting</a></li>
                            <li><a href="{{ route('user.index') }}" key="t-products">Users</a></li>
                            <li><a href="{{ route('teams.index') }}" key="t-products">Team</a></li>
                            <li><a href="{{ route('task.index') }}" key="t-products">Task</a></li>
                        </ul>
                    </li>
                @endsuperadmin

                @admin
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-store"></i>
                            <span key="t-ecommerce">Admin Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('period.index') }}" key="t-products">Session</a></li>
                            <li><a href="{{ route('term.index') }}" key="t-products">Term</a></li>
                            <li><a href="{{ route('grade.index') }}" key="t-products">Class</a></li>
                            <li><a href="{{ route('subject.index') }}" key="t-products">Subjects</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-store"></i>
                            <span key="t-ecommerce">Student Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('student.index') }}" key="t-products">Students</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-store"></i>
                            <span key="t-ecommerce">Result Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('result.index') }}" key="t-products">Upload Result</a></li>
                        </ul>
                    </li>
                @endadmin
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
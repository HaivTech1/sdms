    @can('student_list_access')
        <li>
            <a href="{{ route('teacher.students') }}" class="waves-effect">
                <i class="bx bx-list-check"></i>
                <span key="t-chat">Student List</span>
            </a>
        </li>
    @endif
    
    @can('attendance_create')
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bxs-folder-open"></i>
                <span key="t-ecommerce">Attendance Management</span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                <li><a href="{{ route('attendance.index') }}" key="t-products">Daily Attendance</a></li>
            </ul>
        </li>
    @endcan

    @can('lesson_create')
        <!-- <li>
            <a href="{{ route('lesson.teacher') }}" class="waves-effect">
                <i class="bx bx-video"></i>
                <span key="t-chat">Virtual Lesson</span>
            </a>
        </li> -->
    @endcan
    @can('assignment_create')
        <li>
            <a href="{{ route('assignment.index') }}" class="waves-effect">
                <i class="bx bx-archive-out"></i>
                <span key="t-chat">Assignment Management</span>
            </a>
        </li>
    @endcan
@teacher
    <li>
        <a href="{{ route('teacher.students') }}" class="waves-effect">
            <i class="bx bx-list-check"></i>
            <span key="t-chat">Pupils List</span>
        </a>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bxs-folder-open"></i>
            <span key="t-ecommerce">Attendance Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="true">
            <li><a href="{{ route('attendance.index') }}" key="t-products">Attendance Log</a>
            </li>
            <li><a href="{{ route('check.sheet-report') }}" key="t-products">Attendance Report</a></li>
        </ul>
    </li>
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
    <li>
        <a href="{{ route('check.index') }}" class="waves-effect">
            <i class="bx bx-list-check"></i>
            <span key="t-chat">Attendance Sheet</span>
        </a>
    </li>
    <li>
        <a href="{{ route('lesson.teacher') }}" class="waves-effect">
            <i class="bx bx-video"></i>
            <span key="t-chat">Virtual Lesson</span>
        </a>
    </li>
    <li>
        <a href="{{ route('assignment.index') }}" class="waves-effect">
            <i class="bx bx-archive-out"></i>
            <span key="t-chat">Assignment Management</span>
        </a>
    </li>
@endteacher
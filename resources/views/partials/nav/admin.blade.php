@admin
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-command"></i>
            <span key="t-ecommerce">Settings Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('period.index') }}" key="t-products">Session</a></li>
            <li><a href="{{ route('term.index') }}" key="t-products">Term</a></li>
            <li><a href="{{ route('house.index') }}" key="t-products">House</a></li>
            <li><a href="{{ route('club.index') }}" key="t-products">Club</a></li>
            <li><a href="{{ route('grade.index') }}" key="t-products">Class</a></li>
            <li><a href="{{ route('subject.index') }}" key="t-products">Subjects</a></li>
            <li><a href="{{ route('event.index') }}" key="t-products">Event</a></li>
            <li><a href="{{ route('schedule.index') }}" key="t-products">Schedule</a></li>
            <li><a href="{{ route('finger_device.index') }}" key="t-products">Biometric Device</a></li>
        </ul>
    </li>
    <li>
        <a href="{{ route('teacher.index') }}" class="waves-effect">
            <i class="bx bx-user"></i>
            <span key="t-chat">Teachers</span>
        </a>
    </li>
    <li>
        <a href="{{ url('index/registration') }}" class="waves-effect">
            <i class="bx bx-folder"></i>
            <span key="t-chat">Registrations</span>
        </a>
    </li>
    <li>
        <a href="{{ route('student.index') }}" class="waves-effect">
            <i class="bx bx-user"></i>
            <span key="t-chat">Students</span>
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
            <i class="bx bx-command"></i>
            <span key="t-ecommerce">Result Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('result.midterm') }}" key="t-products">Mid Term Result</a></li>
            <li><a href="{{ route('result.primary') }}" key="t-products">Primary</a></li>
            <li><a href="{{ route('result.secondary') }}" key="t-products">Secondary</a></li>
        </ul>
    </li>
        <li>
        <a href="{{ route('user.certificate') }}" class="waves-effect">
            <i class="bx bx-paperclip"></i>
            <span key="t-chat">Certificate</span>
        </a>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-ecommerce">Messaging</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('messaging.email') }}" key="t-add-product">Email</a></li>
            <li><a href="{{ route('messaging.sms') }}" key="t-add-product">Bulk SMS</a></li>
        </ul>
    </li>
    
@endadmin
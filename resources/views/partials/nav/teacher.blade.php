@teacher
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bxs-folder-open"></i>
            <span key="t-ecommerce">Result Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="true">
            <li><a href="{{ route('result.midterm.upload') }}" key="t-products">Mid-Term Upload</a></li>
            <li><a href="{{ route('result.singleUpload') }}" key="t-products">Primary Upload</a></li>
            <li><a href="{{ route('result.secondary.upload') }}" key="t-products">Secondary Upload</a></li>
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
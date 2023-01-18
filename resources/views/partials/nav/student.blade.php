@student
    <li>
        <a href="{{ route('student.fees') }}" class="waves-effect">
            <i class="bx bx-credit-card"></i>
            <span key="t-chat">Fee</span>
        </a>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-right-indent"></i>
            <span key="t-ecommerce">Result</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('result.midtermIndex') }}" key="t-products">Mid-Term Result</a></li>
            <li><a href="{{ route('result.index') }}" key="t-products">Exam Result</a></li>
        </ul>
    </li>
    <li>
        <a href="{{ route('assignment.get') }}" class="waves-effect">
            <i class="bx bx-right-indent"></i>
            <span key="t-chat">Assignment</span>
        </a>
    </li>
    <li>
        <a href="{{ route('lesson.index') }}" class="waves-effect">
            <i class="bx bx-video"></i>
            <span key="t-chat">Visual Class</span>
        </a>
    </li>
@endstudent
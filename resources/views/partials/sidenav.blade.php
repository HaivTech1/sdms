<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                @superadmin
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-wrench"></i>
                            <span key="t-ecommerce">Site Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('setting.index') }}" key="t-products">Setting</a></li>
                            <li><a href="{{ route('user.index') }}" key="t-products">Users</a></li>
                            <li><a href="{{ route('teams.index') }}" key="t-products">Team</a></li>
                            {{-- <li><a href="{{ route('task.index') }}" key="t-products">Task</a></li> --}}
                        </ul>
                    </li>
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
                    <li>
                        <a href="{{ route('design.index') }}" class="waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-chat">Frontend Management</span>
                        </a>
                    </li>
                @endsuperadmin

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
                    
                    <li>
                        <a href="{{ route('timetable.index') }}" class="waves-effect">
                            <i class="bx bx-calendar"></i>
                            <span key="t-chat">Timetable</span>
                        </a>
                    </li>
                @endadmin

                @bursal
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-money"></i>
                            <span key="t-ecommerce">Account Module</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('fee.index') }}" key="t-add-product">Fee</a></li>
                            <li><a href="{{ route('fee.create') }}" key="t-add-product">Payments</a></li>
                        </ul>
                    </li>
                @endbursal

                @teacher
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-folder-open"></i>
                            <span key="t-ecommerce">Result Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="{{ route('result.singleUpload') }}" key="t-products">Individual Upload</a>
                            </li>
                            <li><a href="{{ route('result.create') }}" key="t-products">Batch Upload</a></li>
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
                @endteacher

                @student
                     <li>
                        <a href="{{ route('student.fees') }}" class="waves-effect">
                            <i class="bx bx-credit-card"></i>
                            <span key="t-chat">Fee</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('result.index') }}" class="waves-effect">
                            <i class="bx bx-right-indent"></i>
                            <span key="t-chat">Result</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="waves-effect">
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
            </ul>
        </div>
    </div>
</div>
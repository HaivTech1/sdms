@can('setting_access')
<li>
    <a href="javascript: void(0);" class="has-arrow waves-effect">
        <i class="bx bx-command"></i>
        <span key="t-ecommerce">Settings Management</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        @can('setting_access')
            <li><a href="{{ route('setting.index') }}" key="t-products">Setting</a></li>
        @endcan
        <li><a href="{{ route('period.index') }}" key="t-products">Session</a></li>
        <li><a href="{{ route('term.index') }}" key="t-products">Term</a></li>
        <li><a href="{{ route('house.index') }}" key="t-products">House</a></li>
        <li><a href="{{ route('club.index') }}" key="t-products">Club</a></li>
        <li><a href="{{ route('grade.index') }}" key="t-products">Class</a></li>
        {{-- <li><a href="{{ route('subgrade.index') }}" key="t-products">Sub Class</a></li> --}}
        <li><a href="{{ route('subject.index') }}" key="t-products">Subjects</a></li>
        <li><a href="{{ route('schedule.index') }}" key="t-products">Schedule</a></li>
        @can('fingerprint_access')
            <li><a href="{{ route('finger_device.index') }}" key="t-products">Biometric Device</a></li>
        @endcan
    </ul>
</li>
@endcan

@can('website_access')
    <li>
        <a href="{{ route('design.index') }}" class="waves-effect">
            <i class="bx bx-cog"></i>
            <span key="t-chat">Website Management</span>
        </a>
    </li>
@endcan
@can('staff_access')
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-command"></i>
            <span key="t-ecommerce">Staff Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('teacher.index') }}" key="t-products">Teachers</a></li>
            <li><a href="{{ route('staff.index') }}" key="t-products">Staffs</a></li>
        </ul>
    </li>
@endcan
@can('registration_access')
    <li>
        <a href="{{ url('index/registration') }}" class="waves-effect">
            <i class="bx bx-folder"></i>
            <span key="t-chat">Registrations</span>
        </a>
    </li>
@endcan
@can('student_access')
    <li>
        <a href="{{ route('student.index') }}" class="waves-effect">
            <i class="bx bx-user"></i>
            <span key="t-chat">Students</span>
        </a>
    </li> 
@endcan
@can('promotion_access')
    <li>
        <a href="{{ route('student.batch.promotion') }}" class="waves-effect">
            <i class="bx bx-transfer"></i>
            <span key="t-chat">Promotion</span>
        </a>
    </li>
@endcan
@can('certificate_access')
    <li>
        <a href="{{ route('user.certificate') }}" class="waves-effect">
            <i class="bx bx-paperclip"></i>
            <span key="t-chat">Certificate</span>
        </a>
    </li>
@endcan
@can('messaging_access')
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
@endcan
@can('transport_access')
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-car"></i>
            <span key="t-ecommerce">Transport Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('vehicle.index') }}" key="t-products">Vehicle</a></li>
            <li><a href="{{ route('driver.index') }}" key="t-add-product">Drivers</a></li>
            <li><a href="{{ route('trip.index') }}" key="t-add-product">Trips</a></li>
        </ul>
    </li>
@endcan
@can('ecommerce_access')
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-store-alt"></i>
            <span key="t-ecommerce">Ecommerce Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('product.index') }}" key="t-add-product">Products</a></li>
            <li><a href="{{ route('order.index') }}" key="t-add-product">Orders</a></li>
        </ul>
    </li>
@endcan
@can('whatsapp_access')
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bxl-whatsapp"></i>
            <span key="t-ecommerce">Bot Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('messaging.email') }}" key="t-add-product">Connect</a></li>
            <li><a href="{{ route('messaging.sms') }}" key="t-add-product">Inbox</a></li>
        </ul>
    </li>
@endcan

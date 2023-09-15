@superadmin
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-wrench"></i>
            <span key="t-ecommerce">Site Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('user.index') }}" key="t-products">Users</a></li>
            <li><a href="{{ route('teams.index') }}" key="t-products">Team</a></li>
            <li><a href="{{ route('permission.index') }}" key="t-products">Permissions</a></li>
            <li><a href="{{ route('role.index') }}" key="t-products">Roles</a></li>
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
@endsuperadmin
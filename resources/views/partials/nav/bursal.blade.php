@can('account_access')
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-money"></i>
            <span key="t-ecommerce">Account Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            @can('fee_create')
                <li><a href="{{ route('fee.index') }}" key="t-add-product">Fee</a></li>
            @endcan
            @can('payment_access')
                <li><a href="{{ route('fee.create') }}" key="t-add-product">Payments</a></li>
            @endcan
            @can('payslip_access')
                <li><a href="{{ route('payslip.index') }}" key="t-add-product">Payslip Generate</a></li>
            @endcan
        </ul>
    </li>
@endcan

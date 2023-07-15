<div>
    @if ($total > 0)
        <div class="dropdown d-inline-block">
            <a href="{{ route('user.product.cart') }}" class="btn header-item noti-icon waves-effect"
                id="page-header-notifications-dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-shopping-bag bx-tada"></i>
                <span class="badge bg-danger rounded-pill">{{ $total }}</span>
            </a>
        </div>
    @endif
</div>

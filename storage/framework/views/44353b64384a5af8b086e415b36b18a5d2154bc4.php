<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account_access')): ?>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-money"></i>
            <span key="t-ecommerce">Account Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fee_create')): ?>
                <li><a href="<?php echo e(route('fee.index')); ?>" key="t-add-product">Fee</a></li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment_access')): ?>
                <li><a href="<?php echo e(route('fee.create')); ?>" key="t-add-product">Payments</a></li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payslip_access')): ?>
                <li><a href="<?php echo e(route('payslip.index')); ?>" key="t-add-product">Payslip Generate</a></li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views/partials/nav/bursal.blade.php ENDPATH**/ ?>
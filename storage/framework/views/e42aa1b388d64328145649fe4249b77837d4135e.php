<div>
    <?php if($total > 0): ?>
        <div class="dropdown d-inline-block">
            <a href="<?php echo e(route('user.product.cart')); ?>" class="btn header-item noti-icon waves-effect"
                id="page-header-notifications-dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-shopping-bag bx-tada"></i>
                <span class="badge bg-danger rounded-pill"><?php echo e($total); ?></span>
            </a>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views/livewire/components/student/cart-counter.blade.php ENDPATH**/ ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting_access')): ?>
<li>
    <a href="javascript: void(0);" class="has-arrow waves-effect">
        <i class="bx bx-command"></i>
        <span key="t-ecommerce">Settings Management</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting_access')): ?>
            <li><a href="<?php echo e(route('setting.index')); ?>" key="t-products">Setting</a></li>
        <?php endif; ?>
        <li><a href="<?php echo e(route('period.index')); ?>" key="t-products">Session</a></li>
        <li><a href="<?php echo e(route('term.index')); ?>" key="t-products">Term</a></li>
        <li><a href="<?php echo e(route('house.index')); ?>" key="t-products">House</a></li>
        <li><a href="<?php echo e(route('club.index')); ?>" key="t-products">Club</a></li>
        <li><a href="<?php echo e(route('grade.index')); ?>" key="t-products">Class</a></li>
        
        <li><a href="<?php echo e(route('subject.index')); ?>" key="t-products">Subjects</a></li>
        <li><a href="<?php echo e(route('schedule.index')); ?>" key="t-products">Schedule</a></li>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fingerprint_access')): ?>
            <li><a href="<?php echo e(route('finger_device.index')); ?>" key="t-products">Biometric Device</a></li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('website_access')): ?>
    <li>
        <a href="<?php echo e(route('design.index')); ?>" class="waves-effect">
            <i class="bx bx-cog"></i>
            <span key="t-chat">Website Management</span>
        </a>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff_access')): ?>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-command"></i>
            <span key="t-ecommerce">Staff Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?php echo e(route('teacher.index')); ?>" key="t-products">Teachers</a></li>
            <li><a href="<?php echo e(route('staff.index')); ?>" key="t-products">Staffs</a></li>
        </ul>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('registration_access')): ?>
    <li>
        <a href="<?php echo e(url('index/registration')); ?>" class="waves-effect">
            <i class="bx bx-folder"></i>
            <span key="t-chat">Registrations</span>
        </a>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_access')): ?>
    <li>
        <a href="<?php echo e(route('student.index')); ?>" class="waves-effect">
            <i class="bx bx-user"></i>
            <span key="t-chat">Students</span>
        </a>
    </li> 
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('promotion_access')): ?>
    <li>
        <a href="<?php echo e(route('student.batch.promotion')); ?>" class="waves-effect">
            <i class="bx bx-transfer"></i>
            <span key="t-chat">Promotion</span>
        </a>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('certificate_access')): ?>
    <li>
        <a href="<?php echo e(route('user.certificate')); ?>" class="waves-effect">
            <i class="bx bx-paperclip"></i>
            <span key="t-chat">Certificate</span>
        </a>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('messaging_access')): ?>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-ecommerce">Messaging</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?php echo e(route('messaging.email')); ?>" key="t-add-product">Email</a></li>
            <li><a href="<?php echo e(route('messaging.sms')); ?>" key="t-add-product">Bulk SMS</a></li>
        </ul>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transport_access')): ?>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-car"></i>
            <span key="t-ecommerce">Transport Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?php echo e(route('vehicle.index')); ?>" key="t-products">Vehicle</a></li>
            <li><a href="<?php echo e(route('driver.index')); ?>" key="t-add-product">Drivers</a></li>
            <li><a href="<?php echo e(route('trip.index')); ?>" key="t-add-product">Trips</a></li>
        </ul>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ecommerce_access')): ?>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-store-alt"></i>
            <span key="t-ecommerce">Ecommerce Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?php echo e(route('product.index')); ?>" key="t-add-product">Products</a></li>
            <li><a href="<?php echo e(route('order.index')); ?>" key="t-add-product">Orders</a></li>
        </ul>
    </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('whatsapp_access')): ?>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bxl-whatsapp"></i>
            <span key="t-ecommerce">Bot Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?php echo e(route('messaging.email')); ?>" key="t-add-product">Connect</a></li>
            <li><a href="<?php echo e(route('messaging.sms')); ?>" key="t-add-product">Inbox</a></li>
        </ul>
    </li>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views\partials\nav\admin.blade.php ENDPATH**/ ?>
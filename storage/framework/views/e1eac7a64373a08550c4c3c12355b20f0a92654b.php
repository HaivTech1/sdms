    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student_list_access')): ?>
        <li>
            <a href="<?php echo e(route('teacher.students')); ?>" class="waves-effect">
                <i class="bx bx-list-check"></i>
                <span key="t-chat">Student List</span>
            </a>
        </li>
    <?php endif; ?>
    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('attendance_create')): ?>
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bxs-folder-open"></i>
                <span key="t-ecommerce">Attendance Management</span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
                <li><a href="<?php echo e(route('attendance.index')); ?>" key="t-products">Daily Attendance</a></li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_create')): ?>
        <!-- <li>
            <a href="<?php echo e(route('lesson.teacher')); ?>" class="waves-effect">
                <i class="bx bx-video"></i>
                <span key="t-chat">Virtual Lesson</span>
            </a>
        </li> -->
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_create')): ?>
        <li>
            <a href="<?php echo e(route('assignment.index')); ?>" class="waves-effect">
                <i class="bx bx-archive-out"></i>
                <span key="t-chat">Assignment Management</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_create')): ?>
        <li>
            <a href="<?php echo e(route('teacher.curriculum')); ?>" class="waves-effect">
                <i class="bx bx-book"></i>
                <span key="t-chat">Curriculum Management</span>
            </a>
        </li>
    <?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views/partials/nav/teacher.blade.php ENDPATH**/ ?>
<div class="d-flex py-3 border-bottom">
    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="flex-shrink-0 me-3">
        <img src="assets/images/users/avatar-2.jpg" class="avatar-xs rounded-circle" alt="img" />
    </div>

    <div class="flex-grow-1">
        <h5 class="mb-1 font-size-15"><?php echo e($review->author()->name()); ?></h5>
        <p class="text-muted"><?php echo e($review->message); ?></p>
        <ul class="list-inline float-sm-end mb-sm-0">
            <li class="list-inline-item">
                <a href="javascript: void(0);"><i class="far fa-thumbs-up me-1"></i> Publish</a>
            </li>
            <li class="list-inline-item">
                <a href="javascript: void(0);"><i class="far fa-comment-dots me-1"></i>
                    Delete</a>
            </li>
        </ul>
        <div class="text-muted font-size-12"><i class="far fa-calendar-alt text-primary me-1"></i>
            <?php echo e($review->created_at->diffForHumans()); ?></div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\review.blade.php ENDPATH**/ ?>
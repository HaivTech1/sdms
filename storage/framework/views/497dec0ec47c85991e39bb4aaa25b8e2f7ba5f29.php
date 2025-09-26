<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Grade</th>
            <th>Subject</th>
            <th>Period</th>
            <th>Term</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $curriculums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curriculum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($curriculum->name); ?></td>
                <td><?php echo e(optional($curriculum->grade)->title); ?></td>
                <td><?php echo e(optional($curriculum->subject)->title); ?></td>
                <td><?php echo e(optional($curriculum->period)->title); ?></td>
                <td><?php echo e(optional($curriculum->term)->title); ?></td>
                <td>
                    <?php $me = auth()->user(); ?>
                    <?php if($me->isAdmin() || $curriculum->isAuthoredBy($me)): ?>
                        <button type="button" class="btn btn-sm btn-primary edit-curriculum" data-url="<?php echo e(route('teacher.curriculum.edit', $curriculum)); ?>"><i class="bx bx-edit"></i></button>
                        <button class="btn btn-sm btn-danger delete-curriculum" type="button" data-url="<?php echo e(route('teacher.curriculum.destroy', $curriculum)); ?>"><i class="bx bx-trash"></i></button>
                    <?php endif; ?>
                    <a href="<?php echo e(route('teacher.curriculum.topics', $curriculum)); ?>" class="btn btn-sm btn-info">Topics</a>
                    <button class="btn btn-sm btn-primary download-questions" type="button" data-url="<?php echo e(route('teacher.curriculum.download_questions', $curriculum)); ?>">Download Questions</button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6">No curriculums found</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <?php echo $curriculums->links(); ?>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.download-questions');
    if (!btn) return;
    e.preventDefault();
    const url = btn.getAttribute('data-url');
    if (!url) return;

    // Optional: add query params e.g., week_id or order
    const params = new URLSearchParams();
    // Example: keep sequential order; to randomize use params.set('order','random')
    // if you want to filter by week, set params.set('week_id', someWeekId)

    const fullUrl = params.toString() ? (url + '?' + params.toString()) : url;
    window.open(fullUrl, '_blank');
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\laragon\www\primary\resources\views/teacher/curriculum/_list.blade.php ENDPATH**/ ?>
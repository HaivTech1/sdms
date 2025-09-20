<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Hairstyle</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Period</th>
            <th>Term</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($week->id); ?></td>
                <td><?php echo e($week->hairstyle->title ?? ''); ?></td>
                <td><?php echo e(optional($week->start_date)->format('Y-m-d')); ?></td>
                <td><?php echo e(optional($week->end_date)->format('Y-m-d')); ?></td>
                <td><?php echo e($week->period->title()); ?></td>
                <td><?php echo e($week->term->title()); ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-primary edit-week" data-week-id="<?php echo e($week->id); ?>" data-hairstyle-id="<?php echo e($week->hairstyle_id); ?>">Edit</button>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php echo e($weeks instanceof \Illuminate\Pagination\LengthAwarePaginator ? $weeks->links() : ''); ?>

<?php /**PATH C:\laragon\www\primary\resources\views\admin\weeks\_weeks_list.blade.php ENDPATH**/ ?>
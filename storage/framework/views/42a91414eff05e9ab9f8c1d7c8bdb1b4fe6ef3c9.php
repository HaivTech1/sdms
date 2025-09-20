<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Front</th>
            <th>Side</th>
            <th>Back</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $hairstyles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($h->id); ?></td>
                <td><?php echo e($h->title); ?></td>
                <td><?php echo e(Str::limit($h->description, 60)); ?></td>
                <td style="width:80px;">
                    <img class="img-thumbnail" style="max-width:70px; max-height:70px;" src="<?php echo e($h->front_view ? asset('storage/' . $h->front_view) : asset('noImage.png')); ?>" alt="front-<?php echo e($h->id); ?>">
                </td>
                <td style="width:80px;">
                    <img class="img-thumbnail" style="max-width:70px; max-height:70px;" src="<?php echo e($h->side_view ? asset('storage/' . $h->side_view) : asset('noImage.png')); ?>" alt="side-<?php echo e($h->id); ?>">
                </td>
                <td style="width:80px;">
                    <img class="img-thumbnail" style="max-width:70px; max-height:70px;" src="<?php echo e($h->back_view ? asset('storage/' . $h->back_view) : asset('noImage.png')); ?>" alt="back-<?php echo e($h->id); ?>">
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="actions">
                        <button class="btn btn-sm btn-danger delete-hair" data-hair-id="<?php echo e($h->id); ?>" title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php echo e($hairstyles instanceof \Illuminate\Pagination\LengthAwarePaginator ? $hairstyles->links() : ''); ?>

<?php /**PATH C:\laragon\www\primary\resources\views\admin\hairstyle\_hairstyles_list.blade.php ENDPATH**/ ?>
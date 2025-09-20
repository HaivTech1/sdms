

<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Edit Curriculum</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('teacher.curriculum.update', $curriculum)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" value="<?php echo e(old('name', $curriculum->name)); ?>" required />
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"><?php echo e(old('description', $curriculum->description)); ?></textarea>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="<?php echo e(route('teacher.curriculum')); ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\primary\resources\views\teacher\curriculum\edit.blade.php ENDPATH**/ ?>
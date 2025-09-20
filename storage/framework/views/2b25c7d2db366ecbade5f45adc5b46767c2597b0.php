

<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Edit Topic - <?php echo e($topic->title); ?></h3>

    <form method="POST" action="<?php echo e(route('teacher.curriculum.topics.update', [$curriculum, $topic])); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label>Week</label>
            <select name="week_id" class="form-control">
                <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($week->id); ?>" <?php if($week->id == $topic->week_id): ?> selected <?php endif; ?>><?php echo e($week->name ?? $week->start_date->format('d M')); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" value="<?php echo e(old('title', $topic->title)); ?>" />
        </div>

        <div class="mb-3">
            <label>Objectives</label>
            <textarea name="objectives" class="form-control"><?php echo e(old('objectives', $topic->objectives)); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Bloom Level</label>
            <input name="bloom_level" class="form-control" value="<?php echo e(old('bloom_level', $topic->bloom_level)); ?>" />
        </div>

        <div class="mb-3">
            <label>Resources</label>
            <input name="resources" class="form-control" value="<?php echo e(old('resources', $topic->resources)); ?>" />
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="<?php echo e(route('teacher.curriculum.topics', $curriculum)); ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\primary\resources\views\teacher\curriculum\topic_edit.blade.php ENDPATH**/ ?>
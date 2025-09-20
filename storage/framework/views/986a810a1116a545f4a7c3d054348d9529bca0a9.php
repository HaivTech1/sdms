<form id="editTopicForm" method="POST" action="<?php echo e(route('teacher.curriculum.topics.update', [$curriculum, $topic])); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="mb-3">
        <label>Week</label>
        <select name="week_id" class="form-control">
            <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($week->id); ?>" <?php if($week->id == $topic->week_id): ?> selected <?php endif; ?>><?php echo e($index +1); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Title</label>
        <input name="title" class="form-control" value="<?php echo e(old('title', $topic->title)); ?>" placeholder="Enter topic title" />
    </div>

    <div class="mb-3">
        <label>Objectives</label>
        <textarea name="objectives" class="form-control"><?php echo e(old('objectives', $topic->objectives)); ?></textarea>
    </div>

    <div class="mb-3">
        <label>Bloom Level</label>
        <select name="bloom_level" class="form-control" required>
            <option value="" disabled <?php echo e(old('bloom_level', $topic->bloom_level) ? '' : 'selected'); ?>>Select Bloom level</option>
            <?php $__currentLoopData = ['Remember','Understand','Apply','Analyze','Evaluate','Create']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($level); ?>" <?php echo e(old('bloom_level', $topic->bloom_level) == $level ? 'selected' : ''); ?>><?php echo e($level); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Resources</label>
        <input name="resources" class="form-control" value="<?php echo e(old('resources', $topic->resources)); ?>" />
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<?php /**PATH C:\laragon\www\primary\resources\views/teacher/curriculum/_topic_edit_form.blade.php ENDPATH**/ ?>
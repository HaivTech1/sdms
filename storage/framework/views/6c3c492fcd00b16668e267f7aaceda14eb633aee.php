<table class="table table-striped">
    <thead>
        <tr>
            <th>Week</th>
            <th>Title</th>
            <th>Objectives</th>
            <th>Bloom</th>
            <th>Resources</th>
            <th>Questions</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr data-id="<?php echo e($topic->id); ?>">
                <td><?php echo e(optional($topic->week)->name ?? $topic->week_id); ?></td>
                <td class="topic-title"><?php echo e($topic->title); ?></td>
                <td class="topic-objectives"><?php echo e(\Str::limit(strip_tags($topic->objectives), 100)); ?></td>
                <td class="topic-bloom"><?php echo e($topic->bloom_level); ?></td>
                <td class="topic-resources"><?php echo e($topic->resources); ?></td>
                <td class="topic-questions">
                    <?php $count = $topic->questions_count ?? $topic->questions()->count(); ?>
                    <a href="<?php echo e(route('teacher.curriculum.topics.questions', [$curriculum, $topic])); ?>">Questions (<?php echo e($count); ?>)</a>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary edit-topic" data-url="<?php echo e(route('teacher.curriculum.topics.edit', [$curriculum, $topic])); ?>">Edit</button>
                    <button class="btn btn-sm btn-danger delete-topic" data-url="<?php echo e(route('teacher.curriculum.topics.destroy', [$curriculum, $topic])); ?>">Delete</button>
                    <button class="btn btn-sm btn-success generate-questions">Questions</button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6">No topics found</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="d-flex justify-content-center">
    
    <?php if(method_exists($topics, 'links')): ?>
        <?php echo $topics->links(); ?>

    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views/teacher/curriculum/_topics_list.blade.php ENDPATH**/ ?>
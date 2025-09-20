<?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $qJson = e(json_encode([
        'id' => $q->id,
        'question' => $q->question,
        'options' => $q->options,
        'correct_index' => $q->correct_index,
        'difficulty' => $q->difficulty,
        'bloom_level' => $q->bloom_level,
        'explanation' => $q->explanation,
    ])) ?>
    <tr data-id="<?php echo e($q->id); ?>" data-question="<?php echo $qJson; ?>">
        <td><?php echo e($q->id); ?></td>
        <td><?php echo nl2br(e($q->question)); ?></td>
        <td>
            <ul>
                <?php $__currentLoopData = $q->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li <?php echo $i == $q->correct_index ? 'style="font-weight:700"' : ''; ?>><?php echo e($opt); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </td>
        <td><?php echo e($q->difficulty); ?></td>
        <td><?php echo e($q->bloom_level); ?></td>
        <td>
            <a href="#" class="btn btn-sm btn-primary edit-saved-question" data-url="<?php echo e(route('curriculum.topics.question.update', [$q->curriculum_id, $q->id])); ?>">Edit</a>
            <button class="btn btn-sm btn-danger delete-saved-question" data-url="<?php echo e(route('curriculum.topics.question.destroy', [$q->curriculum_id, $q->id])); ?>">Delete</button>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<tr><td colspan="6"><?php echo e($questions->links()); ?></td></tr>
<?php /**PATH C:\laragon\www\primary\resources\views\teacher\curriculum\_questions_list.blade.php ENDPATH**/ ?>
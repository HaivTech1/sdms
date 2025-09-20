<?php ($previousLevel = 2); ?>

<ul <?php echo e($attributes); ?>>
    <li>
        <?php $__currentLoopData = $items($slot); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(! $loop->first): ?>
                <?php if($item['level'] > $previousLevel): ?>
                    <ul>
                        <li>
                <?php endif; ?>

                <?php if($item['level'] < $previousLevel): ?>
                        </li>
                    </ul>
                <?php endif; ?>

                <?php if($item['level'] <= $previousLevel): ?>
                    </li>
                    <li>
                <?php endif; ?>
            <?php endif; ?>

            <a href="<?php echo e($url); ?>#<?php echo e($item['anchor']); ?>">
                <?php echo e($item['title']); ?>

            </a>

            <?php if($loop->last && $item['level'] === 3): ?>
                    </li>
                </ul>
            <?php endif; ?>

            <?php ($previousLevel = $item['level']); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </li>
</ul>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\markdown\toc.blade.php ENDPATH**/ ?>
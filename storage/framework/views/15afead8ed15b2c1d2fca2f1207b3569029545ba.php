<?php if($paginator->hasPages()): ?>
<div class="shorting_pagination">

    <div class="shorting_pagination_laft">
        <h5 class="">
            <?php echo __('Showing'); ?>

            <?php if($paginator->firstItem()): ?>
            <span class="font-medium"><?php echo e($paginator->firstItem()); ?></span>
            <?php echo __('- to -'); ?>

            <span class="font-medium"><?php echo e($paginator->lastItem()); ?></span>
            <?php else: ?>
            <?php echo e($paginator->count()); ?>

            <?php endif; ?>
            <?php echo __('of'); ?>

            <span class="font-medium"><?php echo e($paginator->total()); ?></span>
            <?php echo __('results'); ?>

        </h5>
    </div>

    <div class="shorting_pagination_right">
        <ul>
            <?php if($paginator->onFirstPage()): ?>
            <li><a>Prev</a></li>
            <?php else: ?>
            <li wire:click="previousPage"><a class="cursor-pointer">Prev</a></li>
            <?php endif; ?>

            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_array($element)): ?>
            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($page == $paginator->currentPage()): ?>
            <li wire:click="gotoPage(<?php echo e($page); ?>)" class="cursor-pointer"><a class="active"><?php echo e($page); ?></a></li>
            <?php else: ?>
            <li wire:click="gotoPage(<?php echo e($page); ?>)" class="cursor-pointer"><a><?php echo e($page); ?></a></li>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($paginator->hasMorePages()): ?>
            <li wire:click="nextPage" class="cursor-pointer"><a>Next</a></li>
            <?php else: ?>
            <li><a>Next</a></li>
            <?php endif; ?>
        </ul>
    </div>

</div>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\pagination-link.blade.php ENDPATH**/ ?>
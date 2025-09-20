<div
    x-data="
{
    initMapbox: function () {
        mapboxgl.accessToken = '<?php echo e(config('services.mapbox.public_token')); ?>';
        var map = new mapboxgl.Map(<?php echo e(json_encode($options())); ?>);

        <?php $__currentLoopData = $markers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            new mapboxgl.Marker()
                .setLngLat(<?php echo e(json_encode($marker)); ?>)
                    .addTo(map);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    }
}"
    x-init="initMapbox()"
    id="<?php echo e($id); ?>"
    <?php echo e($attributes); ?>

></div>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\maps\mapbox.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', $product->title().""); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Market place</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active"><?php echo e($product->title()); ?></li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="product-detai-imgs">
                                <div class="row">
                                    <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="product-1" role="tabpanel" aria-labelledby="product-1-tab">
                                                <div>
                                                    <img src="<?php echo e(asset('storage/'.$product->image())); ?>" alt="" class="img-fluid mx-auto d-block">
                                                </div>
                                            </div>
                                        </div>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.student.add-to-cart', ['product' => $product])->html();
} elseif ($_instance->childHasBeenRendered('lPEdI1B')) {
    $componentId = $_instance->getRenderedChildComponentId('lPEdI1B');
    $componentTag = $_instance->getRenderedChildComponentTagName('lPEdI1B');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('lPEdI1B');
} else {
    $response = \Livewire\Livewire::mount('components.student.add-to-cart', ['product' => $product]);
    $html = $response->html();
    $_instance->logRenderedChild('lPEdI1B', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="mt-4 mt-xl-3">
                                <a href="javascript: void(0);" class="text-primary"><?php echo e($product->category->title()); ?></a>
                                <h4 class="mt-1 mb-3"><?php echo e($product->title()); ?></h4>

                                <h5 class="mb-4">Price : <b><?php echo e(trans('global.naira')); ?><?php echo e(number_format($product->price, 2)); ?></b></h5>
                                <p class="text-muted mb-4">
                                    <?php echo e($product->description); ?>

                                </p>
                               
                                <?php if($product->speculations): ?>
                                    <?php
                                        $specs = json_decode($product->speculations, true);
                                    ?>

                                    <?php $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="product-color">
                                            <span class="font-size-15">Available <?php echo e($key); ?>:</span>
                                            <b><?php echo e(implode(', ', $values)); ?></b>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\student\market\show.blade.php ENDPATH**/ ?>
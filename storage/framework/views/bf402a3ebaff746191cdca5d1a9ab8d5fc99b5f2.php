<div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4">Filter</h4>
                        <?php if($category): ?>
                            <span wire:click="clearCategoryFilter" class="text-danger text-lg cursor-pointer btn"><i class="bx bx-x"></i></span>
                        <?php endif; ?>
                    </div>

                    <div>
                        <h5 class="font-size-14 mb-3">Categories</h5>
                        <ul class="list-unstyled product-list">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="javascript: void(0);" wire:click='setCategory(<?php echo e($category->id()); ?>)'><i class="mdi mdi-chevron-right me-1"></i><?php echo e($category->title()); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-lg-9">
                
            <div class="row mb-3">
                <div class="col-xl-4 col-sm-6">
                    <div class="mt-2 d-flex align-items-center">
                        <h5>Products</h5> 
                        <?php if($search): ?>
                            <span wire:click="clearSearchFilter" class="text-danger text-lg cursor-pointer btn"><i class="bx bx-x"></i></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-8 col-sm-6">
                    <div class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
                        <div class="search-box me-2">
                            <div class="position-relative">
                                <input type="text" class="form-control border-0" placeholder="Search..." wire:model.debounce.200ms="search">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-4 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-img position-relative">
                                    <div class="avatar-sm product-ribbon">
                                        <span class="avatar-title rounded-circle  bg-primary">
                                            <?php echo e($product->category->title()); ?>

                                        </span>
                                    </div>
                                    <a href="<?php echo e(route('user.product.show', $product->slug)); ?>"z>
                                        <img src="<?php echo e(asset('storage/'.$product->image())); ?>" alt="" class="img-fluid mx-auto d-block">
                                    </a>
                                </div>
                                <div class="mt-4 text-center">
                                    <h5 class="mb-2 text-truncate"><a href="<?php echo e(route('user.product.show', $product->slug)); ?>" class="text-dark"><?php echo e($product->title()); ?></a></h5>
                                    <h5 class="my-0"><b><?php echo e(trans('global.naira')); ?><?php echo e(number_format($product->price, 2)); ?></b></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <?php echo e($products->links('pagination::custom-pagination')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\student\market\index.blade.php ENDPATH**/ ?>
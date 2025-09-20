<div>
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <?php if(count($cartItems) > 0): ?>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Product Desc</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th colspan="2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo e(asset('storage/'.$item->product->image())); ?>" alt="<?php echo e($item->product->title()); ?>" title="product-img"
                                                    class="avatar-md" />
                                            </td>
                                            <td>
                                                <h5 class="font-size-14 text-truncate"><a href="<?php echo e(route('user.product.show', $item->product->slug)); ?>"
                                                        class="text-dark"><?php echo e($item->product->title()); ?></a></h5>
                                            </td>
                                            <td>
                                                <?php echo e(trans('global.naira')); ?> <?php echo e(number_format($item->product->price(), 2)); ?>

                                            </td>
                                            <td>
                                                <div class="me-3" style="width: 120px;">
                                                    <input type="text" value="<?php echo e($item->quantity); ?>" name="demo_vertical" data-item-id="<?php echo e($item->id); ?>">
                                                </div>
                                            </td>
                                            <td>
                                            <?php echo e(trans('global.naira')); ?> <?php echo e(number_format($item->product->price * $item->quantity, 2)); ?>

                                            </td>
                                            <td>
                                                <button 
                                                    class="action-icon text-danger removeItem"
                                                    data-id="<?php echo e($item->id); ?>"
                                                > 
                                                    <i class="mdi mdi-trash-can font-size-18"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <a href="<?php echo e(route('user.product.index')); ?>" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Continue Shopping </a>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    <a href="<?php echo e(route('user.product.checkout')); ?>" class="btn btn-success">
                                        <i class="mdi mdi-cart-arrow-right me-1"></i> Checkout </a>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    <?php else: ?>
                        <div class="d-flex justify-content-center mt-4">
                            <div class="col-sm-6">
                                <p>You have no product in your cart!</p>
                                <a href="<?php echo e(route('user.product.index')); ?>" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Continue Shopping 
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Order Summary</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Grand Total :</td>
                                    <td><?php echo e(trans('global.naira')); ?> <?php echo e(number_format($total, 2)); ?></td>
                                </tr>
                                <tr>
                                    <td>Estimated Tax : </td>
                                    <td><?php echo e(trans('global.naira')); ?> <?php echo e(number_format($tax, 2)); ?></td>
                                </tr>
                                <tr>
                                    <th>Total :</th>
                                    <th><?php echo e(trans('global.naira')); ?> <?php echo e(number_format($total, 2)); ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>

    <div id="removeProductModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Confirm  Action!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-title">Are you sure you want to remove this product?</p>
                </div>
                 <div class="modal-footer">
                    <form wire:submit.prevent="removeProduct">
                        <div class="">
                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger" type="submit">Yes remove</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
        $("input[name='demo_vertical']").TouchSpin({verticalbuttons:!0});

        $('input[name="demo_vertical"]').on('change', function() {
            var updatedQuantity = $(this).val();
            var itemId = $(this).data('item-id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $.ajax({
                url: '<?php echo e(route("user.product.update.cartitem", ["item" => ":item_id", "quantity" => ":quantity"])); ?>'.replace(':item_id', itemId).replace(':quantity', updatedQuantity),
                type: 'GET',
                dataType: 'json',
            }).done((res) => {
                toastr.success(res.message, 'Updated');
                Livewire.emit('refreshComponent')
            }).fail((error) => {
                toastr.error(error.responseJSON.message);
                console.log(error);
            });
        });

        $('.removeItem').on('click', function(e) {
            var button = $(this);
            toggleAble(button, true);
            var id = $(this).data('id');

            Swal.fire({
                title: 'Delete Item',
                text: 'Are you sure you want to remove this product from cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#502179',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Remove'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });

                    $.ajax({
                        url: '<?php echo e(route("user.product.delete.cartitem", ["item" => ":item_id"])); ?>'.replace(':item_id', id),
                        type: 'GET',
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble(button, false);
                        Swal.fire('Removeed!', res.message, 'success');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                        console.log(error);
                    });                 
                }else{
                    toggleAble(button, false);
                }
            });
        });

        document.addEventListener('livewire:load', function(){
            Livewire.on('refreshComponent', function(){
                location.reload();
            });
        })
        </script>
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\student\cart.blade.php ENDPATH**/ ?>
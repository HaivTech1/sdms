<div>
    <?php
        $user = auth()->user();
    ?>
     <div class='row'>
        <div class='col-sm-12'>
            <div class="table-responsive">
                <table class="table align-middle table-nowrap table-check">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle"> Location </th>
                            <th class="align-middle"> Price </th>
                            <th class="align-middle"> Partial Payment </th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $payments = \App\Models\Payment::wherePayment_category('schoolbus_service')
                                    ->whereStudent_uuid($user->student->id())
                                    ->whereTerm_id(term('id'))
                                    ->wherePeriod_id(period('id'))->first();

                                $verify = calculateTotalAmount($payments);
                                $balance = calculateTripBalance($payments);
                            ?>
                            <tr>
                                <td>
                                    <?php echo e($trip->address()); ?>

                                </td>
                                <td>
                                    <?php if($user->student->assingedTrip()->where('trip_id', $trip->id)->exists()): ?>
                                        <?php if($balance): ?>
                                           <span class="text-danger">To balance:</span> <?php echo e(trans('global.naira')); ?> <?php echo e(number_format($balance, 2)); ?>

                                        <?php else: ?>
                                            <?php echo e(trans('global.naira')); ?> <?php echo e(number_format($trip->price(), 2)); ?>

                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo e(trans('global.naira')); ?> <?php echo e(number_format($trip->price(), 2)); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($trip->split_status); ?>

                                </td>
                                <td>
                                    <?php if($user->student->assingedTrip()->where('trip_id', $trip->id)->exists()): ?>
                                        <?php if($balance): ?>
                                             <form method="POST" action="<?php echo e(route('user.schoolbus.paystack.one-time')); ?>">
                                                    <?php echo csrf_field(); ?>

                                                    <input type="hidden" name="metadata" 
                                                        value="<?php echo e(json_encode($array = [
                                                            'student_uuid' =>  $user->student->id(),
                                                            'term_id' => term('id'),
                                                            'period_id' => period('id'),
                                                            'author_id' => $user->id(),
                                                            'trip_id' => $trip->id(),
                                                            'type' => 'schoolbus_service',
                                                            'callback' => 'user.schoolbus.paystack.callback',
                                                        ])); ?>"
                                                    >
                                                    <?php if(isset($user->student->mother)): ?>
                                                        <input type="hidden" name="email" value="<?php echo e($user->student->mother->email()); ?>">
                                                    <?php elseif(isset($user->student->father)): ?>
                                                        <input type="hidden" name="email" value="<?php echo e($user->student->father->email()); ?>">
                                                    <?php else: ?>
                                                        <input type="hidden" name="email" value="<?php echo e(application('email')); ?>">
                                                    <?php endif; ?>

                                                    <input id="amount" type="hidden" name="amount" value="<?php echo e($balance ? ($balance) * 100 :($trip->price()) * 100); ?>">
                                                    <input type="hidden" name="currency" value="NGN">

                                                    <button class="btn btn-success btn-sm" id="" type="submit">Pay balance</button>
                                                </form>
                                        <?php else: ?>
                                            <span class="badge badge-soft-success">Paid</span>
                                        <?php endif; ?>
                                    <?php else: ?> 
                                        <?php if(!$verify): ?>
                                            <div class="d-flex gap-2">
                                                <form method="POST" action="<?php echo e(route('payment.paystack.initiate')); ?>">
                                                    <?php echo csrf_field(); ?>

                                                    <input type="hidden" name="metadata" 
                                                        value="<?php echo e(json_encode($array = [
                                                            'student_uuid' =>  $user->student->id(),
                                                            'term_id' => term('id'),
                                                            'period_id' => period('id'),
                                                            'author_id' => $user->id(),
                                                            'trip_id' => $trip->id(),
                                                            'type' => 'schoolbus_service',
                                                            'callback' => 'payment.paystack.callback',
                                                        ])); ?>"
                                                    >
                                                    <?php if(isset($user->student->mother)): ?>
                                                        <input type="hidden" name="email" value="<?php echo e($user->student->mother->email()); ?>">
                                                    <?php elseif(isset($user->student->father)): ?>
                                                        <input type="hidden" name="email" value="<?php echo e($user->student->father->email()); ?>">
                                                    <?php else: ?>
                                                        <input type="hidden" name="email" value="<?php echo e(application('email')); ?>">
                                                    <?php endif; ?>

                                                    <input id="amount" type="hidden" name="amount" value="<?php echo e($balance ? ($balance) * 100 :($trip->price()) * 100); ?>">
                                                    <input type="hidden" name="currency" value="NGN">

                                                    <?php if($trip->split): ?>
                                                        <div class="btn-group btn-group-example mb-3" role="group">
                                                            <button id="pay" type="submit" class="btn btn-success w-xs">Pay</button>
                                                            <button id="partial" type="button" class="btn btn-danger w-xs">Enter Amount</button>
                                                        </div>
                                                    <?php else: ?>
                                                        <button class="btn btn-success btn-sm" id="" type="submit">Pay</button>
                                                    <?php endif; ?>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge badge-soft-danger">x</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <?php echo e($trips->links('pagination::custom-pagination')); ?>

            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#partial').on('click', function() {
                     Swal.fire({
                        title:"Enter the amount to pay",
                        input:"text",
                        showCancelButton:!0,
                        confirmButtonText:"Submit",
                        showLoaderOnConfirm:!0,
                        confirmButtonColor:"#556ee6",
                        cancelButtonColor:"#f46a6a",
                        preConfirm:function(n){
                            var newAmount = n;
                            var x = document.getElementById("pay");
                                x.innerHTML = 'Pay';
                            var y = document.getElementById("amount");
                                y.value= newAmount * 100;
                        },
                        allowOutsideClick: !1,
                    });
                });
            })
        </script>
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\student\trip\index.blade.php ENDPATH**/ ?>
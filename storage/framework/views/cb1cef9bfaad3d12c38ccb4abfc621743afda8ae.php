<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name') . ' | Student School Fees'); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Fees</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Assigned Fees for <?php echo e(period('title')); ?></li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <?php if(auth()->user()->student->outstanding !== null): ?>
                    <div class="card-header">
                        <div class="">
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Alert!</h4>
                                <p>
                                    We are sorry to inform you that you still have an outstanding of 
                                    <?php echo e(trans('global.naira')); ?> <?php echo e(number_format(auth()->user()->student->outstanding['outstanding'], 2)); ?>. 
                                    Please endeavour to pay your outstanding balance as soon as possible. Thank you!
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <?php if($fee): ?>
                        <table class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Term</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $verification = \App\Models\Payment::whereTerm_id($fee['term_id'])
                                        ->where('payment_category', 'school_fees')
                                        ->where('student_uuid', $user->student->id())
                                        ->first();

                                    $term = \App\Models\Term::findOrFail($fee['term_id']);
                                ?>

                                <tr>
                                    <td>
                                        <?php echo e($term->title()); ?> Tuition
                                    </td>
                                    <td> 
                                        <?php
                                            $newFee = $fee['price'];
                                            $toPay = $newFee;
                                        ?>
                                        <?php echo e(trans('global.naira')); ?>  
                                        <?php echo e($verification ? $fee['price'] : number_format($toPay, 2)); ?>

                                    </td>
                                    <td>
                                        <?php if($verification): ?>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span class="badge badge-soft-success text-center mr-2">Paid</span>
                                                <div class="ml-2">
                                                    <a class="btn btn-primary btn-sm"
                                                        href="<?php echo e(route('receipt', $verification)); ?>">Print Receipt</a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <form method="POST" action="<?php echo e(route('payment.paystack.initiate')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php
                                                    $per = payment_percent(0.015, $toPay);
                                                ?>
                                                <input type="hidden" name="metadata" 
                                                        value="<?php echo e(json_encode($array = [
                                                                    'student_uuid' => $user->student->id(),
                                                                    'term_id' => $fee['term_id'],
                                                                    'author_id' => $user->id(),
                                                                    'type' => 'school_fees',
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
                                                
                                                <input id="amount" type="hidden" name="amount" value="<?php echo e(($toPay) * 100); ?>">
                                                <button type="submit" class="btn btn-primary">Pay Now</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-center text-danger">No fee assigned yet! please check back</p>
                    <?php endif; ?>
                </div>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views/admin/student/fees.blade.php ENDPATH**/ ?>
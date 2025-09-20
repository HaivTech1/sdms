<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Viewport" content="width=device-width, initial-scale=1.0">
        <Title>Order details</Title>

        <style>
            table {
                width: 95%;
                border-collapse: collapse;
                margin: 30px auto;
            }

            tr::nth-of-type(odd){
                background: #eee;
            }

            th{
                text-align: left;
                font-size: 10px;
            }

            td, th{
                border: 1px solid #ccc;
            }
        </style>
    </head>

    <body>
        <div style="width: 95%; margin: 0 auto">
            <div style="width: 10%; float: left; margin-right: 20px">
                <img src="<?php echo e(public_path('storage/'.application('image'))); ?>" width="70%" alt="<?php echo e(application('name')); ?>" />
            </div>
            <div style="width: 50%; float: left">
                <h5 style="text-align: center"><?php echo e($term->title()); ?>/<?php echo e($period->title()); ?> Paid <?php echo e($type); ?> list for <?php echo e($grade->title()); ?> </h5>
            </div>
        </div>

        <table style="position: relative; top: 20px">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Amount Paid</th>   
                    <th>To Balance</th> 
                    <th>Channel</th>               
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="padding: 3px">
                        <td style="padding: 3px"><?php echo e($key+1); ?></td>
                        <td style="padding: 3px" data-column="Address"><?php echo e($trip->student->lastName()); ?> <?php echo e($trip->student->firstName()); ?></td>
                        <td style="padding: 3px" data-column="Price"><?php echo e($trip->trip->price()); ?></td>
                        <td style="padding: 3px" data-column="Amount Paid"><?php echo e($trip->payment->amount); ?></td>
                        <td style="padding: 3px" data-column="Balance"><?php echo e($trip->payment->balance); ?></td>
                        <td style="padding: 3px" data-column="Balance"><?php echo e($trip->payment->channel); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </body>
</html><?php /**PATH C:\laragon\www\primary\resources\views\generate\trip_paid_list.blade.php ENDPATH**/ ?>
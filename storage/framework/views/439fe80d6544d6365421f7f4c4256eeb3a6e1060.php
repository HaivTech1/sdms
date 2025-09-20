<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Viewport" content="width=device-width, initial-scale=1.0">
        <Title>Midterm Excel sheet</Title>

        <style>
            table {
                width: 95%;
                border-collapse: collapse;
                margin: 50px auto;
            }

            tr::nth-of-type(odd){
                background: #eee;
            }

            th{
                background: #502179;
                color: #fff;
                font-weight: bold;
                text-align: left;
                font-size: 18px;
            }

            td, th{
                padding: 10px;
                border: 1px solid #ccc;
            }
        </style>
    </head>

    <body>

        <table style="position: relative; top: 20px">
            <?php
                $midterm = get_settings('midterm_format');
            ?>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Id</th>
                    <th>Subject</th>
                    <th>Period</th>
                    <th>Term</th>
                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($key); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td data-column="Name"><?php echo e($result->student->lastName()); ?> <?php echo e($result->student->firstName()); ?> <?php echo e($result->student->firstName()); ?></td>
                        <td data-column="Id"><?php echo e($result->student->user->code()); ?></td>
                        <td data-column="subject"><?php echo e($result->period_id); ?></td>
                        <td data-column="period"><?php echo e($result->term_id); ?></td>
                        <td data-column="term"><?php echo e($result->subject_id); ?></td>
                        <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($result[$key])): ?>
                                <td data-column="<?php echo e($key); ?>"><?php echo e($result[$key]); ?></td>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </body>
</html><?php /**PATH C:\laragon\www\primary\resources\views\generate\midtermExcel.blade.php ENDPATH**/ ?>
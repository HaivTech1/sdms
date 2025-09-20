<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php $__env->startSection('title', $student->last_name . " | Mid Term Result Page"); ?>
    <style>
        .page-break {
            page-break-after: always;
        }
        .header {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .header-item {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .header-item:first-child {
            text-align: left;
            width: 10%
        }

        .header-item:last-child {
            text-align: right;
            width: 10%
        }

        .majorContainer {
            width: 100%;
            margin-bottom: 1em;
        }

        .majorContainer::after {
            content: '';
            display: table;
            clear: both;
            vertical-align: middle;
        }

        .mainContainer {
            float: left;
            width: 50%;
        }

        .minorContainer {
            float: right;
            width: 50%;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
        }

        .result-table th,
        .result-table td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .result-item {
            font-size: 15px;
        }

        .rotate-header {
            transform: rotate(270deg);
            writing-mode: vertical-rl;
            white-space: nowrap;
            vertical-align: middle;
            transform-origin: bottom right;
            text-orientation: mixed;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-item">
            <img src="<?php echo e(public_path('storage/' . application('image'))); ?>" width="100" height="90" alt="Profile Image">
        </div>
        <div class="header-item">
            <div style="font-weight: bold; text-align: center; text-transform: uppercase"><?php echo e(application('name')); ?>

            </div>
            <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                <?php echo e(application('address')); ?>

            </div>
            <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                <?php echo e(application('line1')); ?>, <?php echo e(application('line2')); ?>

            </div>
        </div>
        <div class="header-item">
            <img src="<?php echo e(public_path('storage/' . $student->user->image())); ?>" width="100" height="90"
                alt="<?php echo e($student->last_name); ?>">
        </div>
    </div>

    <div style="margin: 10px 0">
        <div style="font-weight: bold; text-align: center; text-transform: uppercase">Mid-Term Evaluation Report Sheet
        </div>
        <div style="font-weight: bold; text-align: center; text-transform: uppercase"><?php echo e($term->title()); ?>

            <?php echo e($period->title()); ?> Academic Session</div>
    </div>

    <div class="majorContainer">
        <div class="mainContainer">
            <div class="result-item">
                <b>Name:</b> <span><?php echo e(ucfirst($student->lastName())); ?> <?php echo e(ucfirst($student->firstName())); ?>

                    <?php echo e(ucfirst($student->otherName())); ?></span>
            </div>
            <div class="result-item">
                <b>Admission No.:</b>
                <span><?php echo e($student->user->code()); ?></span>
            </div>
            <div class="result-item">
                <b>Class:</b>
                <span><?php echo e($student->grade->title()); ?></span>
            </div>
        </div>
        <div class="minorContainer">
            <div class="result-item">
                <b>Class Population:</b>
                <span><?php echo e($student->grade->students->count()); ?></span>
            </div>
            <div class="result-item">
                <b>Age:</b>
                <span>
                    <?php
$year = Carbon\Carbon::parse($student->dob())->age
                    ?>
                    <?php echo e($year); ?>

                </span>
            </div>

        </div>
    </div>

    <div>
        <table class="result-table">
            <?php
$midterm = get_settings('midterm_format');
$midtermTotal = 0;

if (is_array($midterm)) {
    foreach ($midterm as $key => $value) {
        if (isset($value['mark'])) {
            $midtermTotal += $value['mark'];
        }
    }
}
            ?>

            <thead>
                <tr>
                    <th style="width: 50%; padding-left: 10px; text-align: left">Subjects</th>
                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                            <?php echo e($value['full_name']); ?>

                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">
                        Total
                    </th>
                    <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">
                        Percentage
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
$totalSum = 0;
                ?>
                <tr style="text-align: center; color: green;">
                    <td style="width: 50%"></td>
                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">
                                            <?php echo e($value['mark']); ?>

                                            <?php
    $totalSum += $value['mark'];
                                            ?>
                                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center"><?php echo e($totalSum); ?></td>
                    <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">100%</td>
                </tr>
                <tr>
                    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php if($result->subject->title() != null): ?>
                                <td style="padding-left: 10px; width: 50%; text-align: left; font-size: 10px">
                                    <?php echo e($result->subject->title()); ?></td>
                            <?php endif; ?>
                            <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(isset($result[$key])): ?>
                                    <td
                                        style="font-size: 10px; font-weight: 400; text-align: center; color: <?php echo e(exam20Color($result[$key])); ?>">
                                        <?php echo e($result[$key]); ?></td>
                                <?php else: ?>
                                    <td>-</td>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e($result->total()); ?></td>
                            <td style="font-size: 10px; font-weight: 500; text-align: center">
                                <?php echo e(round(divnum($result->total() * 100, $totalSum))); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin: 5px 0" class="page-break">
        <span style="font-weight: bold; font-size: 15px">Principal's Remark: </span><span><?php echo e($comment); ?></span>
    </div>
</body>

</html><?php /**PATH C:\laragon\www\primary\resources\views\admin\result\midterm_pdf_result.blade.php ENDPATH**/ ?>
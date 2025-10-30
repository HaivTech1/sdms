<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php $__env->startSection('title', $grade->title . " | Class Mid Term Result Report"); ?>
    <style>
        @font-face {
          font-family: 'Amiri';
          src: url('<?php echo e(public_path("fonts/Amiri-Regular.ttf")); ?>') format('truetype');
        }
        body {
            font-family: 'Amiri', Arial, Helvetica, sans-serif;
        }

        #body_content {
            position: relative;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bg_img {
            position: absolute;
            opacity: 0.1;
            background-repeat: no-repeat;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @page  {
            margin: 0.5in;
            size: A4 portrait;
        }

        .page-break {
            page-break-before: always;
        }

        .header {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 20px;
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

        .student-result {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            padding: 15px;
        }

        .student-header {
            background-color: #f5f5f5;
            padding: 10px;
            margin: -15px -15px 15px -15px;
            border-bottom: 1px solid #ddd;
        }

        .student-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .result-table th,
        .result-table td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: center;
            font-size: 10px;
        }

        .result-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .rotate-header {
            display: inline-block;
            transform: rotate(-90deg);
            writing-mode: vertical-rl;
            white-space: nowrap;
            line-height: 1;
            vertical-align: middle;
            transform-origin: center;
            font-size: 8px;
            padding: 2px 0;
        }

        .remark {
            font-size: 10px;
            margin-top: 10px;
        }

        .class-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div id="body_content">
    <div class="bg_img">
        <img src="<?php echo e(asset('storage/' .application('image'))); ?>" alt="<?php echo e(application('name')); ?>" width="320px">
    </div>
    <div class="header">
        <div class="header-item">
            <img src="<?php echo e(public_path('storage/' . application('image'))); ?>" width="60" height="60" alt="Profile Image">
        </div>
        <div class="header-item">
            <div style="font-weight: bold; text-align: center; text-transform: uppercase"><?php echo e(application('name')); ?>

            </div>
            <div style="font-size: 12px"><?php echo e(application('address')); ?></div>
            <div style="font-size: 12px"><?php echo e(application('line1')); ?>, <?php echo e(application('line2')); ?></div>
        </div>
        <div class="header-item">
        </div>
    </div>

    <div class="class-title">
        <?php echo e($grade->title); ?> - Mid-Term Evaluation Report<br>
        <?php echo e($term->title()); ?> <?php echo e($period->title()); ?> Academic Session
    </div>

    <?php $__currentLoopData = $classData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $studentData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($index > 0): ?>
            <div class="page-break"></div>
        <?php endif; ?>
        
        <div class="student-result">
            <div class="student-header">
                <strong><?php echo e(ucfirst($studentData['student']->lastName())); ?> <?php echo e(ucfirst($studentData['student']->firstName())); ?> <?php echo e(ucfirst($studentData['student']->otherName())); ?></strong>
                <span style="float: right;">Admission No: <?php echo e($studentData['student']->user->code()); ?></span>
            </div>

            <div class="student-info">
                <div>
                    <strong>Class:</strong> <?php echo e($grade->title()); ?><br>
                    <strong>Age:</strong> 
                    <?php
                        $year = Carbon\Carbon::parse($studentData['student']->dob())->age
                    ?>
                    <?php echo e($year); ?>

                </div>
                <div>
                    <strong>Class Population:</strong> <?php echo e($grade->students->count()); ?><br>
                    <strong>Term:</strong> <?php echo e($term->title()); ?>

                </div>
            </div>

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
                        <th style="width: 40%; padding-left: 10px; text-align: left">Subjects</th>
                        <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center; vertical-align: bottom; height: 60px;">
                                <div class="rotate-header"><?php echo e($value['full_name']); ?></div>
                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th style="font-size: 8px; font-weight: 500; text-align: center; vertical-align: bottom; height: 60px;">
                            <div class="rotate-header">Total</div>
                        </th>
                        <th style="font-size: 8px; font-weight: 500; text-align: center; vertical-align: bottom; height: 60px;">
                            <div class="rotate-header">Percentage</div>
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
                            <td style="width: 5%; font-size: 8px; font-weight: 900; text-align: center">
                                <?php echo e($value['mark']); ?>

                                <?php
                                    $totalSum += $value['mark'];
                                ?>
                            </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <td style="width: 5%; font-size: 8px; font-weight: 900; text-align: center"><?php echo e($totalSum); ?></td>
                        <td style="width: 5%; font-size: 8px; font-weight: 900; text-align: center">100%</td>
                    </tr>
                    
                    <?php $__currentLoopData = $studentData['results']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php if($result->subject->title() != null): ?>
                                <td style="padding-left: 10px; width: 50%; text-align: left; font-size: 8px">
                                    <?php echo e($result->subject->title()); ?></td>
                            <?php endif; ?>
                            <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(isset($result[$key])): ?>
                                    <td style="font-size: 8px; font-weight: 400; text-align: center; color: <?php echo e(exam20Color($result[$key])); ?>">
                                        <?php echo e($result[$key]); ?></td>
                                <?php else: ?>
                                    <td style="font-size: 8px;">-</td>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td style="font-size: 8px; font-weight: 500; text-align: center"><?php echo e($result->total()); ?></td>
                            <td style="font-size: 8px; font-weight: 500; text-align: center">
                                <?php echo e(round(divnum($result->total() * 100, $totalSum))); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php if(!empty($studentData['comment'])): ?>
                <div class="remark">
                    <strong>Remark:</strong> <?php echo e($studentData['comment']); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>

</html><?php /**PATH C:\laragon\www\primary\resources\views/admin/result/class_midterm_pdf_result.blade.php ENDPATH**/ ?>
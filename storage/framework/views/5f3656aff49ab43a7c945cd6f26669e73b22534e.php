<!DOCTYPE html>
<html>
<head>
    <?php $__env->startSection('title', $student->last_name." | Exam Result Page"); ?>
    <style>
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
            width: 40%;
        }

        .minorContainer {
            float: right;
            width: 30%;
        }

        .affectiveContainer {
            float: left;
            width: 45%;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
        }

        .result-table th,
        .result-table td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .beh-d th, beh-d td{
            padding: 2px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-item {
            font-size: 15px;
        }

        .affect-table {
            width: 100%;
            border-collapse: collapse;
        }

        .affect-table th,
        .affect-table td {
            padding: 2px;
            border: 1px solid #000;
            text-align: center;
        }

        .affect-table th {
            background-color: #f2f2f2;
        }

        .affect-item {
            font-size: 8px;
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
    <div id="body_content">
        <div class="bg_img">
            <img src="<?php echo e(asset('storage/' .application('image'))); ?>" alt="<?php echo e(application('name')); ?>" width="300px">
        </div>

        <div>
            <div class="header">
                <div class="header-item">
                    <img src="<?php echo e(public_path('storage/'.application('image'))); ?>" width="70" height="70" alt="Profile Image">
                </div>
                <div class="header-item">
                    <div style="font-weight: bold; text-align: center; text-transform: uppercase"><?php echo e(application('name')); ?></div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        <?php echo e(application('address')); ?>

                    </div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        <?php echo e(application('line1')); ?>, <?php echo e(application('line2')); ?>

                    </div>
                </div>
                <div class="header-item">
                    <img src="<?php echo e(public_path('storage/'.$student->user->image())); ?>" width="70" height="70" alt="<?php echo e($student->last_name); ?>">
                </div>
            </div>

            <div style="margin: 10px 0">
                <div style="font-weight: 500; text-align: center; text-transform: uppercase">Terminal Evaluation Report Sheet</div>
                <div style="font-weight: 500; text-align: center; text-transform: uppercase"><?php echo e($term->title()); ?> <?php echo e($period->title()); ?> Academic Session</div>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <div class="result-item">
                        <b>Name:</b> <span><?php echo e(ucfirst($student->lastName())); ?> <?php echo e(ucfirst($student->firstName())); ?> <?php echo e(ucfirst($student->otherName())); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Admission No.:</b>
                        <span><?php echo e($student->user->code()); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Class:</b>
                        <span><?php echo e($student->grade->title()); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Students in class:</b>
                        <span><?php echo e($student->grade->students->count()); ?></span>
                    </div>
                </div>
                <div class="mainContainer">
                    <div class="result-item">
                        <b>Aggregate:</b><span class="s-avg aggregate"> <?php echo e(number_format($aggregate , 1)); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Mark obtainable:</b>
                        <span><?php echo e($student->subjects->count() * 100); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Mark obtained:</b>
                        <span class="s-avg grand_total"> <?php echo e($marksObtained); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Position in class:</b>
                        <span><?php echo $position; ?></span>
                    </div>
                </div>
                <div class="minorContainer">
                    <div class="result-item">
                        <b>No. of times school opened:</b>
                        <span><?php echo e($studentAtendance->attendance_duration ?? 0 ?? ''); ?></span>
                    </div>
                    <div class="result-item">
                        <b>No. of times present:</b>
                        <span><?php echo e($studentAttendance->attendance_present ?? ''); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Attendance Average:</b>
                        <span><?php echo e(number_format(calculatePercentage($studentAttendance->attendance_duration ?? 0, $studentAttendance->attendance_present ?? 0, 100), 1) ?? ''); ?>%</span>
                    </div>
                </div>
            </div>

            <div class="table-wrapper table-responsive" style="margin: 5px 0">
                <table class="result-table">
                    <thead>
                        <tr>
                            <th colspan="6" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">PHYSICAL DEVELOPMENT</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <th colspan="2" class="v-align">Height (m)</th>
                            <th colspan="2">Width (kg)</th>
                            <th rowspan="2" style="width: 20%"> </th>
                            <th rowspan="2" style="font-size: 8px">Nature of Illness</th>
                        </tr>
                        <tr>
                            <td style="font-size: 8px">Beginning of Term</td>
                            <td style="font-size: 8px">End of Term</td>
                            <td style="font-size: 8px">Beginning of Term</td>
                            <td style="font-size: 8px">End of Term</td>
                        
                        </tr>
                        <tr>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td colspan="2"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                    <?php if($term->id() === '1'): ?>
                        <table class="result-table">
                            <thead id="ch">
                                <tr>
                                    <th colspan="11" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Subjects</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Activities</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">PROJECT</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">EXAM</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Avg</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">GRADE</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Remarks</th>
                                </tr>
                                <tr style="text-align: center">
                                    <th></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">60</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">40</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">%</th>
                                    <th></th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody style="">
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="text-align: left; font-size: 10px"><?php echo e($result['subject']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result['ca1'])); ?>"><?php echo e($result['ca1'] ?? ''); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result['ca2'])); ?>"><?php echo e($result['ca2'] ?? ''); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam10Color($result['ca3'])); ?>"><?php echo e($result['ca3'] ?? ''); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam10Color($result['pr'])); ?>"><?php echo e($result['pr'] ?? ''); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam60Color($result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr'])); ?>"> <?php echo e($result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam40Color($result['exam'])); ?>"><?php echo e($result['exam'] ?? ''); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e($result['total'] ?? ''); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(class_average($student->grade->id(), $result['subject'], $term->id(), $period->id() )); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e(examGrade($result['total'])); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e(examRemark($result['total'])); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php elseif($term->id() === '2'): ?>
                        <table class="result-table">
                            <thead id="ch">
                                <tr>
                                    <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Subjects</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Activities</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">PROJECT</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">EXAM</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">1st Term Score</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Grand TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Avg.</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">GRADE</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Avg.</th>
                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">Remarks</th>
                                </tr>
                                </tr>
                                <tr style="text-align: center">
                                    <th></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">60</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">40</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">200</th>
                                    <th></th>
                                    <th></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">%</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="">
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if ($term->id() === '2'){
                                            $total = $result['total'] + $result['first_term_cummulative'];
                                        }elseif($term->id() === '3'){
                                            $total = $result['total'] + $result['first_term_cummulative'] + $result['second_term_cummulative'];
                                        }
                                    ?>

                                    <tr>
                                        <td style="text-align: left; font-size: 10px"><?php echo e($result['subject']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result['ca1'])); ?>"><?php echo e($result['ca1']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result['ca2'])); ?>"><?php echo e($result['ca2']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam10Color($result['ca3'])); ?>"><?php echo e($result['ca3']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam10Color($result['pr'])); ?>"><?php echo e($result['pr']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam60Color($result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr'])); ?>"> <?php echo e($result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam40Color($result['exam'])); ?>"><?php echo e($result['exam']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e($result['total']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['first_term_cummulative'])); ?>"><?php echo e($result['first_term_cummulative']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center;"><?php echo e(sum($result['total'], $result['first_term_cummulative'])); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?>"><?php echo e(divnum(sum($result['total'], $result['first_term_cummulative']), 2)); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?>"><?php echo e(examGrade(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(class_average($student->grade->id(), $result['subject'], $term->id(), $period->id() )); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; width: 20%; color: <?php echo e(exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?>"><?php echo e(examRemark(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <table class="result-table">
                            <thead id="ch">
                                <tr>
                                    <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">3. COGNITIVE DOMAIN</th>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Subjects</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Activities</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Project</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Total</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Exam</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Total</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">1st TS</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">2nd TS</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Grand Total</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Avg.</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Grade</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Avg.</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Remarks</th>
                                </tr>
                                <tr style="text-align: center">
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center"></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">60</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">40</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">300</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">%</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center"></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center"></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center"></th>
                                </tr>
                            </thead>
                            <tbody style="">
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if ($term->id() === '2'){
                                            $total = $result['total'] + $result['first_term_cummulative'];
                                        }elseif($term->id() === '3'){
                                            $total = $result['total'] + $result['first_term_cummulative'] + $result['second_term_cummulative'];
                                        }
                                    ?>

                                    <tr>
                                        <td style="text-align: left; font-size: 10px"><?php echo e($result['subject']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result['ca1'])); ?>"><?php echo e($result['ca1']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result['ca2'])); ?>"><?php echo e($result['ca2']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam10Color($result['ca3'])); ?>"><?php echo e($result['ca3']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam10Color($result['pr'])); ?>"><?php echo e($result['pr']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam60Color($result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr'])); ?>"> <?php echo e($result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam40Color($result['exam'])); ?>"><?php echo e($result['exam']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e($result['total']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['first_term_cummulative'])); ?>"><?php echo e($result['first_term_cummulative']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['second_term_cummulative'])); ?>"><?php echo e($result['second_term_cummulative']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative'])); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(examGrade(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3)))); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(class_average($student->grade->id(), $result['subject'], $term->id(), $period->id() )); ?></td>
                                        <td style="font-size: 8px; font-weight: 500; text-align: center; width: 20%"><?php echo e(examRemark(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3)))); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
            </div>

            <div class="majorContainer">
                <div class="affectiveContainer">
                    <table class="affect-table" style="height: 50px; padding: 5px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="v-align" style="font-size: 8px">BEHAVIOURS</th>
                                <th colspan="5" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500; font-size: 8px">PSYCHOMOTOR DOMAIN</th>
                            </tr>
                            <tr>
                                <td style="font-size: 8px">5</td>
                                <td style="font-size: 8px">4</td>
                                <td style="font-size: 8px">3</td>
                                <td style="font-size: 8px">2</td>
                                <td style="font-size: 8px">1</td>
                            </tr>
                        </thead>

                        <?php $__currentLoopData = $psychomotors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $psychomotor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tbody class="beh-d" style="height: 100px; padding: 10px;">
                                <tr>
                                    <th style="font-size: 8px; text-align: left"><?php echo e($psychomotor->title()); ?></th>
                                    <td>
                                        <?php if($psychomotor->rate == 5): ?>
                                            <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($psychomotor->rate == 4): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($psychomotor->rate == 3): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($psychomotor->rate == 2): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($psychomotor->rate == 1): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>

                <div class="affectiveContainer" style="margin-left: 10px">
                    <table class="affect-table" style="height: 50px; padding: 5px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="v-align" style="margin: 4px 20px; font-size: 8px">BEHAVIOURS</th>
                                <th colspan="5" class="text-center" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500; font-size: 8px">AFFECTIVE DOMAIN</th>
                            </tr>
                            <tr>
                                <td style="font-size: 8px">5</td>
                                <td style="font-size: 8px">4</td>
                                <td style="font-size: 8px">3</td>
                                <td style="font-size: 8px">2</td>
                                <td style="font-size: 8px">1</td>
                            </tr>
                        </thead>

                        <?php $__currentLoopData = $affectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $affective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tbody class="beh-d">
                                <tr>
                                    <th style="font-size: 8px; text-align: left"><?php echo e($affective->title()); ?></th>
                                    <td>
                                        <?php if($affective->rate == 5): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($affective->rate == 4): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($affective->rate == 3): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($affective->rate == 2): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($affective->rate == 1): ?>
                                        <span style="font-size: 8px">V</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            </tbody>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>

            <div class="majorContainer">
                <div class="affectiveContainer">
                    <table class="result-table">
                        <thead style="text-align: center">
                            <tr>
                                <th colspan="7" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">INTERPRETATION OF RESULT</th>
                            </tr>
                            <tr>
                                <th style="font-size: 8px">Color code</th>
                                <th style="font-size: 8px">Over 10</th>
                                <th style="font-size: 8px">Over 20</th>
                                <th style="font-size: 8px">Over 40</th>
                                <th style="font-size: 8px">Over 60</th>
                                <th style="font-size: 8px">Over 100</th>
                                <th style="font-size: 8px">Grade</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            <tr>
                                <td style="color: black; font-size: 8px">BLACK</td>
                                <td style="font-size: 8px">8-10</td>
                                <td style="font-size: 8px">16-20</td>
                                <td style="font-size: 8px">32-40</td>
                                <td style="font-size: 8px">48-60</td>
                                <td style="font-size: 8px">80-100</td>
                                <td style="font-size: 8px">A</td>
                            </tr>
                            <tr>
                                <td style="color: black; font-size: 8px">BLACK</td>
                                <td style="font-size: 8px">7-7.9</td>
                                <td style="font-size: 8px">14-15.9</td>
                                <td style="font-size: 8px">28-31.9</td>
                                <td style="font-size: 8px">42-47.9</td>
                                <td style="font-size: 8px">70-79.9</td>
                                <td style="font-size: 8px">B</td>
                            </tr>
                            <tr>
                                <td style="color: green; font-size: 8px">GREEN</td>
                                <td style="font-size: 8px">6-6.9</td>
                                <td style="font-size: 8px">12-13.9</td>
                                <td style="font-size: 8px">24-27.9</td>
                                <td style="font-size: 8px">36-41.9</td>
                                <td style="font-size: 8px">60-99.9</td>
                                <td style="font-size: 8px">C</td>
                            </tr>
                            <tr>
                                <td style="color: blue; font-size: 8px">BLUE</td>
                                <td style="font-size: 8px">5.8-5.9</td>
                                <td style="font-size: 8px">11.6-11.9</td>
                                <td style="font-size: 8px">23.3-23.9</td>
                                <td style="font-size: 8px">34.8-35.9</td>
                                <td style="font-size: 8px">58-59.9</td>
                                <td style="font-size: 8px">D</td>
                            </tr>
                            <tr>
                                <td style="color: blue; font-size: 8px">BLUE</td>
                                <td style="font-size: 8px">5.6-5.79</td>
                                <td style="font-size: 8px">11.2-11.5</td>
                                <td style="font-size: 8px">22.4-23.1</td>
                                <td style="font-size: 8px">33.6-34.7</td>
                                <td style="font-size: 8px">56-57.9</td>
                                <td style="font-size: 8px">E</td>
                            </tr>
                            <tr>
                                <td style="color: red; font-size: 8px">RED</td>
                                <td style="font-size: 8px">Below 5.6</td>
                                <td style="font-size: 8px">Below 11.2</td>
                                <td style="font-size: 8px">Below 22.4</td>
                                <td style="font-size: 8px">Below 33.6</td>
                                <td style="font-size: 8px">Below 56</td>
                                <td style="font-size: 8px">F</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="affectiveContainer" style="margin-left: 5px">
                    <table class="result-table">
                        <thead style="text-align: center">
                            <tr>
                                <th colspan="5" style="padding: 0 5px; background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">CLUB & SOCIETY</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            <tr>
                                <td colspan="5" style=""></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">OFFICE HELD</td>
                            </tr>
                            <tr>
                                <td colspan="5" style=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div style="margin: 5px 0">
                    <span style="font-weight: bold; font-size: 12px">
                        <b>Class Teacher's Remarks</b>: 
                    </span>
                    <span style="font-size: 10px"><?php echo e($studentAttendance?->comment() ?? 'No comment'); ?></span>
                </div>
                <div style="margin: 5px 0">
                    <span style="font-weight: bold; font-size: 12px"><b>Principal's Remarks</b>: </span><span style="font-size: 10px"><?php echo e($comment ?? 'No comment'); ?></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\primary\resources\views\admin\result\primary_exam_pdf_result.blade.php ENDPATH**/ ?>
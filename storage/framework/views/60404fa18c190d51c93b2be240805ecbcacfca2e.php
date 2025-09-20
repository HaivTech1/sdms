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
                <div class="minorContainer">
                    <div class="result-item">
                        <b>No. of times school opened:</b>
                        <span><?php echo e($studentAttendance->attendance_duration ?? ''); ?></span>
                    </div>
                    <div class="result-item">
                        <b>No. of times present:</b>
                        <span><?php echo e($studentAttendance->attendance_present ?? ''); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Attendance Average:</b>
                        <span><?php echo e(number_format(calculatePercentage($studentAttendance->attendance_present ?? 0, $studentAttendance->attendance_duration ?? 0, 100), 1) ?? ''); ?>%</span>
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
                <table class="result-table">
                    <thead id="ch">
                        <tr>
                            <th colspan="3" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                        </tr>
                        <tr>
                            <th style="width: 20%; font-weight: 900;">Subjects</th>
                            <th style="font-weight: 900; text-align: center">Activity</th>
                            <th style="font-weight: 900; text-align: center">Teacher's Remarks</th>
                        </tr>
                    </thead>
                    <tbody style="">
                        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="text-align: left"><?php echo e($result['subject']['title']); ?></td>
                                <?php if(is_array($result['remark'])): ?>
                                    <td style="text-align: left; font-weight: 900; width: 15%;">
                                        <?php $__currentLoopData = $result['remark']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div><?php echo e($key); ?>:</div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td style="text-align: left">
                                        <?php $__currentLoopData = $result['remark']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div><?php echo e($value); ?></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                <?php else: ?>
                                    <td colspan="2" style="text-align: left"><?php echo e($result['remark']); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
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
            </div>

            <div>
                <div style="margin: 10px 0">
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
<?php /**PATH C:\laragon\www\primary\resources\views\admin\result\playgroup.blade.php ENDPATH**/ ?>
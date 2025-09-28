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
            width: 35%;
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
            <img src="<?php echo e(asset('storage/' .application('image'))); ?>" alt="<?php echo e(application('name')); ?>" width="320px">
        </div>

        <div>
            <div class="header">
                <div class="header-item">
                    <img src="<?php echo e(public_path('storage/'.application('image'))); ?>" width="70" height="70" alt="Profile Image">
                </div>
                <div class="header-item">
                    <div style="font-weight: 900; text-align: center; text-transform: uppercase; font-size: 30px;"><?php echo e(application('name')); ?></div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        <?php echo e(application('address')); ?>

                    </div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        <?php echo e(application('line1')); ?>, <?php echo e(application('line2')); ?>

                    </div>
                </div>
                <div class="header-item">
                    <img src="<?php echo e(public_path('storage/'.$student->user->image())); ?>" width="80" height="80" alt="<?php echo e($student->last_name); ?>">
                </div>
            </div>

            <div style="margin: 10px 0">
                <div style="font-weight: 500; text-align: center; text-transform: uppercase">REPORT SHEET FOR <?php echo e($term->title()); ?> <?php echo e($period->title()); ?> Academic Session</div>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <div class="result-item">
                        <b>Name:</b> <span><?php echo e(ucfirst($student->lastName())); ?> <?php echo e(ucfirst($student->firstName())); ?> <?php echo e(ucfirst($student->otherName())); ?></span>
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
                        <b>No. of times school opened:</b>
                        <span><?php echo e($termSetting?->no_school_opened ?? " "); ?></span>
                    </div>
                    <div class="result-item">
                        <b>No. of times present:</b>
                        <span><?php echo e($studentAttendance?->attendance_present ?? ''); ?></span>
                    </div>
                    <div class="result-item">
                        <b>Attendance Average:</b>
                        <span><?php echo e(round(calculatePercentage($studentAttendance->attendance_present, $termSetting?->no_school_opened ?? 0, 100))); ?>%</span>
                    </div>

                    
                </div>
                <div class="minorContainer">
                    <div class="result-item">
                        <b>Next term resumes:</b>
                        <span><?php echo e($termSetting?->next_term_resumption->format('d-M-Y') ?? '-----'); ?></span>
                    </div>
                </div>
            </div>

            <div>
            <table class="result-table">
                    <?php
                        $midterm = get_settings('midterm_format');
                        $exam = get_settings('exam_format');
                        
                        $remarkFormat = \Illuminate\Support\Str::startsWith($student->grade->title, "SSS") ? get_settings('exam_remark') : get_settings('exam_remark');
                        $gradingFormat = \Illuminate\Support\Str::startsWith($student->grade->title, "SSS") ? get_settings('exam_grade') : get_settings('exam_grade');

                        $midtermTotal = 0;
                        $examTotal = 0;

                        if (is_array($midterm)) {
                            foreach ($midterm as $key => $value) {
                                if (isset($value['mark'])) {
                                    $midtermTotal += $value['mark'];
                                }
                            }
                        }

                        if (is_array($exam)) {
                            foreach ($exam as $key => $value) {
                                if (isset($value['mark'])) {
                                    $examTotal += $value['mark'];
                                }
                            }
                        }

                        $expectedTotal = $examTotal + $midtermTotal;
                        $mapping = generate_mapping($gradingFormat, $remarkFormat);
                    ?>

                    <thead>
                        <tr>
                            <th style="width: 40%; padding-left: 10px; text-align: left">Subjects</th>
                            <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                    <?php echo e($value['full_name']); ?>

                                </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center"><?php echo e($value['full_name']); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                Total 
                            </th>
                            <?php if($term->id() === '2'): ?>
                                <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                    Brought Forward
                                </th>
                                <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                Total cummulative
                                </th>
                                <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                Average cummulative
                                </th>
                            <?php endif; ?>

                            <?php if($term->id() === '3'): ?>
                                <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                    Brought Forward
                                </th>
                                <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                cummulative
                                </th>
                                <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                    Average cummulative
                                </th>
                            <?php endif; ?>
                            <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                Position 
                            </th>
                            <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                Position in Grade
                            </th>
                            <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                            GRADE
                            </th>
                            <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">REMARK</th>
                        </tr>
                        <tr>
                            <th style="font-size: 8px; text-align: left">Marks Obtainable</th>
                            <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th style="font-size: 8px"><?php echo e($value['mark']); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th style="font-size: 8px"><?php echo e($value['mark']); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <th style="font-size: 8px"><?php echo e($expectedTotal); ?></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <?php if($term->id() === '2'): ?>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <?php endif; ?>
                            <?php if($term->id() === '3'): ?>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="padding-left: 10px; font-weight: 500; width: 40%; text-align: left; font-size: 11px"><?php echo e($result['subject']); ?></td>
                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                        <td
                                            style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                        <?php
                                            $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                        ?>
                                        <td
                                            style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td
                                        style="font-size: 10px; font-weight: 500; text-align: center">
                                        <?php echo e(calculateResult($result)); ?></td>

                                    <?php if($term->id() === '1'): ?>
                                         <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result['position_in_class_subject']); ?>

                                        </td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result['position_in_grade_subject']); ?>

                                        </td>
                                        <td
                                            style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e(examGrade(calculateResult($result), $student->grade->title())); ?></td>
                                        <td
                                        style="font-size: 10px; width: 20%; font-weight: 500; text-align: center">
                                        <?php echo e(examRemark(calculateResult($result), $student->grade->title())); ?></td>
                                        
                                    <?php endif; ?>

                                    <?php if($term->id() === '2'): ?>
                                        <td
                                            style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result['first_term']); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e(sum($result['first_term'], calculateResult($result))); ?>

                                        </td>
                                        <td
                                            style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e(divnum(sum($result['first_term'], calculateResult($result)), 2)); ?>

                                        </td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result['position_in_class_subject']); ?>

                                        </td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result['position_in_grade_subject']); ?>

                                        </td>
                                        <td
                                            style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e(examGrade(divnum(sum($result['first_term'], calculateResult($result)), 2), $student->grade->title())); ?>

                                        </td>
                                        <td
                                            style="font-size: 10px; font-weight: 500; width: 20%; text-align: center">
                                            <?php echo e(examRemark(divnum(sum($result['first_term'], calculateResult($result)), 2), $student->grade->title())); ?>

                                        </td>
                                    <?php endif; ?>

                                    <?php if($term->id() === '3'): ?>
                                        <td
                                            style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(divnum(sum($result['first_term'], $result['second_term']), 2)); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e(ceil(divnum(sum($result['first_term'], $result['second_term']), 2) + calculateResult($result))); ?>

                                        </td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2))); ?></td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result['position_in_class_subject']); ?>

                                        </td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e($result['position_in_grade_subject']); ?>

                                        </td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            <?php echo e(examGrade(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2)), $student->grade->title())); ?>

                                        </td>
                                        <td style="font-size: 8px; font-weight: 500; width: 30%; text-align: center">
                                            <?php echo e(examRemark(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2)), $student->grade->title())); ?>

                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin: 10px 0">
                <div style="font-size: 8px; text-align: center">
                    <span><b>Grading system</b>: </span>
                    <span>
                        <?php $__currentLoopData = $mapping; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <strong><?php echo e(strtoupper($key)); ?></strong>:<?php echo e($value); ?>,
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </span>
                </div>
            </div>

            <div style="text-align: center; margin: 7px 0">
                <div><b style="font-size: 14px; text-align: center">Aggregate:</b> <span style="font-size: 12px;"><?php echo e(round($aggregate)); ?>/100</span></div>
                        <div><b style="font-size: 14px; text-align: center">Position in class:</b> <span
                        style="font-size: 12px"><?php echo e($studentAttendance->position_in_class ?? ''); ?> of
                        <?php echo e($gradeStudentsCount); ?> students</span></div>
                <div><b style="font-size: 14px; text-align: center">Position in grade:</b> <span
                        style="font-size: 12px"><?php echo e($studentAttendance->position_in_grade ?? ''); ?> of
                        <?php echo e($gradeStudentsCount); ?> students</span></div>
            </div>

            <div class="majorContainer">
                <div class="affectiveContainer">
                    <table class="affect-table" style="height: 50px; padding: 5px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="v-align" style="font-size: 8px">CHARACTER</th>
                                <th colspan="5" class="text-center" style="font-size: 8px">RATING</th>
                            </tr>
                            <tr>
                                <td style="font-size: 8px">Excellent</td>
                                <td style="font-size: 8px">Very Good</td>
                                <td style="font-size: 8px">Good</td>
                                <td style="font-size: 8px">Below average</td>
                                <td style="font-size: 8px">Poor</td>
                            </tr>
                        </thead>

                        <?php $__currentLoopData = $psychomotors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $psychomotor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tbody class="beh-d">
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
                                <th rowspan="2" class="v-align" style="font-size: 8px">PRACTICAL</th>
                                <th colspan="5" class="text-center" style="font-size: 8px">RATING</th>
                            </tr>
                            <tr>
                                <td style="font-size: 8px">Excellent</td>
                                <td style="font-size: 8px">Very Good</td>
                                <td style="font-size: 8px">Good</td>
                                <td style="font-size: 8px">Below average</td>
                                <td style="font-size: 8px">Poor</td>
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

            <div style="margin: 5px 0">
                <span style="font-weight: bold; font-size: 10px">
                    <b>Class Teacher's Remarks</b>: 
                </span>
                <b style="font-size: 12px"><?php echo e($studentAttendance?->comment() ?? ''); ?></b>
            </div>
            <div style="margin: 5px 0">
                <span style="font-weight: bold; font-size: 10px"><b>Principal's Remarks</b>: </span><b style="font-size: 12px"><?php echo e($studentAttendance?->pcomment() ?? $comment); ?></b>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\primary\resources\views/admin/result/exam_pdf_result.blade.php ENDPATH**/ ?>
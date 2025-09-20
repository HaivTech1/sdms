<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Primary Result Page"); ?>
        <?php $__env->startSection('styles'); ?>
            <style>
                .mainContainer {
                    width: 60%;
                }
                .minorContainer{
                    width: 35%
                }
                .majorContainer{
                    display: flex; 
                    flex-wrap: wrap;
                    justify-content: space-between; 
                    margin-top: 1px
                }
                .appName{
                    font-size: 35px; 
                    font-weight: bold; 
                    text-transform : uppercase
                }
                
                @media  screen and (max-width: 480px) {
                    .mainContainer{
                        width: 100%;
                    }
                    .minorContainer{
                        width: 100%;
                    }
                    .majorContainer{
                        margin-top: 5px;
                        flex-direction: column;
                    }
                    .appName{
                        font-size: 15px;
                        margin: 10px;
                    }
                }

                .rotate-header {
                    transform: rotate(-180deg);
                    writing-mode: vertical-lr;
                    white-space: nowrap;
                    font-size: 10px;
                    font-weight: bold;
                    text-align: left;
                    vertical-align: middle;
                    width: 5%; 
                    font-weight: 900;
                }
            </style>
        <?php $__env->stopSection(); ?>

    <div class="row" id="resultPrintMargin">
        <div class="col-lg-12">
            <div class='parent'>
                <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                    <img class='img-rounded img-responsive' src='<?php echo e(asset('storage/'.application('image'))); ?>' alt='<?php echo e(application(' name')); ?>' />
                </div>

                <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                    <h1 class="appName"> <?php echo e(application('name')); ?></h1>
                        
                    <p style='font-size: 15px; font-family: Arial, Helvetica, sans-serif'>
                        <?php echo e(application('address')); ?>

                    </p>
                </div>

                <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                    <img src='<?php echo e(asset('storage/'.$student->user->image())); ?>' class='img-rounded img-responsive' alt='<?php echo e($student->firstName()); ?>' />
                </div>
            </div>

            <div style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px">
                <p style="font-weight: bold; color: white; text-align: center">Evaluation Report Sheet</p>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center">
                <div style="border: 1px solid #000; padding: 0 15px; font-weight: bold; text-align: left"><?php echo e($term->title()); ?></div>
                <div style="border: 1px solid #000; padding: 0 15px; font-weight: bold; text-align: right"><?php echo e($period->title()); ?></div>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Surname</th>
                                <td><?php echo e(ucfirst($student->lastName())); ?></td>
                                <th>Other Names:</th>
                                <td><?php echo e(ucfirst($student->firstName())); ?> <?php echo e(ucfirst($student->otherName())); ?></td>
                            </tr>
                            <tr>
                                <th>Class:</th>
                                <td><?php echo e($grade->title()); ?></td>
                                <th colspan="2"></th>
                            </tr>
                            <tr>
                                <th>House:</th>
                                <td><?php echo e(ucfirst($student->house?->title())); ?> </td>
                                <th colspan="2"></th>
                            </tr>
                            <tr>
                                <th>No. of Times Present</th>
                                <td><?php echo e($studentAttendance->attendance_present ?? ''); ?></td>
                                <th>Out of:</th>
                                <td><?php echo e($totalSchoolOpen ?? ''); ?> days</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="minorContainer">
                    <table class="table table-bordered table-condensed">
                        <tbody>
                            <tr>
                                <th>Sex</th>
                                <td><?php echo e(ucfirst($student->gender())); ?></td>
                            </tr>
                            <tr>
                                <th>No. In Class:</th>
                                <td><?php echo e($gradeStudentsCount); ?></td>
                            </tr>
                            <tr>
                                <th>Age:</th>
                                <td>
                                     <?php
                                        $year = Carbon\Carbon::parse($student->dob)->age
                                    ?>
                                    <?php echo e($year); ?>

                                </td>
                            </tr>
                            <tr>
                                <th>Admission</th>
                                <td><?php echo e($student->user->code()); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-wrapper table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th colspan="6" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">2. PHYSICAL DEVELOPMENT</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <th colspan="2" class="v-align">Height (m)</th>
                            <th colspan="2">Width (kg)</th>
                            <th rowspan="2" style="width: 20%"> </th>
                            <th rowspan="2">Nature of Illness</th>
                        </tr>
                        <tr>
                            <td>Beginning of Term</td>
                            <td>End of Term</td>
                            <td>Beginning of Term</td>
                            <td>End of Term</td>
                       
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

            <?php
                $midterm = get_settings('midterm_format');
                $exam = get_settings('exam_format');
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
            ?>

            <div class="table-wrapper table-responsive">
                <?php if($term->id() === '1'): ?>
                    <table class="table table-bordered table-condensed">
                        <thead id="ch">
                            <tr>
                                <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">3. COGNITIVE DOMAIN</th>
                            </tr>
                            <tr>
                                <th rowspan="3" style="width: 30%;">Subjects</th>
                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th rowspan="2" class="rotate-header"><?php echo e($value['full_name']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th rowspan="2" class="rotate-header">TOTAL</th>
                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th rowspan="2" class="rotate-header"><?php echo e($value['full_name']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th rowspan="2" class="rotate-header">TOTAL</th>
                                <th rowspan="2" class="rotate-header">Class Avg</th>
                            </tr>
                            <tr>
                                <th class="rotate-header">GRADE</th>
                                <th class="rotate-header" colspan="2">Remarks</th>
                            </tr>
                            </tr>
                            <tr style="text-align: center">
                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($value['mark']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($midtermTotal); ?></th>
                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($examTotal); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($expectedTotal); ?></th>
                                <th></th>
                                <th></th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody style="">
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($result['subject']); ?></td>
                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                            <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result[$key])); ?>"><?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                    ?>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e($color); ?>"><?php echo e($result['midterm_total']); ?></td>
                                    <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                            <?php
                                                $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                            ?>
                                            <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e($color); ?>"><?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e($result['total']); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(class_average($grade->id(), $result['subject'], $term->id(), $period->id() )); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e(examGrade($result['total'])); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e(examRemark($result['total'])); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th colspan="5"></th>
                                <th colspan="2" style="text-align: right">Grand Total:</th>
                                <th colspan="2" class="grand_total" style="text-align: center"></th>
                                <th>Aggregrate:</th>
                                <th colspan="1" class="aggregate" style="text-align: right"></th>
                            </tr>
                        </tbody>
                    </table>
                <?php elseif($term->id() === '2'): ?>
                    <table class="table table-bordered table-condensed">
                        <thead id="ch">
                            <tr>
                                <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">3. COGNITIVE DOMAIN</th>
                            </tr>
                            <tr>
                                <th rowspan="3" style="width: 30%;">Subjects</th>
                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th rowspan="2" class="rotate-header"><?php echo e($value['full_name']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th rowspan="2" class="rotate-header">TOTAL</th>
                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th rowspan="2" class="rotate-header"><?php echo e($value['full_name']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th rowspan="2" class="rotate-header">TOTAL</th>
                            </tr>
                            <tr>
                                <th class="rotate-header">1st Term Score</th>
                                <th class="rotate-header">Grand TOTAL</th>
                                <th class="rotate-header">Average</th>
                                <th class="rotate-header">GRADE</th>
                                <th class="rotate-header">Class Average</th>
                                <th class="rotate-header" colspan="2">Remarks</th>
                            </tr>
                            </tr>
                            <tr style="text-align: center">
                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($value['mark']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <th><?php echo e($midtermTotal); ?></th>
                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($examTotal); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($expectedTotal); ?></th>
                                <th>100</th>
                                <th>200</th>
                                <th></th>
                                <th></th>
                                <th>%</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody style="">
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($result['subject']); ?></td>
                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                            <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result[$key])); ?>"><?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                    ?>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e($color); ?>"><?php echo e($result['midterm_total']); ?></td>
                                    <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                            <?php
                                                $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                            ?>
                                            <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e($color); ?>"><?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e($result['total']); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['first_term_cummulative'])); ?>"><?php echo e($result['first_term_cummulative']); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center;"><?php echo e(sum($result['total'], $result['first_term_cummulative'])); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?>"><?php echo e(divnum(sum($result['total'], $result['first_term_cummulative']), 2)); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?>"><?php echo e(examGrade(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(class_average($grade->id(), $result['subject'], $term->id(), $period->id() )); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; width: 20%; color: <?php echo e(exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?>"><?php echo e(examRemark(divnum(sum($result['total'], $result['first_term_cummulative']), 2))); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th colspan="5"></th>
                                <th colspan="2" style="text-align: right">Grand Total:</th>
                                <th colspan="2" class="grand_total" style="text-align: center"></th>
                                <th>Aggregrate:</th>
                                <th colspan="1" class="aggregate" style="text-align: right"></th>
                            </tr>
                        </tbody>
                    </table>
                <?php else: ?>
                    <table class="table table-bordered table-condensed">
                        <thead id="ch">
                            <tr>
                                <th colspan="17" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">3. COGNITIVE DOMAIN</th>
                            </tr>
                            <tr>
                                <th rowspan="3" style="width: 30%;">Subjects</th>
                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th rowspan="2" class="rotate-header"><?php echo e($value['full_name']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th rowspan="2" class="rotate-header">TOTAL</th>
                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th rowspan="2" class="rotate-header"><?php echo e($value['full_name']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th rowspan="2" class="rotate-header">TOTAL</th>
                            </tr>
                            <tr>
                                <th class="rotate-header">First Term Score</th>
                                <th class="rotate-header">Second Term Score</th>
                                <th class="rotate-header">Grand TOTAL</th>
                                <th class="rotate-header">Average</th>
                                <th class="rotate-header">GRADE</th>
                                <th class="rotate-header">Class Average</th>
                                <th class="rotate-header" colspan="2">Remarks</th>
                            </tr>
                            </tr>
                            <tr style="text-align: center">
                                 <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($value['mark']); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <th><?php echo e($midtermTotal); ?></th>
                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($examTotal); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($expectedTotal); ?></th>
                                <th>100</th>
                                <th>100</th>
                                <th>300</th>
                                <th>%</th>
                                <th></th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody style="">
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($result['subject']); ?></td>
                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                            <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam20Color($result[$key])); ?>"><?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                    ?>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e($color); ?>"><?php echo e($result['midterm_total']); ?></td>
                                    <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($result[$key])): ?>
                                            <?php
                                                $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                            ?>
                                            <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e($color); ?>"><?php echo e($result[$key]); ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['total'])); ?>"><?php echo e($result['total']); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['first_term_cummulative'])); ?>"><?php echo e($result['first_term_cummulative']); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: <?php echo e(exam100Color($result['second_term_cummulative'])); ?>"><?php echo e($result['second_term_cummulative']); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative'])); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(examGrade(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3)))); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(class_average($grade->id(), $result['subject'], $term->id(), $period->id() )); ?></td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(examRemark(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3)))); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th colspan="5"></th>
                                <th colspan="2" style="text-align: right">Grand Total:</th>
                                <th colspan="2" class="grand_total" style="text-align: center"></th>
                                <th>Aggregrate:</th>
                                <th colspan="1" class="aggregate" style="text-align: right"></th>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <div class="majorContainer">
                        <div class="table-wrapper minorContainer">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="v-align">BEHAVIOURS</th>
                                        <th colspan="5" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">4. AFFECTIVE DOMAIN</th>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>4</td>
                                        <td>3</td>
                                        <td>2</td>
                                        <td>1</td>
                                    </tr>
                                </thead>

                                <?php $__currentLoopData = $affectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $affective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>     
                                    <tbody class="beh-d">
                                        <tr>
                                            <th><?php echo e($affective->title()); ?></th>
                                            <td>
                                                <?php if($affective->rate == 5): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($affective->rate == 4): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($affective->rate == 3): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                    <?php if($affective->rate == 2): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($affective->rate == 1): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                         <div class="table-wrapper minorContainer">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="v-align">BEHAVIOURS</th>
                                        <th colspan="5" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">5. PSYCHOMOTIVE DOMAIN</th>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>4</td>
                                        <td>3</td>
                                        <td>2</td>
                                        <td>1</td>
                                    </tr>
                                </thead>

                                <?php $__currentLoopData = $psychomotors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $psychomotor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>     
                                    <tbody class="beh-d">
                                        <tr>
                                            <th><?php echo e($psychomotor->title()); ?></th>
                                            <td>
                                                <?php if($psychomotor->rate == 5): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($psychomotor->rate == 4): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($psychomotor->rate == 3): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                    <?php if($psychomotor->rate == 2): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($psychomotor->rate == 1): ?>
                                                    <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="minorContainer">
                    <div class="table-wrapper">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center; background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">Grading</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="text-align: center">S/N</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">5</th>
                                    <td>Excellence</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">4</th>
                                    <td>Good</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">3</th>
                                    <td>Average</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">2</th>
                                    <td>Below Avarage</td>
                                </tr>
                                 <tr>
                                    <th style="text-align: center">1</th>
                                    <td>Unsatisfactory</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <div class="table-wrapper table-responsive">
                        <table class="table table-condensed">
                            <thead style="text-align: center">
                                <tr>
                                    <th colspan="8" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">INTERPRETATION OF RESULT</th>
                                </tr>
                                <tr>
                                    <th style="padding: 6px 5px" class="rotate-header">Color code</th>
                                    <th style="padding: 6px 5px" class="rotate-header">Over 10</th>
                                    <th style="padding: 6px 5px" class="rotate-header">Over 20</th>
                                    <th style="padding: 6px 5px" class="rotate-header">Over 40</th>
                                    <th style="padding: 6px 5px" class="rotate-header">Over 60</th>
                                    <th style="padding: 6px 5px" class="rotate-header">Over 100</th>
                                    <th style="padding: 6px 5px" class="rotate-header">Grade</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center">
                                <tr>
                                    <td style="color: black">BLACK</td>
                                    <td>8-10</td>
                                    <td>16-20</td>
                                    <td>32-40</td>
                                    <td>48-60</td>
                                    <td>80-100</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td style="color: black">BLACK</td>
                                    <td>7-7.9</td>
                                    <td>14-15.9</td>
                                    <td>28-31.9</td>
                                    <td>42-47.9</td>
                                    <td>70-79.9</td>
                                    <td>B</td>
                                </tr>
                                <tr>
                                    <td style="color: green">GREEN</td>
                                    <td>6-6.9</td>
                                    <td>12-13.9</td>
                                    <td>24-27.9</td>
                                    <td>36-41.9</td>
                                    <td>60-99.9</td>
                                    <td>C</td>
                                </tr>
                                <tr>
                                    <td style="color: blue">BLUE</td>
                                    <td>5.8-5.9</td>
                                    <td>11.6-11.9</td>
                                    <td>23.3-23.9</td>
                                    <td>34.8-35.9</td>
                                    <td>58-59.9</td>
                                    <td>D</td>
                                </tr>
                                <tr>
                                    <td style="color: blue">BLUE</td>
                                    <td>5.6-5.79</td>
                                    <td>11.2-11.5</td>
                                    <td>22.4-23.1</td>
                                    <td>33.6-34.7</td>
                                    <td>56-57.9</td>
                                    <td>E</td>
                                </tr>
                                <tr>
                                    <td style="color: red">RED</td>
                                    <td>Below 5.6</td>
                                    <td>Below 11.2</td>
                                    <td>Below 22.4</td>
                                    <td>Below 33.6</td>
                                    <td>Below 56</td>
                                    <td>F</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="minorContainer">
                    

                    <div class="table-wrapper table-responsive">
                        <table class="table table-condensed">
                            <thead style="text-align: center">
                                <tr>
                                    <th colspan="5" style="padding: 0 25px; background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">CLUB & SOCIETY</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center">
                                <tr>
                                    <td colspan="5" style="height: 20px"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">OFFICE HELD</td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="height: 20px"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 1px">
                 <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Class Teacher's Comment</th>
                            </tr>
                            <tr>
                                <th colspan="5" style="height: 20px; padding: 0 10px"><?php echo e($studentAttendance->comment ?? ''); ?></th>
                            </tr>
                            <tr>
                                <th>Headmistress' Comment</th>
                            </tr>
                            <tr>
                                <th colspan="5" style="height: 20px; padding: 0 10px"><?php echo e($comment); ?></th>
                            </tr>
                        </thead>
                    </table>
            </div>

            
        </div>
    </div>

    <div class="row">
        <div class="d-print-none">
            <div class="float-end">
                
                <a href="javascript:window.print()"
                    class="btn btn-success waves-effect waves-light me-1">Download PDF
                </a>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>

         <script>
            function generatePDF() {
                toggleAble('#downloadPdf', true);

                const style = document.createElement('style');
                style.innerHTML = 'td, th { line-height: 2; padding: 5px}';
                document.head.appendChild(style);
                const container = document.getElementById("resultPrintMargin");

                html2canvas(container, {
                    scale: 2,
                    allowTaint: false,
                    }).then(function(canvas) {
                    const imgData = canvas.toDataURL("image/png");

                    const pdfDocDefinition = {
                        pageSize: 'A4',
                        watermark: {text: ''+<?php echo json_encode(application('name'), 15, 512) ?>, color: 'gray', opacity: 0.1, bold: true, fontSize: 30,},
                        pageOrientation: 'portrait',
                        content: [
                            {
                                image: imgData,
                                width: 520,
                                height: 800
                            }
                        ],
                        styles: {
                            header: {
                                fontSize: 18,
                                bold: false,
                                margin: [0, 0, 0, 0]
                            },
                            body: {
                                fontSize: 12,
                                margin: [0, 0, 0, 0]
                            }
                        }
                    };

                    pdfMake.createPdf(pdfDocDefinition).open();
                });
                document.head.removeChild(style);
                toggleAble('#downloadPdf', false);
            }
        </script>

        <script>
            $(document).ready(function() {
                var grandTotal = 0;
                var numSubjects = <?php echo e(count($results)); ?>;
                var grand = numSubjects * 100
                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    var total = <?php echo e($result['total']); ?>;
                    grandTotal += total;
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                var aggregate = grandTotal / numSubjects;
                aggregate = aggregate.toFixed(2);

                var tot = grandTotal + ' of ' + grand
                $('.grand_total').text(tot);
                $('.aggregate').text(aggregate);
            });
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\result\primary.blade.php ENDPATH**/ ?>
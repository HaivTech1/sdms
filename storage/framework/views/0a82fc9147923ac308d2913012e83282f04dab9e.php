<div>
    <?php $__env->startSection('styles'); ?>
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
                width: 30%;
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
    <?php $__env->stopSection(); ?>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.loading','data' => []]); ?>
<?php $component->withName('loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.debounce.300ms="grade_id">
                                    <option value=''>Class</option>
                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="student_id">
                                    <option value=''>Students</option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student['uuid']); ?>"><?php echo e($student['last_name']); ?> <?php echo e($student['first_name']); ?> <?php echo e($student['other_name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
    
                            <div class="col-lg-2">
                                <select class="form-control " wire:model.defer="period_id">
                                    <option value=''>Select Session</option>
                                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
    
                            </div>
    
                            <div class="col-lg-2">
                                <select class="form-control select2" wire:model.defer="term_id">
                                    <option value=''>Select Term</option>
                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
    
                            </div>

                            <div class="col-lg-2">
                                <div class="float-end">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i> Fetch Result
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class='row mt-4'>
                        <div class="card">
                            <div class="card-header">
                                <?php if(count($results) > 0): ?>
                                    <div id="body_content">
                                        <div class="bg_img">
                                            <img src="<?php echo e(asset('storage/' .application('image'))); ?>" alt="<?php echo e(application('name')); ?>" width="300px">
                                        </div>

                                        <div>
                                            <div class="header">
                                                <div class="header-item">
                                                    <img src="<?php echo e(asset('storage/'.application('image'))); ?>" width="70" height="70" alt="Profile Image">
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
                                                    <img src="<?php echo e(asset('storage/'.$student_data->user->image())); ?>" width="70" height="70" alt="<?php echo e($student_data->last_name); ?>">
                                                </div>
                                            </div>

                                            <div style="margin: 10px 0">
                                                <div style="font-weight: 500; text-align: center; text-transform: uppercase">Terminal Evaluation Report Sheet</div>
                                                <div style="font-weight: 500; text-align: center; text-transform: uppercase"><?php echo e($term_data->title()); ?> <?php echo e($period_data->title()); ?> Academic Session</div>
                                            </div>

                                            <div class="majorContainer">
                                                <div class="mainContainer">
                                                    <div class="result-item">
                                                        <b>Name:</b> <span><?php echo e(ucfirst($student_data->lastName())); ?> <?php echo e(ucfirst($student_data->firstName())); ?> <?php echo e(ucfirst($student_data->otherName())); ?></span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Admission No.:</b>
                                                        <span><?php echo e($student_data->user->code()); ?></span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Class:</b>
                                                        <span><?php echo e($student_data->grade->title()); ?></span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Students in class:</b>
                                                        <span><?php echo e($student_data->grade->students->count()); ?></span>
                                                    </div>
                                                </div>
                                                <div class="mainContainer">
                                                    <div class="result-item">
                                                        <b>Aggregate:</b><span class="s-avg aggregate"> <?php echo e(number_format($aggregate , 1)); ?></span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Mark obtainable:</b>
                                                        <span><?php echo e($markObtainable); ?></span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Mark Obtained:</b>
                                                        <span class="s-avg grand_total"> <?php echo e($marksObtained); ?></span>
                                                    </div>
                                                </div>
                                                <div class="minorContainer">
                                                    <div class="result-item">
                                                        <b>No. of times school opened:</b>
                                                        <span><?php echo e(get_settings('no_school_open')); ?></span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>No. of times present:</b>
                                                        <span><?php echo e($studentAttendance->attendance_present ?? ''); ?></span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Attendance Average:</b>
                                                        <span><?php echo e(round(calculatePercentage($studentAttendance->attendance_present, get_settings('no_school_open'), 100)) ?? ''); ?>%</span>
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
                                                        <?php
                                                            $classPositionAllow = get_application_settings('class_position');
                                                            $gradePositionAllow = get_application_settings('class_position');
                                                            $resultPosition = get_application_settings('result_position');

                                                            $midterm = get_settings('midterm_format');
                                                            $exam = get_settings('exam_format');

                                                            $remarkFormat = \Illuminate\Support\Str::startsWith($student_data->grade->title, "SSS") ? get_settings('exam_remark') : get_settings('exam_remark_jun');
                                                            $gradingFormat = \Illuminate\Support\Str::startsWith($student_data->grade->title, "SSS") ? get_settings('exam_grade') : get_settings('exam_grade_jun');

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

                                                        <thead id="ch">
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
                                                                <?php if($term_data->id() === '2'): ?>
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

                                                                <?php if($term_data->id() === '3'): ?>
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
                                                                <?php if($classPositionAllow == 1): ?>
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                                                    Position 
                                                                </th>
                                                                <?php endif; ?>
                                                                <?php if($gradePositionAllow == 1): ?>
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                                                    Position in Grade
                                                                </th>
                                                                <?php endif; ?>
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                                                GRADE
                                                                </th>
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">REMARK</th>
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

                                                                        <?php if($term_data->id() === '1'): ?>
                                                                            <?php if($classPositionAllow == 1): ?>
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    <?php echo e($result['position_in_class_subject']); ?>

                                                                                </td>
                                                                            <?php endif; ?>
                                                                            <?php if($gradePositionAllow == 1): ?>
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    <?php echo e($result['position_in_grade_subject']); ?>

                                                                                </td>
                                                                            <?php endif; ?>
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                <?php echo e(examGrade(calculateResult($result), $student_data->grade->title())); ?></td>
                                                                            <td
                                                                            style="font-size: 10px; width: 20%; font-weight: 500; text-align: center">
                                                                                <?php echo e(examRemark(calculateResult($result), $student_data->grade->title())); ?>

                                                                            </td>

                                                                            
                                                                        <?php endif; ?>

                                                                        <?php if($term_data->id() === '2'): ?>
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

                                                                            <?php if($classPositionAllow == 1): ?>
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    <?php echo e($result['position_in_class_subject']); ?>

                                                                                </td>
                                                                            <?php endif; ?>

                                                                            <?php if($gradePositionAllow == 1): ?>
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    <?php echo e($result['position_in_grade_subject']); ?>

                                                                                </td>
                                                                            <?php endif; ?>

                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                <?php echo e(examGrade(divnum(sum($result['first_term'], calculateResult($result)), 2), $student_data->grade->title())); ?>

                                                                            </td>
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; width: 20%; text-align: center">
                                                                                <?php echo e(examRemark(divnum(sum($result['first_term'], calculateResult($result)), 2), $student_data->grade->title())); ?>

                                                                            </td>
                                                                        <?php endif; ?>

                                                                        <?php if($term_data->id() === '3'): ?>
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(divnum(sum($result['first_term'], $result['second_term']), 2)); ?></td>
                                                                            <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                <?php echo e(ceil(divnum(sum($result['first_term'], $result['second_term']), 2) + calculateResult($result))); ?>

                                                                            </td>
                                                                            <td style="font-size: 10px; font-weight: 500; text-align: center"><?php echo e(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2))); ?></td>
                                                                            
                                                                            <?php if($classPositionAllow == 1): ?>
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    <?php echo e($result['position_in_class_subject']); ?>

                                                                                </td>
                                                                            <?php endif; ?>

                                                                            <?php if($gradePositionAllow == 1): ?>
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    <?php echo e($result['position_in_grade_subject']); ?>

                                                                                </td>
                                                                            <?php endif; ?>

                                                                            <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                <?php echo e(examGrade(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2)), $student_data->grade->title())); ?>

                                                                            </td>
                                                                            <td style="font-size: 8px; font-weight: 500; width: 30%; text-align: center">
                                                                                <?php echo e(examRemark(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2)), $student_data->grade->title())); ?>

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
                                                <?php if($resultPosition == 1): ?>
                                                    <div><b style="font-size: 14px; text-align: center">Position in class:</b> <span style="font-size: 12px"><?php echo e($studentAttendance->position_in_class ?? ''); ?> of <?php echo e($student_data->grade->students->count()); ?> students</span></div>
                                                    <div><b style="font-size: 14px; text-align: center">Position in grade:</b> <span style="font-size: 12px"><?php echo e($studentAttendance->position_in_grade ?? ''); ?> of <?php echo e($gradeStudents); ?> students</span></div>
                                                <?php endif; ?>
                                            </div>

                                            <div style="margin: 10px 0">
                                                <div class="majorContainer">
                                                    <div class="affectiveContainer">
                                                        <table class="affect-table" style="height: 50px; padding: 5px;">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2" class="v-align" style="margin: 4px 20px; font-size: 8px">BEHAVIOURS</th>
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
                                                                    <td colspan="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">Next Term Resumes</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5"><?php echo e(\Carbon\carbon::parse(get_settings('next_term_resume'))->format('d F, Y') ?? 'Not set'); ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div wire:ignore>
                                                <div style="margin: 5px 0" class="cursor-pointer" 
                                                    onClick="editPrincipalComment(this)" 
                                                    data-student="<?php echo e($student_data->id()); ?>"
                                                    data-term="<?php echo e($term_data->id()); ?>"
                                                    data-period="<?php echo e($period_data->id()); ?>"
                                                >
                                                    <span" style="font-weight: bold; font-size: 10px">
                                                        <b>Class Teacher's Remarks</b>: 
                                                    </span>

                                                    <b style="font-size: 12px"><?php echo e($studentAttendance?->comment() ?? 'No comment'); ?></b>
                                                </div>

                                                <div style="margin: 5px 0" 
                                                    class="cursor-pointer"
                                                    id="editContainer"
                                                    onClick="editPrincipalComment(this)"
                                                    data-student="<?php echo e($student_data->id()); ?>"
                                                    data-term="<?php echo e($term_data->id()); ?>"
                                                    data-period="<?php echo e($period_data->id()); ?>"
                                                >
                                                    <span style="font-weight: bold; font-size: 10px; cursor: pointer" class="cursor-pointer"><b>Principal's Remarks</b>: </span>
                                                    <b style="font-size: 12px" id="commentPrincipalDisplay"><?php echo e($studentAttendance?->pcomment() ?? ''); ?></b>

                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'commentPrincipalInput','class' => 'block w-full mt-1','type' => 'text','style' => 'display: none;']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'commentPrincipalInput','class' => 'block w-full mt-1','type' => 'text','style' => 'display: none;']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                    <div class="d-flex">
                                                        <button onclick="submitPrincipalComment()" class="btn btn-sm btn-success mt-1" id="commentPrincipalButton" style="display: none;"><i class="bx bx-check"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            function editPrincipalComment(element){
                var studentData = element.getAttribute('data-student');
                var termData = element.getAttribute('data-term');
                var periodData = element.getAttribute('data-period');

                var inputField = document.getElementById('commentPrincipalInput');
                var button = document.getElementById('commentPrincipalButton');

                inputField.style.display = 'block';
                button.style.display = 'block';

                var commentDisplay = document.getElementById('commentPrincipalDisplay');
                commentDisplay.style.display = 'none';

                inputField.value = commentDisplay.innerText;

                inputField.setAttribute('data-student', studentData);
                inputField.setAttribute('data-term', termData);
                inputField.setAttribute('data-period', periodData);

            }
            


            function submitPrincipalComment() {
                var studentData = document.getElementById('editContainer').getAttribute('data-student');
                var termData = document.getElementById('editContainer').getAttribute('data-term');
                var periodData = document.getElementById('editContainer').getAttribute('data-period');
                var newComment = document.getElementById('commentPrincipalInput').value;

                var button = document.getElementById('commentPrincipalButton');
                var inputField = document.getElementById('commentPrincipalInput');
                var commentDisplay = document.getElementById('commentPrincipalDisplay');

                toggleAble(button, true, 'Submitting...');

                var url = '<?php echo e(route('result.principal.comment.upload')); ?>';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $.ajax({
                    type: 'POST',
                    url,
                    data: {student_uuid: studentData, term_id: termData, period_id: periodData, principal_comment: newComment}
                }).done((res) => {
                    toggleAble(button, false);
                    toastr.success(res.message, 'Success!');
                    
                    button.style.display = 'none';
                    inputField.style.display = 'none';

                    commentDisplay.style.display = 'block';
                    commentDisplay.innerText = newComment;
                }).fail((res) => {
                    toggleAble(button, false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            }
        </script>
    <?php $__env->stopSection(); ?>
</div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\result\view-result.blade.php ENDPATH**/ ?>
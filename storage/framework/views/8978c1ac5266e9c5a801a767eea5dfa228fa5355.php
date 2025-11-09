<div>
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?php
                        $grades = \App\Models\Grade::all();
                        $periods = \App\Models\Period::all();
                        $terms = \App\Models\Term::all();
                    ?>

                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="grade_id" id="gradeSelect">
                                    <option value=''>Class</option>
                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control " wire:model.defer="period_id" id="periodSelect">
                                    <option value=''>Select Session</option>
                                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'period_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'period_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="term_id" id="gradeTerm">
                                    <option value=''>Term</option>
                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <div class="d-flex justify-content-center align-self-center">
                                    <button type="submit" id="fetch_btn" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                        Fetch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">

                            <?php
                                $midterm = get_settings('midterm_format');
                                $exam = get_settings('exam_format');
                                $spanCount = count($midterm) + count($exam) + 1;
                            ?>

                            <?php if($studentResults && $subjects): ?>
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Student Name</th>
                                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th colspan="<?php echo e($spanCount); ?>" class="text-center"><?php echo e($subject['title']); ?></th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center" style="font-size: 10px"><?php echo e($value['full_name']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center" style="font-size: 10px"><?php echo e($value['full_name']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <th class="text-center" style="font-size: 10px">Total</th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $__currentLoopData = $studentResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                           <tr>
                                                <td><?php echo e($key+1); ?></td>
                                                <td><?php echo e($student['student_name']); ?></td>
                                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $subjectResult = null;
                                                        foreach ($student['results'] as $result) {
                                                            if ($result['subject_id'] == $subject['id']) {
                                                                $subjectResult = $result;
                                                                break;
                                                            }
                                                        }
                                                    ?>

                                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $midtermKey => $midtermValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td style="text-align: center">
                                                            <?php if($subjectResult && isset($subjectResult[$midtermKey])): ?>
                                                                <p style="color: <?php echo e(exam20Color($subjectResult[$midtermKey])); ?>"><?php echo e($subjectResult[$midtermKey]); ?></p>
                                                            <?php else: ?>
                                                                0
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examKey => $examValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td style="text-align: center">
                                                            <?php if($subjectResult && isset($subjectResult[$examKey])): ?>
                                                                <p style="color: <?php echo e(exam60Color($subjectResult[$examKey])); ?>"><?php echo e($subjectResult[$examKey]); ?></p>
                                                            <?php else: ?>
                                                                0
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    
                                                    <td style="font-weight: 500; color: <?php echo e(exam100Color(calculateResult($subjectResult))); ?>"><?php echo e(calculateResult($subjectResult)); ?></td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<?php /**PATH C:\laragon\www\primary\resources\views/livewire/components/admin/result/broadsheet/grade.blade.php ENDPATH**/ ?>
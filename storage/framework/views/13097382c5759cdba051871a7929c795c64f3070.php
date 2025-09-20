<div>
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?php
                        $grades = \App\Models\Grade::all();
                        $periods = \App\Models\Period::all();
                        $subjects = \App\Models\Subject::withoutGlobalScope(new \App\Scopes\AssignedSubjectsScope)->get();
                    ?>

                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model.defer="grade_id" id="gradeSelect">
                                    <option value=''>Class</option>
                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model.defer="subject_id" id="gradeSelect">
                                    <option value=''>Subject</option>
                                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id()); ?>"><?php echo e($subject->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-2">
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
                            ?>

                            <?php if($studentResults): ?>
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead id="ch">
                                        <tr>
                                            <th></th>
                                            <th>
                                                <th style="background-color: #502179; color: #ffffff" colspan="<?php echo e(count($midterm) + count($exam)); ?>" class="text-center">First Term</th>
                                            </th>
                                            <th>
                                                <th style="background-color: #502179; color: #ffffff" colspan="<?php echo e(count($midterm) + count($exam)); ?>" class="text-center">Second Term</th>
                                            </th>
                                            <th>
                                                <th style="background-color: #502179; color: #ffffff" colspan="<?php echo e(count($midterm) + count($exam)); ?>" class="text-center">Third Term</th>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>
                                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center" style="font-size: 10px"><?php echo e($value['full_name']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center" style="font-size: 10px"><?php echo e($value['full_name']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </th>
                                            <th>
                                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center" style="font-size: 10px"><?php echo e($value['full_name']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center" style="font-size: 10px"><?php echo e($value['full_name']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </th>
                                            <th>
                                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center" style="font-size: 10px"><?php echo e($value['full_name']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center" style="font-size: 10px"><?php echo e($value['full_name']); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $studentResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($student['student_name']); ?></td>
                                                <?php $__currentLoopData = $student['results']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $results): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                   <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td>
                                                            <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $midtermKey => $midtermValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                    <?php if($result && isset($result[$midtermKey])): ?>
                                                                        <?php echo e($result[$midtermKey]); ?>

                                                                    <?php else: ?>
                                                                        -
                                                                    <?php endif; ?>
                                                                </td>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <?php $__currentLoopData = $exam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examKey => $examValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                    <?php if($result && isset($result[$examKey])): ?>
                                                                        <?php echo e($result[$examKey]); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\result\broadsheet\subject.blade.php ENDPATH**/ ?>
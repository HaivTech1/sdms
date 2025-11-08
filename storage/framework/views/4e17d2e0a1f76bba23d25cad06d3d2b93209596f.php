<div>
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

    <?php if (\Illuminate\Support\Facades\Blade::check('examUploadEnabled')): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-body">            
                    <form wire:submit.prevent='selectStudent'>
                        <div class="row">
                            <div class="col-lg-2 mt-2">
                                <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-3 mt-2">
                                <select class="form-control select2" wire:model="student_id">
                                    <option value=''>Select Student</option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student->id()); ?>">
                                        <?php echo e($student->lastName()); ?> <?php echo e($student->firstName()); ?> <?php echo e($student->otherName()); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'student_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'student_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </select>
                            </div>

                            <div class="col-lg-2 mt-2">
                                <select class="form-control " wire:model.defer="period_id">
                                    <option value=''>Select Session</option>
                                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                </select>

                            </div>

                            <div class="col-lg-2 mt-2">
                                <select class="form-control select2" wire:model.defer="term_id">
                                    <option value=''>Select Term</option>
                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'term_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'term_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </select>

                            </div>

                            <div class="col-lg-3">
                                <div class="d-flex justify-content-center align-self-center">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class='row mt-4'>
                        
                        <?php if($selectedTerm): ?>
                            <?php
                                $exam_format = get_settings('exam_format');
                            ?>

                            <?php if($exam_format !== null): ?>
                                <?php if(count($results) > 0): ?>
                                    <div class='col-sm-12'>
                                
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'period_id','value' => ''.e($selectedPeriod->id()).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'period_id','value' => ''.e($selectedPeriod->id()).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'term_id','value' => ''.e($selectedTerm->id()).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'term_id','value' => ''.e($selectedTerm->id()).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'grade_id','value' => ''.e($grade_id).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'grade_id','value' => ''.e($grade_id).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'student_id','value' => ''.e($selectedStudent->id()).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'student_id','value' => ''.e($selectedStudent->id()).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                        <div class='table-responsive'>
                                            <table class="table table-nowrap table-check">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Subjects</th>
                                                        <?php $__currentLoopData = $exam_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <th><?php echo e($value['full_name']); ?></th>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <?php $__currentLoopData = $exam_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <th><?php echo e($value['mark']); ?></th>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                </thead>
                                                <tbody wire:ignore>
                                                    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo e($result->subject->title()); ?>

                                                        </td>
                                                        <?php $__currentLoopData = $exam_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <td>
                                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => ''.e($key).''])->html();
} elseif ($_instance->childHasBeenRendered($result->id())) {
    $componentId = $_instance->getRenderedChildComponentId($result->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($result->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($result->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => ''.e($key).'']);
    $html = $response->html();
    $_instance->logRenderedChild($result->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                            </td>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <form id="uploadPrimary" action="<?php echo e(route('result.storeSinglePrimaryUpload')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                    
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'period_id','value' => ''.e($selectedPeriod->id()).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'period_id','value' => ''.e($selectedPeriod->id()).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'term_id','value' => ''.e($selectedTerm->id()).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'term_id','value' => ''.e($selectedTerm->id()).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'grade_id','value' => ''.e($grade_id).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'grade_id','value' => ''.e($grade_id).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'student_id','value' => ''.e($selectedStudent->id()).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'student_id','value' => ''.e($selectedStudent->id()).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                            <div class='table-responsive'>
                                                <table class="table align-middle table-nowrap ">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Subjects</th>
                                                            <?php $__currentLoopData = $exam_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <th><?php echo e($value['full_name']); ?></th>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <?php $__currentLoopData = $exam_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <th style="text-align: center; width: 70px"><?php echo e($value['mark']); ?></th>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $selectedStudent->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo e($subject->title()); ?>

                                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'subject_id[]','value' => ''.e($subject->id()).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'subject_id[]','value' => ''.e($subject->id()).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                            </td>
                                                             <?php $__currentLoopData = $exam_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <td>
                                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 70px','class' => 'text-center required','type' => 'number','name' => ''.e($key).'[]','value' => '','step' => '0.01','onblur' => 'validateInput(this, '.e($mark['mark']).')']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 70px','class' => 'text-center required','type' => 'number','name' => ''.e($key).'[]','value' => '','step' => '0.01','onblur' => 'validateInput(this, '.e($mark['mark']).')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                    <div class="invalid-feedback"></div>
                                                                </td>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-sm 12 d-flex justify-content-center flex-wrap gap-2">
                                                <button type="submit" id="uploadResult"
                                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                                    Upload Result
                                                </button>
                                            </div>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="row justify-content-center mt-5">
                        <div class="col-sm-4">
                            <div class="maintenance-img">
                                <img src="<?php echo e(asset('images/coming-soon.svg')); ?>" alt="" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <h4 class="mt-5">Uploadng disabled</h4>
                    <p class="text-muted">Please contact the administrator to gain access to this.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php echo $__env->make('partials.affectiveModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.psychomotorModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.commentModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<?php $__env->startSection('scripts'); ?>
        <script>
            function validateInput(input, mark) {
                if (input.value > mark) {
                    input.classList.add('is-invalid');
                    input.nextElementSibling.textContent = 'Value cannot be greater than ' + mark;
                } else {
                    input.nextElementSibling.textContent = '';
                    input.classList.remove('is-invalid');
                }
            }
        </script>

        <script>
            $(document).on('submit', '#uploadPrimary', function (e) {
                e.preventDefault();
                toggleAble('#uploadResult', true, 'Submitting...')

                let inputs = $('#uploadPrimary .required');
                let invalid = false;

                inputs.each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').html('This field is required.');
                        invalid = true;
                    }
                });

                if (invalid) {
                    toggleAble('#uploadResult', false);
                    toastr.error('Please fill in all required fields.', 'Validation Error!');
                    return;
                }
                
                var data = $(this).serializeArray();
                var url = $(this).attr('action');
                var type = $(this).attr('method')

                $.ajax({
                    type,
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        const { data } = res;

                        $('#student_uuid').val(data.student_uuid);
                        $('#period_id').val(data.period_id);
                        $('#term_id').val(data.term_id);

                        toggleAble('#uploadResult', false)
                        toastr.success(res.message, 'Success!');
                        resetForm('#uploadPrimary');
                        $('#affective').modal('toggle');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#uploadResult', false)
                });
                
            });



            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                var student_uuid = $("input[name=student_uuid]").val();
                var period_id = $("input[name=period_id]").val();
                var term_id = $("input[name=term_id]").val();
                
                $('#createAffective').submit(function (e){
                    e.preventDefault();
                    toggleAble('#submit_affective', true, 'Submitting...');

                    var data = $(this).serializeArray();
                    var url = $(this).attr('action');
                    var type = $(this).attr('method')

                    $.ajax({
                        type,
                        url,
                        data,
                    }).done((res) => {
                        if(res.status === true) {
                            const { data } = res;

                            $('#student').val(data.student_uuid);
                            $('#period').val(data.period_id);
                            $('#term').val(data.term_id);

                            toggleAble('#submit_affective', false);
                            toastr.success(res.message, 'Success!');
                            $('#affective').modal('toggle');
                            resetForm('#createAffective');
                            $('#psychomotor').modal('toggle');
                        }
                    }).fail((res) => {
                        toggleAble('#submit_affective', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    });
                })
                
                $('#createPsychomotor').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_psychomotor', true, 'Submitting...');

                    var data = $('#createPsychomotor').serializeArray();
                    var url = '/result/psychomotor/upload';
                    var type = $(this).attr('method')

                    $.ajax({
                        type: 'POST',
                        url,
                        data
                    }).done((res) => {
                        if(res.status === true) {
                             const { data } = res;

                            $('#comment_student').val(data.student_uuid);
                            $('#comment_period').val(data.period_id);
                            $('#comment_term').val(data.term_id);

                            toggleAble('#submit_psychomotor', false);
                            toastr.success(res.message, 'Success!');
                            $('#psychomotor').modal('toggle');
                            resetForm('#createPsychomotor');
                            $('#comment').modal('toggle');
                        }
                    }).fail((res) => {
                        toggleAble('#submit_psychomotor', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    });
                });

                $('#createComment').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_comment', true, 'Submitting...');

                    var data = $('#createComment').serializeArray();
                    var url = '/result/cognitive/upload';
                    var type = $(this).attr('method')

                    $.ajax({
                        type: 'POST',
                        url,
                        data
                    }).done((res) => {
                        if(res.status === true) {
                            toggleAble('#submit_comment', false);
                            toastr.success(res.message, 'Success!');
                            resetForm('#createComment');
                            $('#comment').modal('toggle');
                        }
                    }).fail((res) => {
                        toggleAble('#submit_comment', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    });
                });
            });
        </script>
        <script>
            $('#psychomotorBtn').on('click', function(){
                const currentUrl = window.location.href;
                const searchParams = new URLSearchParams(currentUrl.split('?')[1]);
                const periodId = searchParams.get('period_id');
                const termId = searchParams.get('term_id');
                const studentId = searchParams.get('student_id');

                $('#student').val(studentId);
                $('#period').val(periodId);
                $('#term').val(termId);
                $('#affective').modal('toggle');
                $('#psychomotor').modal('toggle');
            });

            $('#affectiveBtn').on('click', function(){
                const currentUrl = window.location.href;
                const searchParams = new URLSearchParams(currentUrl.split('?')[1]);
                const periodId = searchParams.get('period_id');
                const termId = searchParams.get('term_id');
                const studentId = searchParams.get('student_id');

                $('#student').val(studentId);
                $('#period').val(periodId);
                $('#term').val(termId);
                
                $('#psychomotor').modal('toggle');
                $('#affective').modal('toggle');
            });

            $('#commentBtn').on('click', function(){
                const currentUrl = window.location.href;
                const searchParams = new URLSearchParams(currentUrl.split('?')[1]);
                const periodId = searchParams.get('period_id');
                const termId = searchParams.get('term_id');
                const studentId = searchParams.get('student_id');

                $('#comment_student').val(studentId);
                $('#comment_period').val(periodId);
                $('#comment_term').val(termId);

                $('#psychomotor').modal('toggle');
                $('#comment').modal('toggle');
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php /**PATH C:\laragon\www\primary\resources\views/livewire/components/admin/result/single-upload.blade.php ENDPATH**/ ?>
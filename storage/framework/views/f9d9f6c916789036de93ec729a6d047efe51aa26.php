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

    <?php if (\Illuminate\Support\Facades\Blade::check('midUploadEnabled')): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="fetchData">
                            <div class="row">
                                <div class="col-lg-3">
                                    <select class="form-control select2" wire:model.defer="grade_id">
                                        <option value=''>Class</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control select2" wire:model.defer="subject_id">
                                        <option value=''>Subject</option>
                                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id()); ?>"><?php echo e($subject->title()); ?></option>
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
                                            <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class='row mt-4'>
                            

                            <?php if($selectedGrade): ?>
                                <div class='col-sm-12'>
                                    <?php if(count($results) > 0): ?>
                                        <div class='table-responsive'> 
                                            <table class="table align-middle table-nowrap table-check">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>CA1</th>
                                                        <th>CA2</th>
                                                        <th>CA3</th>
                                                        <th>Examination</th>
                                                        <th>Student Name</th>
                                                        <th>Student Id</th>
                                                        <th>Uploaded by</th>
                                                        <th>Uploaded Date</th>
                                                    </tr>
                                                </thead>
                                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tbody wire:ignore>
                                                        <tr id='<?php echo e($result->id()); ?>'>
                                                            <td>
                                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => 'ca1'])->html();
} elseif ($_instance->childHasBeenRendered($result->id())) {
    $componentId = $_instance->getRenderedChildComponentId($result->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($result->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($result->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => 'ca1']);
    $html = $response->html();
    $_instance->logRenderedChild($result->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                            </td>
                                                            <td>
                                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => 'ca2'])->html();
} elseif ($_instance->childHasBeenRendered($result->id())) {
    $componentId = $_instance->getRenderedChildComponentId($result->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($result->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($result->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => 'ca2']);
    $html = $response->html();
    $_instance->logRenderedChild($result->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                            </td>
                                                            <td>
                                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => 'ca3'])->html();
} elseif ($_instance->childHasBeenRendered($result->id())) {
    $componentId = $_instance->getRenderedChildComponentId($result->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($result->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($result->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => 'ca3']);
    $html = $response->html();
    $_instance->logRenderedChild($result->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                            </td>
                                                            <td>
                                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => 'exam'])->html();
} elseif ($_instance->childHasBeenRendered($result->id())) {
    $componentId = $_instance->getRenderedChildComponentId($result->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($result->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($result->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $result,'field' => 'exam']);
    $html = $response->html();
    $_instance->logRenderedChild($result->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                            </td>
                                                            <td>
                                                                <?php echo e($result->student->firstName()); ?> <?php echo e($result->student->lastName()); ?>

                                                            </td>
                                                            <td><?php echo e($result->student->user->code()); ?></td>
                                                            <td><?php echo e($result->author()->name()); ?></td>
                                                            <td><?php echo e($result->createdAt()); ?></td>
                                                            
                                                        </tr>
                                                    </tbody>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </div>
                                        <?php echo e($results->links('pagination::custom-pagination')); ?>

                                    <?php else: ?>
                                        <form id="uploadPrimary" action="<?php echo e(route('result.store')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class='table-responsive'>
                                                <?php
                                                    $exam_format = get_settings('exam_format');
                                                ?>
                                                <table class="table align-middle table-nowrap table-check">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Student Name</th>
                                                            <?php $__currentLoopData = $exam_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <th><?php echo e($value['full_name']); ?></th>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                        <tr>
                                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'period_id','value' => ''.e($period_id).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'period_id','value' => ''.e($period_id).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'term_id','value' => ''.e($term_id).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'term_id','value' => ''.e($term_id).'','autofocus' => true]); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'subject_id','value' => ''.e($subject_id).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'subject_id','value' => ''.e($subject_id).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($index + 1); ?></td>
                                                                    <td>
                                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'student_id[]','value' => ''.e($student->id()).'','autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'student_id[]','value' => ''.e($student->id()).'','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                        <?php echo e($student->lastName()); ?> <?php echo e($student->firstName()); ?> <?php echo e($student->otherName()); ?>

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
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                                <button id="uploadResult" type="submit"
                                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                                    <?php if(count($results) > 0): ?>
                                                    Update
                                                    <?php else: ?>
                                                    Upload
                                                    <?php endif; ?>
                                                </button>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
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
                    toggleAble('#uploadResult', false)
                    toastr.success(res.message, 'Success!');
                    resetForm('#uploadPrimary');
                    setTimeout(function(){
                        window.location.reload();
                    },1000);
                }).fail((res) => {
                    toggleAble('#uploadResult', false)
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
                
            });
        </script>
    <?php $__env->stopSection(); ?>
</div><?php /**PATH C:\laragon\www\primary\resources\views/livewire/components/admin/result/create.blade.php ENDPATH**/ ?>
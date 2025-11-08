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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="fetchData">
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="form-control" wire:model.defer="grade_id">
                                        <option value=''>Class</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-control" wire:model.defer="subject_id">
                                        <option value=''>Subject</option>
                                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id()); ?>"><?php echo e($subject->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
        
                                <div class="col-lg-6">
                                    <select class="form-control " wire:model.defer="period_id">
                                        <option value=''>Select Session</option>
                                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
        
                                <div class="col-lg-6">
                                    <select class="form-control" wire:model.defer="term_id">
                                        <option value=''>Select Term</option>
                                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
        
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <div class="float-end">
                                        <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                            <i class="bx bx-search-alt" style="background-color: white; color: red; border-radius: 50%; padding: 3px"></i> Students
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <?php
                            $midterm = get_settings('midterm_format');
                        ?>

                        <div class="mt-4">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-bullseye-arrow me-2"></i>
                                Select test type only after selecting the session, term, class and subject!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <select id="format-select" class="form-control">
                                <option value="">Select test type</option>
                                <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($value['full_name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <?php if($selectedGrade): ?>
                            <div class='row mt-4'>
                                <div class='col-sm-12'>
                                    <form id="midFormSubmit" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class='table-responsive'>
                                            
                                            <table class="table align-middle table-nowrap table-check">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Name</th>
                                                        <th></th>
                                                        
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
                                                                
                                                                    <td>
                                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 70px','class' => 'text-center required midterm-input','type' => 'number','name' => '','value' => '','step' => '0.01','onblur' => 'validateInput(this)','disabled' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 70px','class' => 'text-center required midterm-input','type' => 'number','name' => '','value' => '','step' => '0.01','onblur' => 'validateInput(this)','disabled' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                        <div class="invalid-feedback"></div>
                                                                    </td>
                                                                
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="d-flex justify-content-center flex-wrap gap-2">
                                            <button id="submit_button" type="submit"
                                                class="btn btn-primary block waves-effect waves-light pull-right">
                                                Upload Result
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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

    <?php $__env->startSection('scripts'); ?>
        <script>

            $(document).ready(function(){
                $('.midterm-input').prop('disabled', true);

                $('#format-select').on('change', function() {
                    var selectedFormat = $(this).val();
                    $('.midterm-input').prop('disabled', true); // Disable all inputs
                    
                    if (selectedFormat !== '') {
                        $('.midterm-input').prop('disabled', false); // Enable inputs
                        $('.midterm-input').attr('name', selectedFormat + '[]');
                        } else {
                        $('.midterm-input').attr('name', ''); // Clear name attribute
                    }
                });
            });

            function validateInput(input) {
                var selectedFormat = $('#format-select').val();
                var marks = JSON.parse('<?php echo json_encode($midterm); ?>');
                var mark = parseFloat(marks[selectedFormat].mark);
                var value = parseFloat(input.value);

                if (value > mark) {
                    input.classList.add('is-invalid');
                    input.nextElementSibling.textContent = 'Value cannot be greater than ' + mark;
                } else {
                    input.nextElementSibling.textContent = '';
                    input.classList.remove('is-invalid');
                }
            }

            $(document).on('submit', '#midFormSubmit', function (e) {
                e.preventDefault();
                toggleAble('#submit_button', true, 'Submitting...');
                var selectedFormat = $('#format-select').val();

                if (selectedFormat === '') {
                    toastr.info('Please select the score type', 'Note!');
                    toggleAble('#submit_button', false);
                    return;
                }else{

                    let inputs = $('.midterm-input.required');
                    let invalid = false;

                    inputs.each(function() {
                        if (!$(this).val()) {
                            $(this).addClass('is-invalid');
                            $(this).siblings('.invalid-feedback').html('This field is required.');
                            invalid = true;
                        }
                    });

                    if (invalid) {
                        toggleAble('#submit_button', false);
                        toastr.error('Please fill in all required fields.', 'Validation Error!');
                        return;
                    }

                    var url = "<?php echo e(route('result.upload.batch.midterm.score')); ?>";
                    var data = $('#midFormSubmit').serializeArray();
                    data.push({ name: 'format', value: selectedFormat });

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        toggleAble('#submit_button', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#midFormSubmit');
                        setTimeout(function(){
                            window.location.reload();
                        },1000);
                    }).fail((err) => {
                        toggleAble('#submit_button', false);
                        let allErrors = Object.values(err.responseJSON).map(el => (
                        el = `<li>${el}</li>`
                        )).reduce((next, prev) => (next = prev + next));

                        const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul>${allErrors}</ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>`;

                        $('.modalErrorr').html(setErrors);
                        console.log(err.responseJSON.message);
                    });
                }
            });
        </script>
    <?php $__env->stopSection(); ?>
</div><?php /**PATH C:\laragon\www\primary\resources\views/livewire/components/admin/result/batch-midterm-upload.blade.php ENDPATH**/ ?>
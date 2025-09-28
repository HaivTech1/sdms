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
                <div class="card-body">            
                        <div class="card-header">
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
                                        <?php if(isset($students)): ?>
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
                                        <?php endif; ?>
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

                                    <div class="col-lg-3 mt-2">
                                        <div class="d-flex justify-content-center align-self-center">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                                <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                                Student
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php if($selectedTerm): ?>
                            <div class="card mt-4">
                                    <div class='row mt-4'>
                                        <?php
                                            $midterm = get_settings('midterm_format');
                                        ?>

                                        
                                            <form id="midFormSubmit" method="POST">
                                                <?php echo csrf_field(); ?>

                                                <div class="modalErrorr"></div>

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
                                                        <table class="table align-middle table-nowrap table-check">
                                    
                                                            <thead class="table-light">
                                                                <tr class="">
                                                                    <th></th>
                                                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <th><?php echo e($value['full_name']); ?></th>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <th>Total</th>
                                                                </tr>
                                                                <tr>
                                                                    <th></th>
                                                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <th><?php echo e($value['mark']); ?></th>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $__currentLoopData = $selectedStudent->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo e($subject->title()); ?>

                                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'subject_id[]','value' => ''.e($subject->id()).'']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['style' => 'width: 50px','class' => 'text-center','type' => 'hidden','name' => 'subject_id[]','value' => ''.e($subject->id()).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                    </td>
                                                                    <?php $total = 0; ?>
                                                                    <?php $__currentLoopData = $midterm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                                            <?php $total += $mark['mark']; ?>
                                                                        </td>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <td><?php echo e($total); ?></td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-sm 12 d-flex justify-content-center flex-wrap gap-2">
                                                        <button id="submit_button" type="submit"
                                                            class="btn btn-primary block waves-effect waves-light pull-right">
                                                            Upload Result
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        
                                    </div>
                            </div>
                        <?php endif; ?>
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
            

            $('.delete-score').on('click', function(){
                alert();
            })
        </script>

        <script>
            $(document).on('submit', '#midFormSubmit', function (e) {
                e.preventDefault();
                toggleAble('#submit_button', true, 'Submitting...');

                

                var url = "<?php echo e(route('result.upload.midterm.score')); ?>";
                var data = $('#midFormSubmit').serializeArray();

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
                        )).reduce((next, prev) => ( next = prev + next ));

                    const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>${allErrors}</ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `;
                    $('.modalErrorr').html(setErrors);
                });
            });

        </script>
        
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
    <?php $__env->stopSection(); ?>
</div><?php /**PATH C:\laragon\www\primary\resources\views/livewire/components/admin/result/midterm-upload.blade.php ENDPATH**/ ?>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="state.grade_id">
                                    <option value=''>Class</option>
                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'state.grade_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'state.grade_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control " wire:model.defer="state.period_id">
                                    <option value=''>Select Session</option>
                                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'state.period_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'state.period_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="state.term_id">
                                    <option value=''>Select Term</option>
                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'state.term_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'state.term_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php if($period_id && $term_id && $grade_id): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                                                    <th scope="col" class="text-center">Name of Student</th>
                                                    <?php endif; ?>
                                                    <th scope="col" class="text-center">
                                                        Class
                                                    </th>
                                                    <th scope="col" class="text-center">
                                                        Total Subjects
                                                    </th>
                                                    <th scope="col" class="text-center">
                                                        Recorded Subjects
                                                    </th>

                                                    <th scope="col" class="text-center" id="action">
                                                        Action
                                                    </th>
                                                    
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                                                    <td class='text-left'><?php echo e($student->firstName()); ?> <?php echo e($student->lastName()); ?></td>
                                                    <?php endif; ?>
                                                    <td class='text-center'><?php echo e($student->grade->title()); ?></td>
                                                    <td class='text-center'>
                                                        <div class="btn-group dropend">
                                                            <button type="button" class="btn dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <?php echo e($student->totalSubjects()); ?> <i class="mdi mdi-chevron-right"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <?php $__currentLoopData = $student->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <p class="dropdown-item"><?php echo e($subject->title()); ?></p>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class='text-center'>
                                                        <div class="btn-group dropend">
                                                            <button type="button" class="btn dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <?php echo e($student->results->where('term_id', $term_id)->where('period_id', $period_id)->count()); ?> <i class="mdi mdi-chevron-right"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <?php $__currentLoopData = $student->results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <p class="dropdown-item"><?php echo e($result->subject->title()); ?></p>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                   
                                                    <td class='d-flex justify-content-center align-items-center gap-2'>
                                                         <?php if(affectives($student, $term_id, $period_id) === true && psychomotors($student, $term_id, $period_id) === true): ?>
                                                        <a href="<?php echo e(route('result.show', $student)); ?>?grade_id=<?php echo e($grade_id); ?>&period_id=<?php echo e($period_id); ?>&term_id=<?php echo e($term_id); ?>"
                                                            type="button"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Click to view result">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <?php endif; ?>
                                                        <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                                                            <?php if(affectives($student, $term_id, $period_id) === false || psychomotors($student, $term_id, $period_id) === false): ?>
                                                                <button type="button" data-bs-toggle="offcanvas"
                                                                    data-bs-target="#offcanvasWithBothOptions<?php echo e($student->id()); ?>"
                                                                    aria-controls="offcanvasWithBothOptions">
                                                                    <i class="fas fa-compress-arrows-alt"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                                                            <?php if(affectives($student, $term_id, $period_id) === true && psychomotors($student, $term_id, $period_id) === true && cummulatives($student, $term_id, $period_id, $grade_id) == false): ?>
                                                                <button type="button" id='cummulative' onClick="publish('<?php echo e($student->id()); ?>, <?php echo e($period_id); ?>, <?php echo e($term_id); ?>, <?php echo e($grade_id); ?>')">
                                                                    <i class="mdi mdi-upload d-block font-size-16"></i> 
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions<?php echo e($student->id()); ?>"
                                                                    aria-labelledby="offcanvasWithBothOptionsLabel">
                                                            <div class="offcanvas-header">
                                                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                            </div>

                                                            <div class="offcanvas-body">
                                                                <div class="row">
                                                                    <p class="mb-2">Please rate on a scale of 1 - 5</p>
                                                                    <div class="col-sm-6" id="psychings">
                                                                        <h1 class="font-size-5 text-center mb-1">Student's Affective</h1> 
                                                                        
                                                                        <form id="CreateAffective" action="<?php echo e(route('result.affective.upload')); ?>" method="POST">
                                                                            <?php echo csrf_field(); ?>

                                                                            <input type="hidden" name="student_uuid" value="<?php echo e($student->id()); ?>" />
                                                                            <input type="hidden" name="period_id" value="<?php echo e($period_id); ?>" />
                                                                            <input type="hidden" name="term_id" value="<?php echo e($term_id); ?>" />
                                                                                    
                                                                            <div class="row mt-2">
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Attentiveness" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Attentiveness</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Neatness" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Neatness</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Politeness" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Politeness</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Honesty" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Honesty</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Punctuality" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Punctuality</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button id="submit_button1" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                                                        </form>
                                                                    </div>

                                                                    <div class="col-sm-6" id="cogniting">
                                                                        <h1 class="font-size-5 text-center mb-1">Student's Psychomotor</h1>

                                                                        <form id="CreatePsychomotor" action="<?php echo e(route('result.psychomotor.upload')); ?>" method="POST">
                                                                            <?php echo csrf_field(); ?>

                                                                            <input type="hidden" name="student_uuid" value="<?php echo e($student->id()); ?>" />
                                                                            <input type="hidden" name="period_id" value="<?php echo e($period_id); ?>" />
                                                                            <input type="hidden" name="term_id" value="<?php echo e($term_id); ?>" />
                                                                            
                                                                            <div class="row mt-2">
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Listening" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Listening</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Handwriting" />
                                                                                        <div class="input-group">
                                                                                        <div class="input-group-text">Handwriting</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Spoken English" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Spoken English</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Reading skills" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Reading</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Homework" />
                                                                                        <div class="input-group">
                                                                                        <div class="input-group-text">Homework</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Outdoor games" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Outdoor games</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Vocational skills" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Vocational</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button id="submit_button2" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php echo e($students->links('pagination::custom-pagination')); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            $(document).ready(function() {

                var student_uuid = $("input[name=student_uuid]").val();
                var period_id = $("input[name=period_id]").val();
                var term_id = $("input[name=term_id]").val();

                $.ajax({
                    type: "GET",
                    url: "psychomotor/get",
                    data: {student_uuid, period_id, term_id }
                }).done((res) => {
                    var data = res.data
                    psy = data
                    if(data.length > 0){
                        $("#psychings").css("display", "none");
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "cognitive/get",
                    data: {student_uuid, period_id, term_id }
                }).done((res) => {
                    var data = res.data
                    if(data.length > 0){
                        $("#cogniting").css("display", "none");
                    }
                })

                 $.ajax({
                    type: "GET",
                    url: "cummulative/get",
                    data: {student_uuid, period_id, term_id }
                }).done((res) => {
                    var data = res.data
                    if(data.length > 0){
                        $("#cummulative").css("display", "none");
                    }
                })
                
                
                $('#CreatePsychomotor').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_button1', true, 'Submitting...');

                    var data = $('#CreatePsychomotor').serializeArray();
                    var url = "<?php echo e(route('result.psychomotor.upload')); ?>";

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#submit_button1', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#submit_button1', false);
                            toastr.error(res.message, 'Failed!');
                        }
                       
                        console.log(res)
                        resetForm('#CreatePsychomotor');
                        location.reload()
                    }).fail((res) => {
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button1', false);
                    });
                })

                $('#CreateCognitive').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_button2', true, 'Submitting...');

                    var data = $('#CreateCognitive').serializeArray();
                    var url = "<?php echo e(route('result.affective.upload')); ?>";

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#submit_button2', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#submit_button2', false);
                            toastr.error(res.message, 'Success!');
                        }
                       
                        console.log(res)
                        resetForm('#CreateCognitive')
                        location.reload()
                    }).fail((res) => {
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button2', false);
                    });
                })
            });
        </script>
        <script>
            function publish(student){
                var data = student.split(",");
                var student_id = data[0];
                var period_id = data[1];
                var term_id = data[2];
                var grade_id = data[3];

                $.ajax({
                    url: 'publish/cummulative' ,
                    method: 'GET',
                    data: {student_id, period_id, term_id, grade_id }
                }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#cummulative', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#cummulative', false);
                            toastr.error(res.message, 'Success!');
                        }
                        console.log(res)
                        location.reload()
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#cummulative', false);
                });
            }
        </script>
    <?php $__env->stopSection(); ?>

</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\result\check.blade.php ENDPATH**/ ?>
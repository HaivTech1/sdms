<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Assignment Page"); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h4 class="mb-sm-0 font-size-18">Assignment</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><?php echo e($assignment->title()); ?></li>
                </ol>
            </div>
         <?php $__env->endSlot(); ?>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex">

                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="text-truncate font-size-15">Title: <?php echo e($assignment->title()); ?></h5>
                        </div>
                    </div>

                    <h5 class="font-size-15 mt-4">Details :</h5>

                    <p class="text-muted p-2"><?php echo $assignment->content; ?></p>
                    
                    <div class="row task-dates">
                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-calendar me-1 text-primary"></i> Created Date</h5>
                                <p class="text-muted mb-0"><?php echo e($assignment->createdAt()); ?></p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-user-check me-1 text-primary"></i> Assignment By</h5>
                                <p class="text-muted mb-0"><?php echo e($assignment->author()->title()); ?>. <?php echo e($assignment->author()->name()); ?></p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-user-check me-1 text-primary"></i> Download</h5>
                                <a href="<?php echo e(route('assignment.download', $assignment->id())); ?>" class="btn btn-sm btn-primary"><i class="bx bx-download"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assignment_comment')): ?>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Comments</h4>

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.lesson.comments','data' => ['lesson' => $assignment]]); ?>
<?php $component->withName('lesson.comments'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['lesson' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($assignment)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script type="text/javascript">
            var formId = '#save-content-form';

            $(document).on('submit', formId, function(e) {
                e.preventDefault();
                toggleAble('#submit_button', true, 'Creating assignment...');
                var data = $('#save-content-form').serializeArray();
                var url = "<?php echo e(route('assignment.store')); ?>"

                $.ajax({
                        type: 'POST',
                        url,
                        data: fd,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble('#submit_button', false);
                        resetForm(formId);
                        toastr.success(res.message, 'Successful!');
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
                        console.log(err.responseJSON.message);
                    }); 
            });
        </script>
    <?php $__env->stopSection(); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\assignment\show.blade.php ENDPATH**/ ?>
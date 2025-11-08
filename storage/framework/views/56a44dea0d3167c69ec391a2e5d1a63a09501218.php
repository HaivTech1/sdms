<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name') . ' | Student Page'); ?>

     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Student</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Show | <?php echo e($student->firstName()); ?></li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-2">
                    <div class='panel panel-primary'>
                        <div class='panel-body'>
                            <div class='parent'>
                                <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                                    <img class='img-rounded img-responsive' src='<?php echo e(asset('storage/'.application('image'))); ?>' alt='<?php echo e(application(' name')); ?>' />
                                </div>

                                <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                                    <h3> <?php echo e(application('name')); ?></h3>
                                    <p class=''>
                                        <?php echo e(application('motto')); ?>

                                    </p>

                                    <p class=''>
                                        <?php echo e(application('address')); ?>

                                    </p>
                                    <p class=''>
                                        <?php echo e(application('line1')); ?>

                                    </p>
                                </div>

                                <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                                    <img src='<?php echo e(asset('storage/'.$student->user->image())); ?>' class='img-rounded
                                    img-responsive' alt='<?php echo e($student->firstName()); ?>' />
                                </div>
                            </div>
                            <hr style="margin-top: 5px"/>
                        </div>

                        <div style="flex: 1">
                            <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Basic Information</legend>
                                    <p>Surname: <?php echo e($student->lastName()); ?><p>
                                    <p>First Name: <?php echo e($student->firstName()); ?></p>
                                    <p>Other Name: <?php echo e($student->otherName()); ?></p>
                                    <p>Gender: <?php echo e($student->gender()); ?></p>
                                    <p>State of Origin: <?php echo e($student->stateOfOrigin()); ?></p>
                                    <p>Nationality: <?php echo e($student->nationality()); ?></p>
                                    <p>Local Government: <?php echo e($student->localGovernment()); ?></p>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Others</legend>
                                    <p>DOB: <?php echo e($student->dob()); ?></p>
                                    <p>Address: <?php echo e($student->address()); ?></p>
                                    <p>Previous School: <?php echo e($student->prevSchool()); ?></p>
                                    <p>Previous Class: <?php echo e($student->prevClass()); ?></p>
                                </div>
                                
                            </div>
                            <br />

                            <div class='parent'>
                                <?php if(isset($student->father)): ?>
                                    <div class='col-xs-4 col-md-4'>
                                        <legend>Father Details</legend>
                                        <p>Office Address: <?php echo e($student->father->officeAddress()); ?></p>
                                        <p>Email: <?php echo e($student->father->email()); ?></p>
                                        <p>Phone Number: <?php echo e($student->father->phoneNumber()); ?></p>
                                        <p>Occupation: <?php echo e($student->father->occupation()); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($student->mother)): ?>
                                    <div class='col-xs-4 col-md-4'>
                                        <legend>mother Details</legend>
                                        <p>Office Address: <?php echo e($student->mother->officeAddress()); ?></p>
                                        <p>Email: <?php echo e($student->mother->email()); ?></p>
                                        <p>Phone Number: <?php echo e($student->mother->phoneNumber()); ?></p>
                                        <p>Occupation: <?php echo e($student->mother->occupation()); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($student->guardian)): ?>
                                    <div class='col-xs-4 col-md-4'>
                                        <legend>Guardian Details</legend>
                                        <p>Home Address: <?php echo e($student->guardian->homeAddress() ?? ''); ?></p>
                                        <p>Office Address: <?php echo e($student->guardian->officeAddress()); ?></p>
                                        <p>Email: <?php echo e($student->guardian->email()); ?></p>
                                        <p>Phone Number: <?php echo e($student->guardian->phoneNumber()); ?></p>
                                        <p>Occupation: <?php echo e($student->guardian->occupation()); ?></p>
                                        <p>Relationship: <?php echo e($student->guardian->relationship()); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                             <br/> 

                            <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Academics</legend>
                                    <p>Reg. No: <?php echo e($student->user->code()); ?></p>
                                    <p>Class: <?php echo e($student->grade->title() ?? ''); ?></p>
                                    <p>Portal Password: password123</p>
                                </div>
                               
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Registered</legend>
                                    <p>Date: <?php echo e($student->createdAt()); ?></p>
                                </div>
                            </div>

                            <div style="margin-top: 15px">
                                <blockquote><b style="margin-bottom: 5px">Allergics: </b> <?php echo e($student->allergics()); ?>

                                    <blockquote>

                                        <blockquote style="margin-top: 15px"><b>Medical Health Condition:</b> <?php echo e($student->medical()); ?></blockquote>
                            </div>

                             <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <h5 class="mt-4" style="font-weight: bold">Subjects Information</h5>
                                    <?php $__empty_1 = true; $__currentLoopData = $student->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <p><?php echo e($subject->title()); ?><p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-print-none">
                            <div class='col-xs-12 col-md-12 text-center'>
                                <em>
                                    <strong>NOTE:</strong> Print this slip and keep it safe, you will require this for
                                    effective service of your school portal.
                                    We are always ready to asisst in any way we can.
                                    <br />
                                    <span class='fa fa-phone'></span> <?php echo e(application('line1')); ?>,&nbsp;&nbsp;
                                    <span class='fa fa-envelope'></span> <?php echo e(application('email')); ?> &nbsp;&nbsp;
                                </em>
                            </div>
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i
                                    class="fa fa-print"></i></a>

                            <button data-id="<?php echo e($student->id()); ?>" id="syncParent"  onclick="syncParent('<?php echo e($student->id()); ?>')" type="button" class="btn btn-primary w-md waves-effect waves-light">Sync Parent</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            function syncParent(student) {
                toggleAble('#syncParent', true);
                var url = '/student/parent/publish';
                var student_id = student;

                $.ajax({
                    url ,
                    method: 'GET',
                    data: {student_id}
                }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#syncParent', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#syncParent', false);
                            toastr.error(res.message, 'Success!');
                        }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#syncParent', false);
                });
            }
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/admin/student/show.blade.php ENDPATH**/ ?>
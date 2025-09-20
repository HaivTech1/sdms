<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', "Registration Form: ". $registration->firstName() . ' '. $registration->lastName()); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">
            <a href="<?php echo e(url('index/registration')); ?>">Registrations</a>
        </h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active"><?php echo e($registration->firstName()); ?> <?php echo e($registration->lastName()); ?></li>
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
                                    <h1 style="font-size: 35px; font-weight: bold; text-decoration: uppercase"> <?php echo e(application('name')); ?></h1>
                                        
                                        <p style='font-size: 15px; font-family: Arial, Helvetica, sans-serif'>
                                            <?php echo e(application('address')); ?>

                                        </p>
                                </div>

                                <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                                    <img src='<?php echo e(asset('storage/'.$registration->image())); ?>' class='img-rounded
                                    img-responsive' alt='<?php echo e($registration->firstName()); ?>' />
                                </div>
                            </div>
                            <hr style="margin-top: 5px"/>
                        </div>

                        <div style="flex: 1">
                            <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Basic Information</legend>
                                    <blockquote><b>Surname</b>: <?php echo e($registration->lastName()); ?><p>
                                    <blockquote><b>First Name</b>: <?php echo e($registration->firstName()); ?></blockquote>
                                    <blockquote><b>Other Name</b>: <?php echo e($registration->otherName()); ?></blockquote>
                                    <blockquote><b>Gender</b>: <?php echo e($registration->gender()); ?></blockquote>
                                    <blockquote><b>State of Origin</b>: <?php echo e($registration->stateOfOrigin()); ?></blockquote>
                                    <blockquote><b>Nationality</b>: <?php echo e($registration->nationality()); ?></blockquote>
                                    <blockquote><b>Local Government</b>: <?php echo e($registration->localGovernment()); ?></blockquote>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Others</legend>
                                    <blockquote><b>DOB</b>: <?php echo e($registration->dob()); ?></blockquote>
                                    <blockquote>
                                        <?php
                                            $year = Carbon\Carbon::parse($registration->dob)->age
                                        ?>
                                     <b>Age</b>: <?php echo e($year); ?>

                                    </p>
                                    <blockquote><b>Address</b>: <?php echo e($registration->address()); ?></blockquote>
                                    <blockquote><b>Previous School</b>: <?php echo e($registration->prevSchool()); ?></blockquote>
                                    <blockquote><b>Previous Class</b>: <?php echo e($registration->prevClass()); ?></blockquote>
                                </div>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Academics</legend>
                                    <blockquote><b>Class</b>: <?php echo e($registration?->grade?->title() ?? ''); ?></blockquote>
                                </div>
                            </div>

                            <hr />

                            <div class="parent">
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Father's Details</legend>
                                    <blockquote><b>Name</b>: <?php echo e($registration->father_name); ?></blockquote>
                                    <blockquote><b>Office Address</b>: <?php echo e($registration->father_office_address); ?></blockquote>
                                    <blockquote><b>Email</b>: <?php echo e($registration->father_email); ?></blockquote>
                                    <blockquote><b>Phone Number</b>: <?php echo e($registration->father_phone); ?></blockquote>
                                    <blockquote><b>Occupation</b>: <?php echo e($registration->father_occupation); ?></blockquote>
                                </div>

                                <div class='col-xs-4 col-md-4'>
                                    <legend>Mother's Details</legend>
                                    <blockquote><b>Name</b>: <?php echo e($registration->mother_name); ?></blockquote>
                                    <blockquote><b>Office Address</b>: <?php echo e($registration->mother_office_address); ?></blockquote>
                                    <blockquote><b>Email</b>: <?php echo e($registration->mother_email); ?></blockquote>
                                    <blockquote><b>Phone Number</b>: <?php echo e($registration->mother_phone); ?></blockquote>
                                    <blockquote><b>Occupation</b>: <?php echo e($registration->mother_occupation); ?></blockquote>
                                </div>

                                <div class='col-xs-4 col-md-4'>
                                    <legend>Guardian Details</legend>
                                    <blockquote><b>Home Address</b>: <?php echo e($registration->guardian_home_address ?? ''); ?></blockquote>
                                    <blockquote><b>Office Address</b>: <?php echo e($registration->guardian_office_address); ?></blockquote>
                                    <blockquote><b>Email</b>: <?php echo e($registration->guardian_email); ?></blockquote>
                                    <blockquote><b>Phone Number</b>: <?php echo e($registration->guardian_phone_number); ?></blockquote>
                                    <blockquote><b>Occupation</b>: <?php echo e($registration->guardian_occupation); ?></blockquote>
                                    <blockquote><b>Relationship</b>: <?php echo e($registration->guardian_relationship); ?></blockquote>
                                </div>
                            </div>

                            <hr />

                            <div class='parent'>
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Medical Details</legend>
                                    <blockquote><b style="margin-bottom: 5px">Genotype: </b> <?php echo e($registration->genotype); ?> <blockquote>
                                    <blockquote><b style="margin-bottom: 5px">Blood Group: </b> <?php echo e($registration->blood_group); ?> <blockquote>
                                    <blockquote><b style="margin-bottom: 5px">Allergics: </b> <?php echo e($registration->allergics()); ?> <blockquote>
                                    <blockquote><b style="margin-bottom: 5px">Sight: </b> <?php echo e($registration->sight); ?> <blockquote>
                                    <blockquote><b style="margin-bottom: 5px">Speech development: </b> <?php echo e($registration->speech_development); ?> <blockquote>
                                    <blockquote><b>Medical Health Condition:</b> <?php echo e($registration->medical()); ?></blockquote>
                                </div>
                               
                                <div class='col-xs-4 col-md-4'>
                                    <legend>Registered</legend>
                                    <blockquote><b>Date</b>: <?php echo e($registration->createdAt()); ?></blockquote>
                                </div>
                            </div>
                        </div>

                        <br />
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\registration\show.blade.php ENDPATH**/ ?>
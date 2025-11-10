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

    <div class="row mb-2">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.search','data' => []]); ?>
<?php $component->withName('search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                              <?php if($search): ?>
                                <button wire:click.prevent="resetSearch" type=" button"
                                    class="btn btn-danger waves-effect btn-label waves-light">
                                    <i class="bx bx-brush-alt label-icon "></i>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model="type">
                                <option value="">Filter by type</option>
                                <option value="2">Administrator</option>
                                <option value="3">Teachers</option>
                                <option value="5">Bursar</option>
                                <option value="6">Workers</option>
                                <option value="8">Drivers</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-check font-size-16">
                            <input class="form-check-input" type="checkbox" id="checkAll"
                                wire:model="selectPageRows">
                                <label class="form-check-label" for="checkAll">all</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row">
                        <?php if($selectedRows): ?>
                        <div class="col-6">
                            <div class="btn-group btn-group-example mb-3" role="group">
                                <button wire:click.prevent="deleteAll" type="button"
                                    class="btn btn-outline-danger btn-sm w-sm" title="delete all employess">
                                    <i class="bx bx-trash"></i>
                                </button>
                                <button wire:click.prevent="disableAll" type="button"
                                    class="btn btn-outline-primary btn-sm w-sm">
                                    <i class="bx bx-check-double"></i>
                                </button>
                                <button wire:click.prevent="undisableAll" type="button"
                                    class="btn btn-outline-primary btn-sm w-sm">
                                    <i class="bx bx-x-circle"></i>
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </diV>
            </div>
        </div>
        <div class=" col-sm-4">
            <div class="text-sm-end">
                <button type="button" class="btn btn-sm btn-primary btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".createEmployee">
                    <i class="mdi mdi-plus me-1"></i> Add Employee
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-xl-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                                <img class="rounded-circle avatar-xs"
                                src="<?php echo e(asset('storage/'.$employee->image())); ?>"
                                alt="<?php echo e($employee->name()); ?>">
                            </span>
                        </div>
                        <h5 class="font-size-15 mb-1"><a href="javascript: void(0);" class="text-dark"><?php echo e($employee->name()); ?></a></h5>
                        <p class="text-muted"><?php echo e($employee->user_type); ?></p>
                        <p class="text-muted"><?php echo e($employee->code()); ?></p>

                        <div>
                            <?php if($employee->type  == 3 && isset($employee->gradeClassTeacher)): ?>
                                <?php $__empty_2 = true; $__currentLoopData = $employee->gradeClassTeacher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <span class="badge badge-soft-primary font-size-11 m-"><?php echo e($grade->title()); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <span class="badge badge-soft-danger font-size-11 m-">Assign Class</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <div class="contact-links d-flex font-size-20">
                            <div class="form-check font-size-16">
                                <input class="form-check-input" value="<?php echo e($employee->id()); ?>" type="checkbox"
                                    id="<?php echo e($employee->id()); ?>" wire:model="selectedRows">
                                <label class="form-check-label" for="<?php echo e($employee->id()); ?>"></label>
                            </div>
                            <div class="flex-fill">
                                <a href="javascript: void(0);"><i class="bx bx-message-square-dots"></i></a>
                            </div>
                            <?php if(count($employee->gradeClassTeacher) > 0): ?>
                                <?php if($employee->type  == 3): ?>
                                    <div class="flex-fill" title="Assign class for teacher">
                                        <button type="button" value="<?php echo e($employee->id()); ?>" data-class="<?php echo e($employee->gradeClassTeacher[0]->id()); ?>" id="assignClass"><i class="bx bx-dialpad-alt"></i></button>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($employee->type  == 3): ?>
                                    <div class="flex-fill" title="Assign class for teacher">
                                        <button type="button" value="<?php echo e($employee->id()); ?>" id="assignClass"><i class="bx bx-dialpad-alt"></i></button>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                                
                            <div class="flex-fill">
                                <?php if(!isset($employee->profile)): ?>
                                    <button type="button" id="addProfile" value="<?php echo e($employee->id()); ?>"><i class="bx bx-user-x text-danger"></i></button>
                                <?php else: ?>
                                    <button type="button" id="edit_btn<?php echo e($employee->profile->id); ?>" onclick="editProf(<?php echo e($employee->profile->id); ?>)"><i class="bx bx-user-check text-success"></i></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center">
                <p>No data found!</p>
            </div>
        <?php endif; ?>

        <?php echo e($employees->links('pagination::custom-pagination')); ?>

    </div>

    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Account information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="submitProfile" action="<?php echo e(route('staff.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="employee_id" name="employee_id">
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="col-form-label">Salary:</label>
                            <input type="text" class="form-control" id="salary" name="salary">
                        </div>
                        <div class="mb-3">
                            <label for="bank_code">Banks</label>
                            <select class="form-control" id="bank_code" name="bank_code">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="account_number" class="col-form-label">Account Number:</label>
                            <input type="text" class="form-control" id="account_number" name="account_number">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="bank_name" name="bank_name">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="create_profile" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="editProfile" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Update employee's profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editEmployeeProfile" action="<?php echo e(route('staff.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="col-sm-12 mb-3">
                            <input id="profile_id" class="form-control" type="hidden" name="profile_id" />
                        </div>

                        <div class="col-sm-12  mb-3">
                            <label for="salary" class="col-form-label">Salary:</label>
                            <input type="text" class="form-control" id="edit_salary" name="edit_salary">
                        </div>

                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'edit_account_number','value' => ''.e(__('Account Number')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'edit_account_number','value' => ''.e(__('Account Number')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <input id="edit_account_number" class="form-control" type="text" name="edit_account_number" />
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'edit_account_number']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'edit_account_number']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'edit_bank_code','value' => ''.e(__('Bank')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'edit_bank_code','value' => ''.e(__('Bank')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <select class="form-control" name="edit_bank_code" id="edit_bank_code">
                                
                            </select>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'edit_bank_code']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'edit_bank_code']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="edit_bank_name" name="edit_bank_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="update_button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade createEmployee" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Create a new employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="modalErrorr"></div>

                    <form id="employeeForm" action="<?php echo e(route('user.store')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'title','value' => ''.e(__('Title')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'title','value' => ''.e(__('Title')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <select class="form-control select2" name="title" value="old('title')">
                                            <option>Select</option>
                                            <option value="Mr">Mr.</option>
                                            <option value="Miss">Miss.</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Prof">Prof</option>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'title']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'title']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'name','value' => ''.e(__('Name')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'name','value' => ''.e(__('Name')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'name','class' => 'block w-full mt-1','type' => 'text','name' => 'name','value' => old('name')]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'name','class' => 'block w-full mt-1','type' => 'text','name' => 'name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'name']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'email','value' => ''.e(__('Email')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'email','value' => ''.e(__('Email')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'email','class' => 'block w-full mt-1','type' => 'text','name' => 'email','value' => old('email'),'autocomplete' => 'off']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'email','class' => 'block w-full mt-1','type' => 'text','name' => 'email','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('email')),'autocomplete' => 'off']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'email']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone_number"
                                             name="phone_number" :value="old('phone_number')" required>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'phone_number']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'phone_number']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'password','value' => ''.e(__('Password')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'password','value' => ''.e(__('Password')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <input type="password" class="form-control" id="password"
                                         name="password" autocomplete="off">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'password']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="row justify-content-center align-items-center g-2">
                                            <div class="col">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'image','value' => ''.e(__('Image')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'image','value' => ''.e(__('Image')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'image','class' => 'block w-full mt-1','placeholder' => 'image','type' => 'file','name' => 'image']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'image','class' => 'block w-full mt-1','placeholder' => 'image','type' => 'file','name' => 'image']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'image']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'image']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            </div>
                                            <div class="col">
                                             <div class="image" id="img-show-container" style="display: none; width:50px; height: 50px; border-radius: 50%">
                                                <div class="bx bx-trash-alt btn delete" onclick="resetImgUpl()"></div>
                                                <canvas id="img-show" class="img-thumbnail img-response"></canvas>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'type','value' => ''.e(__('Type')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'type','value' => ''.e(__('Type')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <select class="form-control select2" name="type" value="old('type')">
                                            <option>Select</option>
                                            <option value="2">Administrator</option>
                                            <option value="3">Teacher</option>
                                            <option value="5">Bursar</option>
                                            <option value="6">Worker</option>
                                            <option value="8">Driver</option>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'type']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'type']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="d-flex justify-content-center flex-wrap">
                            <button type="submit" id="create_employee" class="btn btn-primary block waves-effect waves-light pull-right">Save
                                Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.add_class', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startSection('scripts'); ?>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $(document).on('click', '#assignClass', function(e) {
            e.preventDefault();
            var id = $(this).val();
            var class_id = $(this).attr('data-class');

            $('#user_id').val(id);
            $('#grade_id').val(class_id);
            $('.addClass').modal('toggle');
        });

        $(document).on('submit', '#assignClasses', function (e) {
            e.preventDefault();
            toggleAble('#submit_button', true, 'Submitting...');
            var data = $('#assignClasses').serializeArray();
            var url = "<?php echo e(route('teacher.assignClass')); ?>";

            $.ajax({
                type: "POST",
                url,
                data
            }).done((res) => {
                if (res.status) {
                    toggleAble('#submit_button', false);
                    toastr.success(res.message, 'Success!');
                    $('.addClass').modal('toggle');
                    setTimeout(function () {window.location.reload()}, 1000);
                } else {
                    toggleAble('#submit_button', false);
                    toastr.error(res.message, 'Failed!');
                }
                resetForm('#assignClasses');
            }).fail((res) => {
                console.log(res.responseJSON.message);
                toastr.error(res.responseJSON.message, 'Failed!');
                toggleAble('#submit_button', false);
            });
        })

        $(document).on('click', '#addProfile', function() {
            toggleAble($(this), true);
            var id = $(this).attr('value');
            $('#employee_id').val(id);

            $.ajax({
                url: "/staff/bank/list",
                method: 'GET',
            }).done((res) => {
                $('#bank_code').empty();
                $.each(res.data, function(index, bank) {
                    $('#bank_code').append('<option value="' + bank.code + '">' + bank.name + '</option>');
                });
                toggleAble($(this), false);
                $('#profileModal').modal('toggle');
            }).fail((e) => {
                console.log(e);
            })
        });

        $('#bank_code').on('change', function() {
            var code = $(this).val();

            $.ajax({
                url: '/staff/bank/single/'+ code,
                method: 'GET',
            }).done((response) => {
                console.log(response[0].name);
                $('#bank_name').val(response[0].name);
            }).fail((err) => {
                console.log(err);
            });
        });

        $('#edit_bank_code').on('change', function() {
            var code = $(this).val();

            $.ajax({
                url: '/staff/bank/single/'+ code,
                method: 'GET',
            }).done((response) => {
                console.log(response[0].name);
                $('#edit_bank_name').val(response[0].name);
            }).fail((err) => {
                console.log(err);
            });
        });

        function editProf(id){

            toggleAble('#edit_btn'+id, true);
            $.get('/staff/profile/edit/'+ id, function(response){
                const {data, banks} = response
                console.log(data);
                $('#profile_id').val(data.id);
                $('#edit_salary').val(data.salary);
                $('#edit_bank_code').val(data.bank_code);
                $('#edit_bank_name').val(data.bank_name);
                $('#edit_account_number').val(data.account_number);

                $.each(banks.data, function(index, bank) {
                    $('#edit_bank_code').append('<option value="' + bank.code + '">' + bank.name + '</option>');
                });
                toggleAble('#edit_btn'+id, false);
                $('#editProfile').modal('toggle');
            });
        }

        $(document).on('submit', '#submitProfile', function(e){
            e.preventDefault();
            toggleAble('#create_profile', true, 'Submitting...');
            var data = $(this).serializeArray();
            var url = $(this).attr('action');
            var type = $(this).attr('method');

             $.ajax({
                url, 
                data, 
                type 
            }).done((res) => {
                if (res.status == true) {
                    resetForm('#submitProfile');
                    toggleAble('#create_profile', false);
                    $('#profileModal').modal('toggle');
                    Swal.fire({
                        title: "Success!",
                        text: "Success! " + res.message + "",
                        icon: "success",
                        confirmButtonColor: "#556ee6",
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: " Sorry! " + res.message + "",
                        icon: "error",
                        confirmButtonColor: "#556ee6",
                    });
                    toggleAble('#create_profile', false);
                }
            }).fail((e) => {
                    console.log(e);
                    Swal.fire({
                        title: "Oops!",
                        text: "There was a server error",
                        icon: "question",
                        confirmButtonColor: "#556ee6",
                    });
                    toggleAble('#create_profile', false);
            });
           
        })

        $(document).on('submit', '#editEmployeeProfile', function(e){
            e.preventDefault();
            toggleAble('#update_button', true, 'Updating...');
            var data = $(this).serializeArray();
            var url = $(this).attr('action');
            var type = $(this).attr('method');

             $.ajax({
                url, 
                data, 
                type 
            }).done((res) => {
                if (res.status == true) {
                    toggleAble('#update_button', false);
                    $('#editProfile').modal('toggle');
                    Swal.fire({
                        title: "Success!",
                        text: "Success! " + res.message + "",
                        icon: "success",
                        confirmButtonColor: "#556ee6",
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: " Sorry! " + res.message + "",
                        icon: "error",
                        confirmButtonColor: "#556ee6",
                    });
                }
            }).fail((e) => {
                    toggleAble('#update_button', false);
                    console.log(e);
                    Swal.fire({
                        title: "Oops!",
                        text: "There was a server error",
                        icon: "question",
                        confirmButtonColor: "#556ee6",
                    });
            });
           
        })

        $(document).on('submit', '#employeeForm', function(e){
            e.preventDefault();

            let formData = new FormData($('#employeeForm')[0]);
            toggleAble('#create_employee', true, 'Submitting...');
            var url = $(this).attr('action');

                $.ajax({
                    method: "POST",
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    toggleAble('#create_employee', false);
                    toastr.success(res.message, 'Success!');
                    $('.createEmployee').modal('toggle');
                    setTimeout(function () {window.location.reload()}, 1000);
                    resetForm('#employeeForm')
                }).fail((err) => {
                    console.log(err);
                    toggleAble('#create_employee', false);
                    const errorResponse = err.responseJSON;
                    toastr.error(errorResponse.message, 'Failed!');
                    if (errorResponse && errorResponse.errors) {
                        const errors = errorResponse.errors;
                        const allErrors = Object.values(errors).map(el => `<li>${el}</li>`).reduce((prev, next) => prev + next, '');
                    
                        const setErrors = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>${allErrors}</ul>
                            </div>
                        `;
                    
                        $('.modalErrorr').html(setErrors);
                    } else {
                    }
                });
        })
    </script>

    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views/livewire/components/admin/staff/index.blade.php ENDPATH**/ ?>
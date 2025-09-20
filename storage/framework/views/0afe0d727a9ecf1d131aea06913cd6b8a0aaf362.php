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
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
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
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        <?php if($search): ?>
                                        <div class="col-6">
                                            <button wire:click.prevent="resetSearch" type=" button"
                                                class="btn btn-danger waves-effect btn-label waves-light">
                                                <i class="bx bx-block label-icon "></i>
                                                clear search
                                            </button>
                                        </div>
                                        <?php endif; ?>
                                        <?php if($selectedRows): ?>
                                        <div class="col-6">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button wire:click.prevent="deleteAll" type="button"
                                                    class="btn btn-outline-danger w-sm">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                                <button wire:click.prevent="disableAll" type="button"
                                                    class="btn btn-outline-warning w-sm">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                                <button wire:click.prevent="undisableAll" type="button"
                                                    class="btn btn-outline-success w-sm">
                                                    <i class="bx bx-check"></i>
                                                </button>
                                                <button wire:click.prevent="sendDetails" type="button"
                                                    class="btn btn-outline-info w-sm">
                                                    <i class="bx bx-key"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Registered Teachers</p>
                                            <h4 class="mb-0"><?php echo e(count($allTeachers)); ?></h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Active Teachers</p>
                                            <h4 class="mb-0"><?php echo e(count($activeTeachers)); ?></h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Unactive Teachers</p>
                                            <h4 class="mb-0"><?php echo e(count($unactiveTeachers)); ?></h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20px;" class="align-middle">
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                wire:model="selectPageRows">
                                            <label class="form-check-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th class="align-middle"></th>
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">ID</th>
                                    <th class="align-middle">Email</th>
                                    <th class="align-middle">Privileges</th>
                                    <th class="align-middle">Assigned Classes</th>
                                    <th class="align-middle">Assigned Subjects</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="<?php echo e($teacher->id()); ?>" type="checkbox"
                                                id="<?php echo e($teacher->id()); ?>" wire:model="selectedRows">
                                            <label class="form-check-label" for="<?php echo e($teacher->id()); ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <img class="rounded-circle avatar-xs"
                                                src="<?php echo e(asset('storage/' . $teacher->image())); ?>"
                                                alt="<?php echo e($teacher->name()); ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $teacher,'field' => 'name'])->html();
} elseif ($_instance->childHasBeenRendered($teacher->id())) {
    $componentId = $_instance->getRenderedChildComponentId($teacher->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($teacher->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($teacher->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $teacher,'field' => 'name']);
    $html = $response->html();
    $_instance->logRenderedChild($teacher->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </td>
                                    <td>
                                        <?php echo e($teacher->code()); ?>

                                    </td>
                                    <td>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $teacher,'field' => 'email'])->html();
} elseif ($_instance->childHasBeenRendered($teacher->id())) {
    $componentId = $_instance->getRenderedChildComponentId($teacher->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($teacher->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($teacher->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $teacher,'field' => 'email']);
    $html = $response->html();
    $_instance->logRenderedChild($teacher->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </td>
                                    <td>
                                        <ul class="list-group">
                                            <?php $__currentLoopData = $teacher->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div><?php echo e($role->title()); ?></div>
                                                    <button type="button" class="btn btn-sm btn-danger delete-role" data-user-id="<?php echo e($teacher->id()); ?>"
                                                        data-role-id="<?php echo e($role->id()); ?>">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="accordion" id="accordionExamplegrade">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headinggrade<?php echo e($teacher->id()); ?>">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapsegrade<?php echo e($teacher->id()); ?>" aria-expanded="true"
                                                        aria-controls="collapsegrade<?php echo e($teacher->id()); ?>">
                                                        Expand Classes
                                                    </button>
                                                </h2>
                                                <div id="collapsegrade<?php echo e($teacher->id()); ?>" class="accordion-collapse collapse"
                                                    aria-labelledby="headinggrade<?php echo e($teacher->id()); ?>" data-bs-parent="#accordionExamplegrade">
                                                    <div class="accordion-body">
                                                        <ul class="list-group">
                                                            <?php $__empty_1 = true; $__currentLoopData = $teacher->gradeClassTeacher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <?php echo e($grade->title()); ?>

                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingsubject<?php echo e($teacher->id()); ?>">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesubject<?php echo e($teacher->id()); ?>" aria-expanded="true" aria-controls="collapsesubject<?php echo e($teacher->id()); ?>">
                                                        Expand Subjects
                                                    </button>
                                                </h2>
                                                <div id="collapsesubject<?php echo e($teacher->id()); ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo e($teacher->id()); ?>" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <ul class="list-group">
                                                            <?php $__empty_2 = true; $__currentLoopData = $teacher->assignedSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignedSubjects): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <?php echo e($assignedSubjects->title()); ?>

                                                            </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <button data-id="<?php echo e($teacher->id()); ?>" class="dropdown-item show"><i
                                                    class="mdi mdi-eye me-1"></i> View
                                                </button>
                                                <button class="dropdown-item" type="button" value="<?php echo e($teacher->id()); ?>" data-class="" id="assignClass">
                                                    <i class="fas fa-compress-arrows-alt"></i> Assign Class
                                                </button>
                                                <button class="dropdown-item assignSubject" type="button" data-id="<?php echo e($teacher->id()); ?>" id="assignSubject">
                                                    <i class="fas fa-compress-arrows-alt"></i> Assign Subject
                                                </button>
                                                <button class="dropdown-item" type="button" id="changePassword" data-user="<?php echo e($teacher->id()); ?>">
                                                    <i class="fas fa-compress-arrows-alt"></i> Update Password
                                                </button>
                                                <button class="dropdown-item" type="button" id="assignRole" data-id="<?php echo e($teacher->id()); ?>">
                                                    <i class="fas fa-compress-arrows-alt"></i> Assign Role Privilege
                                                </button>
                                                <?php if($teacher->qrcode): ?>
                                                 <button class="dropdown-item" type="button" id="showQrcode"
                                                     value="<?php echo e($teacher->qrcode); ?>">
                                                     <i class="fa fa-eye"></i> Show Qrcode
                                                 </button>
                                                <?php else: ?>
                                                 <button class="dropdown-item" type="button" id="generateQrcode"
                                                     value="<?php echo e($teacher->id()); ?>">
                                                     <i class="fa fa-qrcode"></i> Generate Qrcode
                                                 </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo e($teachers->links('pagination::custom-pagination')); ?>

                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.add_class', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.add_teacher_subject', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="modal fade showTeacherSubject" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Teacher details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div>
                        <div class="row">
                            <div class="row">
                                <input name="selected_teacher_id" id="selected_teacher_id" type="hidden" />

                                <div class="col-sm-6 mb-2">
                                    <h5>List of assigned subjects</h5>
                                    <hr/> 
                                    <br />
                                    
                                    <div class="table-responsive">
                                        <table id="subjects-teacher" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                 <div class="col-sm-6 mb-2">
                                    <h5>List of assigned classes</h5>
                                    <hr/> 
                                    <br />

                                    <div class="table-responsive">
                                        <table id="grades-teacher" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade passwordUpdate" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="updatePass" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <input id="user_id" name="user_id" type="hidden" />

                        <div class="row" style="display: flex; justify-content: center; align-items: center">
                            <div class="col-sm-6">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'password','value' => ''.e(__('New Password')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'password','value' => ''.e(__('New Password')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'password','class' => 'block w-full mt-1','type' => 'text','name' => 'password']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'password','class' => 'block w-full mt-1','type' => 'text','name' => 'password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                        </div>

                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <button type="submit" id="submit_password" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade addRole bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Roles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="createRoles">
                                <?php echo csrf_field(); ?>

                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['type' => 'hidden','value' => '','name' => 'user_id','id' => 'role_user_id']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'hidden','value' => '','name' => 'user_id','id' => 'role_user_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <select name="roles[]" class="select2 form-control" multiple="multiple" style="height: 300px" id="roles">
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($role->id()); ?>">
                                                    <?php echo e($role->title()); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                    <button type="submit" id="submit_role" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showQrcodeModal" tabindex="-1" aria-labelledby="showQrcodeModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Student QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="qr-preview" src="" alt="QR Code" class="img-fluid mx-auto d-block"
                        style="max-width:200px;">
                </div>
            </div>
        </div>
    </div>

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

            $(document).on('click', '.assignSubject', function() {
                var button = $(this);
                var teacherId = $(this).data('id');
                toggleAble(button, true);

                $('#teacher_id').val(teacherId);
                $('.addSubject').modal('toggle');
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
            });

            $(document).on('submit', '#createSubjects', function(e) {
                e.preventDefault();

                toggleAble('#submit_Sub', true, 'Syncing...');
                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                $.ajax({
                    url,
                    type: "POST",
                    data,
                }).done((res) => {
                    if (res.status) {
                        toggleAble('#submit_Sub', false);
                        toastr.success(res.message, 'Success!');
                        $('.addSubject').modal('toggle');
                    }
                    resetForm('#createSubjects');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000)
                }).fail((res) => {
                    toggleAble('#submit_Sub', false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });;
            });

            $(document).on('click', '.show', function() {
                var teacherId = $(this).data('id');
                document.getElementById("selected_teacher_id").value=teacherId;

                $.ajax({
                    url: '/teacher/subject/' + teacherId,
                    method: 'GET',
                    success: function(response) {
                        var subjects  = response.subjects;
                        var grades = response.grades;

                        var html = '';
                        $.each(subjects, function(index, subject) {
                            html += '<tr>';
                            html += '<td>' + subject.title + '</td>';
                            html += '<td><button class="btn btn-sm btn-danger btn-rounded waves-effect waves-light mb-2 me-2 remove" data-id="' + subject.id + '" data-teacher="' + teacherId + '">Remove</button></td>';
                            html += '</tr>';
                        });

                        var template = '';
                        $.each(grades, function(index, grade) {
                            template += '<tr>';
                            template += '<td>' + grade.title + '</td>';
                            template += '<td><button class="btn btn-sm btn-danger btn-rounded waves-effect waves-light mb-2 me-2 remove_grade" data-id="' + grade.id + '" data-teacher="' + teacherId + '">Remove</button></td>';
                            template += '</tr>';
                        });

                        $('#subjects-teacher tbody').html(html);
                        $('#grades-teacher tbody').html(template);

                        $('.showTeacherSubject').modal('toggle');
                    },
                    error: function(response) {
                        console.log(response.responseJSON.message);
                    }
                });
            });

            $(document).on('click', '.remove', function(e) {
                e.preventDefault();
                var button = $(this);
                toggleAble(button, true);

                var subjectId = $(this).data('id');
                var teacherId = $(this).data('teacher');
                var row = $(this).closest('tr');

                $.ajax({
                    url: "/teacher/subject/" + subjectId + "/teacher/"+teacherId,
                    method: 'GET',
                    success: function(response) {
                        toggleAble(button, false);
                        toastr.success(response.message);
                        row.remove();
                    },
                    error: function(response) {
                        toggleAble(button, false);
                        console.log(response.responseJSON.message);
                    }
                });
            });

            $(document).on('click', '.remove_grade', function(e) {
                e.preventDefault();
                var button = $(this);
                toggleAble(button, true);

                var gradeId = $(this).data('id');
                var teacherId = $(this).data('teacher');
                var row = $(this).closest('tr');

                $.ajax({
                    url: "/teacher/grade/" + gradeId + "/teacher/"+teacherId,
                    method: 'GET',
                    success: function(response) {
                        toggleAble(button, false);
                        toastr.success(response.message);
                        row.remove();
                    },
                    error: function(response) {
                        toggleAble(button, false);
                    }
                });
            });

            $(document).on('click', '#changePassword', function() {
                var userId = $(this).data('user');
                document.getElementById('user_id').value = userId;
                $('.passwordUpdate').modal('toggle')
            });

            $(document).on('submit', '#updatePass', function (e) {
                e.preventDefault();
                let data = $(this).serializeArray();
                toggleAble('#submit_password', true, 'Submitting...');
                var url = "<?php echo e(route('update.password')); ?>";

                $.ajax({
                    method: "POST",
                    url,
                    data: data,
                }).done((res) => {
                    toggleAble('#submit_password', false);
                    toastr.success(res.message, 'Success!');
                    $('#img-show-container').hide();
                    $('.updatePassport').modal('toggle');
                    resetForm('#upload')

                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }).fail((err) => {
                    console.log(err);
                    toggleAble('#submit_password', false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $(document).on('click', '#assignRole', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var button = $(this);
                toggleAble(button, true);

                $.ajax({
                    url: "/user/roles/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        toggleAble(button, false);

                        $.each(response.data, function(index, role) {
                            $('#roles option[value="' + role.id + '"]').prop('selected', true);
                        });

                        $('#role_user_id').val(id);
                        $('.addRole').modal('show');
                    },
                    error: function(xhr, status, error) {
                        toggleAble(button, false);
                        toastr.error(xhr.responseText, 'Failed!');
                    }
                });
            });

            $(document).on('submit', '#createRoles', function(e){
                e.preventDefault();
                toggleAble('#submit_role', true, 'Submitting...');
                var data = $('#createRoles').serializeArray();
                var url = "<?php echo e(route('user.assignRole')); ?>";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble('#submit_role', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createRoles');
                    $('.addRole').modal('toggle');
                    setTimeout(function () {
                        window.location.reload()
                    }, 2000);
                }).fail((res) => {
                    toggleAble('#submit_role', false);
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
                
            });

            $(document).on('click', '.delete-role', function() {
                var userId = $(this).data('user-id');
                var roleId = $(this).data('role-id');

                toggleAble($(this), true);

                $.ajax({
                    url: '/user/' + userId + '/role/' + roleId,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toggleAble($(this), false);
                        toastr.success(response.message, 'Success!');
                        setTimeout(function () {window.location.reload()}, 1500);
                    },
                    error: function(xhr, status, error) {
                        toggleAble($(this), false);
                        toastr.error(xhr.responseText, 'Failed!');
                    }
                });
            });

            $(document).on('click', '#generateQrcode', function() {
                var teacherId = $(this).val();
                var button = $(this); 

                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the old QR code and generate a new one.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, regenerate it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        toggleAble(button, true);

                        // Show loading modal
                        Swal.fire({
                            title: "Generating QR Code...",
                            text: "Please wait a moment.",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '/staff/generate-qrcode/' + teacherId,
                            type: 'GET',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                toggleAble(button, false);
                                Swal.close(); // close loading modal
                                toastr.success(response.message, 'Success!');
                                $('#qr-preview').attr('src', response.file);
                                $('#showQrcodeModal').modal('show');
                            },
                            error: function(xhr, status, error) {
                                toggleAble(button, false);
                                Swal.close(); // close loading modal
                                toastr.error("Failed to generate QR code", 'Error!');
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#showQrcode', function() {
                var qrPath = $(this).val(); 
                
                if (qrPath) {
                    $('#qr-preview').attr('src', '/storage/' + qrPath);
                    $('#showQrcodeModal').modal('show');
                } else {
                    toastr.error("QR code not found for this student.", "Error!");
                }
            });

        </script>
    <?php $__env->stopSection(); ?>
</div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\teacher.blade.php ENDPATH**/ ?>
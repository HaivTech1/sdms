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
                                                    <i class="bx bx-x"></i> Delete
                                                </button>
                                                <button wire:click.prevent="disableAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    Disable
                                                </button>
                                                <button wire:click.prevent="undisableAll" type="button"
                                                    class="btn btn-outline-info w-sm">
                                                    Undisable
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
                                <a href="<?php echo e(route('user.create')); ?>"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Add User</a>
                            </div>
                        </div><!-- end col-->
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
                                    <th class="align-middle">Id</th>
                                    <th class="align-middle">Privileges</th>
                                    <th class="align-middle">Role</th>
                                    <th class="align-middle">Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="<?php echo e($user->id()); ?>" type="checkbox"
                                                id="<?php echo e($user->id()); ?>" wire:model="selectedRows">
                                            <label class="form-check-label" for="<?php echo e($user->id()); ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <img class="rounded-circle avatar-xs"
                                                src="<?php echo e(asset('storage/'.$user->image())); ?>" alt="<?php echo e($user->name()); ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $user,'field' => 'name'])->html();
} elseif ($_instance->childHasBeenRendered($user->id())) {
    $componentId = $_instance->getRenderedChildComponentId($user->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($user->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($user->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $user,'field' => 'name']);
    $html = $response->html();
    $_instance->logRenderedChild($user->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </td>
                                    <td>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $user,'field' => 'reg_no'])->html();
} elseif ($_instance->childHasBeenRendered($user->id())) {
    $componentId = $_instance->getRenderedChildComponentId($user->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($user->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($user->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $user,'field' => 'reg_no']);
    $html = $response->html();
    $_instance->logRenderedChild($user->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </td>
                                    <td>
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading<?php echo e($user->id()); ?>">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($user->id()); ?>" aria-expanded="true" aria-controls="collapse<?php echo e($user->id()); ?>">
                                                        Click to expand
                                                    </button>
                                                </h2>
                                                <div id="collapse<?php echo e($user->id()); ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo e($user->id()); ?>" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <ul class="list-group">
                                                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <?php echo e($role->title()); ?>

                                                                    <button type="button" class="btn btn-sm btn-danger delete-role"  data-user-id="<?php echo e($user->id); ?>" data-role-id="<?php echo e($role->id); ?>">
                                                                        <i class="bx bx-x"></i>
                                                                    </button>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="px-2 py-1 text-center text-gray-700 bg-green-200 rounded">
                                            <select wire:change="changeUser(<?php echo e($user); ?>, $event.target.value)"
                                                class="form-control w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="1" <?php if($user->type() === 1): ?> selected <?php endif; ?>>Super Admin
                                                </option>
                                                <option value="2" <?php if($user->type() === 2): ?> selected <?php endif; ?>>Admin
                                                </option>
                                                <option value="3" <?php if($user->type() === 3): ?> selected <?php endif; ?>>Teacher
                                                </option>
                                                <option value="4" <?php if($user->type() === 4): ?> selected <?php endif; ?>>Student
                                                </option>
                                                <option value="5" <?php if($user->type() === 5): ?> selected <?php endif; ?>>Bursal
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.toggle-button', ['model' => $user,'field' => 'isAvailable'])->html();
} elseif ($_instance->childHasBeenRendered($user->id())) {
    $componentId = $_instance->getRenderedChildComponentId($user->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($user->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($user->id());
} else {
    $response = \Livewire\Livewire::mount('components.toggle-button', ['model' => $user,'field' => 'isAvailable']);
    $html = $response->html();
    $_instance->logRenderedChild($user->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                
                                                <button class="dropdown-item" type="button" id="changePassword" data-user="<?php echo e($user->id()); ?>">
                                                    <i class="fas fa-compress-arrows-alt"></i> Update Password
                                                </button>

                                                <button class="dropdown-item" type="button" id="assignRole" data-id="<?php echo e($user->id()); ?>">
                                                    <i class="fas fa-compress-arrows-alt"></i> Assign Role Privilege
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo e($users->links('pagination::custom-pagination')); ?>

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

      <?php $__env->startSection('scripts'); ?>
        <script>

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
        </script>
        
    <?php $__env->stopSection(); ?>

</div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\manager\user.blade.php ENDPATH**/ ?>
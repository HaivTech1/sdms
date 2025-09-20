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
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-6">
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
                                <div class=" col-sm-6">
                                    <div class="">
                                        <button data-bs-toggle="modal" data-bs-target=".downloadRegistrationForm" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Download Registration Form </button>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="gender">
                                                <option value=''>Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Others</option>
                                            </select>

                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="grade">
                                                <option value=''>Select Grade</option>
                                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($grade->id); ?>"><?php echo e($grade->title()); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="sortBy">
                                                <option value=''>Sort By</option>
                                                <option value="asc">ASC</option>
                                                <option value="desc">DESC</option>
                                            </select>

                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="orderBy">
                                                <option value=''>Order By</option>
                                                <option value="first_name">First Name</option>
                                                <option value="last_name">Last Name</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="status">
                                                <option value=''>Status</option>
                                                <option value="1">Active</option>
                                                <option value="false">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button type="button" id="compare" class="btn btn-primary w-xs"><i class="mdi mdi-thumb-up"></i></button>
                                                <button type="button" id="syncParent" class="btn btn-danger w-xs"><i class="fa fa-users"></i></button>
                                            </div>
                                        </div>
                                    </div>     
                                </diV>
                            </div>
                            <?php if($selectedRows): ?>
                                <div class="row mt-2">
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="acceptAll" type="button"
                                                class="btn btn-outline-success w-sm">
                                                <i class="bx bx-check"></i>
                                                Accept All
                                                </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="deleteAll" type="button"
                                                class="btn btn-outline-danger w-sm">
                                                <i class="bx bx-trash"></i>
                                                Delete All
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Today's Registration</p>
                                            <h4 class="mb-0"><?php echo e(count($todayRegistrations)); ?></h4>
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
                                            <p class="text-muted fw-medium">Admitted</p>
                                            <h4 class="mb-0"><?php echo e(count($admittedRegistrations)); ?></h4>
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
                                            <p class="text-muted fw-medium">Unadmitted</p>
                                            <h4 class="mb-0"><?php echo e(count($unadmittedRegistrations)); ?></h4>
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

                    <div class='row'>
                        <div class='col-sm-12'>
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
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Name </th>
                                            <th class="align-middle"> Class </th>
                                            <th class="align-middle"> Status </th>
                                            <th class="align-middle"> Submitted at </th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="<?php echo e($registration->id()); ?>"
                                                        type="checkbox" id="<?php echo e($registration->id()); ?>"
                                                        wire:model="selectedRows">
                                                    <label class="form-check-label" for="<?php echo e($registration->id()); ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);" class="text-body fw-bold"><?php echo e($key + 1); ?></a>
                                            </td>
                                            <td>
                                                <?php echo e($registration->firstName()); ?> <?php echo e($registration->lastName()); ?>

                                            </td>
                                            <td>
                                                <?php echo e($registration->grade->title()); ?>

                                            </td>
                                            <td>
                                                <?php if($registration->status === true): ?>
                                                    <span class="badge badge-soft-success">Admitted</span>
                                                <?php else: ?>
                                                    <span class="badge badge-soft-danger">Not Admitted</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo e($registration->createdAt()); ?>

                                            </td>
                                            <td>
                                                 <div class="row">
                                                    <div class="col-sm-4">
                                                        <a class="btn btn-sm btn-secondary"
                                                            href="<?php echo e(url('show/registration', $registration)); ?>"><i
                                                                class="fa fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button data-id="<?php echo e($registration->id()); ?>" class="btn btn-sm btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo e($registrations->links('pagination::custom-pagination')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('partials.compare', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.parent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>


<?php $__env->startSection('scripts'); ?>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#delete').on('click', function() {
                if(confirm(`Are you sure want to remove this?`)){
                    var id = $(this).data('id');
                    $.ajax({
                        url:"/delete/registration" +'/'+ id,
                        type:"DELETE",
                        dataType:'json',
                        success:function(response)
                        {
                            toastr.success(response.message, 'Success!');
                        },
                        error:function(error)
                        {
                            console.log(error);
                            toastr.error(error, 'Failed!');
                        },
                    });
                }
            })
        });

        $('#compare').on('click', function(){
            toggleAble('#compare', true, 'Fetching...');
            $.get("/compare/registration", function(response){
                const { data, message } = response;
                if(response.status){
                    toggleAble('#compare', false);
                     var rows = "";
                    $.each(data, function(key, value) {
                        rows += "<tr>";
                        rows += "<td><input type='checkbox' name='selected[]' value='" + value.id + "'></td>";
                        rows += "<td>" + value.first_name + ' ' + value.last_name + ' ' + value.other_name +"</td>";
                        rows += "<td><button class='btn btn-secondary' id='accept' data-id='" + value.id + "'>Accept</button></td>";
                        rows += "</tr>";
                    });
                    $("#table-body").append(rows);
                    $(".message").append(message);
                    $('.compareRegistration').modal('toggle');
                }
            });
        });

        $('#syncParent').on('click', function(){
            toggleAble('#syncParent', true, 'Fetching...');
            $.get("/sync/parent", function(response){
                const { data, message } = response;
                if(response.status){
                    toggleAble('#syncParent', false);
                     var rows = "";
                    $.each(data, function(key, value) {
                        rows += "<tr>";
                        rows += "<td><input type='checkbox' name='selected[]' value='" + value.uuid + "'></td>";
                        rows += "<td>" + value.first_name + ' ' + value.last_name + ' ' + value.other_name +"</td>";
                        rows += "<td><button type='button' class='btn btn-secondary' id='sync' data-id='" + value.uuid + "'>Sync</button></td>";
                        rows += "</tr>";
                    });
                    $("#table-body2").append(rows);
                    $(".message").append(message);
                    $('.syncParentModal').modal('toggle');
                }
            });
        });

        

        $(document).on('click', '#table-body button', function() {
            var id = $(this).data('id');
            toggleAble('#accept', true);
            $.ajax({
                url:"/accept/student" +'/'+ id,
                type:"GET",
                dataType:'json',
                success:function(response)
                {
                    toastr.success(response.message, 'Success!');
                    toggleAble('#accept', false);
                    $('.compareRegistration').modal('toggle');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error:function(error)
                {
                    console.log(error);
                    toastr.error(error, 'Failed!');
                    toggleAble('#accept', false);
                },
            });
        });

        $(document).on('click', '#select-all', function() {

            var cherker = document.getElementById('select-all');
            var sendBtn = document.getElementById('submit_button');

            cherker.onchange = function(){
                if(this.checked){
                    sendBtn.disabled = false;
                }else{
                    sendBtn.disabled = true;
                }
            }

            $('input[name="selected[]"]').prop('checked', $(this).prop('checked'));
        });

        $(document).on('click', 'input[name="selected[]"]', function() {

            var cherker = document.querySelector('input[name="selected[]"]');
            var sendBtn = document.getElementById('submit_button');

            cherker.onchange = function(){
                if(this.checked){
                    sendBtn.disabled = false;
                }else{
                    sendBtn.disabled = true;
                }
            }

            var allChecked = $('input[name="selected[]"]').length === $('input[name="selected[]"]:checked').length;
            $('#select-all').prop('checked', allChecked);
        });

        $(document).on('submit', '#accpeptAllStudents', function(e) {
            e.preventDefault();
            toggleAble('#submit_button', true, 'Submitting');
            var selected = $('input[name="selected[]"]:checked').map(function() {
                return this.value;
            }).get();

            var formData = new FormData();
            formData.append('selected', selected);

            $.ajax({
                url: "/accept/student/all",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message, 'Success!');
                    toggleAble('#submit_button', false);
                    $('.compareRegistration').modal('toggle');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    toastr.error(error, 'Failed!');
                    toggleAble('#submit_button', false);
                }
            });
        });

        $(document).on('click', '#table-body2 button', function() {
            var id = $(this).data('id');
            toggleAble('#sync', true);
            $.ajax({
                url:"/resync/parent" +'/'+ id,
                type:"GET",
                dataType:'json',
                success:function(response)
                {
                    toastr.success(response.message, 'Success!');
                    toggleAble('#sync', false);
                    $('.syncParentModal').modal('toggle');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error:function(error)
                {
                    console.log(error);
                    toastr.error(error, 'Failed!');
                    toggleAble('#sync', false);
                },
            });
        });

        $(document).on('submit', '#syncAllParents', function(e) {
            e.preventDefault();
            toggleAble('#sync_button', true, 'Submitting');
            var selected = $('input[name="selected[]"]:checked').map(function() {
                return this.value;
            }).get();

            var formData = new FormData();
            formData.append('selected', selected);

            $.ajax({
                url: "/sync/parent/all",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message, 'Success!');
                    toggleAble('#sync_button', false);
                    $('.syncParentModal').modal('toggle');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    toastr.error(error, 'Failed!');
                    toggleAble('#sync_button', false);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\registration\index.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | ".$title); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Frontend</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active"><?php echo e($title); ?></li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="row mb-2">
            <div class="col-sm-8">
                <button id="deleteButton" style="display: none;" class="btn btn-danger"><i class="bx bx-trash"></i>Delete</button>
            </div>
            <div class="col-sm-4">
                <div class="text-sm-end">
                    <button type="button"
                        data-bs-toggle="modal" data-bs-target=".createImage"
                        class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2"><i
                            class="mdi mdi-plus me-1"></i> 
                            Add Image
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20px;" class="align-middle">
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="align-middle">Image</th>
                                <th class="align-middle">Title</th>
                                <th class="align-middle">Status</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input selectRow" value="<?php echo e($gallery->id()); ?>"
                                            type="checkbox" id="<?php echo e($gallery->id()); ?>"
                                        >
                                        <label class="form-check-label" for="<?php echo e($gallery->id()); ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <img 
                                    class="rounded-circle avatar-xs"
                                    data-id="<?php echo e($gallery->id()); ?>"
                                    src="<?php echo e(asset($gallery->image())); ?>"
                                    alt="<?php echo e($gallery->title()); ?>">
                                </td>
                                <td>
                                    <?php echo e($gallery->title()); ?>

                                </td>
                                <td>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.toggle-button', ['model' => $gallery,'field' => 'status'])->html();
} elseif ($_instance->childHasBeenRendered($gallery->id())) {
    $componentId = $_instance->getRenderedChildComponentId($gallery->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($gallery->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($gallery->id());
} else {
    $response = \Livewire\Livewire::mount('components.toggle-button', ['model' => $gallery,'field' => 'status']);
    $html = $response->html();
    $_instance->logRenderedChild($gallery->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                </td>
                                <td>
                                    <button data-id="<?php echo e($gallery->id()); ?>" class="btn btn-sm btn-warning remove"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    
                     <?php echo e($galleries->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>

        <div class="modal fade createImage" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create a new image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="imageForm"  method="POST" action="<?php echo e(route('admin.gallery.store')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
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
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'title','class' => 'block w-full mt-1','type' => 'text','name' => 'title','value' => old('title'),'autofocus' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'title','class' => 'block w-full mt-1','type' => 'text','name' => 'title','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('title')),'autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'image','value' => ''.e(__('Select File')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'image','value' => ''.e(__('Select File')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <input type="file" id="path" name="image" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                <button type="submit" id="submit_image" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            $(document).ready(function () {
                $(document).on('submit', '#imageForm', function (e) {
                    e.preventDefault();
                    let formData = new FormData($('#imageForm')[0]);
                    toggleAble('#submit_image', true, 'Submitting...');
                    var url = $(this).attr('action');

                    $.ajax({
                        method: "POST",
                        url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble('#submit_image', false);
                        toastr.success(res.message, 'Success!');
                        $('.createImage').modal('toggle');

                        setTimeout(() =>{
                            window.location.reload();
                        }, 1500);
                    }).fail((err) => {
                        toggleAble('#submit_image', false);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                });

                $(document).on('click', '.remove', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);
                    var galleryId = $(this).data('id');
                    var row = $(this).closest('tr');

                    Swal.fire({
                            title: 'Confirm Deletion',
                            text: 'Are you sure you want to delete this item?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#502179',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                            });

                            $.ajax({
                                url: "<?php echo e(route('admin.gallery.delete', ['gallery' => ':gallery_id'])); ?>".replace(':gallery_id', galleryId),
                                method: 'DELETE',
                                success: function(response) {
                                    toggleAble(button, false);
                                    Swal.fire('Deleted!', response.message, 'success');
                                    row.remove();
                                },
                                error: function(response) {
                                    toggleAble(button, false);
                                    console.log(response.responseJSON.message);
                                    toastr.error(response.responseJSON.message, 'Failed');
                                }
                            });
                            
                        }else{
                            toggleAble(button, false);
                        }
                    });
                });

                function updateDeleteButtonVisibility() {
                    var anyCheckboxChecked = $(".selectRow:checked").length > 0;
                    $("#deleteButton").toggle(anyCheckboxChecked);
                }

                $("#checkAll").change(function () {
                    $(".selectRow").prop('checked', $(this).prop("checked"));
                    updateDeleteButtonVisibility();
                });

                $(".selectRow").change(function () {
                    if (!$(this).prop("checked")) {
                        $("#checkAll").prop('checked', false);
                    }
                    updateDeleteButtonVisibility();
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $("#deleteButton").click(function () {
                    var button = $(this);
                    toggleAble(button, true, 'Deleting');

                    var selectedIds = [];
                    $(".selectRow:checked").each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (selectedIds.length > 0) {
                        $.ajax({
                            url: '<?php echo e(route("admin.gallery.deleteMany")); ?>',
                            type: 'POST',
                            data: { ids: selectedIds },
                            success: function (response) {
                                toggleAble(button, false);
                                toastr.success(response.message, 'Success');

                                setTimeout(function () {
                                    window.location.reload();
                                }, 1500)
                            },
                            error: function (error) {
                                toggleAble(button, false);
                                toastr.error(response.responseJSON.message, 'Failed');
                            }
                        });
                    } else {
                        toggleAble(button, false);
                        alert('No items selected');
                    }
                });

                $("#deleteButton").hide();
            });
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\frontend\gallery\index.blade.php ENDPATH**/ ?>
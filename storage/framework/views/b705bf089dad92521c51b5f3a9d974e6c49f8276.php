<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Hairstyles')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Manage Hairstyles</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".hairstyleModal">Add Hairstyle</button>
                    </div>

                    <div id="hairstyles-wrap" data-list-url="<?php echo e(route('admin.hairstyle.list')); ?>">
                        <?php echo $__env->make('admin.hairstyle._hairstyles_list', ['hairstyles' => $hairstyles], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade hairstyleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new hairstyle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="hairstyleForm" action="<?php echo e(route('admin.hairstyle.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'title','class' => 'block w-full mt-1','type' => 'text','name' => 'title','value' => old('title')]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'title','class' => 'block w-full mt-1','type' => 'text','name' => 'title','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('title'))]); ?>
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
                            <div class="col-sm-12 mb-3">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'description','value' => ''.e(__('Note')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'description','value' => ''.e(__('Note')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <textarea class="form-control" name="description"><?php echo e(old('description')); ?></textarea>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'description']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="side_view_input" class="form-label">Side View:</label>
                                    <input type="file" id="side_view_input" class="form-control" name="side_view" accept="image/*" onchange="previewImage('side_view_input', 'side_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="side_view_preview" src="#" alt="Side view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="front_view_input" class="form-label">Front View:</label>
                                    <input type="file" id="front_view_input" class="form-control" name="front_view" accept="image/*" onchange="previewImage('front_view_input', 'front_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="front_view_preview" src="#" alt="Front view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="back_view_input" class="form-label">Back View:</label>
                                    <input type="file" id="back_view_input" class="form-control" name="back_view" accept="image/*" onchange="previewImage('back_view_input', 'back_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="back_view_preview" src="#" alt="Back view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Activate</label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                                <button id="createHair" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            function previewImage(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        preview.setAttribute('src', e.target.result);
                        preview.style.display = 'block';
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.setAttribute('src', '#');
                    preview.style.display = 'none';
                }
            }

            (function($){
                const $wrap = $('#hairstyles-wrap');
                const listUrl = $wrap.data('list-url');

                function loadList(url){
                    try { $wrap.append($('<div class="overlay-loader">').css({position: 'absolute', top:0, left:0, width:'100%', height:'100%', background:'rgba(255,255,255,0.6)', 'z-index': 9999}).append(divLoader())); } catch(e){}
                    $.get(url).done(function(html){ $wrap.html(html); }).fail(function(){ Swal.fire('Error','Failed to load hairstyles','error'); }).always(function(){ $wrap.find('.overlay-loader').remove(); });
                }

                // submit create via AJAX
                $('#hairstyleForm').on('submit', function(e){
                    e.preventDefault();
                    const fd = new FormData(this);
                    const $btn = $('#createHair');
                    toggleAble($btn, true, 'Creating...');
                    $.ajax({ url: $(this).attr('action'), data: fd, method: 'POST', processData: false, contentType: false })
                        .done(function(){ toggleAble($btn, false); $('.hairstyleModal').modal('hide'); Swal.fire('Added','Hairstyle added','success'); loadList(listUrl); })
                        .fail(function(xhr){ toggleAble($btn, false); Swal.fire('Error', xhr.responseJSON?.message || 'Failed to create', 'error'); });
                });

                // pagination links
                $wrap.on('click', '.pagination a', function(e){ e.preventDefault(); loadList($(this).attr('href')); });

                // delegated delete handler
                $wrap.on('click', '.delete-hair', function(e){
                    e.preventDefault();
                    const id = $(this).data('hair-id');
                    if(!id) return;
                    Swal.fire({
                        title: 'Delete hairstyle?',
                        text: 'This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete',
                    }).then(function(res){
                        if(!res.isConfirmed) return;
                        try { $wrap.append($('<div class="overlay-loader">').css({position: 'absolute', top:0, left:0, width:'100%', height:'100%', background:'rgba(255,255,255,0.6)', 'z-index': 9999}).append(divLoader())); } catch(e){}
                        $.ajax({
                            url: "<?php echo e(url('/admin/hairstyle')); ?>/" + id,
                            method: 'POST',
                            data: { _method: 'DELETE', _token: '<?php echo e(csrf_token()); ?>' }
                        }).done(function(){ Swal.fire('Deleted','Hairstyle removed','success'); loadList(listUrl); }).fail(function(xhr){ Swal.fire('Error', xhr.responseJSON?.message || 'Failed to delete', 'error'); }).always(function(){ $wrap.find('.overlay-loader').remove(); });
                    });
                });

            })(jQuery);
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views\admin\hairstyle\index.blade.php ENDPATH**/ ?>
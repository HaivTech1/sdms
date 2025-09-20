<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <?php $__env->startSection('title', application('name')." | Curriculum Page"); ?>

     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Curriculum</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="container">
            <div class="row mb-3">
                    <div class="col-md-6">
                            <h3>My Curriculums</h3>
                    </div>
                    <div class="col-md-6 text-end">
                            <button id="openCreate" class="btn btn-primary">Create Curriculum</button>
                    </div>
            </div>

            <div class="row mb-2">
                    <div class="col-md-4">
                            <input id="search" class="form-control" placeholder="Search by name" />
                    </div>
            </div>

                <div id="curriculum-wrap" data-list-url="<?php echo e(route('teacher.curriculum')); ?>" data-grade-subjects='<?php echo json_encode($gradeSubjectsMap ?? [], 15, 512) ?>'>
                    
                    <?php echo $__env->make('teacher.curriculum._list', ['curriculums' => $curriculums], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
    </div>

    <!-- Create modal -->
    <div class="modal fade" id="createCurriculum" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createForm" method="POST" action="<?php echo e(route('teacher.curriculum.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Create Curriculum</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" class="form-control" required />
                        </div>
                        <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <select name="grade_id" id="grade_id" class="form-control" required>
                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id); ?>"><?php echo e($grade->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <select name="subject_id" class="form-control" id="subject_id" required>
                                    
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Period</label>
                            <select name="period_id" class="form-control" required>
                                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($period->id); ?>"><?php echo e($period->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Term</label>
                            <select name="term_id" class="form-control" required>
                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($term->id); ?>"><?php echo e($term->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- Edit modal (will be populated via AJAX) -->
        <div class="modal fade" id="editCurriculumModal" tabindex="-1">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-body" id="editCurriculumBody">
                                        <!-- edit form will be injected here -->
                                </div>
                        </div>
                </div>
        </div>

    <?php $__env->startSection('scripts'); ?>
    <script>
            (function($){
                const $wrap = $('#curriculum-wrap');
                const listUrl = $wrap.data('list-url');

                try {
                    const gsData = $wrap.data('grade-subjects');
                    if (typeof gsData === 'string') {
                        window.gradeSubjects = JSON.parse(gsData || '{}');
                    } else {
                        // already an object (jQuery may auto-parse JSON)
                        window.gradeSubjects = gsData || {};
                    }
                } catch (e) {
                    window.gradeSubjects = {};
                }

                // Helper to populate a target select for a given gradeId
                function populateSubjectsFor(gradeId, targetSelector){
                    const $select = $(targetSelector);
                    $select.empty();
                    const subs = (window.gradeSubjects && window.gradeSubjects[gradeId]) || [];
                    console.log(subs)
                    if (subs.length === 0) {
                        $select.append($('<option>').text('No subjects for selected grade').attr('value',''));
                        $select.prop('disabled', true);
                    } else {
                        $select.prop('disabled', false);
                        $select.append($('<option>').text('-- Select subject --').attr('value',''));
                        subs.forEach(function(s){ $select.append($('<option>').attr('value', s.id).text(s.title)); });
                    }
                }

                // When grade changes in create modal, load subjects
                $(document).on('change', '#grade_id', function(){
                    populateSubjectsFor($(this).val(), '#subject_id');
                });

                // Open create modal: populate subjects for the selected grade
                $('#openCreate').on('click', function(){
                    const firstGrade = $('#grade_id').val();
                    populateSubjectsFor(firstGrade, '#subject_id');
                    $('#createCurriculum').modal('show');
                });

                function loadPage(url, params = {}){
                    params._token = '<?php echo e(csrf_token()); ?>';
                    // show overlay loader
                    try {
                        $wrap.css('position', 'relative');
                        // $wrap.append($('<div class="overlay-loader">').css({position: 'absolute', top:0, left:0, width:'100%', height:'100%', background:'rgba(255,255,255,0.6)', 'z-index': 9999}).append(divLoader()));
                    } catch (e) { /* ignore if divLoader not available */ }

                    $.ajax({ url: url, data: params, method: 'GET' })
                        .done(function(html){
                            // Expect the server to return the partial HTML for the list
                            $wrap.html(html);
                        })
                        .fail(function(xhr){
                            let msg = 'Failed to load data';
                            if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                            Swal.fire('Error', msg, 'error');
                        })
                        .always(function(){
                            $wrap.find('.overlay-loader').remove();
                        });
                }

                // Search key
                $('#search').on('keyup', function(e){
                    const q = $(this).val();
                    // load fresh results (page param removed)
                    loadPage(listUrl + '?search=' + encodeURIComponent(q));
                });

                // Submit create form via AJAX with spinner + SweetAlert
                $('#createForm').on('submit', function(e){
                    e.preventDefault();
                    const $form = $(this);
                    const $btn = $form.find('button[type=submit]');
                    toggleAble($btn, true, 'Creating...');
                    const data = $form.serialize();
                    $.post($form.attr('action'), data)
                        .done(function(){
                            toggleAble($btn, false);
                            $('#createCurriculum').modal('hide');
                            Swal.fire('Created!', 'Curriculum created', 'success');
                            loadPage(listUrl);
                        })
                        .fail(function(xhr){
                            toggleAble($btn, false);
                            // handle validation errors if present
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                const errs = xhr.responseJSON.errors;
                                let html = Object.values(errs).flat().join('<br/>');
                                Swal.fire({ title: 'Validation error', html: html, icon: 'error' });
                            } else {
                                let msg = 'Failed to create curriculum';
                                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                                Swal.fire('Error', msg, 'error');
                            }
                        });
                });

                // Delegate pagination/link clicks inside the wrap
                $wrap.on('click', '.pagination a', function(e){
                    e.preventDefault();
                    const href = $(this).attr('href');
                    loadPage(href);
                });

                // Delegate delete button clicks
                $wrap.on('click', '.delete-curriculum', function(e){
                    e.preventDefault();
                    const $btn = $(this);
                    const url = $btn.data('url');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This will permanently delete the curriculum',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#502179',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            toggleAble($btn, true, 'Deleting...');
                            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                            // some servers don't accept DELETE verbs via AJAX; send as POST with _method override
                            $.ajax({ url: url, method: 'POST', data: { _method: 'DELETE' } })
                                .done(function(resp){
                                    toggleAble($btn, false);
                                    Swal.fire('Deleted!', resp.message || 'Curriculum deleted', 'success');
                                    loadPage(listUrl);
                                })
                                .fail(function(xhr){
                                    toggleAble($btn, false);
                                    let msg = 'Failed to delete';
                                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                                    Swal.fire('Error', msg, 'error');
                                });
                        }
                    });
                });

                // Delegate edit button clicks - load form into modal
                $wrap.on('click', '.edit-curriculum', function(e){
                    e.preventDefault();
                    const $btn = $(this);
                    const url = $btn.data('url');
                    // fetch edit form
                    $.get(url, {}, function(html){
                        $('#editCurriculumBody').html(html);
                        $('#editCurriculumModal').modal('show');

                        // Attach submit handler
                        $('#editCurriculumForm').on('submit', function(e){
                            e.preventDefault();
                            const $form = $(this);
                            const $submit = $form.find('button[type=submit]');
                            toggleAble($submit, true, 'Saving...');
                            const data = $form.serialize();
                            $.post($form.attr('action'), data)
                                .done(function(resp){
                                    toggleAble($submit, false);
                                    $('#editCurriculumModal').modal('hide');
                                    Swal.fire('Updated!', resp.message || 'Curriculum updated', 'success');
                                    loadPage(listUrl);
                                })
                                .fail(function(xhr){
                                    toggleAble($submit, false);
                                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                                        let html = Object.values(xhr.responseJSON.errors).flat().join('<br/>');
                                        Swal.fire({ title: 'Validation error', html: html, icon: 'error' });
                                    } else {
                                        let msg = 'Failed to update';
                                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                                        Swal.fire('Error', msg, 'error');
                                    }
                                });
                        });
                    }).fail(function(xhr){
                        // Surface server message when possible
                        let msg = 'Failed to load edit form';
                        try {
                            if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                            else if (xhr && xhr.responseText) {
                                // try to extract simple text from HTML response
                                const m = /<title>(.*?)<\/title>/i.exec(xhr.responseText);
                                if (m && m[1]) msg = m[1];
                            }
                        } catch(e) { /* ignore */ }
                        Swal.fire('Error', msg, 'error');
                    });
                });

                // Initial behaviour: nothing to do; server-rendered initial list included
            })(jQuery);
    </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/teacher/curriculum/index.blade.php ENDPATH**/ ?>
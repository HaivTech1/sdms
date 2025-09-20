<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> <h2>Saved Questions for Topic: <?php echo e($topic->title); ?></h2> <?php $__env->endSlot(); ?>

    <div class="container">
        <div class="mb-3">
            <a href="<?php echo e(route('teacher.curriculum.topics', $curriculum)); ?>" class="btn btn-secondary">Back to topics</a>
        </div>

        <table class="table table-striped" id="savedQuestionsTable">
            <thead><tr><th>ID</th><th>Question</th><th>Options</th><th>Difficulty</th><th>Bloom</th><th>Actions</th></tr></thead>
            <tbody id="savedQuestionsBody">
                <?php echo $__env->make('teacher.curriculum._questions_list', ['questions' => $questions], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </tbody>
        </table>
    </div>

    <?php $__env->startSection('scripts'); ?>
    <script>
        (function($){
            $('#savedQuestionsBody').on('click', '.delete-saved-question', function(){
                const url = $(this).data('url');
                const $btn = $(this);
                Swal.fire({ title: 'Are you sure?', text: 'This will delete the question', icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes, delete' }).then((res)=>{
                    if (!res.isConfirmed) return;
                    toggleAble($btn, true, 'Deleting...');
                    $.ajax({ url: url, method: 'DELETE', data: { _token: '<?php echo e(csrf_token()); ?>' }})
                        .done(function(){ toggleAble($btn, false); Swal.fire('Deleted','Question removed','success'); location.reload(); })
                        .fail(function(){ toggleAble($btn, false); Swal.fire('Error','Failed to delete','error'); });
                });
            });

            // wire edit modal
            $('body').append(`
                <div class="modal fade" id="editSavedQuestionModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Edit Question</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                            <div class="modal-body">
                                <form id="editSavedQuestionForm">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="hidden" name="_question_id" id="_question_id">
                                    <div class="mb-2">
                                        <label>Question</label>
                                        <input class="form-control" name="question" id="edit_q_question">
                                    </div>
                                    <div id="edit_q_options">
                                    </div>
                                    <div class="mb-2 text-end">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            $('#savedQuestionsBody').on('click', '.edit-saved-question', function(e){
                e.preventDefault();
                const $tr = $(this).closest('tr');
                const data = $tr.data('question');
                if (!data) return Swal.fire('Error','Cannot load question','error');

                $('#_question_id').val(data.id);
                $('#edit_q_question').val(data.question);
                const $opts = $('#edit_q_options').empty();
                data.options.forEach(function(opt, i){
                    $opts.append(`<div class="mb-1"><label>Option ${i+1}</label><input class="form-control" name="options[${i}]" value="${opt}"></div>`);
                });

                // show modal
                $('#editSavedQuestionModal').modal('show');

                $('#editSavedQuestionForm').off('submit').on('submit', function(ev){
                    ev.preventDefault();
                    const qid = $('#_question_id').val();
                    const payload = $(this).serializeArray();
                    const url = '<?php echo e(url("/teacher/curriculum")); ?>/' + '<?php echo e($curriculum->id); ?>' + '/questions/' + qid; // route expects /curriculum/{curriculum}/questions/{question}
                    const dataToSend = {};
                    payload.forEach(function(p){ dataToSend[p.name] = p.value; });
                    dataToSend._token = '<?php echo e(csrf_token()); ?>';

                    $.ajax({ url: url, method: 'PUT', data: dataToSend })
                        .done(function(){ Swal.fire('Saved','Question updated','success'); location.reload(); })
                        .fail(function(){ Swal.fire('Error','Failed to update','error'); });
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
<?php /**PATH C:\laragon\www\primary\resources\views\teacher\curriculum\questions.blade.php ENDPATH**/ ?>
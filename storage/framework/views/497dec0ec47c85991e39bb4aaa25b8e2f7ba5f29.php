<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Grade</th>
            <th>Subject</th>
            <th>Period</th>
            <th>Term</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $curriculums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curriculum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($curriculum->name); ?></td>
                <td><?php echo e(optional($curriculum->grade)->title); ?></td>
                <td><?php echo e(optional($curriculum->subject)->title); ?></td>
                <td><?php echo e(optional($curriculum->period)->title); ?></td>
                <td><?php echo e(optional($curriculum->term)->title); ?></td>
                <td>
                    <?php $me = auth()->user(); ?>
                    <?php if($me->isAdmin() || $curriculum->isAuthoredBy($me)): ?>
                        <button type="button" class="btn btn-sm btn-primary edit-curriculum" data-url="<?php echo e(route('teacher.curriculum.edit', $curriculum)); ?>"><i class="bx bx-edit"></i></button>
                        <button class="btn btn-sm btn-danger delete-curriculum" type="button" data-url="<?php echo e(route('teacher.curriculum.destroy', $curriculum)); ?>"><i class="bx bx-trash"></i></button>
                    <?php endif; ?>
                    <a href="<?php echo e(route('teacher.curriculum.topics', $curriculum)); ?>" class="btn btn-sm btn-info">Topics</a>
                    <button class="btn btn-sm btn-primary download-questions" type="button" data-url="<?php echo e(route('teacher.curriculum.download_questions', $curriculum)); ?>">Download Questions</button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6">No curriculums found</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <?php echo $curriculums->links(); ?>

</div>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function(){
                // When user clicks the Download Questions button, show modal to choose mode
                $(document).on('click', '.download-questions', function(e){
                        e.preventDefault();
                        const url = $(this).data('url');
                        if (!url) return;
                        $('#downloadQuestionsModal').data('url', url).modal('show');
                });

                // When user confirms options, open the PDF in new tab
                $('#downloadQuestionsConfirm').on('click', function(e){
                        const modal = $('#downloadQuestionsModal');
                        const url = modal.data('url');
                        if (!url) return;

                        const mode = modal.find('input[name="dq_mode"]:checked').val();
                        const order = modal.find('select[name="dq_order"]').val();
                        const weekId = modal.find('select[name="dq_week"]').val();

                        const params = new URLSearchParams();
                        if (mode) params.set('mode', mode);
                        if (order) params.set('order', order);
                        if (weekId) params.set('week_id', weekId);

                        const finalUrl = url + (params.toString() ? ('?' + params.toString()) : '');
                        window.open(finalUrl, '_blank');
                        modal.modal('hide');
                });
        });
    </script>
<?php $__env->stopSection(); ?>

<!-- Download Questions Modal -->
<div class="modal fade" id="downloadQuestionsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download Questions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                        <label>Include</label>
                        <div>
                                <label class="mr-2"><input type="radio" name="dq_mode" value="questions" checked> Questions only</label>
                                <label class="mr-2"><input type="radio" name="dq_mode" value="questions_answers"> Questions + Answers</label>
                                <label class="mr-2"><input type="radio" name="dq_mode" value="answers"> Answers only</label>
                        </div>
                </div>
                <div class="form-group">
                        <label>Order</label>
                        <select name="dq_order" class="form-control">
                                <option value="sequential">Sequential</option>
                                <option value="random">Random</option>
                        </select>
                </div>
                <div class="form-group">
                        <label>Week (optional)</label>
                        <select name="dq_week" class="form-control">
                                <option value="">All weeks</option>
                                <?php $__currentLoopData = \App\Models\Week::where('term_id', term('id'))->where('period_id', period('id'))->orderBy('start_date')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($w->id); ?>"><?php echo e(optional($w->start_date)->format('j M Y')); ?> - <?php echo e(optional($w->end_date)->format('j M Y')); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="downloadQuestionsConfirm" class="btn btn-primary">Download</button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\primary\resources\views/teacher/curriculum/_list.blade.php ENDPATH**/ ?>


<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Event Notification Batch</h3>
    <p>Batch ID: <strong id="batch-id"><?php echo e($batchId); ?></strong></p>

    <div id="batch-status">
        <p>Status: <span id="status">Loading...</span></p>
        <p>Total jobs: <span id="total">-</span></p>
        <p>Processed: <span id="processed">-</span></p>
        <p>Pending: <span id="pending">-</span></p>
        <p>Failed: <span id="failed">-</span></p>
    </div>

    <div id="actions">
        <button id="refresh" class="btn btn-primary">Refresh</button>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script>
    (function(){
        const batchId = document.getElementById('batch-id').innerText;
        const url = '/admin/events/batch-info/' + batchId;

        async function fetchBatch(){
            try {
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const json = await res.json();
                if(!json.status) {
                    document.getElementById('status').innerText = 'Not found';
                    return;
                }
                const b = json.batch;
                document.getElementById('total').innerText = b.total_jobs;
                document.getElementById('processed').innerText = b.processed;
                document.getElementById('pending').innerText = b.pending;
                document.getElementById('failed').innerText = b.failed;
                document.getElementById('status').innerText = b.finished ? 'Finished' : 'Running';
            } catch (e) {
                document.getElementById('status').innerText = 'Error';
            }
        }

        document.getElementById('refresh').addEventListener('click', fetchBatch);
        fetchBatch();
        setInterval(fetchBatch, 5000);
    })();
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\event\batch.blade.php ENDPATH**/ ?>
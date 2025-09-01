@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Event Notification Batch</h3>
    <p>Batch ID: <strong id="batch-id">{{ $batchId }}</strong></p>

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

@section('scripts')
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
@endsection

@endsection


$(document).ready(function () {
    // Allow pages to opt-out of automatic DataTable initialization by setting
    // window.DISABLE_DATATABLES = true before this script runs.
    if (window.DISABLE_DATATABLES) return;

    if (document.querySelector('#datatable')) {
        try {
            $('#datatable').DataTable();
        } catch (e) {
            console.error('Failed to init #datatable DataTable', e);
        }
    }

    if (document.querySelector('#datatable-buttons')) {
        try {
            const dt = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });
            if (dt && dt.buttons) {
                dt.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            }
            $('.dataTables_length select').addClass('form-select form-select-sm');
        } catch (e) {
            console.error('Failed to init #datatable-buttons DataTable', e);
        }
    }
});
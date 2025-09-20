<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name') . " | Attendance Page"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Attendance</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Daily Attendance</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="mb-3 row">
                            <div class="col-md-3">
                                <input type="date" id="filterDate" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <select id="filterType" class="form-control">
                                    <option value="">All</option>
                                    <option value="student">Student</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button id="btnFilter" class="btn btn-primary">Filter</button>
                                <button id="btnClear" class="btn btn-secondary ml-2">Clear</button>
                            </div>
                            <div class="col-md-3 text-right">
                                <!-- Export modal trigger -->
                                <button type="button" class="btn btn-success exportModal">Export & Email PDF</button>
                                 
                                <!-- Export Modal -->
                                <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exportModalLabel">Export Attendance</h5>
                                                <button type="button" class="close closeModal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="exportModalForm">
                                                    <div class="form-group">
                                                        <label for="modalExportEmail">Recipient email</label>
                                                        <input type="email" id="modalExportEmail" class="form-control" placeholder="recipient@example.com" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="modalExportDate">Date (optional)</label>
                                                        <input type="date" id="modalExportDate" class="form-control" />
                                                        <small class="form-text text-muted">Leave empty to export today's attendance.</small>
                                                    </div>
                                                <div class="form-group">
                                                    <label for="modalExportUser">Student (optional)</label>
                                                    <select id="modalExportUser" class="form-control select2">
                                                        <option value="">All / Select specific</option>
                                                    </select>
                                                    <small class="form-text text-muted">Select a student to export only their attendance.</small>
                                                </div>
                                                    <div class="form-group">
                                                        <label for="modalExportType">Type</label>
                                                        <select id="modalExportType" class="form-control">
                                                            <option value="">All</option>
                                                            <option value="student">Student</option>
                                                            <option value="staff">Staff</option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary closeModal">Close</button>
                                                <button id="btnModalExport" type="button" class="btn btn-primary">Send Export</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>

                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="attendanceTable"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Reg No</th>
                                            <th>Grade</th>
                                            <th>Type</th>
                                            <th>AM</th>
                                            <th>PM</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody id="attendanceBody">
                                        <tr>
                                            <td colspan="8" class="text-center">Loading...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <div>
                                <select id="perPage" class="form-control" style="width:100px; display:inline-block">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="50" selected>50</option>
                                </select>
                                <span id="totalCount" class="ml-2"></span>
                            </div>
                            <nav>
                                <ul id="pagination" class="pagination"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            (function () {
                const apiBase = '/attendance';
                let currentPage = 1;
                let lastRows = [];

                const escapeHtml = (unsafe) => {
                    if (!unsafe && unsafe !== 0) return '';
                    return String(unsafe)
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#039;');
                };

                const renderError = (msg) => {
                    const body = document.getElementById('attendanceBody');
                    body.innerHTML = '<tr><td colspan="8" class="text-center text-danger">' + msg + '</td></tr>';
                };

                const renderRows = (rows) => {
                    lastRows = rows || [];
                    const body = document.getElementById('attendanceBody');
                    body.innerHTML = '';
                    if (!rows || !rows.length) {
                        body.innerHTML = '<tr><td colspan="8" class="text-center">No records found</td></tr>';
                        return;
                    }

                    rows.forEach(r => {
                        const person = r.person || r.information || {};
                        const name = person.name || r.name || '-';
                        const reg_no = person.reg_no || r.reg_no || '-';

                        let grade = '-';
                        if (person.grade) {
                            if (typeof person.grade === 'object') {
                                grade = person.grade.name || person.grade.grade || JSON.stringify(person.grade);
                            } else {
                                grade = person.grade;
                            }
                        }

                        const amPresent = !!r.am_status;
                        const pmPresent = !!r.pm_status;

                        const amTimeLocal = r.am_check_in_at ? (new Date(r.am_check_in_at)).toLocaleString() : '';
                        const pmTimeLocal = r.pm_check_out_at ? (new Date(r.pm_check_out_at)).toLocaleString() : '';

                        const amTitle = r.am_check_in_at ? escapeHtml(r.am_check_in_at) : '';
                        const pmTitle = r.pm_check_out_at ? escapeHtml(r.pm_check_out_at) : '';

                        const amDisplay = amPresent ? ('<span title="' + amTitle + '">' + (amTimeLocal ? ' (' + escapeHtml(amTimeLocal) + ')' : '') + '</span>') : 'Absent';
                        const pmDisplay = pmPresent ? ('<span title="' + pmTitle + '">' + (pmTimeLocal ? ' (' + escapeHtml(pmTimeLocal) + ')' : '') + '</span>') : 'Absent';

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${escapeHtml(name)}</td>
                            <td>${escapeHtml(reg_no)}</td>
                            <td>${escapeHtml(grade)}</td>
                            <td>${escapeHtml(r.type || '-')}</td>
                            <td>${amDisplay}</td>
                            <td>${pmDisplay}</td>
                            <td>${escapeHtml(r.note || '')}</td>
                        `;
                        body.appendChild(tr);
                    });
                };

                const renderPagination = (meta) => {
                    const totalCountEl = document.getElementById('totalCount');
                    if (totalCountEl) totalCountEl.textContent = 'Total: ' + (meta.total || 0);
                    currentPage = meta.current_page || 1;
                    const lastPage = meta.last_page || 1;
                    const pagination = document.getElementById('pagination');
                    pagination.innerHTML = '';

                    const makePageItem = (p, label = null, active = false, disabled = false) => {
                        const li = document.createElement('li');
                        li.className = 'page-item' + (active ? ' active' : '') + (disabled ? ' disabled' : '');
                        const a = document.createElement('a');
                        a.className = 'page-link';
                        a.href = '#';
                        a.textContent = label || p;
                        a.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (!disabled) fetchData(p);
                        });
                        li.appendChild(a);
                        return li;
                    };

                    pagination.appendChild(makePageItem(1, '<<', false, currentPage === 1));
                    pagination.appendChild(makePageItem(Math.max(1, currentPage - 1), 'Prev', false, currentPage === 1));
                    const start = Math.max(1, currentPage - 2);
                    const end = Math.min(lastPage, currentPage + 2);
                    for (let p = start; p <= end; p++) pagination.appendChild(makePageItem(p, null, p === currentPage));
                    pagination.appendChild(makePageItem(Math.min(lastPage, currentPage + 1), 'Next', false, currentPage === lastPage));
                    pagination.appendChild(makePageItem(lastPage, '>>', false, currentPage === lastPage));
                };

                const showLoading = (btn) => {
                    if (typeof $ === 'function' && typeof $.LoadingOverlay === 'function') {
                        $('body').LoadingOverlay('show');
                    }
                    if (btn) {
                        btn.dataset.oldHtml = btn.innerHTML;
                        btn.disabled = true;
                        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading';
                    }
                };

                const hideLoading = (btn) => {
                    if (typeof $ === 'function' && typeof $.LoadingOverlay === 'function') {
                        $('body').LoadingOverlay('hide');
                    }
                    if (btn) {
                        btn.disabled = false;
                        if (btn.dataset.oldHtml) {
                            btn.innerHTML = btn.dataset.oldHtml;
                            delete btn.dataset.oldHtml;
                        }
                    }
                };

                const fetchData = (page = 1) => {
                    const date = document.getElementById('filterDate').value;
                    const type = document.getElementById('filterType').value;
                    const perPage = document.getElementById('perPage') ? document.getElementById('perPage').value : 50;
                    const data = { page, per_page: perPage };
                    if (date) data.date = date;
                    if (type) data.type = type;

                    return $.ajax({
                        url: apiBase + '/daily/all',
                        method: 'GET',
                        data: data,
                        dataType: 'json'
                    }).done(function (json) {
                        if (!json) return renderError('Empty response');
                        if (!json.status && typeof json.status !== 'undefined') return renderError('Error fetching data');
                        const rows = json.attendance || json.records || [];
                        renderRows(rows);
                        renderPagination(json.meta || {});
                    }).fail(function (xhr) {
                        console.error('Attendance AJAX failed', xhr.responseText || xhr.statusText);
                        let message = 'Fetch error';
                        try { const body = JSON.parse(xhr.responseText || '{}'); if (body.message) message = body.message; } catch(e) {}
                        renderError('Fetch error: ' + message);
                    });
                };

                // DOM elements
                const btnFilter = document.getElementById('btnFilter');
                const btnClear = document.getElementById('btnClear');
                const btnModalExport = document.getElementById('btnModalExport');
                const modalExportEmail = document.getElementById('modalExportEmail');
                const modalExportDate = document.getElementById('modalExportDate');
                const modalExportType = document.getElementById('modalExportType');
                const modalExportUser = document.getElementById('modalExportUser');

                btnFilter.addEventListener('click', (e) => {
                    e.preventDefault();
                    showLoading(btnFilter);
                    fetchData(1).always(() => hideLoading(btnFilter));
                });

                btnClear.addEventListener('click', (e) => {
                    e.preventDefault();
                    const dateEl = document.getElementById('filterDate');
                    const typeEl = document.getElementById('filterType');
                    const perPageEl = document.getElementById('perPage');
                    if (dateEl) dateEl.value = '';
                    if (typeEl) typeEl.value = '';
                    if (perPageEl) perPageEl.value = '50';
                    fetchData(1);
                });

                document.getElementById('filterDate').addEventListener('change', () => fetchData(1));
                document.getElementById('filterType').addEventListener('change', () => fetchData(1));
                const perPageEl = document.getElementById('perPage');
                if (perPageEl) perPageEl.addEventListener('change', () => fetchData(1));

                // Populate modal select when opening and prefill date
                $('#exportModal').on('show.bs.modal', function () {
                    // populate users
                    if (modalExportUser) {
                        modalExportUser.innerHTML = '<option value="">All / Select specific</option>';
                        lastRows.forEach(r => {
                            const info = r.person || r.information || {};
                            const id = info.id || r.user_id || r.id;
                            const name = info.name || (info.reg_no ? (info.reg_no) : (r.name || '-'));
                            if (id) {
                                const opt = document.createElement('option');
                                opt.value = id;
                                opt.textContent = name + (info.reg_no ? (' (' + info.reg_no + ')') : '');
                                modalExportUser.appendChild(opt);
                            }
                        });
                    }
                    if (modalExportDate) modalExportDate.value = document.getElementById('filterDate').value || '';
                    // Prefill recipient email with authenticated user's email if available and field is empty
                    if (modalExportEmail && !modalExportEmail.value) modalExportEmail.value = <?php echo json_encode(auth()->user()->email ?? ''); ?>;

                    // Initialize select2 on the student select if available
                    if (typeof $ === 'function' && $.fn && $.fn.select2) {
                        $(modalExportUser).select2({
                            dropdownParent: $('#exportModal'),
                            width: '100%',
                            placeholder: 'Search or select a student',
                            allowClear: true,
                            minimumInputLength: 1,
                            ajax: {
                                url: '/search-students',
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return { q: params.term, limit: 30 };
                                },
                                processResults: function (data) {
                                    return { results: data.results || [] };
                                },
                                cache: true
                            }
                        });
                    }
                });

                // Destroy Select2 when modal hides to avoid duplicate instances
                $('#exportModal').on('hidden.bs.modal', function () {
                    if (typeof $ === 'function' && $.fn && $.fn.select2) {
                        try { $(modalExportUser).select2('destroy'); } catch (e) { /* ignore */ }
                    }
                });

                // modal export handler
                btnModalExport.addEventListener('click', function () {
                    const email = modalExportEmail.value;
                    const date = modalExportDate.value;
                    const type = modalExportType.value;
                    const userId = modalExportUser ? (modalExportUser.value || null) : null;
                    if (!email) { toastr.error('Please provide a recipient email'); return; }

                    const payload = { email, date, type };
                    if (userId) payload.user_id = userId;

                    showLoading(btnModalExport);
                    $.ajax({
                        url: apiBase + '/daily/export',
                        method: 'POST',
                        data: JSON.stringify(payload),
                        contentType: 'application/json',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
                    }).done(function (j) {
                        if (j.status) { toastr.success('PDF queued for emailing'); $('#exportModal').modal('hide'); }
                        else { toastr.error('Error: ' + (j.errors || j.message || 'Unknown')); }
                    }).fail(function (xhr) { toastr.error('Request failed'); console.error('Export AJAX failed', xhr.responseText); })
                    .always(function () { hideLoading(btnModalExport); });
                });

                // initial load
                fetchData();
            })();

            $(document).ready(function () {
                // Initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();

                // Handle export modal show
                $('.exportModal').on('click', function () {
                    const userId = $(this).data('user-id');
                    $('#modalExportUser').val(userId);
                    $("#exportModal").modal('show');
                });

                $(".closeModal").on('click', function () {
                    $("#exportModal").modal('hide');
                });
            });
        </script>
    <?php $__env->stopSection(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views\admin\attendance\index.blade.php ENDPATH**/ ?>
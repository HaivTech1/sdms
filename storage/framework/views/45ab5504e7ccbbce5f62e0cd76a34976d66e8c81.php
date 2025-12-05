
<script>
$(function () {
    const fetchUrl = "<?php echo e(route('student.list.data')); ?>";
    const $table = $('#students-table');
    const $tableBody = $('#students-table-body');
    const $totalCounter = $('#total-students');
    const $rangeText = $('#students-range');
    const $pagination = $('#students-pagination');
    const $selectAll = $('#select-all-students');
    const studentsCache = new Map();
    const $syncSubjectsBtn = $('#sync-class-subjects');

    const routes = {
        profile: $table.data('profile-url-template'),
        edit: $table.data('edit-url-template'),
        passportUpload: $table.data('passport-upload-url'),
        qr: $table.data('generate-qr-url-template'),
    };

    const state = {
        search: '',
        gender: 'all',
        grade: 'all',
        status: 'all',
        orderBy: 'created_at',
        sortDirection: 'desc',
        currentPage: 1,
        perPage: 15,
    };

    let searchTimer = null;

    function getSelectedStudentIds() {
        return $tableBody.find('.student-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
    }

    function updateBulkActionsVisibility() {
        const selectedCount = $tableBody.find('.student-checkbox:checked').length;
        if (selectedCount > 0) {
            $syncSubjectsBtn.removeClass('d-none');
        } else {
            $syncSubjectsBtn.addClass('d-none');
        }
    }

    function bulkSyncSubjects(studentIds) {
        $syncSubjectsBtn.prop('disabled', true).html('<i class="bx bx-loader bx-spin me-2"></i>Processing...');
        
        $.ajax({
            url: '/student/sync-subjects-multiple',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                student_ids: studentIds
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message || 'Class subjects synced successfully for selected students',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'Failed to sync subjects';
                Swal.fire('Error', errorMessage, 'error');
                $syncSubjectsBtn.prop('disabled', false).html('Sync Subjects');
            }
        });
    }

    bindEvents();
    fetchStudents();

    function bindEvents() {
        $('#search-students').on('input', function () {
            clearTimeout(searchTimer);
            state.search = $(this).val();
            state.currentPage = 1;
            searchTimer = setTimeout(fetchStudents, 300);
        });

        $('#filter-gender').on('change', function () {
            state.gender = $(this).val();
            state.currentPage = 1;
            fetchStudents();
        });

        $('#filter-grade').on('change', function () {
            state.grade = $(this).val();
            state.currentPage = 1;
            fetchStudents();
        });

        $('#filter-status').on('change', function () {
            state.status = $(this).val();
            state.currentPage = 1;
            fetchStudents();
        });

        $('#filter-order-by').on('change', function () {
            state.orderBy = $(this).val();
            state.currentPage = 1;
            fetchStudents();
        });

        $('#filter-sort-direction').on('change', function () {
            state.sortDirection = $(this).val();
            state.currentPage = 1;
            fetchStudents();
        });

        $('#filters-apply').on('click', function () {
            state.currentPage = 1;
            fetchStudents();
        });

        $('#filters-reset').on('click', function () {
            $('#filter-gender').val('all');
            $('#filter-grade').val('all');
            $('#filter-status').val('all');
            $('#filter-order-by').val('created_at');
            $('#filter-sort-direction').val('desc');
            $('#search-students').val('');

            Object.assign(state, {
                search: '',
                gender: 'all',
                grade: 'all',
                status: 'all',
                orderBy: 'created_at',
                sortDirection: 'desc',
                currentPage: 1,
            });

            fetchStudents();
        });

        $pagination.on('click', 'a.page-link', function (event) {
            event.preventDefault();
            const page = Number($(this).data('page'));
            if (!page || page === state.currentPage) {
                return;
            }
            state.currentPage = page;
            fetchStudents();
        });

        $selectAll.on('change', function () {
            const isChecked = $(this).is(':checked');
            $tableBody.find('.student-checkbox').prop('checked', isChecked);
            updateBulkActionsVisibility();
        });

        $tableBody.on('change', '.student-checkbox', function () {
            const total = $tableBody.find('.student-checkbox').length;
            const selected = $tableBody.find('.student-checkbox:checked').length;
            $selectAll.prop('checked', total && total === selected);
            $selectAll.prop('indeterminate', selected > 0 && selected < total);
            updateBulkActionsVisibility();
        });

        // Bulk sync subjects button
        $syncSubjectsBtn.on('click', function () {
            const selectedIds = getSelectedStudentIds();
            if (selectedIds.length === 0) {
                Swal.fire('No Selection', 'Please select at least one student', 'warning');
                return;
            }

            Swal.fire({
                title: `Sync Subjects for ${selectedIds.length} Student(s)?`,
                text: `Are you sure you want to sync class subjects for ${selectedIds.length} selected student(s)?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Sync Subjects!'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkSyncSubjects(selectedIds);
                }
            });
        });

        $tableBody.on('click', '.upload-passport', function () {
            const studentId = $(this).data('student');
            openPassportModal(studentId);
        });

        $('#upload').on('submit', function (event) {
            event.preventDefault();
            submitPassport(new FormData(this));
        });

        $('#image').on('change', previewPassport);

        $('#refresh-table-btn').on('click', function() {
            fetchStudents();
            $('#subjectManagementModal').modal('hide');
        });

        $tableBody.on('click', '.manage-subjects', function () {
            const studentId = $(this).data('student');
            const student = studentsCache.get(studentId);
            if (student) {
                openSubjectManagementModal(student);
            }
        });

        $tableBody.on('click', '.assign-subjects, .assign-more-subjects', function () {
            const studentId = $(this).data('student');
            assignSubject(studentId);
        });

        $tableBody.on('click', '.delete-subject', function () {
            const studentId = $(this).data('student-id');
            const subjectId = $(this).data('subject-id');
            const $button = $(this);
            
            if (!confirm('Are you sure you want to remove this subject?')) {
                return;
            }
            
            $button.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i>');
            
            $.ajax({
                url: `/student/${studentId}/subject/${subjectId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            }).done(function (response) {
                if (response.status) {
                    showModalAlert('.table-container', 'success', 'Subject removed successfully.');
                    fetchStudents(); // Refresh the table
                } else {
                    showModalAlert('.table-container', 'danger', response.message || 'Unable to remove subject.');
                }
            }).fail(function () {
                showModalAlert('.table-container', 'danger', 'Failed to remove subject.');
            }).always(function () {
                $button.prop('disabled', false).html('<i class="bx bx-trash"></i>');
            });
        });

        $tableBody.on('click', '.show-qr', function () {
            const studentId = $(this).data('student');
            const student = studentsCache.get(studentId);
            if (student) {
                openQrModal(student, false);
            }
        });

        $tableBody.on('click', '.generate-qr', function () {
            const studentId = $(this).data('student');
            const student = studentsCache.get(studentId);
            if (student) {
                openQrModal(student, true);
            }
        });

        $('#copy-qr-url').on('click', function () {
            const url = $('#qr-url').text();
            if (!url) {
                return;
            }
            navigator.clipboard?.writeText(url).then(function () {
                showModalAlert('#qr-modal-feedback', 'success', 'QR code link copied to clipboard.');
            }).catch(function () {
                showModalAlert('#qr-modal-feedback', 'danger', 'Unable to copy the link.');
            });
        });

        $('#download-qr').on('click', function () {
            const canvas = document.querySelector('#qr-code-display canvas');
            if (!canvas) {
                return;
            }
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'student-qr.png';
            link.click();
        });

        $('#print-qr').on('click', function () {
            const canvas = document.querySelector('#qr-code-display canvas');
            if (!canvas) {
                return;
            }
            const image = canvas.toDataURL('image/png');
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`<img src="${image}" style="width:100%;" />`);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        });

        // Send credentials handler
        $tableBody.on('click', '.send-credentials', function () {
            const studentId = $(this).data('student-id');
            const $button = $(this);
            
            Swal.fire({
                title: 'Send Login Credentials?',
                text: 'Are you sure you want to send login credentials to this student\'s parents?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $button.prop('disabled', true).html('<i class="bx bx-loader bx-spin me-2"></i>Sending...');
                    
                    $.ajax({
                        url: `/student/send-credentials/${studentId}`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                    }).done(function (response) {
                        if (response.status) {
                            Swal.fire('Sent!', response.message || 'Credentials sent successfully.', 'success');
                        } else {
                            Swal.fire('Error!', response.message || 'Unable to send credentials.', 'error');
                        }
                    }).fail(function () {
                        Swal.fire('Error!', 'Failed to send credentials.', 'error');
                    }).always(function () {
                        $button.prop('disabled', false).html('<i class="bx bx-envelope text-primary me-2"></i> Send Credentials');
                    });
                }
            });
        });

        // Toggle status handler
        $tableBody.on('click', '.toggle-status', function () {
            const studentId = $(this).data('student-id');
            const currentStatus = $(this).data('current-status');
            const $button = $(this);
            const action = currentStatus ? 'deactivate' : 'activate';
            const actionTitle = currentStatus ? 'Deactivate Student?' : 'Activate Student?';
            const actionText = `Are you sure you want to ${action} this student?`;
            
            Swal.fire({
                title: actionTitle,
                text: actionText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: currentStatus ? '#d33' : '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${action}!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $button.prop('disabled', true).html('<i class="bx bx-loader bx-spin me-2"></i>Processing...');
                    
                    $.ajax({
                        url: `/student/toggle-status/${studentId}`,
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                    }).done(function (response) {
                        if (response.status) {
                            Swal.fire('Updated!', response.message || 'Student status updated successfully.', 'success');
                            fetchStudents(); // Refresh the table to show updated status
                        } else {
                            Swal.fire('Error!', response.message || 'Unable to update student status.', 'error');
                        }
                    }).fail(function () {
                        Swal.fire('Error!', 'Failed to update student status.', 'error');
                    }).always(function () {
                        $button.prop('disabled', false);
                    });
                }
            });
        });

        $tableBody.on('click', '.sync-subjects', function(){
            const studentId = $(this).data('student-id');
            const $button = $(this);

            Swal.fire({
                title: "Sync Class Subjects",
                text: "Are you sure you want to sync the student's class subjects?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    $button.prop('disabled', true).html('<i class="bx bx-loader bx-spin me-2"></i>Processing...');
                    
                    $.ajax({
                        url: `/student/sync-subjects/${studentId}`,
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                    }).done(function (response) {
                        if (response.status) {
                            Swal.fire('Synced!', response.message || 'Student subjects updated successfully.', 'success');
                            fetchStudents(); // Refresh the table to show updated status
                        } else {
                            Swal.fire('Error!', response.message || 'Unable to update student subjects.', 'error');
                        }
                    }).fail(function () {
                        Swal.fire('Error!', 'Failed to update student subjects.', 'error');
                    }).always(function () {
                        $button.prop('disabled', false).html('Sync Subjects');
                    });
                }
            });
        })
    }

    function fetchStudents() {
        showTableLoading();

        $.ajax({
            url: fetchUrl,
            method: 'GET',
            data: {
                search: state.search,
                gender: state.gender,
                grade: state.grade,
                status: state.status,
                order_by: state.orderBy,
                sort_direction: state.sortDirection,
                page: state.currentPage,
                per_page: state.perPage,
            },
        }).done(function (response) {
            const students = Array.isArray(response.data) ? response.data : [];
            const pagination = response.pagination || {};

            studentsCache.clear();
            students.forEach(function (student) {
                studentsCache.set(student.id, student);
            });

            renderStudents(students);
            renderPagination(pagination);
            updateCounters(pagination, students.length);
        }).fail(function () {
            $tableBody.html(`
                <tr>
                    <td colspan="10" class="text-center text-danger py-4">
                        Unable to load students at the moment.
                    </td>
                </tr>
            `);
        });
    }

    function showTableLoading() {
        $tableBody.html(`
            <tr>
                <td colspan="10" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-3 mb-0">Fetching students...</p>
                </td>
            </tr>
        `);
        $selectAll.prop('checked', false).prop('indeterminate', false);
    }

    function renderStudents(students) {
        if (!students.length) {
            $tableBody.html(`
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <i class="bx bx-search-alt display-4 text-muted"></i>
                        <p class="text-muted mt-3 mb-0">No students match the current filters.</p>
                    </td>
                </tr>
            `);
            return;
        }

        const startIndex = (state.currentPage - 1) * state.perPage;

        const rows = students.map(function (student, index) {
            const sequence = startIndex + index + 1;
            const roles = (student.roles || []).map(function (role) {
                return `<span class="badge bg-info-subtle text-info me-1">${escapeHtml(role)}</span>`;
            }).join('');

            const subjectCount = student.subjects ? student.subjects.length : 0;
            const hasSubjects = subjectCount > 0;

            const subjectsHtml = hasSubjects
                ? `<div class="subjects-preview">
                    ${student.subjects.slice(0, 3).map(function (subject) {
                        return `<span class="badge bg-light text-dark me-1">${escapeHtml(subject.title)}</span>`;
                    }).join('')}
                    ${subjectCount > 3 ? `<span class="badge bg-secondary">+${subjectCount - 3} more</span>` : ''}
                   </div>`
                : '<span class="text-muted">No subjects</span>';

            const statusBadge = student.status
                ? '<span class="badge bg-success-subtle text-success">Active</span>'
                : '<span class="badge bg-secondary-subtle text-muted">Inactive</span>';

            const profileUrl = routes.profile.replace('__STUDENT__', student.id);
            const editUrl = routes.edit.replace('__STUDENT__', student.id);

            const qrAction = student.qrcode_url
                ? `<button class="dropdown-item show-qr" type="button" data-student="${student.id}">
                        <i class="bx bx-qr text-primary me-2"></i> Show QR Code
                   </button>`
                : `<button class="dropdown-item generate-qr" type="button" data-student="${student.id}">
                        <i class="bx bx-qr-scan text-secondary me-2"></i> Generate QR Code
                   </button>`;

            return `
                <tr class="student-row" data-student="${student.id}">
                    <td>
                        <div class="form-check font-size-16">
                            <input class="form-check-input student-checkbox" type="checkbox" id="student-${student.id}" value="${student.id}">
                            <label class="form-check-label" for="student-${student.id}"></label>
                        </div>
                    </td>
                    <td><span class="fw-bold text-primary">${sequence}</span></td>
                    <td>
                        <div class="position-relative">
                            <img src="${student.photo}" alt="${escapeHtml(student.first_name)}" class="rounded-circle avatar-sm border-2 border-white shadow-sm upload-passport"
                                 data-student="${student.id}" style="cursor: pointer; transition: transform 0.2s;">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                <i class="bx bx-camera font-size-10"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <h6 class="mb-1 fw-semibold">${escapeHtml(student.last_name)} ${escapeHtml(student.first_name)}</h6>
                            <p class="text-muted mb-0 small">${escapeHtml(student.other_name || '')}</p>
                        </div>
                    </td>
                    <td>
                        ${student.class_name ? `<span class="badge bg-primary-subtle text-primary">${escapeHtml(student.class_name)}</span>` : '-'}
                    </td>
                    <td>${roles || '<span class="text-muted">No roles</span>'}</td>
                    <td><span class="fw-semibold">${escapeHtml(student.reg_no || '-')}</span></td>
                    <td>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="flex-grow-1">
                                ${subjectsHtml}
                            </div>
                            <div class="ms-2">
                                <button class="btn btn-sm btn-outline-info manage-subjects" type="button" 
                                        data-student="${student.id}" title="Manage subjects">
                                    <i class="bx bx-cog"></i> <span class="badge bg-info">${subjectCount}</span>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                <div class="dropdown-header"><h6 class="mb-0">Quick Actions</h6></div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="${profileUrl}"><i class="bx bx-show text-info me-2"></i> View Profile</a>
                                <a class="dropdown-item" href="${editUrl}"><i class="bx bx-edit text-warning me-2"></i> Edit Details</a>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item send-credentials" data-student-id="${student.id}">
                                    <i class="bx bx-envelope text-primary me-2"></i> Send Credentials
                                </button>
                                <button class="dropdown-item toggle-status" data-student-id="${student.id}" data-current-status="${student.status}">
                                    <i class="bx ${student.status ? 'bx-user-x text-danger' : 'bx-user-check text-success'} me-2"></i> 
                                    ${student.status ? 'Deactivate Student' : 'Activate Student'}
                                </button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item sync-subjects" data-student-id="${student.id}"
                                     data-current-status="${student.status}">
                                     Sync subjects
                                 </button>
                                <div class="dropdown-divider"></div>
                                ${qrAction}
                            </div>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        $tableBody.html(rows);
        $selectAll.prop('checked', false).prop('indeterminate', false);
    }

    function renderPagination(pagination) {
        const lastPage = Number(pagination.last_page) || 1;
        const currentPage = Number(pagination.current_page) || 1;

        if (lastPage <= 1) {
            $pagination.empty();
            return;
        }

        const start = Math.max(1, currentPage - 2);
        const end = Math.min(lastPage, start + 4);

        let html = '<ul class="pagination pagination-sm mb-0">';

        if (currentPage > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;
        }

        for (let page = start; page <= end; page++) {
            html += `<li class="page-item ${page === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${page}">${page}</a></li>`;
        }

        if (currentPage < lastPage) {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;
        }

        html += '</ul>';
        $pagination.html(html);
    }

    function updateCounters(pagination, count) {
        const total = Number(pagination.total) || 0;
        const perPage = Number(pagination.per_page) || state.perPage;
        const currentPage = Number(pagination.current_page) || state.currentPage;

        state.perPage = perPage;
        state.currentPage = currentPage;

        $totalCounter.text(total);

        if (!total) {
            $rangeText.text('Showing 0 to 0 of 0 students');
            return;
        }

        const start = (currentPage - 1) * perPage + 1;
        const end = start + count - 1;
        $rangeText.text(`Showing ${start} to ${end} of ${total} students`);
    }

    function openPassportModal(studentId) {
        const student = studentsCache.get(studentId);
        if (!student) {
            return;
        }

        $('#student_passport_id').val(studentId);
        $('#upload')[0].reset();
        $('#img-show-container').hide();
        $('#no-preview').show();
        $('.modalErrorr').empty();

        const modal = new bootstrap.Modal(document.querySelector('.updatePassport'));
        modal.show();
    }

    function submitPassport(formData) {
        const token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: routes.passportUpload,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': token,
            },
        }).done(function (response) {
            if (response.status) {
                showModalAlert('.modalErrorr', 'success', response.message || 'Passport updated successfully.');
                fetchStudents();
            } else {
                showModalAlert('.modalErrorr', 'danger', response.message || 'Unable to update passport.');
            }
        }).fail(function () {
            showModalAlert('.modalErrorr', 'danger', 'Unexpected error while uploading passport.');
        });
    }

    function previewPassport(event) {
        const file = event.target.files?.[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const canvas = document.getElementById('img-show');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            img.onload = function () {
                canvas.width = 150;
                canvas.height = 150;
                ctx.clearRect(0, 0, 150, 150);
                ctx.drawImage(img, 0, 0, 150, 150);
                $('#img-show-container').show();
                $('#no-preview').hide();
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function openQrModal(student, shouldGenerate) {
        $('#qr-student-name').text(student.name || 'Student');
        $('#qr-student-class').text(student.class_name || '-');
        $('#qr-student-admission').text(student.reg_no || '-');
        $('#qr-student-id').text(student.id);
        $('#qr-student-photo').attr('src', student.photo);
        $('#qr-generated-date').text('');
        $('#qr-url').text('');
        $('#qr-code-display').empty();
        $('#qr-modal-feedback').empty();
        $('#qr-loading').show();

        const modal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
        modal.show();

        if (shouldGenerate || !student.qrcode_url) {
            generateQr(student.id);
        } else {
            renderQr(student.qrcode_url);
            $('#qr-generated-date').text(new Date().toLocaleString());
            $('#qr-loading').hide();
        }
    }

    function generateQr(studentId) {
        const url = routes.qr.replace('__STUDENT__', studentId);

        $.ajax({
            url,
            method: 'GET',
        }).done(function (response) {
            if (response.success && response.file) {
                const student = studentsCache.get(studentId);
                if (student) {
                    student.qrcode_url = response.file;
                    student.qrcode_path = response.path || student.qrcode_path;
                    studentsCache.set(studentId, student);
                }
                renderQr(response.file);
                $('#qr-generated-date').text(new Date().toLocaleString());
                showModalAlert('#qr-modal-feedback', 'success', response.message || 'QR code generated.');
            } else {
                showModalAlert('#qr-modal-feedback', 'danger', response.message || 'Unable to generate QR code.');
            }
        }).fail(function () {
            showModalAlert('#qr-modal-feedback', 'danger', 'QR code generation failed.');
        }).always(function () {
            $('#qr-loading').hide();
        });
    }

    function renderQr(url) {
        const container = document.getElementById('qr-code-display');
        container.innerHTML = '';

        if (typeof QRCode === 'undefined') {
            container.innerHTML = '<p class="text-danger mb-0">QR library not available.</p>';
            return;
        }

        new QRCode(container, {
            text: url,
            width: 200,
            height: 200,
            colorDark: '#000000',
            colorLight: '#ffffff',
        });

        $('#qr-url').text(url);
    }

    function showModalAlert(container, type, message) {
        const icons = {
            success: 'bx-check-circle',
            danger: 'bx-error-circle',
            warning: 'bx-error',
            info: 'bx-info-circle',
        };

        $(container).html(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bx ${icons[type] || 'bx-info-circle'} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    }

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function openSubjectManagementModal(student) {
        
        // Populate student info
        $('#subject-modal-student-name').text(student.name || 'Student');
        $('#subject-modal-student-class').text(student.class_name || '-');
        $('#subject-modal-student-photo').attr('src', student.photo);
        $('#subject-modal-student-id').val(student.id);
        
        // Clear previous content
        $('#current-subjects-list').empty();
        $('#available-subjects-list').empty();
        $('#subject-modal-alerts').empty();
        
        // Show loading
        $('#current-subjects-list').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></div>');
        $('#available-subjects-list').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></div>');
        
        // Load current subjects
        loadCurrentSubjects(student);
        
        // Load available subjects  
        loadAvailableSubjects(student);
        
        // Show modal
        $('#subjectManagementModal').modal('show');
    }

    function loadCurrentSubjects(student) {
        const currentSubjects = student.subjects || [];
        const container = $('#current-subjects-list');
        
        if (currentSubjects.length === 0) {
            container.html('<div class="text-center text-muted py-3"><i class="bx bx-book-open display-4"></i><p class="mt-2">No subjects assigned</p></div>');
            return;
        }
        
        const html = currentSubjects.map(function(subject, index) {
            return `
                <div class="d-flex align-items-center justify-content-between p-2 border rounded mb-2 subject-item" data-subject-id="${subject.id}">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2">${index + 1}</span>
                        <div>
                            <div class="fw-medium">${escapeHtml(subject.title)}</div>
                            <small class="text-muted">Subject ID: ${subject.id}</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-subject" 
                            data-subject-id="${subject.id}" title="Remove subject">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            `;
        }).join('');
        
        container.html(html);
    }

    function loadAvailableSubjects(student) {
        const assignedIds = (student.subjects || []).map(s => parseInt(s.id));
        
        // Use the subjects passed from the blade template as primary source
        const allSubjects = <?php echo json_encode($subjects ?? []); ?>;
        
        if (allSubjects && allSubjects.length > 0) {
            const availableSubjects = allSubjects.filter(subject => 
                !assignedIds.includes(parseInt(subject.id))
            );
            
            const container = $('#available-subjects-list');
            
            if (availableSubjects.length === 0) {
                container.html('<div class="text-center text-muted py-3"><i class="bx bx-check-circle display-4"></i><p class="mt-2">All subjects assigned</p></div>');
                return;
            }
            
            const html = availableSubjects.map(function(subject) {
                const subjectTitle = subject.title || subject.name || `Subject ${subject.id}`;
                return `
                    <div class="d-flex align-items-center justify-content-between p-2 border rounded mb-2 subject-item">
                        <div>
                            <div class="fw-medium">${escapeHtml(subjectTitle)}</div>
                            <small class="text-muted">Subject ID: ${subject.id}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-success add-subject" 
                                data-subject-id="${subject.id}" title="Add subject">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                `;
            }).join('');
            
            container.html(html);
        } else {
            // Fallback: try to fetch from API
            $.ajax({
                url: '<?php echo e(route("subject.index")); ?>',
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
            }).done(function(response) {
                let subjects = [];
                if (response.data) {
                    subjects = response.data;
                } else if (Array.isArray(response)) {
                    subjects = response;
                }
                
                const availableSubjects = subjects.filter(subject => 
                    !assignedIds.includes(parseInt(subject.id))
                );
                
                const container = $('#available-subjects-list');
                
                if (availableSubjects.length === 0) {
                    container.html('<div class="text-center text-muted py-3"><i class="bx bx-check-circle display-4"></i><p class="mt-2">All subjects assigned</p></div>');
                    return;
                }
                
                const html = availableSubjects.map(function(subject) {
                    const subjectTitle = subject.title || subject.name || `Subject ${subject.id}`;
                    return `
                        <div class="d-flex align-items-center justify-content-between p-2 border rounded mb-2 subject-item">
                            <div>
                                <div class="fw-medium">${escapeHtml(subjectTitle)}</div>
                                <small class="text-muted">Subject ID: ${subject.id}</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success add-subject" 
                                    data-subject-id="${subject.id}" title="Add subject">
                                <i class="bx bx-plus"></i>
                            </button>
                        </div>
                    `;
                }).join('');
                
                container.html(html);
            }).fail(function(xhr, status, error) {
                console.error('Failed to load subjects:', error);
                $('#available-subjects-list').html('<div class="text-center text-danger py-3"><i class="bx bx-error-circle display-4"></i><p class="mt-2">Failed to load subjects</p></div>');
            });
        }
    }

    // Global function for subject assignment (fallback)
    window.assignSubject = function(studentId) {
        const student = studentsCache.get(studentId);
        if (student) {
            openSubjectManagementModal(student);
        }
    };

    // Handle subject management actions
    $(document).on('click', '.remove-subject', function() {
        const subjectId = $(this).data('subject-id');
        const studentId = $('#subject-modal-student-id').val();
        removeSubjectFromStudent(studentId, subjectId, $(this).closest('.subject-item'));
    });

    $(document).on('click', '.add-subject', function() {
        const subjectId = $(this).data('subject-id');
        const studentId = $('#subject-modal-student-id').val();
        addSubjectToStudent(studentId, subjectId, $(this).closest('.subject-item'));
    });

    function removeSubjectFromStudent(studentId, subjectId, $element) {
        const $btn = $element.find('.remove-subject');
        $btn.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i>');
        
        // Get the student object to find the UUID
        const student = studentsCache.get(parseInt(studentId));
        const studentUuid = student ? student.id : studentId; // student.id is the UUID from the API
        
        // Debug the URL being constructed
        const deleteUrl = `/student/${studentUuid}/subject/${subjectId}`;
        
        $.ajax({
            url: deleteUrl,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
        }).done(function(response) {
            if (response.status) {
                $element.fadeOut(300, function() {
                    $(this).remove();
                    // Refresh student data and reload available subjects
                    if (student) {
                        student.subjects = student.subjects.filter(s => s.id != subjectId);
                        studentsCache.set(parseInt(studentId), student);
                        loadAvailableSubjects(student);
                        fetchStudents(); // Refresh main table
                    }
                });
                showModalAlert('#subject-modal-alerts', 'success', 'Subject removed successfully');
            } else {
                showModalAlert('#subject-modal-alerts', 'danger', response.message || 'Failed to remove subject');
                $btn.prop('disabled', false).html('<i class="bx bx-trash"></i>');
            }
        }).fail(function(xhr, status, error) {
            console.error('Delete failed:', { xhr, status, error, responseText: xhr.responseText });
            let errorMessage = `HTTP ${xhr.status}: ${xhr.statusText || 'Request failed'}`;
            
            if (xhr.status === 404) {
                errorMessage = 'Student or subject not found. Please refresh the page.';
            } else if (xhr.status === 422) {
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    errorMessage = errorResponse.message || 'Validation error';
                } catch (e) {
                    errorMessage = 'Validation error occurred';
                }
            } else {
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    errorMessage = errorResponse.message || errorMessage;
                } catch (e) {
                    // Use the HTTP status message
                }
            }
            
            showModalAlert('#subject-modal-alerts', 'danger', errorMessage);
            $btn.prop('disabled', false).html('<i class="bx bx-trash"></i>');
        });
    }

    function addSubjectToStudent(studentId, subjectId, $element) {
        const $btn = $element.find('.add-subject');
        $btn.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i>');
        
        // Get current student's existing subjects
        const student = studentsCache.get(parseInt(studentId));
        const currentSubjectIds = student && student.subjects ? student.subjects.map(s => parseInt(s.id)) : [];
        
        // Add the new subject to existing ones (don't replace)
        const allSubjectIds = [...currentSubjectIds, parseInt(subjectId)];
        
        // Use the UUID for the API call (student.id is the UUID from fetchList)
        const studentUuid = student ? student.id : studentId;
        
        $.ajax({
            url: '<?php echo e(route("student.assignSubject")); ?>',
            method: 'POST',
            data: {
                student_id: studentUuid, // Use UUID not integer ID
                subjects: allSubjectIds, // Send all subjects, not just the new one
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
        }).done(function(response) {
            console.log('Add subject response:', response);
            if (response.status) {
                $element.fadeOut(300, function() {
                    $(this).remove();
                    // Refresh student data and reload current subjects
                    fetchStudents(); // This will update the cache
                    setTimeout(() => {
                        const updatedStudent = studentsCache.get(parseInt(studentId));
                        if (updatedStudent) {
                            loadCurrentSubjects(updatedStudent);
                        }
                    }, 500);
                });
                showModalAlert('#subject-modal-alerts', 'success', 'Subject added successfully');
            } else {
                showModalAlert('#subject-modal-alerts', 'danger', response.message || 'Failed to add subject');
                $btn.prop('disabled', false).html('<i class="bx bx-plus"></i>');
            }
        }).fail(function(xhr, status, error) {
            console.error('Add subject error:', xhr.responseText);
            let errorMessage = 'Error adding subject';
            try {
                const errorResponse = JSON.parse(xhr.responseText);
                errorMessage = errorResponse.message || errorMessage;
            } catch (e) {
                // Use default error message
            }
            showModalAlert('#subject-modal-alerts', 'danger', errorMessage);
            $btn.prop('disabled', false).html('<i class="bx bx-plus"></i>');
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>

<style>
.student-row:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.subjects-preview .badge {
    font-size: 0.75em;
    margin-bottom: 2px;
}

.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    border-bottom: none;
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    padding: 1rem 1.5rem;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.table-hover tbody tr:hover {
    color: inherit;
    background-color: rgba(0, 0, 0, 0.04);
}

.spinner-border {
    width: 2rem;
    height: 2rem;
}


.qr-code-container canvas {
    max-width: 100%;
    height: auto;
}

#qr-modal-feedback {
    margin-top: 1rem;
}

/* Enhanced subjects display */
.subjects-preview .badge {
    font-size: 0.75em;
    margin-bottom: 2px;
}

.manage-subjects {
    transition: all 0.2s ease;
}

.manage-subjects:hover {
    transform: scale(1.05);
}

.subject-item {
    transition: all 0.2s ease;
}

.subject-item:hover {
    background-color: #f8f9fa;
    transform: translateX(2px);
}
</style><?php /**PATH C:\laragon\www\primary\resources\views/admin/student/scripts/main-scripts.blade.php ENDPATH**/ ?>
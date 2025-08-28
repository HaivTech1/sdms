<x-app-layout>
@section('title', application('name')." | Class")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Classes</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4" id="gradeSearchWrap" style="display:none;">
                                    <div class="search-box me-2 mb-2 d-inline-block">
                                        <div class="position-relative">
                                            <input id="gradeSearchInput" type="text" class="form-control" placeholder="Search grades..." value="{{ request('search') ?? '' }}">
                                            <i class="bx bx-search-alt search-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button id="deleteAllBtn" type="button"
                                                    class="btn btn-outline-primary w-sm" style="display:none;">
                                                    <i class="bx bx-block"></i>
                                                    Delete All
                                                </button>
                                                <button id="updateStatusBtn" type="button" class="btn btn-outline-warning w-sm ms-2" style="display:none;">
                                                    <i class="fa fa-sync"></i>
                                                    Update Status
                                                </button>
                                                <button id="toggleSearchBtn" type="button" class="btn btn-outline-secondary w-sm ms-2">
                                                    <i class="fa fa-search"></i>
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-sm-12'>
                            <form id="gradeForm">
                                @csrf
                                <div class="hstack gap-3">
                                    <input class="form-control me-auto" name="title"
                                        placeholder="Add your grade here..." aria-label="Add your grade here...">
                                    <x-form.error for="title" />
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                </div>
                            </form>

                        </div>

                        <div class='col-sm-12 mt-4'>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;" class="align-middle">
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        wire:model="selectPageRows">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Title</th>
                                            <th class="align-middle">No. of students</th>
                                            <th class="align-middle">No. of Subjects</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($grades as $key => $grade)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                        <input class="form-check-input grade-checkbox" value="{{ $grade->id() }}"
                                                            type="checkbox" id="grade_{{ $grade->id() }}"
                                                            name="selected[]">
                                                    <label class="form-check-label"
                                                        for="{{ $grade->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold">{{ $key+1 }}</a>
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$grade' field='title'
                                                    :key='$grade->id()' />
                                            </td>
                                            <td>
                                                {{ $grade->students->count() }}
                                            </td>
                                             <td>
                                                 {{ $grade->subjects->count() }}
                                             </td>
                                             <td>
                                                <span class="badge bg-{{ $grade->status ? 'success' : 'danger' }}">
                                                    {{ $grade->status ? 'Active' : 'Inactive' }}
                                                </span>
                                             </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button"
                                                        class="w-full btn btn-info waves-effect waves-light viewSubjects"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-id="{{ $grade->id() }}"
                                                        title="View assigned subjects">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="w-full btn btn-primary waves-effect waves-light
                                                        assignSubjects"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-id="{{ $grade->id() }}"
                                                        title="Click to show assign subjects">
                                                        <i class="fa fa-list"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $grades->links('pagination::custom-pagination')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade addSubject bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Subjects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="createSubjects">
                                @csrf
                                <input type="hidden" value="" name="grade_id" id="edit_grade_id" />

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Assign</th>
                                                    <th>Subject Title</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subjects as $subject)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="subjects[]"
                                                            class="subject-checkbox" value="{{ $subject->id() }}" />
                                                    </td>
                                                    <td>{{ $subject->title() }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-flat pull-left"
                                        data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                    <button type="submit" id="submit_Sub" class="btn btn-primary btn-flat"><i
                                            class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="viewSubjectsModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assigned Subjects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="viewSubjectsBody" class="p-2">
                        <div class="text-center py-3">Loading...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @section("scripts")
        <script>
            $(document).ready(function() {
                // Add new grade
                $(document).on('submit', '#gradeForm', function(e) {
                    e.preventDefault();
                    toggleAble('button[type="submit"]', true, 'Adding...');
                    var data = $('#gradeForm').serializeArray();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('grade.store') }}",
                        data
                    }).done((res) => {
                        toggleAble('button[type="submit"]', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#gradeForm');
                        setTimeout(function () {
                            window.location.reload()
                        }, 1000);
                    }).fail((res) => {
                        toggleAble('button[type="submit"]', false);
                        console.log(res.responseJSON && res.responseJSON.message ? res.responseJSON.message : res.responseText);
                        toastr.error(res.responseJSON && res.responseJSON.message ? res.responseJSON.message : 'Failed to save', 'Failed!');
                    });
                });
            });

            $(document).on('click', '.assignSubjects', function(e) {
                var id = $(this).data('id');
                var button = $(this);
                toggleAble(button, true);

                $.ajax({
                    url: "/grade/subjects/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        // Response contains subjects assigned to this grade. The modal uses checkboxes
                        // so mark matching checkboxes checked. First clear existing selections.
                        $('.subject-checkbox').prop('checked', false);

                        if (Array.isArray(response.subjects)) {
                            response.subjects.forEach(function(subject) {
                                var val = String(subject.id);
                                // match by value attribute; try both quoted and unquoted for safety
                                var $cb = $('.subject-checkbox[value="' + val + '"]');
                                if ($cb.length === 0) {
                                    $cb = $('.subject-checkbox[value=' + val + ']');
                                }
                                if ($cb.length) {
                                    $cb.prop('checked', true);
                                }
                            });
                        }

                        // set grade id into hidden input and show modal
                        $('#edit_grade_id').val(id);
                        toggleAble(button, false);
                        $('.addSubject').modal('show');
                    }
                });
            });

            $(document).on('submit', '#createSubjects', function(e){
                e.preventDefault();
                toggleAble('#submit_Sub', true, 'Submitting...');
                var data = $('#createSubjects').serializeArray();
                var url = "/assign/grade/subjects/" + $('#edit_grade_id').val();

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble('#submit_Sub', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createSubjects');
                    $('.addSubject').modal('toggle');
                    setTimeout(function () {
                        window.location.reload()
                    }, 1000);
                }).fail((res) => {
                    toggleAble('#submit_Sub', false);
                    console.log(res.responseJSON && res.responseJSON.message ? res.responseJSON.message : res.responseText);
                    toastr.error(res.responseJSON && res.responseJSON.message ? res.responseJSON.message : 'Failed to save', 'Failed!');
                });
                
            });

            // View assigned subjects
            $(document).on('click', '.viewSubjects', function (e) {
                e.preventDefault();
                var gradeId = $(this).data('id');
                var $modal = $('#viewSubjectsModal');
                var $body = $('#viewSubjectsBody');
                $body.html('<div class="text-center py-3">Loading...</div>');

                $.ajax({
                    url: '/grade/subjects/' + gradeId,
                    type: 'GET',
                    dataType: 'json'
                }).done(function (res) {
                    if (res && Array.isArray(res.subjects)) {
                        if (res.subjects.length === 0) {
                            $body.html('<div class="alert alert-info">No subjects assigned.</div>');
                        } else {
                            var html = '<ul class="list-group">';
                            res.subjects.forEach(function (s) {
                                html += '<li class="list-group-item">' + (s.title || s.name || s.subject || s.title) + '</li>';
                            });
                            html += '</ul>';
                            $body.html(html);
                        }
                    } else {
                        $body.html('<div class="alert alert-danger">Failed to load subjects.</div>');
                    }
                    $modal.modal('show');
                }).fail(function () {
                    $body.html('<div class="alert alert-danger">Server error loading subjects.</div>');
                    $modal.modal('show');
                });
            });

            // Show delete/update buttons when any grade checkbox is checked
            // Header checkbox: toggle all row checkboxes and update buttons
            $(document).on('change', '#checkAll', function () {
                var checked = $(this).is(':checked');
                $('.grade-checkbox').prop('checked', checked).trigger('change');
            });

            $(document).on('change', '.grade-checkbox', function () {
                var any = $('.grade-checkbox:checked').length > 0;
                if (any) {
                    $('#deleteAllBtn, #updateStatusBtn').show();
                } else {
                    $('#deleteAllBtn, #updateStatusBtn').hide();
                }
            });

            // Delete All selected grades
            $(document).on('click', '#deleteAllBtn', function (e) {
                e.preventDefault();
                var ids = $('.grade-checkbox:checked').map(function () { return $(this).val(); }).get();
                if (!ids.length) {
                    toastr.warning('No grades selected', 'Warning');
                    return;
                }

                var doDelete = function () {
                    var $btn = $(this);
                    toggleAble($btn, true, 'Deleting...');
                    var token = $('input[name="_token"]').first().val();

                    $.ajax({
                        type: 'POST',
                        url: '/grade/delete-all',
                        data: { _token: token, 'ids[]': ids },
                        traditional: true
                    }).done(function (res) {
                        toggleAble($btn, false);
                        toastr.success(res && res.message ? res.message : 'Deleted selected grades', 'Success');
                        setTimeout(function () { window.location.reload(); }, 700);
                    }).fail(function (res) {
                        toggleAble($btn, false);
                        toastr.error(res && res.responseJSON && res.responseJSON.message ? res.responseJSON.message : 'Failed to delete selected grades', 'Error');
                    });
                }.bind(this);

                // Use SweetAlert2 (Swal.fire) if present, fall back to SweetAlert (swal) or native confirm
                if (typeof Swal !== 'undefined' && Swal.fire) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Delete selected grades? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then(function (result) {
                        if (result.isConfirmed) doDelete();
                    });
                } else if (typeof swal !== 'undefined') {
                    swal({
                        title: 'Are you sure?',
                        text: 'Delete selected grades? This action cannot be undone.',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true
                    }).then(function (willDelete) {
                        if (willDelete) doDelete();
                    });
                } else {
                    if (confirm('Delete selected grades? This action cannot be undone.')) doDelete();
                }
            });

            // Bulk Update Status for selected grades
            $(document).on('click', '#updateStatusBtn', function (e) {
                e.preventDefault();
                var ids = $('.grade-checkbox:checked').map(function () { return $(this).val(); }).get();
                if (!ids.length) {
                    toastr.warning('No grades selected', 'Warning');
                    return;
                }

                var $btn = $(this);
                toggleAble($btn, true, 'Updating...');
                var token = $('input[name="_token"]').first().val();

                // Send ids as an array so Laravel receives ids[]
                $.ajax({
                    type: 'POST',
                    url: '/grade/update-status',
                    data: { _token: token, 'ids[]': ids },
                    traditional: true
                }).done(function (res) {
                    toggleAble($btn, false);
                    toastr.success(res && res.message ? res.message : 'Status updated for selected grades', 'Success');
                    setTimeout(function () { window.location.reload(); }, 700);
                }).fail(function (res) {
                    toggleAble($btn, false);
                    toastr.error(res && res.responseJSON && res.responseJSON.message ? res.responseJSON.message : 'Failed to update status for selected grades', 'Error');
                });
            });

            // Toggle search box visibility
            $(document).on('click', '#toggleSearchBtn', function () {
                $('#gradeSearchWrap').toggle();
            });

            // Debounce helper
            function debounce(fn, wait) {
                var t;
                return function () {
                    var ctx = this, args = arguments;
                    clearTimeout(t);
                    t = setTimeout(function () { fn.apply(ctx, args); }, wait);
                };
            }

            // Grade search: update URL query param and reload
            var performSearch = debounce(function () {
                var q = $('#gradeSearchInput').val().trim();
                var url = new URL(window.location.href);
                if (q.length) {
                    url.searchParams.set('search', q);
                } else {
                    url.searchParams.delete('search');
                }
                // reset page param when searching
                url.searchParams.delete('page');
                window.location = url.toString();
            }, 600);

            $(document).on('input', '#gradeSearchInput', performSearch);
            $(document).on('keyup', '#gradeSearchInput', function (e) {
                if (e.key === 'Enter') performSearch();
            });
        </script>
    @endsection  
 
</x-app-layout>
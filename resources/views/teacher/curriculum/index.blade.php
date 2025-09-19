<x-app-layout>

    @section('title', application('name')." | Curriculum Page")

    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Curriculum</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

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

                <div id="curriculum-wrap" data-list-url="{{ route('teacher.curriculum') }}">
                    {{-- AJAX loaded list will go here --}}
                    @include('teacher.curriculum._list', ['curriculums' => $curriculums])
            </div>
    </div>

    <!-- Create modal -->
    <div class="modal fade" id="createCurriculum" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createForm" method="POST" action="{{ route('teacher.curriculum.store') }}">
                    @csrf
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
                                                                        @foreach($grades as $grade)
                                                                                <option value="{{ $grade->id }}">{{ $grade->title }}</option>
                                                                        @endforeach
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
                                    @foreach($periods as $period)
                                            <option value="{{ $period->id }}">{{ $period->title }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Term</label>
                            <select name="term_id" class="form-control" required>
                                    @foreach($terms as $term)
                                            <option value="{{ $term->id }}">{{ $term->title }}</option>
                                    @endforeach
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

    @section('scripts')
    <script>
            (function($){
                const $wrap = $('#curriculum-wrap');
                        const listUrl = $wrap.data('list-url');

                        // Map of gradeId => subjects (preloaded server-side)
                        const gradeSubjects = @json($grades->mapWithKeys(function($g){
                                return [$g->id => $g->subjects->map(function($s){ return ['id' => $s->id, 'title' => $s->title]; })->toArray()];
                        })->toArray());

                        function populateSubjects(gradeId){
                                const $select = $('#subject_id');
                                $select.empty();
                                const subs = gradeSubjects[gradeId] || [];
                                if (subs.length === 0) {
                                        $select.append($('<option>').text('No subjects for selected grade').attr('value',''));
                                        $select.prop('disabled', true);
                                } else {
                                        $select.prop('disabled', false);
                                        $select.append($('<option>').text('-- Select subject --').attr('value',''));
                                        subs.forEach(function(s){
                                                $select.append($('<option>').attr('value', s.id).text(s.title));
                                        });
                                }
                        }

                        // When grade changes, load subjects
                        $(document).on('change', '#grade_id', function(){
                                populateSubjects($(this).val());
                        });

                        // When modal opens, populate subjects for currently selected grade (or first)
                        $('#openCreate').on('click', function(){
                                const firstGrade = $('#grade_id').val();
                                populateSubjects(firstGrade);
                                $('#createCurriculum').modal('show');
                        });

                    function loadPage(url, params = {}){
                            params._token = '{{ csrf_token() }}';
                            $.get(url, params, function(html){
                                    // Expect the server to return the partial HTML for the list
                                    $wrap.html(html);
                            }).fail(function(xhr){
                                    alert('Failed to load data');
                            });
                    }

                    // Search key
                    $('#search').on('keyup', function(e){
                            const q = $(this).val();
                            // load fresh results (page param removed)
                            loadPage(listUrl + '?search=' + encodeURIComponent(q));
                    });

                    // Open create modal
                    $('#openCreate').on('click', function(){
                            $('#createCurriculum').modal('show');
                    });

                    // Submit create form via AJAX
                    $('#createForm').on('submit', function(e){
                            e.preventDefault();
                            const $form = $(this);
                            const data = $form.serialize();
                            $.post($form.attr('action'), data, function(){
                                    $('#createCurriculum').modal('hide');
                                    loadPage(listUrl);
                            }).fail(function(xhr){
                                    alert('Failed to create curriculum');
                            });
                    });

                    // Delegate pagination/link clicks inside the wrap
                    $wrap.on('click', '.pagination a', function(e){
                            e.preventDefault();
                            const href = $(this).attr('href');
                            loadPage(href);
                    });

                    // Initial behaviour: nothing to do; server-rendered initial list included
            })(jQuery);
    </script>
    @endsection
</x-app-layout>
<x-app-layout>
    <x-slot name="header"><h2>Saved Questions for Topic: {{ $topic->title }}</h2></x-slot>

    <div class="container">
        <div class="mb-3">
            <a href="{{ route('teacher.curriculum.topics', $curriculum) }}" class="btn btn-secondary">Back to topics</a>
        </div>

        <table class="table table-striped" id="savedQuestionsTable">
            <thead><tr><th>ID</th><th>Question</th><th>Options</th><th>Difficulty</th><th>Bloom</th><th>Actions</th></tr></thead>
            <tbody id="savedQuestionsBody">
                @include('teacher.curriculum._questions_list', ['questions' => $questions])
            </tbody>
        </table>
    </div>

    @section('scripts')
    <script>
        (function($){
            $('#savedQuestionsBody').on('click', '.delete-saved-question', function(){
                const url = $(this).data('url');
                const $btn = $(this);
                Swal.fire({ title: 'Are you sure?', text: 'This will delete the question', icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes, delete' }).then((res)=>{
                    if (!res.isConfirmed) return;
                    toggleAble($btn, true, 'Deleting...');
                    $.ajax({ url: url, method: 'DELETE', data: { _token: '{{ csrf_token() }}' }})
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
                                    @csrf
                                    @method('PUT')
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
                // Render each option with a radio button to select the correct_index
                data.options.forEach(function(opt, i){
                    const checked = (typeof data.correct_index !== 'undefined' && parseInt(data.correct_index) === i) ? 'checked' : '';
                    $opts.append(`
                        <div class="mb-1 d-flex align-items-start">
                            <label class="me-2" style="min-width:95px;">
                                <input type="radio" name="correct_index" value="${i}" ${checked}> Correct
                            </label>
                            <div class="flex-grow-1">
                                <label>Option ${i+1}</label>
                                <input class="form-control" name="options[${i}]" value="${opt}">
                            </div>
                        </div>
                    `);
                });

                // show modal
                $('#editSavedQuestionModal').modal('show');

                $('#editSavedQuestionForm').off('submit').on('submit', function(ev){
                    ev.preventDefault();
                    var button = $(this).find('button[type="submit"]');
                    toggleAble(button, true, 'Saving...');
                    const qid = $('#_question_id').val();
                    const payload = $(this).serializeArray();
                    const url = '{{ url("/teacher/curriculum") }}/' + '{{ $curriculum->id }}' + '/questions/' + qid; // route expects /curriculum/{curriculum}/questions/{question}
                    const dataToSend = {};
                    payload.forEach(function(p){ dataToSend[p.name] = p.value; });
                    dataToSend._token = '{{ csrf_token() }}';

                    $.ajax({ url: url, method: 'PUT', data: dataToSend })
                        .done(function(){ 
                            toggleAble(button, false);
                            Swal.fire('Saved','Question updated','success'); location.reload(); })
                        .fail(function(){ 
                            toggleAble(button, false);
                            Swal.fire('Error','Failed to update','error'); });
                });
            });
        })(jQuery);
    </script>
    @endsection
</x-app-layout>

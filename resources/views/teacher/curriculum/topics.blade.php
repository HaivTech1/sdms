<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curriculum Topics') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h3>Topics for: {{ $curriculum->name }}</h3>
            <div>
                <a href="{{ route('teacher.curriculum') }}" class="btn btn-secondary">Back</a>
                <button id="openCreateTopic" class="btn btn-primary">Add Topic</button>
            </div>
        </div>

        <div id="topics-wrap" data-list-url="{{ route('teacher.curriculum.topics', $curriculum) }}">
            @include('teacher.curriculum._topics_list', ['topics' => $topics])
        </div>

        <!-- Create Topic Modal -->
        <div class="modal fade" id="createTopicModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body" id="createTopicBody">
                        @include('teacher.curriculum._topic_form')
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Topic Modal (AJAX injected) -->
        <div class="modal fade" id="editTopicModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body" id="editTopicBody"></div>
                </div>
            </div>
        </div>

        <!-- Generate Questions Modal -->
        <div class="modal fade" id="generateQuestionsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generate Questions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="generateQuestionsForm">
                            @csrf
                            <input type="hidden" name="topic_id" id="g_topic_id">
                            <div class="mb-3">
                                <label class="form-label">Topic</label>
                                <input type="text" id="g_topic_title" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Objectives (for model)</label>
                                <textarea id="g_topic_objectives" class="form-control" rows="4" readonly></textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <label class="form-label">Number of questions</label>
                                    <input type="number" name="count" value="5" min="1" max="50" class="form-control">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label class="form-label">Types</label>
                                    <select name="types" class="form-control">
                                        <option value="MCQ">MCQ</option>
                                        <option value="MCQ|Short">MCQ + Short Answer</option>
                                        <option value="Short">Short Answer</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label class="form-label">Difficulty mix</label>
                                    <select name="difficulty_mix" class="form-control">
                                        <option value="balanced">Balanced</option>
                                        <option value="50-30-20">50% easy / 30% medium / 20% hard</option>
                                        <option value="70-20-10">70% easy / 20% medium / 10% hard</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label">Bloom level (optional)</label>
                                    <select id="bloom_level" name="bloom_level" class="form-control">
                                        <option value="">Any</option>
                                        <option>Remember</option>
                                        <option>Understand</option>
                                        <option>Apply</option>
                                        <option>Analyze</option>
                                        <option>Evaluate</option>
                                        <option>Create</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-primary" type="submit">Generate</button>
                            </div>
                        </form>
                        <div id="generationResult" class="mt-3" style="display:none">
                            <h6>Preview</h6>
                            <div id="generationPreview"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            (function($){
                const $wrap = $('#topics-wrap');
                const listUrl = $wrap.data('list-url');

                function loadPage(url, params = {}){
                    params._token = '{{ csrf_token() }}';
                    // try {
                    //     $wrap.css('position', 'relative');
                    //     $wrap.append($('<div class="overlay-loader">').css({position: 'absolute', top:0, left:0, width:'100%', height:'100%', background:'rgba(255,255,255,0.6)', 'z-index': 9999}).append(divLoader()));
                    // } catch(e){}

                    $.ajax({ url: url, data: params, method: 'GET' })
                        .done(function(html){ $wrap.html(html); })
                        .fail(function(xhr){ let msg = 'Failed to load topics'; if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message; Swal.fire('Error', msg, 'error'); })
                        .always(function(){ $wrap.find('.overlay-loader').remove(); });
                }

                // Open create modal
                $('#openCreateTopic').on('click', function(){
                    $('#createTopicModal').modal('show');
                    // init summernote for create modal
                    try { $('#createTopicBody').find('textarea[name="objectives"]').summernote({ height: 150 }); } catch(e){}
                });

                // Submit create via AJAX and reload list
                $('#createTopicBody').on('submit', '#createTopicForm', function(e){
                    e.preventDefault();
                    const $form = $(this);
                    // ensure summernote content is synced to textarea
                    try { const $obj = $form.find('textarea[name="objectives"]'); if ($obj.length && $obj.summernote) { $obj.val($obj.summernote('code')); } } catch(e){}
                    const $btn = $form.find('button[type=submit]');
                    toggleAble($btn, true, 'Adding...');
                    $.post($form.attr('action'), $form.serialize())
                        .done(function(){ toggleAble($btn, false); $('#createTopicModal').modal('hide'); Swal.fire('Added','Topic added','success'); loadPage(listUrl);
                            setTimeout(function(){
                                window.location.reload();
                            }, 1500);

                         })
                        .fail(function(xhr){ toggleAble($btn, false); if (xhr.responseJSON && xhr.responseJSON.errors) { let html = Object.values(xhr.responseJSON.errors).flat().join('<br/>'); Swal.fire({ title: 'Validation error', html: html, icon: 'error' }); } else { Swal.fire('Error','Failed to add topic','error'); } });
                });

                // Delegate list actions
                $wrap.on('click', '.edit-topic', function(){
                    const url = $(this).data('url');
                    $.get(url).done(function(html){ $('#editTopicBody').html(html); $('#editTopicModal').modal('show');
                        // init summernote for edit form
                        try { $('#editTopicBody').find('textarea[name="objectives"]').summernote({ height: 150 }); } catch(e){}
                        // attach submit handler inside modal
                        $('#editTopicBody').on('submit', '#editTopicForm', function(e){
                            e.preventDefault();
                            const $form = $(this);
                            // sync summernote content
                            try { const $obj = $form.find('textarea[name="objectives"]'); if ($obj.length && $obj.summernote) { $obj.val($obj.summernote('code')); } } catch(e){}
                            const $btn = $form.find('button[type=submit]');
                            toggleAble($btn, true, 'Saving...');
                            $.post($form.attr('action'), $form.serialize())
                                .done(function(){ toggleAble($btn, false); $('#editTopicModal').modal('hide'); Swal.fire('Saved','Topic updated','success'); loadPage(listUrl); })
                                .fail(function(xhr){ toggleAble($btn, false); if (xhr.responseJSON && xhr.responseJSON.errors) { let html = Object.values(xhr.responseJSON.errors).flat().join('<br/>'); Swal.fire({ title: 'Validation error', html: html, icon: 'error' }); } else { Swal.fire('Error','Failed to update topic','error'); } });
                        });
                    }).fail(function(){ Swal.fire('Error','Failed to load edit form','error'); });
                });

                // destroy summernote when modals close to avoid duplicates
                $('#createTopicModal, #editTopicModal').on('hidden.bs.modal', function(){
                    try { $(this).find('textarea[name="objectives"]').each(function(){ if ($(this).data('summernote')) { $(this).summernote('destroy'); } }); } catch(e){}
                    $(this).find('.modal-body').empty();
                });

                $wrap.on('click', '.delete-topic', function(){
                    const url = $(this).data('url');
                    const $btn = $(this);
                    Swal.fire({ title: 'Are you sure?', text: 'This will delete the topic', icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes, delete' }).then((res)=>{
                        if (!res.isConfirmed) return;
                        toggleAble($btn, true, 'Deleting...');
                        $.ajax({ url: url, method: 'POST', data: { _method: 'DELETE' } })
                            .done(function(){ toggleAble($btn, false); Swal.fire('Deleted','Topic removed','success'); loadPage(listUrl); })
                            .fail(function(){ toggleAble($btn, false); Swal.fire('Error','Failed to delete','error'); });
                    });
                });

                // handle pagination links inside topics wrap
                $wrap.on('click', '.pagination a', function(e){ e.preventDefault(); loadPage($(this).attr('href')); });

                // open generate questions modal
                $wrap.on('click', '.generate-questions', function(){
                    const $tr = $(this).closest('tr');
                    const topicId = $tr.data('id');
                    const title = $tr.find('.topic-title').text().trim();
                    const objectives = $tr.find('.topic-objectives').text().trim();
                    const bloom_level = $tr.find('.topic-bloom').text().trim();

                    $('#g_topic_id').val(topicId);
                    $('#g_topic_title').val(title);
                    $('#g_topic_objectives').val(objectives);
                    $('#bloom_level').val(bloom_level);
                    $('#generationResult').hide(); $('#generationPreview').empty();
                    $('#generateQuestionsModal').modal('show');
                });

                // submit generate form
                $('#generateQuestionsForm').on('submit', function(e){
                    e.preventDefault();
                    const $form = $(this);
                    const $btn = $form.find('button[type=submit]');
                    toggleAble($btn, true, 'Generating...');

                    const payload = $form.serialize();
                    $.post("{{ route('teacher.curriculum.topics.generate', $curriculum) }}", payload)
                        .done(function(res){
                            toggleAble($btn, false);
                            if (res.status && res.data) {
                                // Keep a local copy of previewed questions so they can be edited/removed before saving
                                window.__questionPreview = res.data.map(function(q){ return $.extend(true, {}, q); });

                                // Render helper
                                function renderPreviewList(){
                                    $('#generationPreview').html('');
                                    if (!window.__questionPreview || !window.__questionPreview.length) {
                                        $('#generationPreview').html('<div class="text-muted">No questions</div>');
                                        return;
                                    }

                                    window.__questionPreview.forEach(function(q, idx){
                                        let optsHtml = '';
                                        q.options.forEach(function(opt, i){
                                            optsHtml += `<div class="form-check">
                                                <input class="form-check-input preview-correct" type="radio" name="correct_${idx}" value="${i}" ${i===q.correct_index? 'checked' : ''} data-qi="${idx}">
                                                <input class="form-control form-control-sm preview-option" data-qi="${idx}" data-oi="${i}" value="${escapeHtml(opt)}">
                                            </div>`;
                                        });

                                        let card = `<div class="card mb-2" data-qi="${idx}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div><strong>Q${idx+1}:</strong></div>
                                                    <div>
                                                        <button class="btn btn-sm btn-danger remove-question" data-qi="${idx}">Remove</button>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <input class="form-control preview-question" data-qi="${idx}" value="${escapeHtml(q.question)}">
                                                </div>
                                                <div>${optsHtml}</div>
                                                <div class="text-end mt-2">
                                                    <small class="text-muted">Difficulty: ${escapeHtml(q.difficulty || '')} • Bloom: ${escapeHtml(q.bloom_level || '')}</small>
                                                </div>
                                                <div class="text-end mt-2">
                                                    <button class="btn btn-sm btn-secondary edit-preview-question" data-qi="${idx}">Edit</button>
                                                    <button class="btn btn-sm btn-success save-question" data-qi="${idx}">Save</button>
                                                </div>
                                            </div>
                                        </div>`;

                                        $('#generationPreview').append(card);
                                    });

                                    // Append Save All button
                                    $('#generationPreview').append('<div class="text-end mt-3"><button id="saveAllQuestions" class="btn btn-success">Save all questions</button></div>');
                                }

                                // simple HTML escape to avoid accidental markup
                                function escapeHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

                                // handlers: radio change updates correct_index; option input edits option text; remove deletes question; save submits
                                $(document).off('change', '.preview-correct').on('change', '.preview-correct', function(){
                                    const qi = $(this).data('qi');
                                    const val = parseInt($(this).val());
                                    if (window.__questionPreview && window.__questionPreview[qi]) window.__questionPreview[qi].correct_index = val;
                                });

                                $(document).off('input', '.preview-option').on('input', '.preview-option', function(){
                                    const qi = $(this).data('qi');
                                    const oi = $(this).data('oi');
                                    const val = $(this).val();
                                    if (window.__questionPreview && window.__questionPreview[qi]) window.__questionPreview[qi].options[oi] = val;
                                });

                                $(document).off('click', '.remove-question').on('click', '.remove-question', function(){
                                    const qi = $(this).data('qi');
                                    if (!window.__questionPreview) return;
                                    window.__questionPreview.splice(qi,1);
                                    renderPreviewList();
                                });

                                $(document).off('click', '#saveAllQuestions').on('click', '#saveAllQuestions', function(){
                                    const $btn = $(this);
                                    toggleAble($btn, true, 'Saving...');
                                    // prepare payload
                                    const payload = {
                                        _token: '{{ csrf_token() }}',
                                        curriculum_topic_id: $('#g_topic_id').val(),
                                        questions: window.__questionPreview
                                    };

                                    $.post("{{ route('teacher.curriculum.topics.save_questions', $curriculum) }}", payload)
                                        .done(function(resp){ toggleAble($btn, false); if (resp.status) { Swal.fire('Saved','Questions saved','success'); $('#generateQuestionsModal').modal('hide'); loadPage(listUrl); } else { Swal.fire('Error', resp.message || 'Failed to save','error'); } })
                                        .fail(function(xhr){ toggleAble($btn, false); Swal.fire('Error', xhr.responseJSON?.message || 'Failed to save','error'); });
                                });

                                // per-question save
                                $(document).off('click', '.save-question').on('click', '.save-question', function(){
                                    const qi = $(this).data('qi');
                                    if (!window.__questionPreview || !window.__questionPreview[qi]) return;
                                    const q = window.__questionPreview[qi];
                                    const $btn = $(this);
                                    toggleAble($btn, true, 'Saving...');

                                    const payload = {
                                        _token: '{{ csrf_token() }}',
                                        curriculum_topic_id: $('#g_topic_id').val(),
                                        question: q.question,
                                        options: q.options,
                                        correct_index: q.correct_index,
                                        difficulty: q.difficulty || null,
                                        bloom_level: q.bloom_level || null,
                                        explanation: q.explanation || null,
                                    };

                                    $.post("{{ route('teacher.curriculum.topics.save_question', $curriculum) }}", payload)
                                        .done(function(resp){ toggleAble($btn, false); if (resp.status) { Swal.fire('Saved','Question saved','success'); $btn.prop('disabled', true).text('Saved'); loadPage(listUrl); } else { Swal.fire('Error', resp.message || 'Failed to save','error'); } })
                                        .fail(function(xhr){ toggleAble($btn, false); Swal.fire('Error', xhr.responseJSON?.message || 'Failed to save','error'); });
                                });

                                // Edit preview question in a modal
                                $('body').append(`<div class="modal fade" id="editPreviewQuestionModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Edit Question</h5><button class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><form id="editPreviewQuestionForm"><input type="hidden" id="preview_qi"><div class="mb-2"><label>Question</label><input class="form-control" id="preview_q_text"></div><div id="preview_q_opts"></div><div class="text-end mt-2"><button class="btn btn-primary" type="submit">Save</button></div></form></div></div></div></div>`);

                                $(document).off('click', '.edit-preview-question').on('click', '.edit-preview-question', function(){
                                    const qi = $(this).data('qi');
                                    const q = window.__questionPreview && window.__questionPreview[qi];
                                    if (!q) return;
                                    $('#preview_qi').val(qi);
                                    $('#preview_q_text').val(q.question);
                                    const $opts = $('#preview_q_opts').empty();
                                    q.options.forEach(function(opt, i){
                                        $opts.append(`<div class="mb-1"><label>Option ${i+1}</label><input class="form-control" data-oi="${i}" id="preview_opt_${i}" value="${opt}"></div>`);
                                    });
                                    $('#editPreviewQuestionModal').modal('show');
                                });

                                $(document).off('submit', '#editPreviewQuestionForm').on('submit', '#editPreviewQuestionForm', function(e){
                                    e.preventDefault();
                                    const qi = parseInt($('#preview_qi').val());
                                    if (!window.__questionPreview || !window.__questionPreview[qi]) return;
                                    window.__questionPreview[qi].question = $('#preview_q_text').val();
                                    $('#preview_q_opts').find('input').each(function(){
                                        const oi = $(this).data('oi');
                                        window.__questionPreview[qi].options[oi] = $(this).val();
                                    });
                                    $('#editPreviewQuestionModal').modal('hide');
                                    renderPreviewList();
                                });

                                // initial render
                                renderPreviewList();
                                $('#generationResult').show();
                            } else {
                                Swal.fire('Error', res.message || 'Failed to generate', 'error');
                            }
                        })
                        .fail(function(xhr){ toggleAble($btn, false); Swal.fire('Error', xhr.responseJSON?.message || 'Failed to generate', 'error'); });
                });

            })(jQuery);
        </script>
    @endsection
</x-app-layout>

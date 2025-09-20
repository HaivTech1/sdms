<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weeks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Week generation controls --}}
                    @php $term_setting = termSetting(term('id'), period('id')); @endphp
                    <div class="mb-4">
                        @if($term_setting && $term_setting->resumption_date && $term_setting->vacation_date)
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                <div>
                                    <strong>Term resumption:</strong> {{ $term_setting->resumption_date->format('Y-m-d') }}
                                    &nbsp;&nbsp;
                                    <strong>Vacation:</strong> {{ $term_setting->vacation_date->format('Y-m-d') }}
                                </div>
                                <div>
                                    <button id="generateFromTerm" class="btn btn-primary">Generate Weeks from Term</button>
                                </div>
                            </div>
                        @else
                            <form id="manualWeekForm" class="form-inline d-flex gap-2 align-items-end">
                                @csrf

                                <div class="form-group">
                                    <label class="d-block">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label class="d-block">End Date</label>
                                    <input type="date" name="end_date" class="form-control" required />
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">Generate Weeks</button>
                                </div>
                            </form>
                        @endif
                    </div>
                    <div id="weeks-wrap" data-list-url="{{ route('admin.week.list') }}">
                        @include('admin.weeks._weeks_list', ['weeks' => $weeks])
                    </div>

                <!-- Edit Hairstyle Modal -->
                <div class="modal fade" id="editHairstyleModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Week Hairstyle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editHairstyleForm">
                                    @csrf
                                    <input type="hidden" name="week_id" id="edit_week_id" />
                                    <div class="mb-3">
                                        <label for="hairstyle_select" class="form-label">Hairstyle</label>
                                        <div class="d-flex gap-3 mb-2 align-items-center">
                                            <div>
                                                <img id="hairstyle_preview_front" src="{{ asset("noImage.png") }}" alt="front" style="max-width:80px; max-height:80px; object-fit:cover; border:1px solid #ddd; padding:2px; background:#fff;" />
                                            </div>
                                            <div>
                                                <img id="hairstyle_preview_side" src="{{ asset("noImage.png") }}" alt="side" style="max-width:80px; max-height:80px; object-fit:cover; border:1px solid #ddd; padding:2px; background:#fff;" />
                                            </div>
                                            <div>
                                                <img id="hairstyle_preview_back" src="{{ asset("noImage.png") }}" alt="back" style="max-width:80px; max-height:80px; object-fit:cover; border:1px solid #ddd; padding:2px; background:#fff;" />
                                            </div>
                                        </div>

                                        <select id="hairstyle_select" name="hairstyle_id" class="form-control">
                                            <option value="">-- None --</option>
                                        </select>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                {{-- scripts for AJAX generation --}}
                @section('scripts')
                            <script>
                        (function($){
                            const $wrap = $('#weeks-wrap');
                            const listUrl = $wrap.data('list-url');

                            function loadWeeks(url, params = {}){
                                params._token = '{{ csrf_token() }}';
                                // try { $wrap.append($('<div class="overlay-loader">').css({position: 'absolute', top:0, left:0, width:'100%', height:'100%', background:'rgba(255,255,255,0.6)', 'z-index': 9999}).append(divLoader())); } catch(e){}
                                $.get(url, params).done(function(html){
                                    // if server returned JSON list (API), render rows; if returned blade partial, replace
                                    if (typeof html === 'object' && html.data) {
                                        // build table rows
                                        let rows = '';
                                        html.data.forEach(function(w){
                                            rows += `<tr><td>${w.id}</td><td>${w.hairstyle.title ||''}</td><td>${w.start_date.toLocalString() ||''}</td><td>${w.end_date.toLocalString() ||''}</td><td>${w.period.title() || ''}</td><td>${w.term.title() || ''}</td><td></td></tr>`;
                                        });
                                        $wrap.html('<table class="table table-bordered"><thead><tr><th>ID</th><th>Hairstyle</th><th>Start Date</th><th>End Date</th><th>Period</th><th>Term</th><th>Actions</th></tr></thead><tbody>'+rows+'</tbody></table>');
                                    } else {
                                        $wrap.html(html);
                                    }
                                }).fail(function(){ Swal.fire('Error','Failed to load weeks','error'); })
                                  .always(function(){ $wrap.find('.overlay-loader').remove(); });
                            }

                            // initial load will use the included partial; set up handlers to reload after generation
                            $('#generateFromTerm').on('click', function(e){
                                e.preventDefault();
                                const $btn = $(this);
                                toggleAble($btn, true, 'Generating...');
                                $.post("{{ route('admin.week.store') }}", {_token: '{{ csrf_token() }}'})
                                    .done(function(res){ toggleAble($btn, false); Swal.fire('Done', res.message || 'Weeks created', 'success'); loadWeeks(listUrl); })
                                    .fail(function(xhr){ toggleAble($btn, false); Swal.fire('Error', xhr.responseJSON?.message || 'Failed to create weeks', 'error'); });
                            });

                            $('#manualWeekForm').on('submit', function(e){
                                e.preventDefault();
                                const $form = $(this);
                                const $btn = $form.find('button[type=submit]');
                                toggleAble($btn, true, 'Generating...');
                                $.post("{{ route('admin.week.store') }}", $form.serialize())
                                    .done(function(res){ toggleAble($btn, false); Swal.fire('Done', res.message || 'Weeks created', 'success'); loadWeeks(listUrl); })
                                    .fail(function(xhr){ toggleAble($btn, false); Swal.fire('Error', xhr.responseJSON?.message || 'Failed to create weeks', 'error'); });
                            });

                            // handle pagination links inside wrapper
                            $wrap.on('click', '.pagination a', function(e){ e.preventDefault(); loadWeeks($(this).attr('href')); });

                            // open edit modal and load hairstyles
                            $wrap.on('click', '.edit-week', function(e){
                                e.preventDefault();
                                const weekId = $(this).data('week-id');
                                const currentHairId = $(this).data('hairstyle-id');
                                $('#edit_week_id').val(weekId);
                                $('#hairstyle_select').html('<option>Loading...</option>');
                                $('#editHairstyleModal').modal('show');

                                $.get("{{ route('admin.hairstyle.all') }}").done(function(res){
                                    if(res.status && res.data){
                                        let options = '<option value="">-- None --</option>';
                                        res.data.forEach(function(h){
                                            // include data attributes for preview images
                                            options += `<option value="${h.id}" data-front="${h.front}" data-side="${h.side}" data-back="${h.back}" ${h.id == currentHairId ? 'selected' : ''}>${h.title}</option>`;
                                        });
                                        $('#hairstyle_select').html(options);

                                        // set preview to currently selected
                                        const $sel = $('#hairstyle_select');
                                        const sel = $sel.find('option:selected');
                                        $('#hairstyle_preview_front').attr('src', sel.data('front') || '{{ asset("noImage.png") }}');
                                        $('#hairstyle_preview_side').attr('src', sel.data('side') || '{{ asset("noImage.png") }}');
                                        $('#hairstyle_preview_back').attr('src', sel.data('back') || '{{ asset("noImage.png") }}');

                                        // update preview on change
                                        $sel.off('change.preview').on('change.preview', function(){
                                            const s = $(this).find('option:selected');
                                            $('#hairstyle_preview_front').attr('src', s.data('front') || '{{ asset("noImage.png") }}');
                                            $('#hairstyle_preview_side').attr('src', s.data('side') || '{{ asset("noImage.png") }}');
                                            $('#hairstyle_preview_back').attr('src', s.data('back') || '{{ asset("noImage.png") }}');
                                        });
                                    } else {
                                        $('#hairstyle_select').html('<option value="">-- None --</option>');
                                        $('#hairstyle_preview_front').attr('src', '{{ asset("noImage.png") }}');
                                        $('#hairstyle_preview_side').attr('src', '{{ asset("noImage.png") }}');
                                        $('#hairstyle_preview_back').attr('src', '{{ asset("noImage.png") }}');
                                    }
                                }).fail(function(){ 
                                    $('#hairstyle_select').html('<option value="">-- None --</option>');
                                    $('#hairstyle_preview_front').attr('src', '{{ asset("noImage.png") }}');
                                    $('#hairstyle_preview_side').attr('src', '{{ asset("noImage.png") }}');
                                    $('#hairstyle_preview_back').attr('src', '{{ asset("noImage.png") }}');
                                });
                            });

                            // submit edit form
                            $('#editHairstyleForm').on('submit', function(e){
                                e.preventDefault();
                                const weekId = $('#edit_week_id').val();
                                const hairId = $('#hairstyle_select').val();
                                const $btn = $(this).find('button[type=submit]');
                                toggleAble($btn, true, 'Saving...');
                                $.ajax({ url: "{{ url('/admin/week') }}/" + weekId, method: 'PUT', data: { hairstyle_id: hairId, _token: '{{ csrf_token() }}' } })
                                    .done(function(){ toggleAble($btn, false); $('#editHairstyleModal').modal('hide'); Swal.fire('Saved','Week updated','success'); loadWeeks(listUrl); })
                                    .fail(function(xhr){ toggleAble($btn, false); Swal.fire('Error', xhr.responseJSON?.message || 'Failed to update', 'error'); });
                            });

                        })(jQuery);
                    </script>
                @endsection
            </div>
        </div>
    </div>
</x-app-layout>
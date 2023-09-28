<x-app-layout>
    @section('title', application('name')." | Create Assignment Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Assignment</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </x-slot>
    
     <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle"> Title</th>
                                <th class="align-middle">Subject</th>
                                <th class="align-middle">Class</th>
                                <th class="align-middle">Status</th>
                                <th class="align-middle">Views</th>
                                <th class="align-middle">Comments</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $key => $assignment)
                            <tr>
                                <td>
                                    <livewire:components.edit-title :model='$assignment' field='title'
                                        :key='$assignment->id()' />
                                </td>
                                <td>
                                    {{ $assignment->subject->title() }}
                                </td>
                                <td>
                                    {{ $assignment->grade->title() }}
                                </td>
                                <td>
                                    <livewire:components.toggle-button :model='$assignment' field='status' :key='$assignment->id()'/>
                                </td>
                                <td>
                                    <i class= "bx bxs-show me-1"></i> {{ views($assignment)->count(); }}
                                </td>
                                <td>
                                    <i class= "bx bxs-comment me-1"></i> {{ $assignment->comments()->count() }}
                                    <input class="d-none" id="link" value="{{ application('website') }}/assignment/show/{{ $assignment->id() }}" />
                                </td>
                                <td>
                                    {{-- @teacher --}}
                                        @can('assignment_action')
                                            @if ($assignment->path())
                                                <a href="{{ route('assignment.download', $assignment->id()) }}" class="btn btn-sm btn-primary"><i class="bx bx-download"></i></a>
                                            @endif
                                            <a href="{{ route('assignment.show', $assignment->id()) }}" class="btn btn-sm btn-success"><i class="bx bx-show"></i></a>

                                            <button id="publish" onClick="publish('{{ $assignment->id() }}')" class="btn btn-sm btn-warning"><i class="mdi mdi-upload"></i></button>
                                            <button onclick="copyClipboard()" class="btn btn-sm btn-primary">Generate Link</button>
                                            <a href="{{ route('assignment.destroy', $assignment->id()) }}" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></a>
                                        @endcan
                                    {{-- @endteacher --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $assignments->links('pagination::custom-pagination')}}
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Create a new assignment</h4>
                    <div class="modalErrorr"></div>

                    <form  method="POST" action="{{ route('assignment.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="title" value="{{ __('Title') }}" />
                                        <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                            :value="old('title')" id="title" autofocus />
                                        <x-form.error for="title" />
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="grade_id" value="{{ __('Class') }}" />
                                        <select class="form-control" name="grade_id">
                                            <option>Select</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="subject_id" value="{{ __('Subject') }}" />
                                        <select class="form-control" name="subject_id">
                                            <option>Select</option>
                                            @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id() }}">{{ $subject->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="path" value="{{ __('Select File') }}" />
                                        <input type="file" id="path" name="path" class="form-control"/>
                                        <x-form.error for="path" />
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <x-form.label for="content" value="{{ __('Content') }}" />
                                                <textarea class="form-control" name="content" id="summernote">{{ old('content') }}</textarea>
                                        <x-form.error for="content" />
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_button" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script type="text/javascript">
            var formId = '#save-content-form';

            $(document).on('submit', formId, function(e) {
                e.preventDefault();
                toggleAble('#submit_button', true, 'Creating assignment...');
                var data = $('#save-content-form').serializeArray();
                var url = "{{ route('assignment.store') }}"

                $.ajax({
                        type: 'POST',
                        url,
                        data: fd,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble('#submit_button', false);
                        resetForm(formId);
                        toastr.success(res.message, 'Successful!');
                    }).fail((err) => {
                         toggleAble('#submit_button', false);
                         let allErrors = Object.values(err.responseJSON).map(el => (
                            el = `<li>${el}</li>`
                        )).reduce((next, prev) => ( next = prev + next ));

                        const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul>${allErrors}</ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            `;

                        $('.modalErrorr').html(setErrors);
                        console.log(err.responseJSON.message);
                    }); 
            });
        </script>
        <script>
            function publish(assignment){
                var assignment_id = assignment;
                toggleAble('#publish', true);

                $.ajax({
                    url: '{{ route('assignment.publish') }}' ,
                    method: 'GET',
                    data: {assignment_id}
                }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#publish', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#publish', false);
                            toastr.error(res.message, 'Success!');
                        }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#publish', false);
                });
            }

           function copyClipboard() {
                var copyText = document.getElementById("link");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value)
                    .then(function() {
                        alert("Link copied to clipboard: " + copyText.value);
                    })
                    .catch(function(error) {
                        console.error("Error copying text to clipboard: ", error);
                    });
            }

        </script>
    @endsection

    </x-app-layout>
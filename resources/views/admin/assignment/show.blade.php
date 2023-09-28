<x-app-layout>
    @section('title', application('name')." | Assignment Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Assignment</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">{{ $assignment->title() }}</li>
                </ol>
            </div>
        </x-slot>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex">

                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="text-truncate font-size-15">Title: {{ $assignment->title() }}</h5>
                        </div>
                    </div>

                    <h5 class="font-size-15 mt-4">Details :</h5>

                    <p class="text-muted p-2">{!! $assignment->content !!}</p>
                    
                    <div class="row task-dates">
                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-calendar me-1 text-primary"></i> Created Date</h5>
                                <p class="text-muted mb-0">{{ $assignment->createdAt() }}</p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-user-check me-1 text-primary"></i> Assignment By</h5>
                                <p class="text-muted mb-0">{{ $assignment->author()->title() }}. {{ $assignment->author()->name() }}</p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-user-check me-1 text-primary"></i> Download</h5>
                                <a href="{{ route('assignment.download', $assignment->id()) }}" class="btn btn-sm btn-primary"><i class="bx bx-download"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('assignment_comment')
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Comments</h4>

                        <x-lesson.comments :lesson="$assignment" />
                    </div>
                </div>
            </div>
        @endcan
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
    @endsection

    </x-app-layout>
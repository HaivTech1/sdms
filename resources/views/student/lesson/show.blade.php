<x-app-layout>
    @section('title', application('name')." | Student Virtual Class")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Virtual Class</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $lesson->title() }}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <div class="card" style="width: 100%">
                        <figure id="videoContainer">
                            <video width="320" height="240" 
                                id="video"
                                controls 
                                preload="metadata"
                                {{-- poster="{{ asset('storage/'.$lesson->cover()) }}" --}}
                                >
                                <source src="{{ asset('storage/'.$lesson->path()) }}" type="{{ $lesson->type() }}">
                            </video> 
                            <ul id="video-controls" class="controls">
                                <li><button id="playpause" type="button"><i class="bx bx-play"></i>/<i class="bx bx-pause"></i></button></li>
                                <li><button id="stop" type="button"><i class="bx bx-stop"></i></button></li>
                                <li class="progress">
                                    <progress id="progress" value="0" min="0">
                                    <span id="progress-bar"></span>
                                    </progress>
                                </li>
                                <li><button id="mute" type="button"><i class="bx bx-volume-mute"></i></button></li>
                                <li><button id="volinc" type="button"><i class="bx bx-volume-full"></i></button></li>
                                <li><button id="voldec" type="button"><i class="bx bx-volume-low"></i></button></li>
                                <li><button id="fs" type="button"><i class="bx bx-fullscreen"></i></button></li>
                            </ul> 
                        </figure>
                    </div>

                    <div class="d-flex">
                        <div class="flex-shrink-0 me-4">
                            <img src="{{ asset('storage/'.$lesson->cover()) }}" alt="{{ $lesson->title() }}" class="avatar-sm">
                        </div>

                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="text-truncate font-size-15">{{ $lesson->title() }}</h5>
                            <p class="text-muted">{{ $lesson->excerpt() }}</p>
                        </div>
                    </div>

                    <h5 class="font-size-15 mt-4">Topic Details :</h5>

                    <p class="text-muted">{{ $lesson->description() }}</p>
                    
                    <div class="row task-dates">
                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-calendar me-1 text-primary"></i> Created Date</h5>
                                <p class="text-muted mb-0">{{ $lesson->createdAt() }}</p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-user-check me-1 text-primary"></i> Lesson By</h5>
                                <p class="text-muted mb-0">{{ $lesson->author()->title() }}. {{ $lesson->author()->name() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <iframe src="{{ asset('storage/'.$lesson->transcript()) }}#toolbar=0" height="300" style="border:none;"></iframe>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Comments</h4>

                    <x-lesson.comments :lesson="$lesson" />
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
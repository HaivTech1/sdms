<x-app-layout>
    @section('title', application('name')." | Virtual Class")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Virtual Class</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Teachers</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-lg-9">
                <div class="row">
                    @foreach ($lessons as $lesson)
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-4">
                                            <div class="avatar-md">
                                                <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                                                    <img src="{{ asset('storage/'.$lesson->cover()) }}" alt="{{ $lesson->title() }}" height="30" class="rounded-circle avatar-md">
                                                </span>
                                            </div>
                                        </div>
                                        

                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-truncate font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $lesson->title() }}</a></h5>
                                            <p class="text-muted mb-4">{{ $lesson->excerpt() }}</p>
                                            <div class="avatar-group">
                                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample{{ $lesson->id() }}"
                                                    aria-expanded="false" aria-controls="collapseWidthExample">
                                                    <i class="bx bx-video"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm deleteLesson" data-id="{{ $lesson->id() }}" type="button">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                                <div class="m-2">
                                                    @admin
                                                        <livewire:components.toggle-button :model='$lesson'
                                                            field='status' :key='$lesson->id()' />
                                                    @endadmin
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 border-top">
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item me-3">
                                            @if ($lesson->status === true)
                                                <span class="badge bg-success">{{ $lesson->verify_badge }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ $lesson->verify_badge }}</span>
                                            @endif
                                        </li>
                                        <li class="list-inline-item me-3">
                                            <i class= "bx bx-calendar me-1"></i> {{ $lesson->createdAt() }}
                                        </li>
                                        <li class="list-inline-item me-3">
                                            <i class= "bx bxs-show me-1"></i> {{ views($lesson)->count(); }}
                                        </li>
                                        @admin
                                            @if ($lesson->transcript())
                                                <li class="list-inline-item me-3 btn btn-sm btn-primary" title="Click to download file">
                                                    <a href="{{ route('lesson.download', $lesson->id()) }}"><i class= "bx bx-file"></i> <i class="bx bx-download"></i></a>
                                                </li>
                                            @endif
                                        @endadmin
                                    </ul>
                                    <div>
                                        <div class="collapse collapse-horizontal" id="collapseWidthExample{{ $lesson->id() }}">
                                            <div class="card" style="width: 300px;">
                                                <figure id="videoContainer">
                                                    <video width="320" height="240" 
                                                        id="video"
                                                        controls 
                                                        preload="metadata"
                                                        poster="{{ asset('storage/'.$lesson->cover()) }}"
                                                        >
                                                        <source src="{{ asset('storage/'.$lesson->path()) }}" type="{{ $lesson->type() }}">
                                                    </video> 
                                                    <ul id="video-controls" class="controls">
                                                        <li><button id="playpause" type="button"><i class="bx bx-play"></i></button></li>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                    {{ $lessons->links('pagination::custom-pagination')}}
            </div>
            <div class="col-lg-3">
                <form action="{{ route('lesson.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <h1 class="mb-2">Create a new virtual lesson</h1>
                    <div class="col-sm-12 mb-3">
                        <x-form.label for="title" value="{{ __('Title') }}" />
                        <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                            :value="old('title')" id="title" autofocus />
                        <x-form.error for="title" />
                    </div>
                    <div class="col-sm-12 mb-3">
                        <x-form.label for="description" value="{{ __('Description') }}" />
                        <x-form.input id="description" class="block w-full mt-1" type="text" name="description"
                            :value="old('description')" id="description" autofocus />
                        <x-form.error for="description" />
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
                    <div class="col-md-12 mb-3">
                        <x-form.label for="cover" value="{{ __('Select cover') }}" />
                        <input type="file" name="cover" class="form-control"/>
                        <x-form.error for="cover" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <x-form.label for="transcript" value="{{ __('Select transcript') }}" />
                        <input type="file" name="transcript" class="form-control"/>
                        <x-form.error for="transcript" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <x-form.label for="video" value="{{ __('Select Video') }}" />
                        <input type="file" name="video" class="form-control"/>
                        <x-form.error for="video" />
                    </div>
                    <div class="col-md-6 form-group">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                  </div>
               </form>
            </div>
        </div>
    </div>
</x-app-layout>
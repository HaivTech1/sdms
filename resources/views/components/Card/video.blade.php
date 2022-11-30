<div class="col-xl-6 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-shrink-0 me-4">
                    <div class="avatar-md">
                        <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                            <img src="{{ asset('storage/'.$model->cover()) }}" alt="{{ $model->title() }}" height="30" class="rounded-circle avatar-md">
                        </span>
                    </div>
                </div>
                

                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-truncate font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $model->title() }}</a></h5>
                    <p class="text-muted mb-4">{{ $model->excerpt() }}</p>
                    <div class="avatar-group">
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample{{ $model->id() }}"
                            aria-expanded="false" aria-controls="collapseWidthExample">
                            <i class="bx bx-video"></i>
                        </button>
                        <button class="btn btn-danger btn-sm deletemodel" data-id="{{ $model->id() }}" type="button">
                            <i class="bx bx-trash"></i>
                        </button>
                        <div class="m-2">
                            @admin
                                <livewire:components.toggle-button :model='$model'
                                    field='status' :key='$model->id()' />
                            @endadmin
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 border-top">
            <ul class="list-inline mb-0">
                <li class="list-inline-item me-3">
                    @if ($model->status === true)
                        <span class="badge bg-success">{{ $model->verify_badge }}</span>
                    @else
                        <span class="badge bg-warning">{{ $model->verify_badge }}</span>
                    @endif
                </li>
                <li class="list-inline-item me-3">
                    <i class= "bx bx-calendar me-1"></i> {{ $model->createdAt() }}
                </li>
                <li class="list-inline-item me-3">
                    <i class= "bx bxs-show me-1"></i> {{ views($model)->count(); }}
                </li>
                @admin
                    @if ($model->transcript())
                        <li class="list-inline-item me-3 btn btn-sm btn-primary" title="Click to download file">
                            <a href="{{ route('model.download', $model->id()) }}"><i class= "bx bx-file"></i> <i class="bx bx-download"></i></a>
                        </li>
                    @endif
                @endadmin
            </ul>
            {{-- poster="{{ asset('storage/'.$model->cover()) }}" --}}
            <div>
                <div class="collapse collapse-horizontal" id="collapseWidthExample{{ $model->id() }}">
                    <div class="card border shadow-none card-body text-muted mb-0" style="width: 300px;">
                        <div class="video-controls" id="video-controls">
                            <video width="320" height="240"
                                    src="{{ URL::asset('storage/'. $model->video() )}}" 
                                    type="{{ $model->type() }}" 
                                    class="video" 
                                    id="video">
                            </video> 
                            <div class="controls">
                                <div class="orange-bar">
                                    <div class="orange-juice"></div>
                                </div>
                                <div class="buttons">
                                    <button id="play-pause"></button>
                                    <button id="stop"><i class="fa fa-stop"></i></button>
                                    <button id="mute"><i class="fa fa-volume-off"></i></button>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
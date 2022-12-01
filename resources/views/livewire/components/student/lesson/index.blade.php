 <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-search />
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-control select2" wire:model.debounce.350ms="grade">
                                                <option value=''>Select Grade</option>
                                                @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="form-control select2" wire:model.debounce.350ms="subject">
                                                <option value=''>Select subject</option>
                                                @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-12">
                            <div class="row">
                                @foreach ($lessons as $lesson)
                                    <div class="col-xl-4 col-sm-4">
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
                                                            <a href="{{ route('lesson.show', $lesson->id()) }}"  class="btn btn-primary btn-sm">
                                                                <i class= "bx bxs-show me-1"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-4 py-3 border-top">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-3">
                                                        <i class= "bx bx-calendar me-1"></i> {{ $lesson->createdAt() }}
                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        <i class= "bx bxs-show me-1"></i> {{ views($lesson)->count() }}
                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        <i class= "bx bxs-comment me-1"></i> {{ $lesson->comments()->count() }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{ $lessons->links('pagination::custom-pagination')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Post</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $post->title()}}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="pt-3">
                        <div class="row justify-content-center">
                            <div class="col-xl-8">
                                <div>
                                    <div class="text-center">
                                        <div class="mb-4">
                                            <a href="javascript: void(0);" class="badge bg-light font-size-12">
                                                <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i>
                                                {{ $post->type() }}
                                            </a>
                                        </div>
                                        <h4>{{ $post->title() }}</h4>
                                        <p class="text-muted mb-4"><i class="mdi mdi-calendar me-1"></i>
                                            {{ $post->created_date }}
                                        </p>
                                    </div>

                                    <hr>
                                    <div class="text-center">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div>
                                                    <p class="text-muted mb-2">Post id</p>
                                                    <h5 class="font-size-15">{{ $post->id() }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mt-4 mt-sm-0">
                                                    <p class="text-muted mb-2">Publication Date</p>
                                                    <h5 class="font-size-15">{{ $post->publishedAt() }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mt-4 mt-sm-0">
                                                    <p class="text-muted mb-2">Post by</p>
                                                    <h5 class="font-size-15">{{ $post->author()->name()}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="my-5">
                                        <img src="{{ asset('storage/'. $post->image()) }}" alt="{{ $post->title() }}"
                                            class="img-thumbnail mx-auto d-block">
                                    </div>

                                    <hr>
                                    <div class="text-center">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div>
                                                    <p class="text-muted mb-2">Image Credit Link</p>
                                                    <h5 class="font-size-15">{{ $post->PhotoCreditText()}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mt-4 mt-sm-0">
                                                    <p class="text-muted mb-2">Image Credit Link</p>
                                                    <h5 class="font-size-15">{{ $post->PhotoCreditLink()}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mt-4 mt-sm-0">
                                                    <p class="text-muted mb-2">Post by</p>
                                                    <h5 class="font-size-15">Gilbert Smith</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="mt-4">
                                        <div class="text-muted font-size-14">
                                            <p>{!! $post->description() !!}</p>

                                            <div class="mt-4">
                                                <h5 class="mb-3">Tag: </h5>

                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-sm-6">
                                                            <div>
                                                                <ul class="ps-4">
                                                                    @foreach($post->tags() as $tag)
                                                                    <li class="py-1">{{ $tag->name}}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>

</x-app-layout>
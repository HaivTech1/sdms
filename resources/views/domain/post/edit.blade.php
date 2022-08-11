<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Posts</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">
                    {{ $post->title()}}
                </li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>

                    <form action="{{ route('post.update',$post) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="title" value="{{ __('Post Title') }}" />
                                        <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                            id="title" placeholder="Post Title" :value="old('title', $post->title())"
                                            autofocus />
                                        <x-form.error for="title" />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="published_at" value="{{ __('Published At') }}" />
                                        <div class="docs-datepicker">
                                            <div class="input-group">
                                                <input type="date" class="form-control docs-date" name="published_at"
                                                    placeholder="Pick a publication date" autocomplete="off"
                                                    value="{{ $post->publishedAt() }}">
                                                <button type="button" class="btn btn-secondary docs-datepicker-trigger"
                                                    disabled>
                                                    <i class="mdi mdi-calendar" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class="docs-datepicker-container"></div>
                                        </div>
                                        <x-form.error for="published_at" />
                                    </div>



                                    {{-- Type --}}
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="type" value="{{ __('Type') }}" />
                                        <select class="form-control select2" name="type">
                                            <option>Select Types</option>
                                            <optgroup label="Post Type">
                                                <option value="standard" @if($post->type() === 'standard') selected
                                                    @endif>Standard</option>
                                                <option value="premium" @if($post->type() === 'premium') selected
                                                    @endif>Premium</option>
                                            </optgroup>
                                        </select>
                                    </div>

                                    {{-- Tags --}}
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="tags" value="{{ __('Tags') }}" />
                                        <select class="form-control select2  select2-multiple" name="tags[]"
                                            multiple="multiple" data-placeholder="Choose ...">
                                            <option>Select Tags</option>
                                            <optgroup label="Post Type">
                                                @foreach ($tags as $id => $tag)
                                                <option value="{{ $tag->id() }}" @if(in_array($tag->id(),
                                                    $selectedTags))
                                                    selected
                                                    @endif>{{ $tag->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>

                                    {{-- Photo credit text --}}
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="photo_credit_text" value="{{ __('Photo credit text') }}" />
                                        <x-form.input name="photo_credit_text" id="photo_credit_text"
                                            class="block w-full mt-1" type="text"
                                            :value="old('photo_credit_text', $post->photoCreditText())" />
                                        <x-form.error for="photo_credit_text" />
                                    </div>

                                    {{-- Photo Credit link --}}
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="photo_credit_link" value="{{ __('Photo credit link') }}" />
                                        <x-form.input name="photo_credit_link" id="photo_credit_link"
                                            class="block w-full mt-1" type="text"
                                            :value="old('photo_credit_link', $post->photoCreditLink())" />
                                        <x-form.error for="photo_credit_link" />
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12">

                                <div class="mb-3">
                                    <x-form.label for="Postdesc" value="{{ __('Post Description') }}" />
                                    <textarea class="form-control" id="Postdesc" rows="5" name="description"
                                        value="old('description')"
                                        placeholder="Post Description">{{ $post->description() }}</textarea>
                                </div>

                            </div>

                            <div class="col-sm-6 mt-3">
                                <h3>Media</h3>

                                <div class="mb-3">
                                    <x-form.label for="image" value="{{ __('Post Images') }}" />
                                    <x-form.input id="image" class="block w-full mt-1" placeholder="image" type="file"
                                        name="image" />
                                    <x-form.error for="image" />
                                </div>

                            </div>

                            {{-- Disable Comments --}}
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <span class="text-bold font-semibold text-primary uppercase p-2">Disable
                                    Comments</span>
                                <input type="checkbox" id="switch1" switch="none" checked value="1"
                                    name="is_commentable" @if(!$post->isCommentable())checked
                                @endif/>
                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>

                                <x-form.error for="is_commentable" />
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit"
                                class="btn btn-primary block waves-effect waves-light pull-right">Update
                                Post</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
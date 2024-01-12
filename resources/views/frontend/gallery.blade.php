<x-base-layout>
    <x-slot name="header">
        <p>{{ $title }}</p>
    </x-slot>

    <div class="rs-gallery pt-100 pb-100 md-pt-70 md-pb-70">
        <div class="container">
            <div class="row">
                @if(count($images) > 0)
                    @foreach($images as $image)
                        <div class="col-lg-4 mb-30 col-md-6">
                            <div class="gallery-item">
                                <div class="gallery-img">
                                    <a class="image-popup" href="{{ asset($image->image()) }}"><img src="{{ asset($image->image()) }}" alt="{{ $image->title() }}"></a>
                                </div>
                                @if($image->title)
                                    <div class="title">
                                        {{ $image->title() }}
                                    </div>
                                @endif
                            </div>
                        </div> 
                    @endforeach
                @else
                    <div style="display: flex; justify-content: center">
                        <p style="text-align: center">No image in the gallery</p>
                    </div> 
                @endif
            </div>
        </div> 
    </div>
</x-base-layout>
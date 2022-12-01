<div class="">
    @foreach ($comments as $comment)
        @php
            $depth = ($comment->depth * 8)
        @endphp

        @if($comment->depth > 0 )ml-{{ $depth }}@endif

        <div class="d-flex py-3">
            <div class="flex-shrink-0 me-3">
                <div class="avatar-xs">
                    <img src="{{ asset('storage/'. $comment->author()->image())}}" alt="" class="img-fluid d-block rounded-circle">
                </div>
            </div>
            <div class="flex-grow-1">
                <h5 class="font-size-14 mb-1">{{ $comment->author()->name() }} <small class="text-muted float-end">{{ $comment->created_at->format('d, M,y')}}</small></h5>
                <p class="text-muted">{{ $comment->body() }}</p>
                <div>
                    {{-- Reply --}}
                    <div class="">
                        @if(!$comment->depth())
                        <x-lesson.reply :comment="$comment" :lesson="$lesson" :loop="$loop->depth" />
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($comment->replies())
        <x-lesson.replies :comments="$comment->replies()" :lesson=$lesson />
        @endif
    @endforeach
<div>
<div class="d-flex py-3 border-bottom">
    @foreach($reviews as $review)
    <div class="flex-shrink-0 me-3">
        <img src="assets/images/users/avatar-2.jpg" class="avatar-xs rounded-circle" alt="img" />
    </div>

    <div class="flex-grow-1">
        <h5 class="mb-1 font-size-15">{{ $review->author()->name() }}</h5>
        <p class="text-muted">{{ $review->message }}</p>
        <ul class="list-inline float-sm-end mb-sm-0">
            <li class="list-inline-item">
                <a href="javascript: void(0);"><i class="far fa-thumbs-up me-1"></i> Publish</a>
            </li>
            <li class="list-inline-item">
                <a href="javascript: void(0);"><i class="far fa-comment-dots me-1"></i>
                    Delete</a>
            </li>
        </ul>
        <div class="text-muted font-size-12"><i class="far fa-calendar-alt text-primary me-1"></i>
            {{ $review->created_at->diffForHumans() }}</div>
    </div>
    @endforeach
</div>
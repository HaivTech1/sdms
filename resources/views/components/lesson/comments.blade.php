<div class="space-y-6">

    <div class="border-b-2 border-theme-blue-100">
        <h2 class="badge badge-soft-primary">
            leave a comment
        </h2>
    </div>
    

    <section class="flex flex-col gap-4 p-2">
        <x-lesson.replies :comments="$lesson->comments()" :lesson="$lesson" />
    </section>

    <div class="">
        <form action="{{ route('comments.store') }}" class="space-y-4" method="POST">
            @csrf
            <x-form.textarea name="body" placeholder="Leave a comment here...">
                {{ old('body') }}
            </x-form.textarea>

            <x-form.error for="body" />
            <input type="hidden" name="commentable_id" value="{{ $lesson->id() }}">
            <input type="hidden" name="commentable_type" value="lessons">
            <input type="hidden" name="depth" value="0">

            <x-buttons.default>
                Submit
            </x-buttons.default>
        </form>
    </div>

</div>

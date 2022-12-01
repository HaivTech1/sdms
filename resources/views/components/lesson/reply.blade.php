<div x-data="{ show: false }">
    @if(!$comment->maximumReplies())
    <button class="text-sm font-semibold text-blue-500 uppercase" @click="show = !show" :aria-expanded="show ? 'true' : 'false'" :class="{ 'active': show }">
        Reply
    </button>
    @else
    <h2 class="text-sm text-theme-blue-100">
        Maximum replies reached for this comment
    </h2>
    @endif
    <div x-show="show">
        <form action="{{ route('comments.store') }}" class="space-y-4" method="POST">
            @csrf
            <x-form.textarea name="body" class="" placeholder="Leave a reply here...">
                {{ old('body') }}
            </x-form.textarea>
            <x-form.error for="body" />

            <input type="hidden" name="commentable_id" value="{{ $lesson->id() }}">
            <input type="hidden" name="commentable_type" value="lessons">
            <input type="hidden" name="parent_id" value="{{ $comment->id() }}">
            <input type="hidden" name="depth" value="{{ $loop }}">


            <x-buttons.default>
                Submit
            </x-buttons.default>
        </form>
    </div>
</div>

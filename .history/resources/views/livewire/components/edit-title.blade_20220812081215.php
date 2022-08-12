<div x-data="
    {
        isEditing: false,
        isTitle: '{{ $isTitle }}',
        focus: function() {
            const textInput = this.$refs.textInput;
            textInput.focus();
            textInput.select();
        }
    }
    "
    x-cloak
>
    <div x-show=!isEditing class="p-2" style="cursor: pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to edit score">
        <span
            x-bind:class="{ 'font-bold': isTitle }"
            x-on:click="isEditing = true; $nextTick(() => focus())"
        >
            @if ($origTitle)
                {{ $origTitle }}
            @else
                0
            @endif
            
        </span>
    </div>
    <div x-show=isEditing class="flex flex-col">
        <form class="flex" wire:submit.prevent="save">
            <x-form.input
                type="text"
              placeholder="100 characters max."
                x-ref="textInput"
                wire:model.lazy="newTitle"
                x-on:keydown.enter="isEditing = false"
                x-on:keydown.escape="isEditing = false"
            />
            <button type="button" class="px-1 ml-2 text-3xl" title="Cancel" x-on:click="isEditing = false">X</button>
            <button
                type="submit"
                class="px-1 ml-1 text-3xl font-bold text-success"
                title="Save"
                x-on:click="isEditing = false"
            >✓</button>
        </form>
        <small class="text-xs">Enter to save, Esc to cancel</small>
    </div>
</div>

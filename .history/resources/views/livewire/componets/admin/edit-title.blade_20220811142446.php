<div x-data="
    {
        isEditing: false,
        isName: '{{ $isName }}',
        focus: function() {
            const textInput = this.$refs.textInput;
            textInput.focus();
            textInput.select();
        }
    }
    "
    x-cloak
>
<div x-show=!isEditing class="p-2">
    <span
        x-bind:class="{ 'font-bold': isName }"
        x-on:click="isEditing = true; $nextTick(() => focus())"
    >
        {{ $origTitle }}
    </span>
</div>
</div>

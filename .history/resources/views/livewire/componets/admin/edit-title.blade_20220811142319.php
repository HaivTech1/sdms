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
x-cloak>
<div class="p-2">
    {{ $origTitle }}
</div>
</div>

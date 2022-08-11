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

</div>
<div class="p-2">
    {{ $origTitle }}
</div>
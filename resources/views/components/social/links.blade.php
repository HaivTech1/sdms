<div class="footer_social" style="display: flex; flex-wrap: wrap; justify-content: space-evenly">

    {{-- Facebook --}}
    <x-buttons.social href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank">
        <x-css-facebook class="w-5 h-5" />
    </x-buttons.social>

    {{-- Twitter --}}
    <x-buttons.social href="https://twitter.com/intent/tweet?url={{ $url }}text={{ $application->name() }}" target="_blank">
        <x-css-twitter class="w-5 h-5" />
    </x-buttons.social>

    {{-- Whatsapp --}}
    <x-buttons.social href="https://wa.me/?text={{ $application->name() }} {{ $url }}" target="_blank">
        <x-bi-whatsapp  class="w-5 h-5" />
    </x-buttons.social>

    {{-- Telegram --}}
    <x-buttons.social href="https://telegram.me/share/url?url={{ $url }}&text={{ $application->name() }}" target="_blank">
        <x-bi-telegram class="w-5 h-5" />
    </x-buttons.social>

</div>

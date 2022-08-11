<x-app-layout>
@section('title', application('name')." | Session Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Session</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.admin.period />
</x-app-layout>
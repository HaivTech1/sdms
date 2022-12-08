<x-app-layout>
@section('title', application('name')." | Club Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Club</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.admin.club />
</x-app-layout>
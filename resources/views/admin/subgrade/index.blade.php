<x-app-layout>
@section('title', application('name')." | Class Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Sub Grade</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.admin.sub-grade />
</x-app-layout>
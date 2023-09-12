<x-app-layout>
    @section('title', application('name')." | School bus service")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">School bus service</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Home</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.student.trip.index>
</x-app-layout>
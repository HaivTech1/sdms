<x-app-layout>
    @section('title', application('name')." | Pin Code")

    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Pin codes</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Pins</li>
            </ol>
        </div>
    </x-slot>

    
    <livewire:manager.pins>
</x-app-layout>
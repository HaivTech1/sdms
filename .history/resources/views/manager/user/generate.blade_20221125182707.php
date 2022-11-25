<x-app-layout>
    @section('title', application('name')." | Pin Code")

    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Pin code</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Generate Pincode</li>
            </ol>
        </div>
    </x-slot>

    <livewire:manager.generate />
</x-app-layout>
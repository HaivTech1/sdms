<x-app-layout>
    @section('title', "Check Result Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Mid Term Result</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Result</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.admin.result.check-midterm />
</x-app-layout>
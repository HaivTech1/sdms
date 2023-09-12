<x-app-layout>
    @section('title', "Check General Result")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">General Results</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Result</li>
            </ol>
        </div>
    </x-slot>
    
    <livewire:components.admin.result.general-primary />
</x-app-layout>
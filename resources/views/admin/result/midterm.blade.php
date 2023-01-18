<x-app-layout>
    @section('title', application('name')." | Result Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Mid-Term Result</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Mid-Term Result Upload</li>
                </ol>
            </div>
        </x-slot>
    
        <livewire:components.admin.result.midterm-upload />
    </x-app-layout>
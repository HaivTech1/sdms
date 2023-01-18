<x-app-layout>
    @section('title', application('name')." | Result Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Mid-Term Results</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </x-slot>

        <livewire:components.student.result.midterm user="{{ $user->id }}">
    </x-app-layout>
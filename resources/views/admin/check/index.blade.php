<x-app-layout>
    @section('title', application('name')." | Schedule Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Mark Attendance</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Check</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.teacher.attendance>
    
</x-app-layout>

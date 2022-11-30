<x-app-layout>
    @section('title', application('name')." | Student Virtual Class")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Virtual Class</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Student</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.student.lesson.index>
</x-app-layout>
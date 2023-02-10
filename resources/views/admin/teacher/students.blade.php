<x-app-layout>
    @section('title', application('name')." | Teachers Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Students</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">List of students</li>
                </ol>
            </div>
        </x-slot>
    
        <livewire:components.teacher.students />
    </x-app-layout>
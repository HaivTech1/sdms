<x-app-layout>
    @section('title', application('name')." | Result Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">School Calendar</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Generate calendar</li>
                </ol>
            </div>
        </x-slot>

        <livewire:components.admin.staff.calendar>
    </x-app-layout>
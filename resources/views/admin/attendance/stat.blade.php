<x-app-layout>
    @section('title', application('name')." | Attendance Stat Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Attendance</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Stat</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.admin.attendance.stat />
</x-app-layout>

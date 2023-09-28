<x-app-layout>
    @section('styles')
        <link href="{{ asset('libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />
    @endsection

    @section('title', application('name')." | Class Broadsheet")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Broadsheet</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Class</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.admin.result.broadsheet.grade>
</x-app-layout>
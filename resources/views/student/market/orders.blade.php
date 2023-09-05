<x-app-layout>
    @section('title', application('name')." | Orders")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Orders</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">all</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.student.market.order.index>
</x-app-layout>
<x-app-layout>
    @section('title', application('name')." | Cart")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Market place</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Cart</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.student.cart>
</x-app-layout>
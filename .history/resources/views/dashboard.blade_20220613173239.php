<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-4">
            <x-card.details />
        </div>

        <div class="col-xl-8">
            <livewire:components.dashboard />
            <div class="card">
                <div class="card-body">
                    @writer
                    <livewire:components.domain.category />
                    @endwriter
                    @agent
                    <livewire:components.housing.category />
                    @endagent
                </div>
            </div>
        </div> <!-- end row -->
    </div>
</x-app-layout>
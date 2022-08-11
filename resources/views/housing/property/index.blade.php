<x-app-layout>
    @section('title', application('name')." | Properties Page")

    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Property</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-4">
            <x-card.details :categories="$categories" :properties="$properties->count()" />
            <livewire:components.housing.category :wire:key="$properties->count()" />
        </div>

        <div class="col-xl-8">
            <div class="">
                <div class="table-responsive">
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 100px">#</th>
                                <th scope="col">Price</th>
                                <th scope="col">Name</th>
                                <th scope="col">Uploaded Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($properties as $key => $property)
                            <tr>
                                <td>
                                    <div class="avatar-group">
                                        @foreach($property->image() as $index => $image)
                                        <div class="avatar-group-item">
                                            <a href="javascript: void(0);" class="d-inline-block">
                                                <img src="{{ asset('storage/properties/'.$image[$index]) }}" alt="" class="rounded-circle avatar-xs">
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td><span class="badge bg-success">{{ trans('global.naira')}}
                                        {{ $property->price() }}</span></td>
                                <td>
                                    <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{ $property->title() }}</a></h5>
                                    <p class="text-muted mb-0">{{ $property->excerpt(50) }}</p>
                                </td>
                                <td>{{ $property->createdAt() }}</td>
                                <td>
                                    @if ($property->isVerified == true)
                                    <span class="badge bg-success">
                                        {{ $property->verify_badge }}
                                    </span>
                                    @else
                                    <span class="badge bg-warning">
                                        {{ $property->verify_badge }}
                                    </span>
                                    @endif

                                </td>
                                <td>
                                    <livewire:components.general-action :model="$property" :wire:key="$property->id()">
                                        <a class="dropdown-item" href="{{ route('property.show', $property) }}"><i class="fa fa-eye"></i></a>
                                        <a class="dropdown-item" href="{{ route('property.edit', $property) }}"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="hstack gap-3">
                    {{ $properties->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    @section('title', application('name')." | Finger Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Fingerprint Device</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">List</li>
            </ol>
        </div>
    </x-slot>

        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('finger_device.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.finger_device.title_singular') }}
                </a>

                <a class="btn btn-primary"
                   href="{{ route('finger_device.clear.attendance') }}">
                    <i class="fas fa-cog"></i>
                    Clear device attendance
                </a>
            </div>
        </div>

     <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                        <tr>
                                            <th data-priority="1"> {{ trans('cruds.finger_device.fields.id') }}</th>
                                            <th data-priority="3">{{ trans('cruds.finger_device.fields.name') }}</th>
                                            <th data-priority="4">{{ trans('cruds.finger_device.fields.ip') }}</th>
                                            <th data-priority="6"> {{ trans('cruds.finger_device.fields.serialNumber') }}</th>
                                            <th data-priority="7">Status</th>
                                            <th data-priority="7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($devices as $key => $device)

                                        <tr data-entry-id="{{ $finger_device->id }}">

                                            <td>{{ $finger_device->id ?? '' }}</td>
                                            <td>{{ $finger_device->name ?? '' }}</td>
                                            <td>{{ $finger_device->ip ?? '' }}</td>
                                            <td> {{ $finger_device->serialNumber ?? '' }}</td>
                                            <td>
                                                @php
                                                    $device = $helper->init($finger_device->ip);
                                                @endphp

                                                @if($helper->getStatus($device))
                                                    <div class="badge badge-success">
                                                        Active
                                                    </div>
                                                @else
                                                    <div class="badge badge-danger">
                                                        Deactivate
                                                    </div>
                                                @endif

                                                <a class="btn btn-xs btn-outline-success"
                                                    href="{{ route('finger_device.add.employee', $finger_device->id) }}">
                                                    <i class="fas fa-plus"></i>
                                                    Add Employee
                                                </a>
                                                
                                                <a class="btn btn-xs btn-outline-success"
                                                    href="{{ route('finger_device.get.attendance', $finger_device->id) }}">
                                                    <i class="fas fa-plus"></i>
                                                    Get Attendance
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-xs btn-primary"
                                                    href="{{ route('finger_device.show', $finger_device->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                                <a class="btn btn-xs btn-info"
                                                    href="{{ route('finger_device.edit', $finger_device->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>

                                                <form action="{{ route('finger_device.destroy', $finger_device->id) }}" method="POST"
                                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                    style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            </td>
                                        </tr>

                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>

</x-app-layout>
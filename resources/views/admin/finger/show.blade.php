<x-app-layout>
    @section('title', application('name')." | Finger Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">{{ trans('global.show') }} {{ trans('cruds.finger_device.title') }}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $fingerDevice->name }}</li>
            </ol>
        </div>
    </x-slot>

    <div class="card">

        <div class="card-header">

            {{ trans('global.show') }} {{ trans('cruds.finger_device.title') }}

        </div>

        <div class="card-body">

            <div class="form-group">

                <div class="form-group">

                    <a class="btn btn-primary" href="{{ route('finger_device.index') }}">

                        {{ trans('global.back_to_list') }}

                    </a>

                </div>

                <table class="table table-bordered table-striped">

                    <tbody>

                        <tr>

                            <th>

                                {{ trans('cruds.finger_device.fields.id') }}

                            </th>

                            <td>

                                {{ $fingerDevice->id }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                {{ trans('cruds.finger_device.fields.name') }}

                            </th>

                            <td>

                                {{ $fingerDevice->name }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                {{ trans('cruds.finger_device.fields.ip') }}

                            </th>

                            <td>

                                {{ $fingerDevice->ip }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                {{ trans('cruds.finger_device.fields.serialNumber') }}

                            </th>

                            <td>

                                {{ $fingerDevice->serialNumber }}

                            </td>

                        </tr>

                    </tbody>

                </table>



            </div>

        </div>

    </div>

</x-app-layout>
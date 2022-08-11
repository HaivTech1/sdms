<x-app-layout>
    @section('title', application('name') . ' | Student Page')

    @push('styles')
        <style>
            .parent {
                display: flex;
                justify-content: space-between;
            }
        </style>
    @endpush
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Student</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Show | {{ $student->firstName()}}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                            <a href="javascript: void(0);" class="btn btn-primary w-md waves-effect waves-light">Send</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

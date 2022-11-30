<x-app-layout>
    @section('title', application('name')." | Result Page")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Results</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </x-slot>

        <livewire:components.student.result.index user="{{ $user->id }}">

        {{-- @section('scripts')
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#fetchResult').on('submit', function() {
                        var data = $('#fetchResult').serializeArray();

                        $.ajax({
                            method: 'GET',
                            url:'',
                            dataType:'json',
                            data,
                        }).then((response) => {
                            toastr.success(response);
                        }).then((error) => {
                            toastr.error(error);
                        });
                    });
                });
            </script>
        @endsection --}}
    </x-app-layout>
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
    
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="fetchResult" class="repeater" enctype="multipart/form-data">
                            <input type="hidden" value="{{ $user->student->grade_id }}" name="grade_id" />
                            <div data-repeater-list="group-a">
                                <div data-repeater-item class="row">
                                    <div  class="mb-3 col-lg-5">
                                        <label for="name">Session</label>
                                        <select id="formrow-inputState" class="form-select" name="period_id">
                                            <option selected>Choose...</option>
                                            @foreach ($periods as $id => $period)
                                                <option value="{{ $id }}">{{ $period }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div  class="mb-3 col-lg-5">
                                        <label for="email">Term</label>
                                        <select id="formrow-inputState" class="form-select" name="term_id">
                                            <option selected>Choose...</option>
                                            @foreach ($terms as $id => $term)
                                                <option value="{{ $id }}">{{ $term }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-2 align-self-center">
                                        <div class="d-grid">
                                            <button data-repeater-delete type="submit" class="btn btn-primary">
                                            <i class="bx bx-download"></i>
                                                Fetch
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @section('scripts')
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
        @endsection
    </x-app-layout>
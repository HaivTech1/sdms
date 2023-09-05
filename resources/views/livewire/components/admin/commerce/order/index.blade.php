<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-search />
                                </div>

                                <div class="col-lg-8">
                                    <div class="btn-group btn-group-example mb-3" role="group">
                                        {{-- <form action="{{ route('admin.export-orders') }}" method="POST" target="_blank">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success w-sm"><i class="bx bx-download"></i> Excel</button>
                                        </form>

                                        <form action="{{ route('admin.view-pdf') }}" method="POST" target="_blank">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-warning w-sm"><i class="bx bxs-file-pdf"></i> PDF</button>
                                        </form>
                                        
                                        <form action="{{ route('admin.download-pdf') }}" method="POST" target="_blank">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary w-sm"><i class="bx bx-download"></i> PDF</button>
                                        </form> --}}
                                    </div>
                                    <div class="row">
                                        @if($selectedRows)
                                            <div class="col-6">
                                                <div class="btn-group btn-group-example mb-3" role="group">
                                                    <button wire:click.prevent="markAllAsAvailable" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-check-double"></i>
                                                        Available
                                                    </button>
                                                    <button wire:click.prevent="markAllAsUnavailable" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-x-circle"></i>
                                                        Unavailable
                                                    </button>
                                                    <button wire:click.prevent="deleteAll" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-block"></i>
                                                        Delete All
                                                    </button>
                                                    <button wire:click.prevent="markAllAsVerified" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-check-double"></i>
                                                        Verified
                                                    </button>
                                                    <button wire:click.prevent="markAllAsUnverified" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-x-circle"></i>
                                                        Unverified
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20px;" class="align-middle">
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                wire:model="selectPageRows">
                                            <label class="form-check-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th class="align-middle">Student</th>
                                    <th class="align-middle">Amount</th>
                                    <th class="align-middle">Products</th>
                                    <th class="align-middle">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" value="{{ $order->id() }}" type="checkbox"
                                                    id="{{ $order->id() }}" wire:model="selectedRows">
                                                <label class="form-check-label" for="{{ $order->id() }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $order->student->student->lastName() }} {{ $order->student->student->firstName() }}</td>
                                        <td>{{ trans('global.naira') }}{{ number_format($order->paid(), 2) }}</td>
                                        <td>{{ count($order->items) }}</td>
                                        <td>
                                            {{  $order->order_status  }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <button 
                                                        wire:click="getOrderDetails({{ $order->id() }})"
                                                        class="dropdown-item"
                                                        data-id="{{ $order->id() }}"
                                                    >
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button 
                                                class="btn btn-sm btn-primary viewOrder"
                                                data-id="{{ $order->id() }}"
                                            >
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>
    </div>

     <div class="modal fade showOrder" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Ordered courses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 mb-2">
                        <div class="table-responsive">
                            <table id="courses-list" class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
        <script>
            $('.viewOrder').on('click', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                
                {{-- $.ajax({
                    url: '{{ route("admin.course.list.enrolled", ["id" => ":id"]) }}'.replace(':id', id),
                    type: 'GET',
                    success: function(data) {
                        var courses = data.courses;

                        var html = '';
                        $.each(courses, function(index, course) {
                            html += '<tr>';
                            html += '<td>' + course.title + '</td>';
                            html += '<td>' + course.price + '</td>';
                            html += '</tr>';
                        });

                        $('#courses-list tbody').html(html);
                        $('.showOrder').modal('toggle');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                }); --}}
            });
        </script>
    @endsection
</div>

<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-search />
                                </div>
                            </div>
                        </div>

                        <div class=" col-sm-4">
                            <div class="text-sm-end">
                                <a href="{{ route('contest.create') }}"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Add Contest</a>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle"></th>
                                    <th class="align-middle">contest Title</th>
                                    <th class="align-middle">contest Theme</th>
                                    <th class="align-middle"></th>
                                    <th class="align-middle">Contestants</th>
                                    <th class="align-middle">Verification Status</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contests as $key => $contest)
                                <tr>
                                    <td>
                                        <a href="javascript: void(0);" class="text-body fw-bold">{{ $key+1 }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);"
                                            class="text-body fw-bold">{{ $contest->title() }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);"
                                            class="text-body fw-bold">{{ $contest->theme() }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);"
                                            class="text-body fw-bold">{{ $contest->startDate() }}
                                            - {{ $contest->endDate() }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);"
                                            class="text-body fw-bold">{{ $contest->contestants()->count() }}</a>
                                    </td>
                                    <td>

                                        @if ($contest->available_badge == 'Not Active' )
                                        <span class="badge badge-pill badge-soft-danger font-size-12">
                                            {{ $contest->available_badge }}</span>
                                        @else
                                        <span class="badge badge-pill badge-soft-success font-size-12">
                                            {{ $contest->available_badge }}</span>
                                        @endif

                                    </td>

                                    <td>
                                        @livewire('components.toggle-button', [
                                        'model' => $contest,
                                        'field' => 'isAvailable'
                                        ])
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $contests->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>
<x-app-layout>
    @section('title', application('name')." | $title")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">{{ $description}}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <div class="row mt-2 mb-2">
        <div class="col-sm-4">
            <div class="search-box me-2 mb-2 d-inline-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search..." id="input-search">
                    <i class="bx bx-search-alt search-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class='row'>
          <div class='col-sm-12'>
            <div class="table-responsive">
                <table class="table align-middle table-nowrap table-check search-table">
                    <thead class="table-light header-item">
                        <tr>
                            <th style="width: 20px;" class="align-middle">
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        wire:model="selectPageRows">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th class="align-middle"> Sender </th>
                            <th class="align-middle"> To</th>
                            <th class="align-middle"> Message</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody class="search-row">
                        @foreach ($messages as $key => $message)
                            <tr class="search-items">
                                <td>
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input message-checkbox" value="{{ $message['id'] }}"
                                            type="checkbox" id="{{ $message['id'] }}">
                                        <label class="form-check-label" for="{{ $message['id'] }}"></label>
                                    </div>
                                </td>
                                <td>
                                    {{ $message['sender'] }}
                                </td>
                                <td>
                                    {{ $message['number'] }}
                                </td>
                                <td>
                                    {{ Illuminate\Support\Str::limit($message['message'], 20, '...') }}
                                </td>
                                <td>
                                    @if ($message['status'] == 1)
                                        <span class="badge bg-success"><i class="bx bx-check"></i> Sent </span>
                                    @else
                                        <span class="badge bg-danger"><i class="bx bx-times"></i> Failed</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary btn-sm resendMessage" data-id="{{ $message['id'] }}" data-phone="{{ $message['id'] }}"><i class="bx bx-send"></i>Resend</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if (count($messages) > 0)
                    {{ $messages->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
    </div>

   

    @section('scripts')
      
    @endsection
</x-app-layout>
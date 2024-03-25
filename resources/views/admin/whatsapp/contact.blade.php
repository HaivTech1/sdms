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

        <div class="col-sm-8">
            <div class="">
                <button type="button"
                    class="btn btn-outline-primary w-sm createContact" data-type="mother">
                    Save Mother's Contact
                </button>
                <button type="button"
                    class="btn btn-outline-primary w-sm createContact" data-type="father">
                    Save Father's Contact
                </button>
                <button id="createNewContact" type="button"
                    class="btn btn-outline-secondary w-sm">
                    <i class="bx bx-edit"></i>
                   Create Contact
                </button>
                <button id="sendMultipleMessage" type="button"
                    class="btn btn-outline-secondary w-sm">
                    <i class="bx bx-send"></i>
                   Message
                </button>
                <button id="scheduleMultipleMessage" type="button"
                    class="btn btn-outline-secondary w-sm">
                    <i class="bx bx-time"></i>
                   Message
                </button>
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
                            <th class="align-middle"> Name </th>
                            <th class="align-middle"> Number</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody class="search-row">
                        @foreach ($contacts as $key => $contact)
                            <tr class="search-items">
                                <td>
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input schedule-checkbox" data-id="{{ $contact['id'] }}" value="{{ $contact['phone_number'] }}"
                                            type="checkbox" id="{{ $contact['id'] }}">
                                        <label class="form-check-label" for="{{ $contact['id'] }}"></label>
                                    </div>
                                </td>
                                <td>
                                    {{ $contact['name'] }}
                                </td>
                                <td>
                                    {{ $contact['phone_number'] }}
                                </td>
                                <td>
                                    @if ($contact['status'] == 1)
                                        <span class="badge bg-success"><i class="bx bx-check"></i> Active </span>
                                    @else
                                        <span class="badge bg-danger"><i class="bx bx-times"></i> Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-danger btn-sm" data-id="{{ $contact['id'] }}"><i class="bx bx-trash"></i></button>
                                        <button class="btn btn-primary btn-sm sendMessage" data-id="{{ $contact['id'] }}" data-phone="{{ $contact['phone_number'] }}"><i class="bx bx-send"></i></button>
                                        <button class="btn btn-success btn-sm scheduleMessage" data-id="{{ $contact['id'] }}"><i class="bx bx-time"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if (count($contacts) > 0)
                    {{ $contacts->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade createNewContactModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create a new contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="card-title">Add new contact</h4>
                    <form id="contactForm" action="{{ route('admin.whatsapp.storeContact') }}">
                        @csrf
                        <div class="col-sm-12 mb-3">
                            <x-form.label for="name" value="{{ __('Name') }}" />
                            <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                :value="old('name')" id="name" placeholder="John Doe" />
                            <x-form.error for="name" />
                        </div>

                         <div class="col-sm-12 mb-3">
                            <x-form.label for="phone_number" value="{{ __('Phone number') }}" />
                            <x-form.input id="phone_number" class="block w-full mt-1" type="text" name="phone_number"
                                :value="old('phone_number')" id="phone_number" placeholder="09066100815" />
                            <x-form.error for="phone_number" />
                        </div>


                        <div class="col-sm-12 mb-3">
                            <x-form.label for="type" value="{{ __('Type') }}" />
                            <select class="form-control" name="type">
                                <option>Select</option>
                                <option value="default">Default</option>
                                <option value="group">Group</option>
                            </select>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_contact" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade parentContactModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Parent's in Bot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="parentContactCreate" method="POST">
                        @csrf
                        <div>
                            <div class="table-responseive">
                                <table class="parent-contact">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <button id="btn_contact" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade sendMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send message to contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sendMessageForm" action="{{ route('admin.whatsapp.sendMessage') }}">
                        @csrf

                        <input type="hidden" name="phone_number" id="send_phone_number" />

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="message" value="{{ __('Message') }}" />
                            <textarea rows="7" class="form-control message" value="old('message')" name="message"></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_single_message" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade sendMessageMultipleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send message to multiple contacts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sendMultipleMessageForm" action="{{ route('admin.whatsapp.sendMultipleMessage') }}">
                        @csrf

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="message" value="{{ __('Message') }}" />
                            <textarea rows="7" class="form-control message" value="old('message')" name="message"></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_multiple_message" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade scheduleMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule message for contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleMessageForm" action="{{ route('admin.whatsapp.scheduleMessage') }}">
                        @csrf

                        <input type="hidden" name="contacts[]" id="schedule_phone_id" />

                        <div class="row">
                            
                            <div class="col-sm-6 mb-3">
                                <x-form.label for="from" value="{{ __('From') }}" />
                                <x-form.input id="from" class="block w-full mt-1" type="date" name="from" id="from" />
                                <x-form.error for="from" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-form.label for="to" value="{{ __('To') }}" />
                                <x-form.input id="to" class="block w-full mt-1" type="date" name="to" id="to" />
                                <x-form.error for="to" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-form.label for="time" value="{{ __('Time') }}" />
                                <x-form.input id="time" class="block w-full mt-1" type="time" name="time" id="time" />
                                <x-form.error for="time" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-form.label for="method" value="{{ __('Method') }}" />
                                <select class="form-control" name="method" :value="old('method')">
                                    <option>Select</option>
                                    <option value="once">Once</option>
                                    <option value="daily">Daily</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="message" value="{{ __('Message') }}" />
                            <textarea rows="7" class="form-control message" value="old('message')" name="message"></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_single_schedule" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade scheduleMultipleMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule message for contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleMultipleMessageForm" action="{{ route('admin.whatsapp.scheduleMessage') }}">
                        @csrf

                        <div class="row">
                            
                            <div class="col-sm-6 mb-3">
                                <x-form.label for="from" value="{{ __('From') }}" />
                                <x-form.input id="from" class="block w-full mt-1" type="date" name="from" id="from" />
                                <x-form.error for="from" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-form.label for="to" value="{{ __('To') }}" />
                                <x-form.input id="to" class="block w-full mt-1" type="date" name="to" id="to" />
                                <x-form.error for="to" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-form.label for="time" value="{{ __('Time') }}" />
                                <x-form.input id="time" class="block w-full mt-1" type="time" name="time" id="time" />
                                <x-form.error for="time" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-form.label for="method" value="{{ __('Method') }}" />
                                <select class="form-control" name="method" :value="old('method')">
                                    <option>Select</option>
                                    <option value="once">Once</option>
                                    <option value="daily">Daily</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="message" value="{{ __('Message') }}" />
                            <textarea rows="7" class="form-control message" value="old('message')" name="message"></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submit_multiple_schedule" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $('#submit_contact').on('click', function(){
                var button = $(this);
                toggleAble(button, true, "Creating...");

                var url = $('#contactForm').attr('action');
                var data = $('#contactForm').serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data,
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500)
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('#createNewContact').on('click', function(){
                $('.createNewContactModal').modal('show');
            });

            $('.createContact').on('click', function() {
                var button = $(this);
                toggleAble(button, true);
                var type = $(this).data('type');
                var url = "{{ route('admin.whatsapp.merge_contact', ['type' => ':type']) }}".replace(':type', type);

                $.ajax({
                    method: "GET",
                    url,
                }).done((response) => {
                        toggleAble(button, false);
                        contacts = response.data;
                        displayContacts(contacts);
                        $('.parentContactModal').modal('show');
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('#parentContactCreate').submit(function(event) {
                event.preventDefault(); 
                var button = $('#btn_contact');
                toggleAble(button, true, 'Creating...');

                var selectedContacts = [];
                $('input[name="ids[]"]:checked').each(function() {
                    var id = $(this).val();
                    var name = $('#' + id + '-name').val();
                    var number = $('#' + id + '-number').val();

                    selectedContacts.push({
                        id: id,
                        name: name,
                        phone_number: number,
                    });
                });

                var url = "{{ route('admin.whatsapp.createMultipleContacts') }}";
                var jsonData = JSON.stringify(selectedContacts);

                $.ajax({
                    method: "POST",
                    url,
                    contentType: 'application/json',
                    data: jsonData
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            
            $("#input-search").on("keyup", function () {
                var rex = new RegExp($(this).val(), "i");
                $(".search-table .search-items:not(.header-item)").hide();
                $(".search-table .search-items:not(.header-item)")
                    .filter(function () {
                        return rex.test($(this).text());
                    })
                .show();
            });

            $('.sendMessage').on('click', function(){
                var number = $(this).data('phone');
                $('#send_phone_number').val(number);
                $('.sendMessageModal').modal('show');
            });

            $('#submit_single_message').on('click', function(){
                var button = $(this);
                toggleAble(button, true, "Sending...");

                var url = $('#sendMessageForm').attr('action');
                var data = $('#sendMessageForm').serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data,
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        $('.sendMessageModal').modal('hide');
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('#sendMultipleMessage').on('click', function(){
                $('.sendMessageMultipleModal').modal('show');
            });

            $('#submit_multiple_message').on('click', function(){
                var contacts = $('.contact-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (contacts.length > 0) {
                    var button = $(this);
                    toggleAble(button, true, "Sending...");

                    var url = $('#sendMultipleMessageForm').attr('action');
                    var data = $('#sendMultipleMessageForm').serializeArray();
                    data.push({ name: 'contacts', value: contacts });

                    $.ajax({
                        method: "POST",
                        url,
                        data,
                    }).done((res) => {
                            toggleAble(button, false);
                            toastr.success(res.message, 'Success!');
                            $('.sendMessageMultipleModal').modal('hide');
                    }).fail((err) => {
                        toggleAble(button, false);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                }else{
                    toastr.info('Please select a contact to', 'Info');
                    toggleAble(button, false);
                }
            });

            $('.scheduleMessage').on('click', function(){
                var id = $(this).data('id');
                $('#schedule_phone_id').val(id);
                $('.scheduleMessageModal').modal('show');
            });

            $('#scheduleMultipleMessage').on('click', function(){
                $('.scheduleMultipleMessageModal').modal('show');
            });

            $('#scheduleMessageForm').submit(function(event) {
                event.preventDefault(); 
                var button = $('#submit_single_schedule');
                toggleAble(button, true, 'Creating...');

                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#scheduleMessageForm');
                        $('.scheduleMessageModal').modal('hide');
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('#scheduleMultipleMessageForm').submit(function(event) {
                event.preventDefault(); 
                var button = $('#submit_multiple_schedule');
                toggleAble(button, true, 'Creating...');

                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                var contacts = $('.schedule-checkbox:checked').map(function () {
                    return $(this).data('id');
                }).get();

                data.push({'name': 'contacts', 'value': contacts});

                if (contacts.length > 0){
                    $.ajax({
                        method: "POST",
                        url,
                        data
                    }).done((res) => {
                            toggleAble(button, false);
                            toastr.success(res.message, 'Success!');
                            resetForm('#scheduleMultipleMessageForm');
                            $('.scheduleMultipleMessageModal').modal('hide');
                    }).fail((err) => {
                        toggleAble(button, false);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                }else{
                    toastr.info('Please select a contacts', 'Info');
                    toggleAble(button, false);
                }
            });

            function displayContacts(data){
                var tableRows = '';

                data.forEach(function(contact) {
                    tableRows += `
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="${contact['phone_number']}" name="ids[]" value="${contact['phone_number']}"} />
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control w-full" id="${contact['phone_number']}-name" name="names[]" value="${contact['name']}"} />
                            </td>
                            <td>
                                <input type="text" class="form-control w-full" id="${contact['phone_number']}-number" name="numbers[]" value="${contact['phone_number']}"} disabled />
                            </td>
                        </tr>
                    `;
                });

                $('.parent-contact tbody').html(tableRows);
            }
            
        </script>
    @endsection
</x-app-layout>
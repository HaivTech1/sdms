<div>
    <x-loading />

    <div class="row">
        <div class="card text-center">
          <div class="card-body">
                <form wire:submit.prevent="generateWeeks">
                    <div class="row">
                        <div class="col-sm-5 form-group">
                            <input type="date" class="form-control" id="startDate" wire:model.defer="startDate">
                        </div>
                        <div class="col-sm-5 form-group">
                            <input type="date" class="form-control" id="endDate" wire:model.defer="endDate">
                        </div>
                        <div class="col-sm-2">
                            @if (count($weeks) > 0)
                                <button type="button" wire:click="flushWeeks" class="btn btn-danger">Flush Weeks</button>
                            @else
                                <button type="submit" class="btn btn-primary">Generate Weeks</button>
                            @endif
                        </div>
                    </div>
                </form>
          </div>
        </div>


        <div class="row">
            <div class="card">
              <div class="card-body">
                    @if ($weeks)
                        <div class="table-responsive" id="pdf-container">
                            <table class="table-fixed w-full table-bordered" style="border-collapse: collapse;">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>Week</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weeks as $key => $week)
                                        <tr>
                                            <td style="padding: 10px; text-align: center; cursor: pointer" data-week="{{ $week->id() }}" data-date="{{ $week->start_date->format('Y-m-d') }}">{{ $key + 1 }}</td>
                                            @for ($i = 0; $i < 5; $i++)
                                                <td style="padding: 10px; text-align: center">
                                                    @php
                                                        $date = $week->start_date->copy()->addDays($i);
                                                    @endphp

                                                    <div>
                                                        <span id="week_date" style="font-size: 10px; font-weight: bold; text-decoration: underline">{{ $date->format('d-m-Y') }}</span>
                                                    </div>
                                                    <div>
                                                        <span style="font-weight: bold; font-size: 10px; cursor: pointer" data-hair-id="{{ $week->hairstyle->id() }}">Hairstyle:</span><span> {{ $week->hairstyle->title() }}</span>
                                                    </div>
                                                    <ul>
                                                        @foreach ($week->events->sortBy('created_at') as $event)
                                                           @if ($event->start->lte($week->end_date) && $event->end->gte($week->start_date))
                                                                @for ($j = 0; $j <= $event->end->diffInDays($event->start); $j++)
                                                                    @php
                                                                        $eventDate = $event->start->copy()->addDays($j);
                                                                    @endphp
                                                                    @if ($eventDate->format('d-m-Y') === $date->format('d-m-Y'))
                                                                        <li style="cursor: pointer" data-event-id="{{ $event->id() }}">
                                                                            <span style="font-weight: bold; font-size: 10px;">Event: </span><span class="badge {{ $event->category }}">{{ $event->title }}</span>
                                                                        </li>
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        
                        @admin
                            <div class="row mt-3 mb-3">
                                <button type="button" class="btn btn-primary" onclick="generatePDF()">Generate PDF</button>
                            </div>
                        @endadmin
                    @endif
              </div>
            </div>
        </div>

    </div>

    <div class="modal fade addEvent" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Create a new event on the school calendar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <form id="event-form">
                        @csrf
                        <input type="hidden" name="week_id" id="week-id">

                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="title" value="{{ __('Title') }}" />
                                <x-form.input type="text" value="" name="title" id="title" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="start" value="{{ __('Start') }}" />
                                <x-form.input type="date" value="" name="start" id="start" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="end" value="{{ __('End') }}" />
                                <x-form.input type="date" value="" name="end" id="end" />
                            </div>
                            <div class="col-sm-12">
                                <select name="category" class="form-control" id="category">
                                    <option value="">Select category</option>
                                    <option value="badge-soft-primary">Blue</option>
                                    <option value="badge-soft-success">Green</option>
                                    <option value="badge-soft-danger">Red</option>
                                    <option value="badge-soft-warning">Yellow</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <button type="submit" id="submit" class="btn btn-primary btn-flat">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade editEvent" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Update event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <form id="editEvent" method="POST">
                        @csrf
                        <input type="hidden" name="week_id" id="edit_week_id">
                        <input type="hidden" name="event_id" id="edit_event_id">

                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="title" value="{{ __('Title') }}" />
                                <x-form.input type="text" value="" name="title" id="edit_title" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="start" value="{{ __('Start') }}" />
                                <x-form.input type="date" value="" name="start" id="edit_start" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="end" value="{{ __('End') }}" />
                                <x-form.input type="date" value="" name="end" id="edit_end" />
                            </div>
                            <div class="col-sm-12">
                                <select name="category" class="form-control" id="edit_category">
                                    <option value="">Select category</option>
                                    <option value="badge-soft-primary">Blue</option>
                                    <option value="badge-soft-success">Green</option>
                                    <option value="badge-soft-danger">Red</option>
                                    <option value="badge-soft-warning">Yellow</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="delete-event-btn" class="btn btn-danger btn-flat pull-left">Delete</button>
                            <button type="submit" id="edit_submit" class="btn btn-primary btn-flat">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showHair" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-light rounded-circle text-primary h1">
                                <i class="bx bx-female"></i>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 class="text-primary" id="hair_title"></h4>
                                <p class="text-muted font-size-14 mb-4" id="hair_description"></p>

                                <div class="bg-light rounded">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <img src="" style="width: 300px; height: 100px; border-radius: 10px" id="hair_front"/>
                                        </div>
                                        <div class="col-sm-4">
                                            <img src=""  style="width: 300px; height: 100px; border-radius: 10px" id="hair_back"/>
                                        </div>
                                        <div class="col-sm-4">
                                            <img src=""  style="width: 300px; height: 100px; border-radius: 10px" id="hair_side"/>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            function generatePDF() {
                const container = document.getElementById("pdf-container");

                html2canvas(container).then(function(canvas) {
                    const imgData = canvas.toDataURL("image/png");

                    const pdfDocDefinition = {
                        pageSize: 'A4',
                        pageOrientation: 'landscape',
                        content: [
                            {
                                image: imgData,
                                width: 800,
                                height: 500
                            }
                        ]
                    };

                    pdfMake.createPdf(pdfDocDefinition).open();
                });
            }


        </script>
        <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $('table td:first-child').on('click', function() {
                    // Get the week start date and ID from the data attributes of the cell
                    var startDate = $(this).data('date');
                    var weekId = $(this).data('week');

                    // Set the week ID in the hidden input field of the modal form
                    $('#week-id').val(weekId);
                    $('#start').val(startDate);

                    // Show the modal form
                    $('.addEvent').modal('toggle');
                });

                // Add submit event listener to the modal form
                $('#event-form').on('submit', function(event) {
                    event.preventDefault();
                    toggleAble('#submit', true, 'Creating...');

                    // Get the event details from the form fields
                    var title = $('#title').val();
                    var category = $('#category').val();
                    var start = $('#start').val();
                    var end = $('#end').val();
                    var weekId = $('#week-id').val();

                    // Send a POST request to create a new event
                    $.ajax({
                        url: '/event',
                        method: 'POST',
                        data: {
                            title: title,
                            category: category,
                            start: start,
                            end: end,
                            week_id: weekId
                        },
                        success: function(response) {
                            if(response.status){
                                toggleAble('#submit', false);
                                $('.addEvent').modal('toggle');
                                toastr.success(response.message);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                                resetForm('#event-form');
                            }
                        },
                        error: function(error) {
                            toggleAble('#submit', false);
                            console.log(error.responseJSON.message);
                            toastr.error(error.responseJSON.message, 'Failed!');
                            let allErrors = Object.values(error.responseJSON.errors).map(el => (
                                    el = `<li>${el}</li>`
                                )).reduce((next, prev) => ( next = prev + next ));

                            const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <ul>${allErrors}</ul>
                                                </div>
                                                `;

                            $('.modalErrorr').html(setErrors);
                        }
                    });
                });

                $('td li').on('click', function() {
                    var eventId = $(this).data('event-id');
                    var button = $(this);
                    toggleAble(button, true);

                    $.ajax({
                        url: '/event/edit/' + eventId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            toggleAble(button, false);
                            $('#edit_week_id').val(data.week_id);
                            $('#edit_event_id').val(data.id);
                            $('#edit_title').val(data.title);
                            $('#edit_category').val(data.category);
                            $('#edit_start').val(formatDate(data.start));
                            $('#edit_end').val(formatDate(data.end));
                            $('#delete_event').val(data.id);
                            $('.editEvent').modal('toggle');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + ': ' + errorThrown);
                        }
                    });
                });

                $('td span:nth-child(1)').on('click', function() {
                    var hairId = $(this).data('hair-id');
                    var button = $(this);
                    toggleAble(button, true);

                    $.ajax({
                        url: '/hairstyle/show/' + hairId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            toggleAble(button, false);
                            var title = document.getElementById('hair_title');
                            var description = document.getElementById('hair_description');
                            var front = document.getElementById('hair_front');
                            var back = document.getElementById('hair_back');
                            var side = document.getElementById('hair_side');

                            var baseUrl = '{{ url('/') }}';

                            title.innerHTML = data.title,
                            description.innerHTML = data.description,
                            front.src = baseUrl  + '/storage/' + data.front_view;
                            back.src = baseUrl + '/storage/' +data.back_view;
                            side.src = baseUrl + '/storage/' +data.side_view;



                            $('#showHair').modal('toggle');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + ': ' + errorThrown);
                        }
                    });
                });

                $('#editEvent').on('submit', function(e){
                    e.preventDefault();
                    toggleAble('#edit_submit', true, 'Updating...');

                    var data = $(this).serializeArray();
                    var url = '/event/update';
                    var type = $(this).attr('method');

                    $.ajax({
                    type,
                    url,
                    data
                    }).done((res) => {
                        if(res.status === true) {
                            toggleAble('#edit_submit', false);
                            toastr.success(res.message, 'Success!');
                            $('.editEvent').modal('toggle');
                            setTimeout(function () {
                                window.location.reload()
                            }, 2000);
                        }else{
                            toggleAble('#edit_submit', false);
                            toastr.error(res.message, 'Failed!');
                        }
                    }).fail((res) => {
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#edit_submit', false);
                    });
                });

                $(document).on('click', '#delete-event-btn', function() {
                    var eventId = $('#edit_event_id').val();
                    var button = $(this);
                    toggleAble(button, true);

                    $.ajax({
                        url: '/event/' + eventId,
                        type: 'DELETE',
                        success: function(res) {
                            if(res.status === true) {
                                toastr.success(res.message, 'Success!');
                                toggleAble(button, false);
                                $('.editEvent').modal('toggle');
                                setTimeout(function () {
                                    window.location.reload()
                                }, 1000);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + ': ' + errorThrown);
                        }
                    });
                });


                function formatDate(date) {
                    // Create a new Date object from the string
                    var d = new Date(date);
                    // Get the year, month, and day components of the date
                    var year = d.getFullYear();
                    var month = ('0' + (d.getMonth() + 1)).slice(-2);
                    var day = ('0' + d.getDate()).slice(-2);
                    // Assemble the formatted date string
                    var formattedDate = year + '-' + month + '-' + day;
                    // Return the formatted date string
                    return formattedDate;
                }
            });
        </script>
    @endsection
</div>

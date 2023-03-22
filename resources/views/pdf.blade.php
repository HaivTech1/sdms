{{-- <table class="table-fixed w-full table-bordered" style="border-collapse: collapse;">
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
</table> --}}
<div id="pdf-container">
      <h1>Hello, world!</h1>
      <p>This is a simple example of generating a PDF with pdfmake.</p>
    </div>
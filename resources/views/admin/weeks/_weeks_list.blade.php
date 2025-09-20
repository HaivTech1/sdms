<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Hairstyle</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Period</th>
            <th>Term</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($weeks as $week)
            <tr>
                <td>{{ $week->id }}</td>
                <td>{{ $week->hairstyle->title ?? '' }}</td>
                <td>{{ optional($week->start_date)->format('Y-m-d') }}</td>
                <td>{{ optional($week->end_date)->format('Y-m-d') }}</td>
                <td>{{ $week->period->title()}}</td>
                <td>{{ $week->term->title()}}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-primary edit-week" data-week-id="{{ $week->id }}" data-hairstyle-id="{{ $week->hairstyle_id }}">Edit</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $weeks instanceof \Illuminate\Pagination\LengthAwarePaginator ? $weeks->links() : '' }}

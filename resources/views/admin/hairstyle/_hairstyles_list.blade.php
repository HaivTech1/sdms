<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Front</th>
            <th>Side</th>
            <th>Back</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hairstyles as $h)
            <tr>
                <td>{{ $h->id }}</td>
                <td>{{ $h->title }}</td>
                <td>{{ Str::limit($h->description, 60) }}</td>
                <td style="width:80px;">
                    <img class="img-thumbnail" style="max-width:70px; max-height:70px;" src="{{ $h->front_view ? asset('storage/' . $h->front_view) : asset('noImage.png') }}" alt="front-{{ $h->id }}">
                </td>
                <td style="width:80px;">
                    <img class="img-thumbnail" style="max-width:70px; max-height:70px;" src="{{ $h->side_view ? asset('storage/' . $h->side_view) : asset('noImage.png') }}" alt="side-{{ $h->id }}">
                </td>
                <td style="width:80px;">
                    <img class="img-thumbnail" style="max-width:70px; max-height:70px;" src="{{ $h->back_view ? asset('storage/' . $h->back_view) : asset('noImage.png') }}" alt="back-{{ $h->id }}">
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="actions">
                        <button class="btn btn-sm btn-danger delete-hair" data-hair-id="{{ $h->id }}" title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $hairstyles instanceof \Illuminate\Pagination\LengthAwarePaginator ? $hairstyles->links() : '' }}

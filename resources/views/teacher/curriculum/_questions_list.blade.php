@foreach($questions as $q)
    @php $qJson = e(json_encode([
        'id' => $q->id,
        'question' => $q->question,
        'options' => $q->options,
        'correct_index' => $q->correct_index,
        'difficulty' => $q->difficulty,
        'bloom_level' => $q->bloom_level,
        'explanation' => $q->explanation,
    ])) @endphp
    <tr data-id="{{ $q->id }}" data-question="{!! $qJson !!}">
        <td>{{ $q->id }}</td>
        <td>{!! nl2br(e($q->question)) !!}</td>
        <td>
            <ul>
                @foreach($q->options as $i => $opt)
                    <li {!! $i == $q->correct_index ? 'style="font-weight:700"' : '' !!}>{{ $opt }}</li>
                @endforeach
            </ul>
        </td>
        <td>{{ $q->difficulty }}</td>
        <td>{{ $q->bloom_level }}</td>
        <td>
            <a href="#" class="btn btn-sm btn-primary edit-saved-question" data-url="{{ route('teacher.curriculum.topics.question.update', [$q->curriculum_id, $q->id]) }}">Edit</a>
            <button class="btn btn-sm btn-danger delete-saved-question"
                data-url="{{ route('teacher.curriculum.topics.question.destroy', [$q->curriculum_id, $q->id]) }}">Delete</button>
        </td>
    </tr>
@endforeach
<tr><td colspan="6">{{ $questions->links() }}</td></tr>

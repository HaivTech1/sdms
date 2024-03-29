
<x-app-layout>
    @section('title', application('name')." | Result Comment")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Result</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Comment</li>
                </ol>
            </div>
        </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="mt-2">

                            <form id="fetchStudent">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control" id="grade_id" name="grade_id">
                                            <option value=''>Class</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <select class="form-control" id="period_id" name="period_id">
                                            <option value=''>Select Session</option>
                                            @foreach ($periods as $period)
                                            <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="period_id" />
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" id="term_id" name="term_id">
                                            <option value=''>Select Term</option>
                                            @foreach ($terms as $term)
                                            <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="term_id" />
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="d-flex justify-content-center align-item-center">
                                            <button type="submit" id="fetchStudentButton" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                                <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i> fetch
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 py-4">
                            <form id="commentForm">
                                @csrf
                                <input type="hidden" name="period_id" id="periodId" value="" />
                                <input type="hidden" name="term_id" id="termId" value="" />

                                <div class="table-responsive">
                                    <table id="comment-data" class="table table-bordered table-striped table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 35%;">Name of Student</th>
                                                <th class="text-center">
                                                    Comment
                                                </th>
                                                <th class="text-center" style="width: 10%;">
                                                    Total present
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    
                                    <div class="d-flex mt-2">
                                        <button type="submit" id="submitComment" class="btn btn-success rounded-pill px-4">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $('#fetchStudent').on('submit', function(e){
                e.preventDefault();

                var button = $('#fetchStudentButton');
                toggleAble(button, true, 'Fetching...');

                var grade = $('#grade_id').val();
                var period = $('#period_id').val();
                var term = $('#term_id').val();

                $.ajax({
                    url: '{{ route("grade.students", ["grade" => ":grade_id"]) }}'.replace(':grade_id', grade),
                    type: 'GET',
                    dataType: 'json',
                }).done((response) => {
                    var students = response.student;

                    $.ajax({
                        url: '{{ route("student.cognitives", ["period" => ":period_id", "term" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term),
                        type: 'GET',
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble(button, false);
                        var cognitives = res.cognitives;

                        $('#periodId').val(period);
                        $('#termId').val(term);

                        displayComment(students, cognitives);
                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                    });
                    
                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                });
            });

            function displayComment(data, initialData){
                var tableRows = '';

                data.forEach(function(student) {

                    var comment = initialData.find(cognitive => cognitive.student_id === student['id']);
                    tableRows += `
                        <tr>
                            <td class="" style="width: 35%;">
                                ${student['name']}
                                <input type="hidden" class="form-control" id="student-${student['id']}" name="students[]" value="${student['id']}" />
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="text" class="form-control" id="student-${student['id']}" name="comments[]" value="${comment && comment.comment !== null ? comment.comment : ''}" />
                                </div>
                            </td>
                            <td style="width: 10%;">
                                <div class="form-check">
                                    <input type="text" class="form-control" id="student-${student['id']}" name="attendances[]" value="${comment && comment.present !== null ? comment.present : ''}" />
                                </div>
                            </td>
                        </tr>
                    `;
                });

                $('#comment-data tbody').html(tableRows);
            }


            $('#commentForm').on('submit', function(e){
                e.preventDefault();
                var button = $('#submitComment');
                toggleAble(button, true, 'Updating...');

                var data = $(this).serializeArray();
                var url = "{{ route('result.batchcognitive') }}";

                $.ajax({
                    url,
                    type: 'POST',
                    data,
                }).done((response) => {
                    toggleAble(button, false);
                    toastr.success(response.message);
                    resetForm('#commentForm');
                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                    console.log(error);
                });
            });
            
        </script>
    @endsection
</x-app-layout>
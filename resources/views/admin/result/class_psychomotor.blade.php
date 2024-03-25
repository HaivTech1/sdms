
<x-app-layout>
    @section('title', application('name')." | Result Psychomotor")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Result</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Psychomotor</li>
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
                                            @php
                                                $psychomotors = get_settings('psychomotor_domain');
                                            @endphp
                                            <tr>
                                                <th class="text-center"  style="width: 300px">Name of Student</th>
                                                @foreach ($psychomotors as $key => $psychomotor)
                                                    <th class="text-center">{{ $key+1 }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    
                                    <div id="noPsychoList" class="my-2 text-center d-none">
                                        <p class="text-danger">The following student's psychomotor domain has not been computed</p>
                                        <p class="listNoPsycho"></p>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center mt-2">
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
                        url: '{{ route("student.psychomotors", ["period" => ":period_id", "term" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term),
                        type: 'GET',
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble(button, false);
                        var psychomotors = res.psychomotors;

                        $('#periodId').val(period);
                        $('#termId').val(term);

                        displayPsychomotor(students, psychomotors);
                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                    });
                    
                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                });
            });

            function displayPsychomotor(students, initialData){
                var tableRows = '';
                var listPsychomotors = @json(get_settings('psychomotor_domain'));

                students.forEach(function(student) {

                    var psychomotorsList = '';
                    listPsychomotors.forEach(function(domain, index) {
                        var radioButtons = '';

                        for (var i = 1; i <= 5; i++) {
                            var psycho = initialData.find(psycho => psycho.student_id === student['id'] && psycho.title.trim() == domain.trim());
                            var isChecked = psycho && psycho.value == i ? 'checked' : '';

                            radioButtons += `
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-${student['id']}-${index + 1}-${i}-${domain}" name="psychomotors[${student['id']}][${domain}][]" value="${i}" ${isChecked} />
                                    <label class="form-check-label" for="checkbox-${student['id']}-${index + 1}-${i}">${i}</label>
                                </div>
                            `;
                        }
                        psychomotorsList += `<td>${domain}${radioButtons}</td>`;
                    });

                    tableRows += `
                        <tr>
                            <td class="text-left" style="width: 300px">
                                ${student['name']}
                                <input type="hidden" class="form-control" id="student-${student['id']}" name="students[]" value="${student['id']}" />
                            </td>
                            ${psychomotorsList}
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
                var url = "{{ route('result.batchPsychomotor') }}";

                $.ajax({
                    url,
                    type: 'POST',
                    data,
                }).done((response) => {
                    toggleAble(button, false);
                    toastr.success(response.message);
                    resetForm('#commentForm');
                    var no_psychomotor_count = response.no_psychomotor.count;
                    var no_psychomotor = response.no_psychomotor.data;

                    var listRow = '';
                    if (no_psychomotor_count > 0) {
                        no_psychomotor.forEach(function(name, index) {
                            listRow += (index < no_psychomotor_count - 1) ? `${name}, ` : `${name}.`;
                        });
                        $('#noPsychoList .listNoPsycho').html(listRow);
                        $('#noPsychoList').removeClass('d-none'); 
                    } else {
                        $('#noPsychoList').addClass('d-none');
                    }

                    setTimeout(() => {
                        $('#noPsychoList').addClass('d-none');
                    }, 10000);

                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                    console.log(error);
                });
            });
            
        </script>
    @endsection
</x-app-layout>
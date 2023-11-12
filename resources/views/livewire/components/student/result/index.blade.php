  <div class="row">
    <x-loading />

      <div class="col-12">
          <div class="card">
              <div class="card-body">
                    @hasPaid
                        <form id="fetchResultForm" class="repeater" enctype="multipart/form-data">
                            <div class="mb-3">
                              <input type="hidden"
                                class="form-control" name="student_id" id="student_id" value="{{ Auth::user()->student->id() }}">
                            </div>

                            <div data-repeater-list="group-a">
                                <div data-repeater-item class="row">
                                    <div class="mb-3 col-lg-3">
                                        <label for="name">Grade</label>
                                        <select class="form-control" id="grade_id">
                                            <option value=''>Choose...</option>
                                            @foreach ($grades as $id => $grade)
                                            <option value="{{  $id }}">{{ $grade }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-lg-3">
                                        <label for="name">Session</label>
                                        <select class="form-control " id="period_id">
                                            <option value=''>Choose...</option>
                                            @foreach ($periods as $id => $period)
                                            <option value="{{  $id }}">{{ $period }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-lg-3">
                                        <label for="email">Term</label>
                                        <select class="form-select" id="term_id">
                                            <option selected>Choose...</option>
                                            @foreach ($terms as $id => $term)
                                            <option value="{{ $id }}">{{ $term }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-3 align-self-center">
                                        <div class="d-grid">
                                            <button id="fetchResultButton" data-repeater-delete type="submit" class="btn btn-primary">
                                                <i class="bx bx-download"></i>
                                                Fetch
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="result-data" class="table table-bordered table-striped table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Name</th>
                                                <th scope="col" class="text-center">
                                                    Present Class
                                                </th>
                                                <th scope="col" class="text-center">
                                                    Class Result
                                                </th>
                                                
                                                <th scope="col" class="text-center" id="action">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="home-wrapper">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4">
                                            <div class="maintenance-img">
                                                <img src="{{ asset('images/maintenance.svg') }}" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="mt-5">You are owing {{ trans('global.naira') }} {{ number_format(hasPaidFullFee(auth()->user(), auth()->user()->student->grade_id)['owing'], 2) }}</h3>
                                    <p> You can only have access to this page if you have paid your tuition fee for the term!</p>
                                </div>
                            </div>
                        </div>
                    @endhasPaid
              </div>
          </div>
      </div>

      @section('scripts')
        <script>
            $(document).ready(function() {
                $('#scratchCard').click(function(){
                    Swal.fire({
                        title:"Enter scratch card pin code to check result",
                        input:"text",
                        showCancelButton:!0,
                        confirmButtonText:"Submit",
                        showLoaderOnConfirm:!0,
                        confirmButtonColor:"#556ee6",
                        cancelButtonColor:"#f46a6a",
                        preConfirm:function(n){
                            var code = n;
                            var grade = @json($grade_id);
                            var period = @json($period_id);
                            var term = @json($term_id);

                            $.ajax({
                                method: 'GET',
                                url: 'result/verify/pin',
                                dataType: 'json',
                                data: {code, period, term, grade}
                            }).then((response) => {
                                console.log(response);

                                    Swal.fire({
                                        icon: "success",
                                        title: "Successfull!",
                                        html: response.message,
                                        confirmButtonColor: "#556ee6",
                                    });
                                    
                                    setTimeout(function () {
                                        window.location.href = response.redirectTo;
                                    }, 2000);
                              
                            }).catch((error) => {
                                 Swal.fire({
                                    icon: "error",
                                    title: "There was a problem!",
                                    html: error.responseJSON.message,
                                    confirmButtonColor: "#FF0000",
                                });
                            })
                        },
                        allowOutsideClick: !1,
                    });
                });

                $('#fetchResultForm').on('submit', function(e){
                    e.preventDefault();
                    var button = $('#fetchResultButton');
                    toggleAble(button, true, 'Fetching...');

                    var grade = $('#grade_id').val();
                    var period = $('#period_id').val();
                    var term = $('#term_id').val();
                    var student = $('#student_id').val();

                    $.ajax({
                        type: 'GET',
                        url: '{{ route("result.check.single.exam", ["student_id" => ":student_id" , "grade_id" => ":grade_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':student_id', student).replace(':grade_id', grade).replace(':period_id', period).replace(':term_id', term),
                        dataType: 'json',
                    }).done((response) => {
                        toggleAble(button, false);
                        var result = response.result;

                        var html = '';
                        if (response.grade_name === 'Playgroup') {
                            html += '<tr>';
                                html += '<td class="text-center">' + result.name + '</td>';
                                html += '<td class="text-center">' + response.current_class + '</td>';
                                html += '<td class="text-center">' + response.grade_name + '</td>';
                                if(result.recorded_subjects > 0){
                                    html += '<td>';
                                    html += '<form action="{{ route('result.playgroup.pdf') }}" method="POST">';
                                    html += '@csrf';
                                    html += '<input type="hidden" name="student_id" value="' + result.id + '" />';
                                    html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                                    html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                                    html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                                    html += '<button class="btn btn-sm btn-info" type="submit">';
                                    html += '<i class="bx bxs-file-pdf"></i> Download PDF';
                                    html += '</form>';
                                    html += '</div>';
                                    html += '</td>';
                                }else{
                                    html += '<td>';
                                    html += '<p>No Results available</p>';
                                    html += '</td>';
                                }
                            html += '</tr>';
                        } else {
                            html += '<tr>';
                                html += '<td class="text-center">' + result.name + '</td>';
                                html += '<td class="text-center">' + response.current_class + '</td>';
                                html += '<td class="text-center">' + response.grade_name + '</td>';

                                if(result.recorded_subjects > 0)
                                {
                                    html += '<td>';
                                    html += '<form action="{{ route('result.exam.pdf') }}" method="POST">';
                                    html += '@csrf';
                                    html += '<input type="hidden" name="student_id" value="' + result.id + '" />';
                                    html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                                    html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                                    html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                                    html += '<button class="btn btn-sm btn-info" type="submit">';
                                    html += '<i class="bx bxs-file-pdf"></i> Download PDF';
                                    html += '</form>';
                                    html += '</div>';
                                    html += '</td>';
                                }else{
                                    html += '<td>';
                                    html += '<p>No Results available</p>';
                                    html += '</td>';
                                }
                            html += '</tr>';
                        }

                        $('#result-data tbody').html(html);

                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                        console.log(error);
                    });
                });
            })
        </script>
      @endsection
  </div>
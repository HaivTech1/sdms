  <div class="row">
    <x-loading />

      <div class="col-12">
          <div class="card">
              <div class="card-body">
                  <form wire:submit.prevent="fetchResult" class="repeater" enctype="multipart/form-data">
                      <input type="hidden" value="{{ $user->student->grade_id }}" name="grade_id" />
                      <div data-repeater-list="group-a">
                          <div data-repeater-item class="row">
                            <div class="mb-3 col-lg-3">
                                <label for="name">Grade</label>
                                <select class="form-control " wire:model.defer="state.grade_id">
                                    <option value=''>Choose...</option>
                                    @foreach ($grades as $id => $grade)
                                    <option value="{{  $id }}">{{ $grade }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.grade_id" />
                            </div>

                            <div class="mb-3 col-lg-3">
                                <label for="name">Session</label>
                                <select class="form-control " wire:model.defer="state.period_id">
                                    <option value=''>Choose...</option>
                                    @foreach ($periods as $id => $period)
                                    <option value="{{  $id }}">{{ $period }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.period_id" />
                            </div>

                            <div class="mb-3 col-lg-3">
                                <label for="email">Term</label>
                                <select id="formrow-inputState" class="form-select" wire:model.defer="state.term_id">
                                    <option selected>Choose...</option>
                                    @foreach ($terms as $id => $term)
                                    <option value="{{ $id }}">{{ $term }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.term_id" />
                            </div>

                            <div class="col-lg-3 align-self-center">
                                <div class="d-grid">
                                    <button data-repeater-delete type="submit" class="btn btn-primary">
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
                            @if ($student && $period_id && $term_id && $grade_id)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">
                                                    Class
                                                </th>
                                                <th scope="col" class="text-center">
                                                    Total Subjects
                                                </th>
                                                <th scope="col" class="text-center">
                                                    Recorded Subjects
                                                </th>

                                                <th scope="col" class="text-center" id="action">
                                                    Action
                                                </th>
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td class='text-center'>{{ $student->grade->title() }}</td>
                                                <td class='text-center'>
                                                    <div class="btn-group dropend">
                                                        <button type="button" class="btn dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ $student->totalSubjects() }} <i class="mdi mdi-chevron-right"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @foreach ($student->subjects as $subject)
                                                                <p class="dropdown-item">{{ $subject->title() }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class='text-center'>
                                                    <div class="btn-group dropend">
                                                        <button type="button" class="btn dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ $student->results->where('term_id', $term_id)->where('period_id', $period_id)->count() }} <i class="mdi mdi-chevron-right"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @foreach ($student->results as $result)
                                                                <p class="dropdown-item">{{ $result->subject->title() }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class='d-flex justify-content-center align-items-center'>
                                                    <button title="Click to view result" id="scratchCard" type="button" class="btn btn-primary waves-effect waves-light" id="ajax-alert">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @elseif(!$student && $period_id && $term_id && $grade_id)
                                <div class="text-center">No result found!</div>
                            @else
                                <div class="text-center">
                                    <i class="bx bx-search"></i><span>Search for results!</span>
                                </div>
                            @endif
                        </div>
                    </div>
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
                                    
                                    setInterval(function () {
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
            })
        </script>
      @endsection
  </div>
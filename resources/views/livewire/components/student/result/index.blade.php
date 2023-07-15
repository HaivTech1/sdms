  <div class="row">
    <x-loading />

      <div class="col-12">
          <div class="card">
              <div class="card-body">
                    @hasPaid
                        <form wire:submit.prevent="fetchResult" class="repeater" enctype="multipart/form-data">
                            <input type="hidden" value="{{ $user->student->grade_id }}" name="grade_id" />
                            <div data-repeater-list="group-a">
                                <div data-repeater-item class="row">
                                    <div class="mb-3 col-lg-3">
                                        <label for="name">Grade</label>
                                        <select class="form-control " wire:model.defer="grade_id">
                                            <option value=''>Choose...</option>
                                            @foreach ($grades as $id => $grade)
                                            <option value="{{  $id }}">{{ $grade }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="grade_id" />
                                    </div>

                                    <div class="mb-3 col-lg-3">
                                        <label for="name">Session</label>
                                        <select class="form-control " wire:model.defer="period_id">
                                            <option value=''>Choose...</option>
                                            @foreach ($periods as $id => $period)
                                            <option value="{{  $id }}">{{ $period }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="period_id" />
                                    </div>

                                    <div class="mb-3 col-lg-3">
                                        <label for="email">Term</label>
                                        <select id="formrow-inputState" class="form-select" wire:model.defer="term_id">
                                            <option selected>Choose...</option>
                                            @foreach ($terms as $id => $term)
                                            <option value="{{ $id }}">{{ $term }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="term_id" />
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
                                                                {{ $student->totalSubjects() }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class='d-flex justify-content-center align-items-center'>
                                                        {{-- <button title="Click to view result" id="scratchCard" type="button" class="btn btn-sm btn-primary waves-effect waves-light" id="ajax-alert">
                                                            <i class="fa fa-eye"></i>
                                                        </button> --}}
                                                        {{-- <a href="{{ route('result.primary.show', $user->student->id()) }}?grade_id={{$grade_id}}&period_id={{$period_id}}&term_id={{$term_id}}" title="Click to view result" class="btn btn-sm btn-primary waves-effect waves-light">
                                                            <i class="fa fa-eye"></i>
                                                        </a> --}}
                                                        <form action="{{ route('result.exam.pdf') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="student_id" value="{{ $student->id() }}" />
                                                            <input type="hidden" name="grade_id" value="{{ $student->grade->id() }}" />
                                                            <input type="hidden" name="period_id" value="{{ $period_id }}" />
                                                            <input type="hidden" name="term_id" value="{{ $term_id }}" />

                                                            <button class="btn btn-sm btn-primary" type="submit">
                                                                <i class="bx bxs-file-pdf"></i> Download PDF
                                                            </button>
                                                        </form>
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
            })
        </script>
      @endsection
  </div>
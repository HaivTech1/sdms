<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-search />
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        @if ($selectedRows)
                                            <div class="col-6">
                                                <div class="btn-group btn-group-example mb-3" role="group">
                                                    <button wire:click.prevent="deleteAll" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-block"></i>
                                                        Delete All
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-lg-3">
                                            <select class="form-control select2" wire:model="period">
                                                <option value=''>Select Period</option>
                                                @foreach ($periods as $period)
                                                <option value="{{ $period->id }}">{{ $period->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <select class="form-control select2" wire:model="term">
                                                <option value=''>Select Term</option>
                                                @foreach ($terms as $term)
                                                <option value="{{ $term->id }}">{{ $term->title() }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </diV>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="btn-group btn-group-example mb-3" role="group">
                                <button type="button" class="btn btn-primary w-xs" data-bs-toggle="modal" data-bs-target=".addPayment">
                                <i class="mdi mdi-plus me-1"></i>Add Payment</button>
                                <button type="button" class="btn btn-danger w-xs" data-bs-toggle="modal" data-bs-target=".outstanding"><i class="mdi mdi-minus me-1"></i>Outstanding</button>
                                <button type="button" class="btn btn-info w-xs" data-bs-toggle="modal" data-bs-target=".verify"><i class="mdi mdi-plus me-1"></i>Verify Payment</button>
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;" class="align-middle">
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        wire:model="selectPageRows">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Paid by</th>
                                            <th class="align-middle"> Student Name</th>
                                            <th class="align-middle"> Class</th>
                                            <th class="align-middle"> Paid</th>
                                            <th class="align-middle"> Balance</th>
                                            <th class="align-middle"> Status</th>
                                            <th class="align-middle"> Date</th>
                                            <th class="align-middle"> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $key => $payment)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $payment->id() }}"
                                                        type="checkbox" id="{{ $payment->id() }}"
                                                        wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $payment->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $key + 1}}
                                            </td>
                                            <td>
                                                {{ $payment->paidBy()}}
                                            </td>
                                            <td>
                                                <span>{{ $payment->student->firstName()}} {{
                                                    $payment->student->lastName()}}</span>
                                            </td>
                                            <td>
                                                <span>{{ $payment->student->grade->title()}}</span>
                                            </td>
                                            <td>
                                                {{ number_format($payment->amount(), 2)}}
                                            </td>
                                            <td>
                                                {{ number_format($payment->balance(), 2)}}
                                            </td>
                                            <td>
                                                <span class="{{ $payment->payment_badge }}">{{
                                                    $payment->payment_status}}</span>
                                            </td>
                                            <td>
                                                {{ $payment->createdAt()}}
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('receipt', $payment) }}">Print Receipt</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $payments->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade outstanding" tabindex="-1" role="dialog" aria-labelledby="outstanding" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outstanding">Manually add outstanding for a student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addOutstanding">
                        <div clss="row">
                            <div class="col-md-12 mb-2">
                                <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-2">
                                <select class="form-control select2" wire:model="student_id">
                                    <option value=''>Select Student</option>
                                    @foreach ($students as $student)
                                    <option value="{{  $student->id() }}">{{ $student->lastName() }} {{
                                        $student->firstName() }} {{
                                        $student->otherName() }} 
                                    </option>
                                    @endforeach
                                    <x-form.error for="student_id" />
                                </select>
                            </div>

                            <div class="col-md-12 mb-2">
                                <select class="form-control " wire:model.defer="period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="period_id" />
                            </div>

                            <div class="col-md-12 mb-2">
                                <select class="form-control select2" wire:model.defer="term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="term_id" />
                            </div>

                            <div class="col-sm-12">
                                <x-form.label for='outstanding' value="{{ __('Outstanding') }}" />
                                <x-form.input type="number" id='outstanding' class="block w-full mt-1"
                                    wire:model.defer="outstanding" />
                                <x-form.error for="outstanding" />
                            </div>

                            <div class="col-sm-12 mt-2">
                                <div class="pull-right">
                                    @if ($check && $check->outstanding !== null)
                                        <button type="button" wire:click="deleteOutstanding" class="btn btn-danger">Delete</button>
                                    @endif
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade addPayment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add payment manually</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div>
                        <form wire:submit.prevent="createPayment">
                            <div class="row">
                                <div class="col-sm-6">
                                    <x-form.input type="text" id='paid_by' class="block w-full mt-1"
                                        wire:model.defer="paid_by"
                                        placeholder="Who is making the Payment?" />
                                    <x-form.error for="paid_by" />
                                </div>

                                <div class="col-sm-6">
                                    <x-form.input type="text" id='description' class="block w-full mt-1"
                                        wire:model.defer="description"
                                        placeholder="Paying for?" />
                                    <x-form.error for="description" />
                                </div>

                                <div class="col-sm-6 mt-2">
                                    <select wire:model="grade" class="form-control">
                                        <option>Select class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="grade" />
                                </div>

                                <div class="col-sm-6 mt-2">
                                    <select wire:model.defer="student" class="form-control">
                                        <option>Select Student</option>
                                        @foreach ($students as $student)
                                        <option value="{{ $student->id() }}">
                                            {{ $student->firstName() }} {{ $student->lastName() }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="student" />
                                </div>

                                <div class="col-sm-6 mt-2">
                                    <select wire:model.defer="period_id" class="form-control">
                                        <option>Select Period</option>
                                        @foreach ($periods as $period)
                                        <option value="{{ $period->id() }}">
                                            {{ $period->title() }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="period_id" />
                                </div>

                                <div class="col-sm-6 mt-2">
                                    <select wire:model.defer="term_id" class="form-control">
                                        <option>Select Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{ $term->id() }}">
                                            {{ $term->title() }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="term_id" />
                                </div>

                                <div class="col-sm-6 mt-2">
                                    <x-form.label for='type' value="{{ __('Payment Type') }}" />
                                    <select wire:model.defer="type" class="form-control">
                                        <option value="">Select type</option>
                                        <option value="partial">Partial</option>
                                        <option value="full">Full payment</option>
                                    </select>
                                    <x-form.error for="type" />
                                </div>

                                <div class="col-sm-6">
                                    <x-form.label for='amount' value="{{ __('Amount') }}" />
                                    <x-form.input type="number" id='amount' class="block w-full mt-1"
                                        wire:model.defer="amount" placeholder="How much?" />
                                    <x-form.error for="amount" />
                                </div>

                                <div class="col-sm-12">
                                    <x-form.label for='balance' value="{{ __('To Balance with') }}" />
                                    <x-form.input type="number" id='balance' class="block w-full mt-1"
                                        wire:model.defer="balance" />
                                    <x-form.error for="balance" />
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-secondary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade verify" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verify payment manually</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                    <label class="form-label">Verify Payment via email</label>
                                        <x-form.input id="first_name" class="block w-full mt-1" type="text" name="email"
                                        :value="old('email')" id="email" placeholder="Enter email" autofocus />
                                </div>
                                <div class="templating-select">
                                    <select class="form-control select2-templating" hidden>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2">
                                <div class="pull-right">
                                    <button type="submit" id="verify-payment" class="btn btn-secondary">Verify</button>
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
            $('#email').on('change', function () {
                var email = $(this).val();
                var select = $('.templating-select select');
                select.empty();
                $.ajax({
                    url: '/payment/get-students',
                    type: 'GET',
                    data: {email: email},
                    success: function (response) {
                        select.empty();
                        select.removeAttr('hidden');
                        $.each(response, function (index, student) {
                            var fullName = student.first_name + ' ' + student.last_name;
                            if (student.other_name) {
                                fullName += ' ' + student.other_name;
                            }
                            
                            var option = $('<option>');
                            option.attr('value', student.uuid);
                            option.text(fullName);
                            select.append(option);
                        });
                        
                        // Show the select element once the AJAX request is complete
                        select.removeClass('hidden');
                    }
                });
            });

            $('#verify-payment').on('click', function () {
                var button = $(this);
                toggleAble(button, true);
                var studentId = $('.templating-select select').val();
                $.ajax({
                    url: '/payment/verify-payment',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {student_id: studentId},
                    success: function (response) {
                        toggleAble(button, false);
                        toastr.success(response.message);
                    },
                    error: function (xhr, status, error) {
                        toggleAble(button, false);
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseText);
                    }
                });
            });

        </script>
    @endsection
</div>

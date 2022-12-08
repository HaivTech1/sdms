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
                                <button type="button" class="btn btn-primary w-xs">Debtors List</button>
                                <button type="button" class="btn btn-danger w-xs"><i class="mdi mdi-thumb-down"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-sm-8'>
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
                        <div class='col-sm-4'>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Make Payment</h4>
                                    <form wire:submit.prevent="createPayment">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <x-form.input type="text" id='paid_by' class="block w-full mt-1"
                                                    wire:model.defer="paid_by"
                                                    placeholder="Who is making the Payment?" />
                                                <x-form.error for="paid_by" />
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
                                                <select wire:model="student" class="form-control">
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
                                                    wire:model="amount" placeholder="How much?" />
                                                <x-form.error for="amount" />
                                            </div>

                                            <div class="col-sm-12">
                                                <x-form.input type="hidden" id='payable' class="block w-full mt-1"
                                                    wire:model="payable" disabled />
                                                <x-form.error for="payable" />
                                            </div>

                                            @if($showBalance)
                                            <div class="col-sm-12">
                                                <x-form.label for='balance' value="{{ __('To Balance with') }}" />
                                                <x-form.input type="number" id='balance' class="block w-full mt-1"
                                                    wire:model="balance" disabled />
                                                <x-form.error for="balance" />
                                            </div>
                                            @endif

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
            </div>
        </div>
    </div>
</div>
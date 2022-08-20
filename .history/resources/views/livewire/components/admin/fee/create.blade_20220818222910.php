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
                                    </div>
                                </diV>
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
                                            <th class="align-middle"> Paid For</th>
                                            <th class="align-middle"> Amount</th>
                                            <th class="align-middle"> Date</th>
                                            <th class="align-middle">Action</th>
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
                                                {{ $payment->author->name()}}
                                            </td>
                                            <td>
                                                {{ $payment->student->firstName()}} {{ $payment->student->lastName()}}
                                            </td>
                                            <td>
                                                {{ $payment->amount()}}
                                            </td>
                                            <td>
                                                {{ $payment->createdAt()}}
                                            </td>
                                            <td>
                                                fjlklsgsdkl
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
                                                <x-form.label for='amount' value="{{ __('Amount') }}" />
                                                <x-form.input type="number" id='amount' class="block w-full mt-1"
                                                    wire:model.defer="state.amount" />
                                                <x-form.error for="amount" />
                                            </div>

                                            <div class="col-sm-12 mt-2">
                                                <x-form.label for='type' value="{{ __('Payment Type') }}" />
                                                <select wire:model.defer="state.type" class="form-control">
                                                    <option>Select type</option>
                                                    <option value="partial">Partial</option>
                                                    <option value="full">Full payment</option>
                                                </select>
                                                <x-form.error for="type" />
                                            </div>

                                            <div class="col-sm-12 mt-2">
                                                <x-form.label for='grade' value="{{ __('Select class') }}" />
                                                <select wire:model="grade" class="form-control">
                                                    <option>Select classes</option>
                                                    @foreach ($grades as $grade)
                                                    <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                                    @endforeach
                                                </select>
                                                <x-form.error for="grade" />
                                            </div>

                                            <div class="col-sm-12 mt-2">
                                                <x-form.label for='student' value="{{ __('Select Student') }}" />
                                                <select wire:model.defer="state.student" class="form-control">
                                                    <option>Select Student</option>
                                                    @foreach ($students as $student)
                                                    <option value="{{ $student->id() }}">
                                                        {{ $student->firstName() }} {{ $student->lastName() }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <x-form.error for="student" />
                                            </div>
                                            <div class="col-sm-12 mt-2">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-secondary">Add</button>
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
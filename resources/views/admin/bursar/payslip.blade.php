<x-app-layout>
    @section('title', application('name')." | Generate Payslip")

        @section('styles')
            <style>
                .analysis {
                    display: none
                }

                .table {
                    display: flex;
                    justify-content: center;
                }
            </style>
        @endsection
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Payslip</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </x-slot>
        
        <livewire:components.admin.payslip.index />

        <div class="modal fade addSlip" tabindex="-1" role="dialog" aria-labelledby="addSlip" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSlip">Generate payment slip</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="modalErrorr"></div>

                        <form id="createSlip">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label>Staff</label>
                                    <select class="form-control select2" name="worker_id" id="worker_id">
                                        <option value=''>Select</option>
                                        @foreach ($workers as $worker)
                                            <option value="{{  $worker->id() }}">{{ $worker->name() }}</option>
                                        @endforeach
                                        <x-form.error for="worker_id" />
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label>Date</label>
                                    <div class="position-relative">
                                        <input type="date" class="form-control" name="date">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <h5 class="text-center text-danger mt-2 mb-2">Payment slip analysis</h5>

                                <div class="col-sm-6">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <tbody class="table">
                                                @foreach (payslipList() as $list)
                                                    <tr>
                                                        <td>{{ $list['title'] }}</td>
                                                        <td>
                                                            <x-form.input id="{{ $list['key'] }}" class="block mt-1 payslip-input" type="text" value="0" name="{{ $list['key'] }}" style="text-align: center" />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6 mb-2">
                                            <label for="total">Gross Salary:</label>
                                            <x-form.input type="text" class="block" name="total" id="total" style="text-align: center" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="pension">+ 10% Pension</label>
                                            <x-form.input type="text" class="block payslip-input" name="pension" id="pension" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="grossPension">Gross + Pension</label>
                                            <x-form.input type="text" class="block" name="grossPension" id="grossPension" style="text-align: center" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="pension10">- 10% Pension</label>
                                            <x-form.input type="text" class="block payslip-input" name="pension10" id="pension10" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="pension8">- 8% Pension</label>
                                            <x-form.input type="text" class="block payslip-input" name="pension8" id="pension8" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="paye">- PAYE</label>
                                            <x-form.input type="text" class="block payslip-input" name="paye" id="paye" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="welfare">- Welfare</label>
                                            <x-form.input type="text" class="block payslip-input" name="welfare" id="welfare" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="others">- Others</label>
                                            <x-form.input type="text" class="block payslip-input" name="others" id="others" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="refund">- Loan Refund</label>
                                            <x-form.input type="text" class="block payslip-input" name="refund" id="refund" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="contribution">- Coop Contribution</label>
                                            <x-form.input type="text" class="block payslip-input" name="contribution" id="contribution" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="loan">- Coop Loan</label>
                                            <x-form.input type="text" class="block payslip-input" name="loan" id="loan" style="text-align: center"  value="0" />
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <label for="net">Net Pay:</label>
                                            <x-form.input type="text" class="block" name="net" id="net" style="text-align: center" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="pull-right">
                                    <button type="submit" id="slipBtn" class="btn btn-primary">Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="reviewModal" class="modal fade" tabindex="-1" aria-labelledby="#reviewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Payslip summary</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Worker</th>
                                                            <th>Account Number</th>
                                                            <th>Bank</th>
                                                            <th class="text-end">Amount</th>
                                                            <th class="d-print-none">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="reviewTable">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-print-none">
                                                <div class="float-end">
                                                    <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-primary w-md waves-effect waves-light">Send</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-print-none">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
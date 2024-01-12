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
                                   <div class="text-sm-end">
                                        <button type="button" data-bs-toggle="modal" data-bs-target=".addSlip"
                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 me-2"><i
                                                class="mdi mdi-plus me-1"></i> Create Payslip</button>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle"> Date</th>
                                            <th class="align-middle">Workers</th>
                                            <th class="align-middle">Amount</th>
                                            <th class="align-middle "></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payslips as $key => $payslip)

                                        @php
                                            $date = \Carbon\Carbon::createFromFormat('m Y', $payslip->month_year);
                                            $month = $date->format('F Y');
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $month }} payslips
                                            </td>
                                            <td>
                                                {{ $payslip->count }}
                                            </td>
                                            <td>
                                               {{ trans('global.naira')}} {{ number_format($payslip->total_net, 2) }}
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary review" data-date="{{ $payslip->month_year }}">Review</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $payslips->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $('.review').on('click', function(){
                var button = $(this);
                toggleAble(button, true);
                var data = $(this).data('date');
                var month = data.split(' ')[0];
                var year = data.split(' ')[1];
                

                $.ajax({
                    url: '/payslip/review',
                    method: 'GET',
                    data: {month:month, year:year},
                    success: function(data) {
                       toggleAble(button, false);
                        var rows = "";
                        let totalNet = 0;
                        let rowNumber = 1;

                        $('#reviewTable').empty();

                        $.each(data, function(key, value) {
                            rows += "<tr>";
                            rows += "<td>" + rowNumber++ +"</td>";
                            rows += "<td>" + value.worker +"</td>";
                            rows += "<td>" + value.account_number +"</td>";
                            rows += "<td>" + value.account_bank +"</td>";
                            rows += "<td class='text-end'>" + "{{ trans('global.naira')}}" + value.items.net +"</td>";
                            rows += "<td class='d-print-none'><button class='btn btn-danger btn-sm delete' id='delete' data-id='" + value.id + "'>Delete</button></td>";
                            rows += "</tr>";

                            totalNet += parseFloat(value.items.net);
                        });

                        rows += "<tr>";
                        rows += "<td colspan='4' class='text-end'>Total Payable:</td>";
                        rows += "<td class='text-end'>" + "{{ trans('global.naira')}}"+ totalNet.toFixed(2) + "</td>";
                        rows += "<td></td>";
                        rows += "</tr>";

                        $("#reviewTable").append(rows);
                        $('#reviewModal').modal('toggle');
                    },
                    error: function(err) {
                       toggleAble(button, false);
                        toastr.info(err.responseJSON.message);
                    }
                });
                
            })

            $(document).on('click', '.delete', function(){
                var id = $(this).data('id');
                var tr = $(this).closest('tr');
                
                $.ajax({
                    type: 'DELETE',
                    url: '/payslip/' + id,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(){
                        tr.remove();
                    },
                    error: function(xhr, status, error){
                        console.log(xhr.responseText);
                    }
                });
            });

        </script>

        <script>
            let inputs = document.querySelectorAll(".payslip-input");

            inputs.forEach(function(input) {
                input.addEventListener("change", updateTotal);
            });

            function updateTotal() {
                let total = 0;
                let pension = parseFloat(document.getElementById("pension").value);
                let pension10 = parseFloat(document.getElementById("pension10").value);
                let pension8 = parseFloat(document.getElementById("pension8").value);
                let paye = parseFloat(document.getElementById("paye").value);
                let welfare = parseFloat(document.getElementById("welfare").value);
                let others = parseFloat(document.getElementById("others").value);
                let refund = parseFloat(document.getElementById("refund").value);
                let contribution = parseFloat(document.getElementById("contribution").value);
                let loan = parseFloat(document.getElementById("loan").value);


                inputs.forEach(function(input) {
                    // only add the value of the input if it's not the "pension" input
                    if (input.id !== "pension" && input.id !== "pension10" && input.id !== "pension8" && input.id !== "paye" && input.id !== "welfare" && input.id !== "others" && input.id !== "refund" && input.id !== "contribution" && input.id !== "loan") {
                        total += parseFloat(input.value);
                    }
                });

                var newTotal = total + pension - pension10 - pension8 - paye - welfare - others - refund - contribution - loan;

                document.getElementById("total").value = total.toFixed(2);
                document.getElementById("net").value = newTotal.toFixed(2);
                
                // call the updateGrossPension function to update the "grossPension" input field
                updateGrossPension();
            }

            function updateGrossPension() {
                let total = 0;
                let pension = parseFloat(document.getElementById("pension").value);
                let pension10 = parseFloat(document.getElementById("pension10").value);
                let pension8 = parseFloat(document.getElementById("pension8").value);
                let paye = parseFloat(document.getElementById("paye").value);
                let welfare = parseFloat(document.getElementById("welfare").value);
                let others = parseFloat(document.getElementById("others").value);
                let refund = parseFloat(document.getElementById("refund").value);
                let contribution = parseFloat(document.getElementById("contribution").value);
                let loan = parseFloat(document.getElementById("loan").value);
                let grossPension = 0;

                inputs.forEach(function(input) {
                    if (input.id !== "pension" && input.id !== "pension10" && input.id !== "pension8" && input.id !== "paye" && input.id !== "welfare" && input.id !== "others" && input.id !== "refund" && input.id !== "contribution" && input.id !== "loan") {
                        total += parseFloat(input.value);
                    }
                });

                grossPension = total + pension;

                document.getElementById("grossPension").value = grossPension.toFixed(2);
            }

            let pensionInput = document.getElementById("pension");
            pensionInput.addEventListener("change", updateGrossPension);

            let pension10Input = document.getElementById("pension10");
            pension10Input.addEventListener("change", updateGrossPension);

            let pension8Input = document.getElementById("pension8");
            pension8Input.addEventListener("change", updateGrossPension);
        </script>
        
        <script>
            $('#createSlip').on('submit', function(e){
                e.preventDefault();
                toggleAble('#slipBtn', true, 'Generating slip...');

                var data = $(this).serializeArray();
                var method = 'POST';
                var url = '{{ route('payslip.store') }}'

                $.ajax({
                    method,
                    url,
                    data,
                 }).done((res) => {
                    toggleAble('#slipBtn', false);
                    toastr.success(res.message);
                    $('.addSlip').modal('toggle');
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000);
                }).fail((err) => {
                    toggleAble('#slipBtn', false);
                     let allErrors = Object.values(err.responseJSON.errors).map(el => (
                            el = `<li>${el}</li>`
                        )).reduce((next, prev) => ( next = prev + next ));

                    const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul>${allErrors}</ul>
                                        </div>
                                        `;

                    $('.modalErrorr').html(setErrors);
                    toastr.error(err.messageJSON.message);
                });
            })
        </script>

        <script>
            $(document).ready(function() {
                $('#worker_id').change(function() {
                    var workerId = $(this).val();

                    $.ajax({
                        url: '/payslip/' + workerId,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                console.log(key);
                                $('#' + key).val(value);
                            });
                        },
                        error: function(err) {
                            toastr.info('No payslip for this worker yet!');
                        }
                    });
                });
            });
        </script>
    @endsection
</div>
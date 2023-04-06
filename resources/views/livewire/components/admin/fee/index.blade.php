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
                                                    class="btn btn-outline-danger w-sm">
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
                        <div class=" col-sm-4">
                            <div class="text-sm-end">
                                <button type="button"
                                    data-bs-toggle="modal" data-bs-target=".addFee"
                                    class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> 
                                        Add Fee
                                </button>
                                <a href="{{ route('fee.create') }}"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                    Make Payment
                                </a>
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
                                            <th class="align-middle"> Class</th>
                                            <th class="align-middle"> Type</th>
                                            <th class="align-middle"> Term</th>
                                            <th class="align-middle"> Price</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fees as $key => $fee)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $fee->id() }}"
                                                        type="checkbox" id="{{ $fee->id() }}" wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $fee->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $key + 1}}
                                            </td>
                                             <td>
                                                {{ $fee->grade->title() ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fee->type_fee }}
                                            </td>
                                            <td>
                                                {{ $fee->term->title() }}
                                            </td>
                                            <td>
                                                {{ trans('global.naira') }} {{ $fee->details->sum('price') }}
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$fee' field='status'
                                                    :key='$fee->id()' />
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary editFee" 
                                                    type="button"
                                                    data-id="{{ $fee->id }}"
                                                    data-grade="{{ $fee->grade_id }}"
                                                    data-term="{{ $fee->term_id }}"
                                                    data-type="{{ $fee->type }}"
                                                    data-details="{{ json_encode($fee->details->toArray()) }}"
                                                >
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $fees->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade addFee" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div>
                        <form id="newFee" action="{{ route('fee.store') }}" method='post'>
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 mt-2 mb-2">
                                    <x-form.label for='grade_id' value="{{ __('Class') }}" />
                                    <select name="grade_id" class="form-control">
                                        <option>Select</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="grade_id" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="term_id" value="{{ __('Term') }}" />
                                    <select class="form-control" name="term_id">
                                        <option>Select</option>
                                        @foreach ($terms as $term)
                                        <option value="{{ $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12 mt-2 mb-2">
                                    <x-form.label for='type' value="{{ __('Fee Type') }}" />
                                    <select name="type" class="form-control">
                                        <option>Select</option>
                                        <option value="n">Normal</option>
                                        <option value="s">Staff</option>
                                        <option value="scholarship">Scholarship</option>
                                    </select>
                                    <x-form.error for="type" />
                                </div>

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="mb-2">
                                            <em>List out the fee details</em>
                                        </div>

                                        <div class="col-sm-12">
                                            <table class="table table-bordered" id="dynamicTable">  
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                                <tr>  
                                                    <td><input type="text" name="addmore[0][title]" placeholder="Enter your title" class="form-control" /></td>  
                                                    <td><input type="text" name="addmore[0][price]" placeholder="Enter your price" class="form-control priceTotl" /></td>  
                                                    <td><button type="button" name="add" id="add" class="btn btn-success"><i class="bx bx-plus"></i></button></td>  
                                                </tr>  
                                            </table> 

                                            <p class="text-center text-lg">Total Price: <span id="total-price">0</span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <div class="pull-right">
                                        <button type="submit" id="submit_btn" class="btn btn-primary">Add Record</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade updateFee" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div>
                        <form id="editSelectedFee" action="{{ route('fee.updateFee') }}" method='post'>
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 mt-2 mb-2">
                                    <input name="fee_id" id="fee" type="hidden" />
                                    
                                    <x-form.label for='grade_id' value="{{ __('Class') }}" />
                                    <select name="grade_id" class="form-control" id="grade">
                                        <option>Select</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="grade_id" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="term_id" value="{{ __('Term') }}" />
                                    <select class="form-control" name="term_id" id="term">
                                        <option>Select</option>
                                        @foreach ($terms as $term)
                                        <option value="{{ $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12 mt-2 mb-2">
                                    <x-form.label for='type' value="{{ __('Fee Type') }}" />
                                    <select name="type" class="form-control" id="type">
                                        <option>Select</option>
                                        <option value="n">Normal</option>
                                        <option value="s">Staff</option>
                                        <option value="scholarship">Scholarship</option>
                                    </select>
                                    <x-form.error for="type" />
                                </div>

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="mb-2">
                                            <em class="text-danger text-center">List of the fee details</em>
                                        </div>

                                        <div class="col-sm-12" id="editTable">
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <div class="pull-right">
                                        <button type="submit" id="editBtn" class="btn btn-primary">Update record</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
        <script>
            $('#newFee').on('submit', function(e){
                e.preventDefault();
                toggleAble('#submit_btn', true, 'Creating...');
                let formData = new FormData($(this)[0]);
                var method = $(this).attr('method');
                var url = $(this).attr('action');

                $.ajax({
                    method,
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    toggleAble('#submit_btn', false);
                    toastr.success(res.message);
                    $('.addFee').modal('toggle');
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000);
                }).fail((err) => {
                    toggleAble('#submit_btn', false);
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

            });

            $(".editFee").click(function(e) {
                e.preventDefault();

                var id = $(this).data('id');
                var grade = $(this).data('grade');
                var term = $(this).data('term');
                var type = $(this).data('type');
                var details = $(this).data('details');


               var table = "<table class='table table-bordered' id='dynamicTable'><tr><th>Title</th><th>Price</th><th>Action</th></tr>";
                details.forEach(function(detail, index) {
                    table += "<tr><td><input type='text' name='addmore["+index+"][title]' value='" + detail.title + "' placeholder='Enter your title' class='form-control' /></td><td><input type='text' name='addmore["+index+"][price]' value='" + detail.price + "' placeholder='Enter your price' class='form-control' /></td><input type='hidden' name='addmore["+index+"][id]' value='" + detail.id + "'/>";
                    if (index == details.length - 1) {
                        table += "<td><button type='button' name='add' id='add' class='btn btn-success'><i class='bx bx-plus'></i></button></td>";
                    } else {
                        table += "<td><button type='button' name='remove' class='btn btn-danger'><i class='bx bx-minus'></i></button></td>";
                    }
                    table += "</tr>";
                });

                table += "</table>";

                $(".updateFee #editTable").html("");
                $(".updateFee #editTable").append(table);

                var addButton = $("#dynamicTable #add");
                var removeButton = $("#dynamicTable button[name='remove']");

                addButton.click(function() {
                    var index = $("#dynamicTable tbody tr").length;
                    var newRow = "<tr><td><input type='text' name='addmore["+index+"][title]' placeholder='Enter your title' class='form-control' /></td><td><input type='text' name='addmore["+index+"][price]' placeholder='Enter your price' class='form-control' /></td><td><button type='button' name='remove' class='btn btn-danger'><i class='bx bx-minus'></i></button></td></tr>";
                    $("#dynamicTable tbody").append(newRow);
                });


                $(document).on("click", "#dynamicTable button[name='remove']", function() {
                    $(this).closest("tr").remove();
                });

                document.getElementById("fee").value=id;
                document.getElementById('grade').value=grade;
                document.getElementById('term').value=term;
                document.getElementById('type').value=type;

                $(".updateFee").modal('toggle');                
            });

            $('#editSelectedFee').on('submit', function(e){
                e.preventDefault();
                toggleAble('#editBtn', true, 'Updating...');
                let formData = new FormData($(this)[0]);
                var method = $(this).attr('method');
                var url = $(this).attr('action');

                $.ajax({
                    method,
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    toggleAble('#editBtn', false);
                    toastr.success(res.message);
                    $('.updateFee').modal('toggle');
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000);
                }).fail((err) => {
                    toggleAble('#editBtn', false);
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
            var i = 0;
            $("#add").click(function(){
                ++i;
                $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][title]" placeholder="Enter your title" class="form-control" /></td><td><input type="text" name="addmore['+i+'][price]" placeholder="Enter your price" class="form-control priceTotl" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
                // add an event listener to the new price input field
                $('#dynamicTable tr:last-child .priceTotl').on('input', function() {
                    calculateTotalPrice();
                });
            });

            $(document).on('click', '.remove-tr', function(){  
                $(this).parents('tr').remove();
                calculateTotalPrice();
            });  

            function calculateTotalPrice() {
                var total = 0;
                // loop through all price input fields and add their values to the total
                $('.priceTotl').each(function() {
                    var price = parseFloat($(this).val());
                    if(!isNaN(price)) {
                        total += price;
                    }
                });
                // update the total price element
                $('#total-price').text(total.toFixed(2));
            }
            
            // call the function initially to calculate the total price for the initial row
            calculateTotalPrice();
        </script>
    @endsection
</div>
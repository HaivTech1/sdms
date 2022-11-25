<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Messaging</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">SMS Messaging</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if(!$smsapi)
                                <div class="row">
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="background-color: rgb(255, 0, 0); padding: 15px; border-radius: 20px">
                                        <div>
                                            <h4 class="card-title text-white">Ooops! SMS API Not Set.</h4>
                                            <p class="card-title-desc text-white">Please <button type="button"
                                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                                                    aria-controls="offcanvasWithBothOptions" class="btn btn-primary">
                                                    Set
                                                    The SMS API </button> to be able to send
                                                sms.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <form id="send-sms-form" role="form" method="POST" action="{{route('messaging.sendSMS')}}">
                                @csrf
                                <input name="author_id" value="3" type="text" hidden="hidden" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <select class="form-control block w-full mt-1 select2-multiple" name="to[]"
                                                multiple="multiple" data-placeholder="Choose Receipient..."
                                                id="num-selector" name="to[]">
                                                <optgroup label="Select Staffs">
                                                    @foreach ($users as $user)
                                                    <option value="{{ $user->phone() }}">{{ $user->name() . ' - ' .
                                                        $user->phone() }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Select guardian">
                                                    @foreach ($guardians as $guardian)
                                                    <option value="{{ $guardian->phoneNumber() }}">{{ $guardian->fullName() }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <x-form.input id="nums" type="text"
                                                    placeholder="Type in comma seperated Numbers and click add"
                                                    class="form-control" aria-label="Recipient's email"
                                                    aria-describedby="basic-addon2" value="{{ old('nums') }}" />
                                            </div>
                                            <div class="col-sm-3">
                                                <button id="add-num" type="button"
                                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                                    Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <textarea id="textarea" class="form-control" maxlength="200" rows="3" name="message"
                                                placeholder="Your message has a limit of 200 words." value="{{ old('message') }}"></textarea>
                                </div>

                                <div class="d-flex justify-content-center flex-wrap mt-5">
                                    <button id="send-btn" type="submit"
                                        class="btn btn-primary block waves-effect waves-light pull-right">Send
                                        Message</button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Create Branch Account</h4>

                            <form id="sub-account" method="post">
                                <div class="row mb-4">
                                    <label for="commission_account_name" class="col-sm-3 col-form-label">Account
                                        Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="commission_account_name"
                                            name="commission_account_name">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="commission_account_number" class="col-sm-3 col-form-label">Account
                                        Number</label>
                                    <div class="col-sm-9">
                                        <input id="commission_account_number" class="form-control" type="number"
                                            name="commission_account_number">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="bank_select" class="col-sm-3 col-form-label">Bank
                                        Name</label>
                                    <div class="col-sm-9">
                                        <select id="bank_select" class="form-control" name="commission_account_bank">
                                        </select>
                                    </div>
                                </div>

                                <input type="text" hidden name="name" value="sub_account">
                                <input type="text" hidden name="percentage_charge" value="0">
                                @csrf

                                <div class="row justify-content-end">
                                    <div class="col-sm-9">
                                        <div>
                                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-title">
                            <div class="d-flex justify-content-center">
                                <button id="demo-editable-enable" class="btn btn-purple"><i
                                        class="fa fa-edit"></i>Edit</button>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="demo-editable-table" class="table table-striped table-nowrap mb-0">
                                    <tbody>
                                    <tbody>
                                        <tr>
                                            <td width="35%">Sms Key</td>
                                            <td width="65%"><a href="#" id="smsapi"></a></td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Sms Secret</td>
                                            <td width="65%"><a href="#" id="smsbalanceapi"></a></td>
                                        </tr>
                                        @admin
                                        <tr>
                                            <td>Collection Commission</td>
                                            <td><a href="#" id="collection_commission" data-type="number" data-pk="1"
                                                    data-placement="right" data-placeholder="e.g, 20"
                                                    data-title="Collection's commission percentage"></a>
                                            </td>
                                        </tr>
                                        @endadmin
                                    </tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @section('scripts')
    <!-- for email manual number input -->
    <script>
        var dt = {}
        $.ajax({
                url: "{{route('option.branch.get')}}"
            })
            .done((res) => {
                if (res.status) {
                    console.log(res.status)
                    json = res.text
                    json.forEach((index) => {
                        dt[index.name] = index.value
                    })
                    console.log(dt);
                    const opt = "setValue"

                    $("#smsapi").editable(opt, dt.smsapi)
                    $("#smsbalanceapi").editable(opt, dt.smsbalanceapi)
                    $("#collection_commission").editable(opt, dt.collection_commission)
                    $("#bank_select").append(
                        `<option selected value="${dt.commission_account_bank}">${dt.commission_account_bank}</option>`
                    )
                    $("#commission_account_name").val(dt.commission_account_name)
                    $("#commission_account_number").val(dt.commission_account_number)
                    // $("#collection_commission").editable(opt, dt.collection_commission)
                }
            })
            .fail((e) => {
                console.log(e);
            })

        $(document).ready(() => {
            // on submit sub account
            $('#sub-account').submit((e) => {
                e.preventDefault();
                const data = $('#sub-account').serializeArray()
                $.post({
                        url: "{{route('option.branch.post')}}",
                        data
                    })
                    .done((res) => {
                        toastr.success(res.text, 'Success!');
                    }).fail((e) => {
                        console.log(e);
                        toastr.error(e, 'Failed!');
                    })
            })

            // fetch banks for select drop down
            $.get("{{route('banks')}}").done((res) => {
                res.map((v) => {
                    $('#bank_select').append(`<option value="${v.value}">${v.text}</option>`)
                })
            })

            // defaults
            $.fn.editable.defaults.url = "{{route('option.branch.post')}}";
            $.fn.editable.defaults.send = 'always';
            // default params e.g token

            $.fn.editable.defaults.params = function (params) {
                params._token = "{{csrf_token()}}";
                return params;
            };

            $("#demo-editable-enable").click(function () {
                $("#demo-editable-table .editable").editable("toggleDisabled");
            });

            //smsapi
            $("#smsapi").editable({
                type: "text",
                pk: 1,
                name: "smsapi",
                mode: "inline",
                params: function (d) {
                    d._token = "{{csrf_token()}}";
                    d.value = encodeURI(d.value)
                    return d
                },
                title: "Enter Your SMS Api Url Exluding message parameter",
                validate: function (value) {
                    if ($.trim(value) == "") return "This field is required";
                }
            });

            //smsbalanceapi
            $("#smsbalanceapi").editable({
                type: "text",
                pk: 1,
                name: "smsbalanceapi",
                mode: "inline",
                params: function (d) {
                    d._token = "{{csrf_token()}}";
                    d.value = encodeURI(d.value)
                    return d
                },
                title: "Enter Your SMS Balance Api Url For Getting SMS Unit Balance",
                validate: function (value) {
                    if ($.trim(value) == "") return "This field is required";
                }
            });

        });

        // collection commission
        $("#collection_commission").editable({
            validate: function (value) {
                if ($.trim(value) == "") return "This field is required";
            }
        });

        var responseText = (obj) => {
            text = ''
            text += `${obj.pass.count} Sent ${obj.fail.count} Failed. Out Of ${obj.total} \n`
            text += (obj.fail.count > 0) ? `Failed Number(s): ${$.each(obj.fail.numbers,(v) => (`${v} `))} \n
                Failed Status: ${$.each(obj.fail.status,(v) => (`${v} `))}` : ''
            return text
        }

        const saveClick = () => {
            $('#mod').hide();
            $('#def').show();
            $('#save-ho').hide();
            $('#cancel-ho').hide();
            $('#edit-ho').show();
            $('#img-logo').show();
            $('#img-logo-input').hide();
        }

        const editClick = () => {
            $('#img-logo').hide();
            $('#mod').show();
            $('#img-logo-input').show();
            $('#cancel-ho').show();
            $('#def').hide();
            $('#edit-ho').hide();
            $('#save-ho').show();
        }

        const cancelClick = () => {
            $('#mod').hide();
            $('#cancel-ho').hide();
            $('#img-logo').show();
            $('#def').show();
            $('#img-logo-input').hide();
            $('#edit-ho').show();
            $('#save-ho').hide();
        }

        // var dummyRes = {status: true, text: { pass: {status: [], count: 1}, fail: {status: [], count: 0, numbers: []}, total: 1}}
        $(document).ready(function () {
            $('#send-sms-form').submit((e) => {
                toggleAble($('#send-btn'), true, 'sending...')
                e.preventDefault();
                data = $('#send-sms-form').serializeArray()
                url = "{{route('messaging.sendSMS')}}"
                
                poster({
                    data,
                    url,
                    alert: 'false'
                }, (res) => {
                    if (res.status === true) {
                        text = responseText(res.text)
                        toastr.success(text, 'Success!');
                        toggleAble($('#send-btn'), false)
                    } else if (res.status === false) {
                        toastr.error(res.text, 'Failed!');
                        toggleAble($('#send-btn'), false)
                    }
                })
                toggleAble($('#send-btn'), false);
            })

            $('#add-num').click(function () {
                if (!$('#nums').val()) {
                    return;
                }
                var items = $('#nums').val().split(',');
                
                $.each(items, function (i, item) {
                    $('#nums').val('');
                    //$("#list").append('<li class="list-group-item d-flex justify-content-between align-items-center">'+ item +'  <span class="badge badge-danger badge-pill"><i onClick="rm_num(this);" class="btn fa fa-trash"></i></span></li>');
                    $('#num-selector').append($('<option>', {
                        value: smsPhoneNumber(item),
                        text: smsPhoneNumber(item),
                        selected: 'selected'
                    }, '</option>'));
                });

                var val = $('#num-selector').text().split(',');

                alert('Added ' + items);
                $('#num-selector').selectpicker('refresh');
                $.each(val, function (i, item) {});
            });

        });

        function smsPhoneNumber(smsNumberString) {
            var cleaned = ('' + smsNumberString).replace(/\D/g, '')
            var NG = 234 + cleaned;
            return NG
        }

        //selected="selected" value="' + item +'" >'+ item +'</option>'
        function rm_num(d) {
            var text = $(d).parent().parent().text();
            var input = $("#num-selector option[value='" + text + "']").remove();
            var ll = $('#list ' + d).remove();
        }

        function fetchBalance() {
            // get these credentials from Vonage's dashboard
            const apiKey = 'b85b9158' 
            const apiSecret = 'ApNc3v2VpO1f7NNN'

            // construct the api endpoint
            const url = `https://rest.nexmo.com/account/get-balance?api_key=${apiKey}&api_secret=${apiSecret}`

            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                        console.log(response)
                     // send a get request
                        // const response = UrlFetchApp.fetch(url, {'method': 'GET'})

                        // discard the execution if status code is other than 200
                        if (response.getResponseCode() !== 200) return

                        // convert the response text into a json object
                        const jsonResponse = JSON.parse(response.getContentText())

                        // parse the response and extract the account balance
                        const currentBalance = jsonResponse.value

                        // inspect the response
                        console.log(currentBalance)
                }
            });

           
        }

    </script>
    @endsection
</x-app-layout>
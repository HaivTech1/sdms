<x-app-layout>

    @section('title', getSiteSettings('app_name') . " | " . $title)

    <x-slot name="header">
        <div class="col-9">
            <h4 class="fw-semibold mb-8">{{ $title}}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="text-muted " href="{{ route('dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $description}}
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <x-search placeholder="Search users..." />

                <div
                    class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <div class="action-btn show-btn" style="display: none">
                        <a href="javascript:void(0)" class="delete-multiple btn-light-danger btn me-2 text-danger d-flex align-items-center font-medium">
                        <i class="ti ti-trash text-danger me-1 fs-5"></i> Delete All Row 
                        </a>
                    </div>
                    
                    <button id="btn-add-user" class="btn btn-info d-flex align-items-center">
                        <i class="ti ti-key text-white me-1 fs-5"></i> Add User
                    </button>
                </div>
            </div>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table search-table align-middle text-nowrap">
                    <thead class="header-item">
                        <th>
                            <div class="n-chk align-self-center text-center">
                                <div class="form-check">
                                <input type="checkbox" class="form-check-input primary" id="user-check-all" />
                                <label class="form-check-label" for="user-check-all"></label>
                                <span class="new-control-indicator"></span>
                            </div>
                        </th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Subscription</th>
                        <th>Type</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="search-items">
                                <td>
                                    <div class="n-chk align-self-center text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input user-chkbox primary" id="checkbox1" />
                                            <label class="form-check-label" for="checkbox1"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="usr-id-addr" data-id="{{ $user->id()  }}" style="display: none"></span>
                                    <span class="usr-first-name" data-first-name="{{ $user->firstName()  }}" style="display: none"></span>
                                    <span class="usr-last-name" data-last-name="{{ $user->lastName()  }}" style="display: none"></span>
                                    <span class="usr-password" data-password="{{ $user->s_password  }}" style="display: none"></span>
                                    <span class="usr-username" data-username="{{ $user->username()  }}">{{ $user->username() }}</span>
                                    <span class="usr-verified" data-verified="{{ $user->email_verified_at  }}" style="display: none">{{ $user->email_verified_at }}</span>
                                </td>
                                  <td>
                                    @if($user->email_verified_at === null)
                                        <span class="mb-1 badge font-medium bg-light-danger text-danger">Not Verified</span>
                                    @else
                                       <span class="mb-1 badge font-medium bg-light-primary text-primary">Verified</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="usr-email" data-email="{{ $user->email()  }}">{{ $user->email() }}</span>
                                </td>
                                <td>
                                    <span class="usr-phone" data-phone="{{ $user?->phone()  }}">{{ $user?->phone() }}</span>
                                </td>
                                <td>
                                    @if ($user->subscription)
                                        <span class="mb-1 badge font-medium bg-light-primary text-primary">{{ $user?->subscription?->title() }}</span>
                                    @else
                                        <span class="mb-1 badge font-medium bg-light-danger text-danger">Not Subscribed</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="usr-type" data-type="{{ $user->type()  }}">{{ $user->user_type }}</span>
                                </td>
                                <td>
                                    <div class="action-btn">
                                        <a href="javascript:void(0)" class="text-info edit">
                                            <i class="ti ti-edit fs-5"></i>
                                        </a>
                                        <a href="javascript:void(0)"  data-id="{{ $user->id()  }}" class="text-dark delete ms-2">
                                            <i class="ti ti-trash fs-5"></i>
                                        </a>
                                        <button class="btn btn-sm text-info setting"  data-name="{{ $user->username()  }}" data-id="{{ $user->id()  }}" data-subscription="{{ $user->subscription ? $user->subscription->id() : null  }}">
                                            <i class="ti ti-menu fs-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <div class="modal fade" id="addUserModal" tabindex="-1" user="dialog" aria-labelledby="addUserModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" user="document">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title">User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="add-contact-box">
                            <div class="add-contact-content">
                                <p id="user-text"></p>
                                
                                <form id="addUserModalTitle">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 user-first-name">
                                                <input type="text" id="c-first_name" class="form-control"
                                                    placeholder="First Name" name="first_name" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 user-last-name">
                                                <input type="text" id="c-last_name" class="form-control"
                                                    placeholder="Last Name" name="last_name" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 user-username">
                                                <input type="text" id="c-username" class="form-control"
                                                    placeholder="User Name" name="username" autocomplete="off" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 user-email">
                                                <input type="email" id="c-email" class="form-control"
                                                    placeholder="Email Address" name="email" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 user-phone-number">
                                                <input type="tel" id="c-phone_number" class="form-control"
                                                    placeholder="Phone number" name="phone_number" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 user-password">
                                                <input type="password" id="c-password" class="form-control"
                                                    placeholder="Password" name="password" autocomplete="off" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 user-email_verified_at">
                                                <input type="date" id="c-email_verified_at" class="form-control"
                                                     name="email_verified_at" autocomplete="off" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 contact-type">
                                            <select class="form-control" id="c-type" name="type">
                                                <option>Select</option>
                                                @foreach(user_type() as $key => $type)
                                                    <option value="{{ $key }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                            <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>

                                        <p class="text-danger">Assign/Assigned Role to user</p>

                                        <div class="col-sm-12 mt-2">
                                            <div class="table-responsive">
                                                <table class="table user-role">
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-add" class="btn btn-success rounded-pill px-4">Add</button>
                        <button id="btn-edit" class="btn btn-success rounded-pill px-4">Save</button>
                        <button class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal"> Discard </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h5 id="modal-title" class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>User Subscription</p>

                                    <div class="mb-3 user-subscription-id">
                                        <select class="form-control" id="c-subscription_id" name="subscription_id">
                                            <option>Select</option>
                                            @foreach($subscriptions as $key => $subscription)
                                                <option value="{{ $subscription->id() }}">{{ $subscription->title() }}</option>
                                            @endforeach
                                        </select>
                                        <span class="validation-text text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal"> Close </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $("#btn-add-user").on("click", function (event) {
                $("#addUserModal #btn-add").show();
                $("#addUserModal #btn-edit").hide();
                $("#addUserModal").modal("show");

                document.getElementById('user-text').innerText = "Create an new user account";

                $.ajax({
                    type: "GET",
                    url: '{{ route("admin.role.all") }}',
                    dataType: 'json',
                })
                .done((res) => {
                    displayRoles("create", res);
                })
                .fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, "Failed!");
                });
            });

            $('.setting').on('click', function(){
                $('#settingModal').modal('show');
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                var subscription = $(this).attr('data-subscription');

                document.getElementById('modal-title').innerText = "Manage " + name + " settings";
                document.getElementById('c-subscription_id').setAttribute('data-id', id);
                $('#c-subscription_id').val(subscription);

            });

            $('#c-subscription_id').on('change', function(e){
                var value = e.target.value;
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Confirm Update',
                    text: 'Are you sure you want to update the subscription?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#502179',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Update'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.user.updateSubscription', ["user" => ":id", "subscription" => ":subscription"]) }}'.replace(':id', id).replace(':subscription', value),
                            type: 'GET',
                        }).done((response) => {
                            Swal.fire('Updated!', response.message, 'success');
                        }).fail((error) => {
                            console.log(error);
                            toastr.error(error.responseJSON.message, 'Failed!');
                        });
                    }
                });
               
            });

            function checkall(clickchk, relChkbox) {
                var checker = $("#" + clickchk);
                var multichk = $("." + relChkbox);

                checker.click(function () {
                    multichk.prop("checked", $(this).prop("checked"));
                    $(".show-btn").toggle();
                });
            }

            checkall("user-check-all", "user-chkbox");

            $("#input-search").on("keyup", function () {
                var rex = new RegExp($(this).val(), "i");
                $(".search-table .search-items:not(.header-item)").hide();
                $(".search-table .search-items:not(.header-item)")
                    .filter(function () {
                        return rex.test($(this).text());
                    })
                    .show();
            });
        </script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            function addUser() {
                $("#btn-add").click(function () {

                    let data = $('#addUserModalTitle').serializeArray();
                    var url = "{{ route('admin.user.store') }}";
                    
                    var button = $(this);
                    toggleAble(button, 'Creating...');

                    $.ajax({
                        type: "POST",
                        url,
                        data,
                    })
                    .done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, "Success!");
                        $("#addUserModal").modal("hide");

                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    })
                    .fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                        toastr.error(error.responseJSON.message, "Failed!");
                    });
                });
            }

            function edituser() {
                $(".edit").on("click", function (event) {
                    $("#addUserModal #btn-add").hide();
                    $("#addUserModal #btn-edit").show();

                    // Get Parents
                    var getParentItem = $(this).parents(".search-items");
                    var getModal = $("#addUserModal");

                    // Get List Item Fields
                    var $_id = getParentItem.find(".usr-id-addr");
                    var $_firstname = getParentItem.find(".usr-first-name");
                    var $_lastname = getParentItem.find(".usr-last-name");
                    var $_username = getParentItem.find(".usr-username");
                    var $_email = getParentItem.find(".usr-email");
                    var $_phone = getParentItem.find(".usr-phone");
                    var $_type = getParentItem.find(".usr-type");
                    var $_password = getParentItem.find(".usr-password");
                    var $_verified = getParentItem.find(".usr-verified");


                    // Get Attributes
                    var $_idAttrValue = $_id.attr("data-id");
                    var $_firstNameAttrValue = $_firstname.attr("data-first-name");
                    var $_lastNameAttrValue = $_lastname.attr("data-last-name");
                    var $_usernameAttrValue = $_username.attr("data-username");
                    var $_emailAttrValue = $_email.attr("data-email");
                    var $_phoneAttrValue = $_phone.attr("data-phone");
                    var $_typeAttrValue = $_type.attr("data-type");
                    var $_passwordAttrValue = $_password.attr("data-password");
                    var $_verifiedAttrValue = $_verified.attr("data-verified");


                    // Get Modal Attributes
                    var $_getModalIdInput = getModal.find("#c-id");
                    var $_getModalFirstNameInput = getModal.find("#c-first_name");
                    var $_getModalLastNameInput = getModal.find("#c-last_name");
                    var $_getModalUsernameInput = getModal.find("#c-username");
                    var $_getModalEmailInput = getModal.find("#c-email");
                    var $_getModalPhoneInput = getModal.find("#c-phone_number");
                    var $_getModalTypeInput = getModal.find("#c-type");
                    var $_getModalPasswordInput = getModal.find("#c-password");
                    var $_getModalVerifiedInput = getModal.find("#c-email_verified_at");


                    // Set Modal Field's Value
                    var $_setModalIdValue = $_getModalIdInput.val($_idAttrValue);
                    var $_setModalFirstNameValue = $_getModalFirstNameInput.val($_firstNameAttrValue);
                    var $_setModalLastNameValue = $_getModalLastNameInput.val($_lastNameAttrValue);
                    var $_setModalUsernameValue = $_getModalUsernameInput.val($_usernameAttrValue);
                    var $_setModalEmailValue = $_getModalEmailInput.val($_emailAttrValue);
                    var $_setModalPhoneValue = $_getModalPhoneInput.val($_phoneAttrValue);
                    var $_setModalTypeValue = $_getModalTypeInput.val($_typeAttrValue);
                    var $_setModalPasswordValue = $_getModalPasswordInput.val($_passwordAttrValue);
                    var $_setModalVerifiedValue = $_getModalVerifiedInput.val($_verifiedAttrValue);

                    document.getElementById('user-text').innerText = "Update " + $_usernameAttrValue + " account details";

                    $.ajax({
                        type: "GET",
                        url: '{{ route("admin.user.role", ["user" => ":id"]) }}'.replace(':id', $_idAttrValue),
                        dataType: 'json',
                    })
                    .done((response) => {
                        $.ajax({
                            type: "GET",
                            url: '{{ route("admin.role.all") }}',
                            dataType: 'json',
                        })
                        .done((res) => {
                            displayRoles("edit", res, response.data);
                            $("#addUserModal").modal("show");
                        })
                    })
                    .fail((res) => {
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, "Failed!");
                    });


                    $("#btn-edit").click(function () {
                        var getParent = $(this).parents(".modal-content");
                        var $_getInputTitle = getParent.find("#c-title");
                        var data = $("#addUserModalTitle").serializeArray();
                        var url = "{{ route('admin.user.update', ["user" => ":id"]) }}".replace(':id', $_idAttrValue);
                        var button = $(this);

                        toggleAble(button, 'Updating...');

                        $.ajax({
                            type: "PUT",
                            url,
                            data,
                        })
                        .done((res) => {
                            toggleAble(button, false);
                            toastr.success(res.message, "Success!");
                            $("#addUserModal").modal("hide");

                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        })
                        .fail((res) => {
                            toggleAble(button, false);
                            console.log(res.responseJSON.message);
                            toastr.error(res.responseJSON.message, "Failed!");
                        });
                    });
                });
            }

            function deleteuser() {
                $(".delete").on("click", function (event) {
                    event.preventDefault();

                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data("id");                    
                    var url = "{{ route('admin.user.delete', ["user" => ":id"]) }}".replace(':id', id);

                    $.ajax({
                        type: "DELETE",
                        url,
                    })
                    .done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, "Success!");
                        $(this).parents(".search-items").remove();
                    })
                    .fail((res) => {
                        toggleAble(button, false);
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, "Failed!");
                    });
                });
            }

            $(".delete-multiple").on("click", function () {
                var inboxCheckboxParents = $(".user-chkbox:checked").parents(
                    ".search-items"
                );

                inboxCheckboxParents.each(function () {
                    var idElement = $(this).find(".usr-id-addr");
                    var id = idElement.text();

                    var url = "{{ route('admin.user.delete', ["user" => ":id"]) }}".replace(':id', id);
                    var button = $(this);
                    toggleAble(button);

                    $.ajax({
                        type: "DELETE",
                        url,
                    })
                    .done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, "Success!");
                        inboxCheckboxParents.remove();
                    })
                    .fail((res) => {
                        toggleAble(button, false);
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, "Failed!");
                    });
                });

            });

            function displayRoles(type = 'create',  data, initiallySelectedRoleIds) {
                var tableRows = '';

                data.forEach(function(role) {

                    if (type === 'edit') {
                        var isChecked = initiallySelectedRoleIds.includes(String(role['id'])) ?? [];
                    }

                    tableRows += `
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-${role['id']}" name="roles[]" value="${role['id']}" ${type === 'edit' && isChecked ? 'checked' : ''} />
                            </div>
                        </td>
                        <td>${role['title']}</td>
                    </tr>
                    `;
                });

                $('.user-role tbody').html(tableRows);
            }

            addUser();
            edituser();
            deleteuser();
        </script>
    @endsection
</x-app-layout>
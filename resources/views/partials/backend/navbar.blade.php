<header class="topbar-nav">
    <nav id="header-setting" class="navbar navbar-expand fixed-top">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="icon-menu menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <form class="search-bar">
                <input type="text" class="form-control" id="searchInvoice" placeholder="Enter keywords">
                    <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                </form>
            </li>
        </ul>

        <ul class="navbar-nav align-items-center right-nav-link">


            {{-- <li class="nav-item dropdown-lg">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"
                    href="javascript:void();">
                    <i class="fa fa-envelope-open-o"></i><span class="badge badge-primary badge-up">12</span></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            You have 12 new messages
                            <span class="badge badge-primary">12</span>
                        </li>
                        <li class="list-group-item">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3"
                                            src="{{asset('assets/images/avatars/avatar-2.png')}}" alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-0 msg-title">Jhon Deo</h6>
                                        <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                        <small>Today, 4:10 PM</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3"
                                            src="{{asset('assets/images/avatars/avatar-2.png')}}" alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-0 msg-title">Sara Jen</h6>
                                        <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                        <small>Yesterday, 8:30 AM</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3"
                                            src="{{asset('assets/images/avatars/avatar-2.png')}}" alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-0 msg-title">Dannish Josh</h6>
                                        <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                        <small>5/11/2018, 2:50 PM</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3"
                                            src="{{asset('assets/images/avatars/avatar-2.png')}}" alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-0 msg-title">Katrina Mccoy</h6>
                                        <p class="msg-info">Lorem ipsum dolor sit amet.</p>
                                        <small>1/11/2018, 2:50 PM</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item text-center"><a href="javaScript:void();">See All Messages</a></li>
                    </ul>
                </div>
            </li> --}}

            @php
            $deliveryManRole = 3;
            $roles = App\admin\UserRolesModel::where('user_id', Auth::user()->id)->where('soft_delete', 0)->pluck('role_id')->toArray();   
            @endphp

            <li class="nav-item dropdown-lg">
                @if(in_array($deliveryManRole, $roles))
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"
                        href="javascript:void();">
                        <i class="fa fa-bell-o"></i><span id="notificationTotal"class="badge badge-info badge-up" style="background: #C70909;">0</span>
                    </a>
                @endif
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="list-group list-group-flush" id="notificationBody" style="max-height: 378px !important;overflow-y: auto;">
                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="badge badge-info" id="notificationSum">0</span>
                        </li> -->
                        <!-- <li class="list-group-item">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <i class="zmdi zmdi-accounts fa-2x mr-3 text-info"></i>
                                    <div class="media-body">
                                        <h6 class="mt-0 msg-title">New Registered Users</h6>
                                        <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <i class="zmdi zmdi-coffee fa-2x mr-3 text-warning"></i>
                                    <div class="media-body">
                                        <h6 class="mt-0 msg-title">New Received Orders</h6>
                                        <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                    </div>
                                </div>
                            </a>
                        </li> -->
                        <!-- <li class="list-group-item">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <i class="zmdi zmdi-notifications-active fa-2x mr-3 text-danger"></i>
                                    <div class="media-body">
                                        <h6 class="mt-0 msg-title">New Updates</h6>
                                        <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                    </div>
                                </div>
                            </a>
                        </li> -->
                        <!-- <li class="list-group-item text-center"><a href="javaScript:void();">See All Notifications</a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item language">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"
                    href="javascript:void();"><i class="fa fa-flag"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item"> <i class="flag-icon flag-icon-gb mr-2"></i> English</li>
                    <li class="dropdown-item"> <i class="flag-icon flag-icon-fr mr-2"></i> French</li>
                    <li class="dropdown-item"> <i class="flag-icon flag-icon-cn mr-2"></i> Chinese</li>
                    <li class="dropdown-item"> <i class="flag-icon flag-icon-de mr-2"></i> German</li>
                </ul>
            </li> -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile"><img src="{{asset('assets/images/avatars/avatar-2.png')}}"

                            class="img-circle" alt="user avatar"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item user-details">
                        <a href="javaScript:void();">
                            <div class="media">

                                <div class="avatar"><img class="align-self-start mr-3"
                                        src="{{asset('assets/images/avatars/avatar-2.png')}}" alt="user avatar"></div>
                                <div class="media-body">
                                    <h6 class="mt-2 user-title"></h6>
                                    {{-- <p class="user-subtitle">@isset(Auth::user()->first_name){{Auth::user()->first_name." ".Auth::user()->last_name}}@endisset</p> --}}
                                    <p class="user-subtitle">{{Auth::user()->email}}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item" onclick="passEdit()"><a href="javascript:void(0)"><i class="fa fa-key"></i> Change Password</a></li>
                    {{-- <li class="dropdown-item" onclick="passEdit()"><a><i class="fa fa-key"></i> Change Password</a></li> --}}
                    <li class="dropdown-item">
                        <a href="{{ URL('dashboardSettings') }}">
                            <i class="icon-settings mr-2"></i> Setting
                        </a>
                    </li>

                    <!-- <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li> -->
                    <!-- <li class="dropdown-divider"></li> -->
                    <!-- <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
           <li class="dropdown-divider"></li>
           <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
           <li class="dropdown-divider"></li> -->
                    <li class="dropdown-item"><i class="icon-power mr-2"></i> <a href='#' onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a></li>
                    {{-- <li><a onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" href="#"><i class="icon-power"></i> Logout</a></li> --}}
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
    </nav>
</header>









<div class="modal fade" id="changePassModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-info">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Change Password</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="changePassForm">
                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Current Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="oldPass" name="oldPass" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="newPass" name="newPass" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Re-type New Password</label>
                        <div class="col-sm-10">
                            {{-- <input type="hidden" id="" name="" value=""> --}}
                            <input type="password" class="form-control" id="confirmPass" name="confirmPass" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-times"></i>
                            Close</button>
                        <button type="submit" class="btn btn-info"><i class="fa fa-check-square-o"></i> Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#changePassForm').submit(function () {
            event.preventDefault();
            setNewPassword();
        });

        setNotification();
    });

    function passEdit() {
        $('#changePassModal').modal('show');
    }

    function setNewPassword() {
        let old_password = document.getElementById('oldPass').value;
        let password = document.getElementById('newPass').value;
        let password_confirmation = document.getElementById('confirmPass').value;

        if (old_password === "" && password === "" && password_confirmation ==="") {
            alertify.error("Enter Your Password");
        } else if (password.length < 8 && password_confirmation.length < 8) {
            alertify.error("Password must be at least 8 characters long");
        } else {
            $.ajax({
                type: 'post',
                url: '{{ URL("setNewPassword") }}',
                data: {
                    old_password: $('#oldPass').val(),
                    password: $('#newPass').val(),
                    password_confirmation: $('#confirmPass').val(),
                },
                success: function (data) {

                    if (typeof data.errors !== 'undefined') {
                        alertify.warning("Something went wrong");
                    } else if (data == "Success") {
                        alertify.success(data);
                        $('#changePassModal').modal('hide');
                        setTimeout(() => location.reload(), 1000);
                    } else if (data == "Failed") {
                        alertify.error("Please Enter Your Current Password Correctly!");
                        $("#oldPass").val("");
                        $("#newPass").val("");
                        $("#confirmPass").val("");
                    }
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.error('New Password Did Not Match!');
                        // alertify.warning(msg);
                    }
                }
            });   
        }


    }

    function setNotification() {
        $.post('{{ URL("getDeliveryManNotification") }}').then(data => {
            console.log(data.length);
            console.log(data);
            $('#notificationTotal').text(data.length);
            $('#notificationBody').append(`<li
                class="list-group-item d-flex justify-content-between align-items-center">
                    You have ${data.length} Notifications
                    <span class="badge badge-info">${data.length}</span>
            </li>`);

            $.each(data, (key, val) => {
                $('#notificationBody').append(`<li class="list-group-item ${val.is_seen == 0 ? 'gradient-quepal' : ''}">
                    <a onclick="openNotificationLink('${val.redirect_link}', '${val.id}')" style="cursor: pointer">
                        <div class="media">
                            <i class="zmdi zmdi-accounts fa-2x mr-3 text-info"></i>
                            <div class="media-body">
                                <h6 class="mt-0 msg-title">${val.message}</h6>
                            </div>
                        </div>
                    </a>
                </li>`);
            });
        })
    }

    function setNotification() {
        $.post('{{ URL("getDeliveryManNotification") }}').then(data => {
            console.log(data.unseen_notifications.length);
            console.log(data.notifications);
            console.log(data.notifications.length);
            $('#notificationTotal').text(data.unseen_notifications.length);
            $('#notificationBody').append(`<li
                class="list-group-item d-flex justify-content-between align-items-center">
                    You have ${data.unseen_notifications.length} Notifications
                    <span class="badge badge-info">${data.unseen_notifications.length}</span>
            </li>`);

            $.each(data.notifications, (key, val) => {
                $('#notificationBody').append(`<li class="list-group-item ${val.is_seen == 0 ? 'gradient-quepal' : ''}">
                    <a onclick="openNotificationLink('${val.redirect_link}', '${val.id}')" style="cursor: pointer">
                        <div class="media">
                            <i class="zmdi zmdi-accounts fa-2x mr-3 text-info"></i>
                            <div class="media-body">
                                <h6 class="mt-0 msg-title">${val.message}</h6>
                            </div>
                        </div>
                    </a>
                </li>`);
            });
        })
    }

    function openNotificationLink(link, notificationID) {
        $.post('{{ URL("setNotificationAsSeen") }}', {id: notificationID}).then(data => {
            if (data == 'Success') {
                console.log(data);
                if (data) {
                    console.log('Notificatin seen!');
                } else {
                    console.log("Can't set notofication as seen!");
                }
            }
        });
        window.open(link, '_blank');
    }

</script>

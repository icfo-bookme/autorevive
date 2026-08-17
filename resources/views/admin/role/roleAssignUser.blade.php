@extends('layouts.backend.master')
@section('content')


<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="userRoleSetupForm">
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                        User Role Assign
                    </h4>


                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">User</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="user" name="user" required>
                                <option value="" selected>--SELECT USER--</option>
                                @foreach ($users as $user)
                                {{-- <option value="{{$user->id}}">{{$user->first_name." ".$user->last_name}}</option> --}}
                                <option value="{{$user->id}}">{{$user->email}}</option>

                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="role" name="role" onchange="RoleModuleDetails(this.value)"
                                required>
                                <option value="" selected>--SELECT ROLE--</option>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-footer text-center">
                        <!-- <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i>
                            CANCEL</button> -->
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" onclick="clearForm()"><i
                                class="fa fa-times"></i>Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-sm-6">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Premission Table of Selected Role</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="roleTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Module</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyModule">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Premission Table of Selected User</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="roleTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyUser">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $("#role").change(function () {
            var role_id = this.value;
            //alert(status);
            $("#tbodyModule").html("");
            var moduleTableBody = "";
            var counter = 1;

            $.ajax({
                type: 'POST',
                url: '{{ URL("admin/getmodulebyrole") }}',
                data: { id: role_id },
                success: function (data) {
                    // alert(data);
                    // console.table(data);
                    // parsed_data = JSON.parse(data);
                    for (var i = 0; i < data.length; i++) { //console.log(data);
                        console.log(data[i].created_by);
                        moduleTableBody += '<tr>';
                        moduleTableBody += '<td>' + counter + '</td>';
                        moduleTableBody += '<td>' + data[i]['name'] + '</td>';
                        moduleTableBody +=
                            '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeModuleOfRole(' + role_id + ',' + data[
                                i]['id'] +
                            ')" style="border-radious: 100%; font-size: 8px;">X</button></td>';
                        moduleTableBody += '</tr>';
                        counter++;
                    }
                    //console.log(moduleTableBody);
                    $("#tbodyModule").append(moduleTableBody);
                }
            });
        });

        $("#user").change(function () {
            var user_id = this.value;

            $("#tbodyUser").html("");
            var userTableBody = "";
            var counter = 1;

            $.ajax({
                type: 'post',
                url: '{{ URL("admin/getModuleByUser") }}',
                data: {
                    user_id: user_id
                },
                success: function (data) {
                    console.log(data.length); // test

                    for (let i = 0; i < data.length; i++) {
                        userTableBody += '<tr>';
                        userTableBody += '<td>' + counter + '</td>';
                        userTableBody += '<td>' + data[i]['name'] + '</td>';
                        userTableBody +=
                            '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeUserRole(' + user_id + ',' + data[i]['id'] + ')" style="border-radious: 100%; font-size: 8px;">X</button></td>';
                        userTableBody += '</tr>';
                        counter++;
                    }

                    $("#tbodyUser").html(userTableBody);
                }
            });
        })

        /**
         * @name fromOnSubmit
         * @role Submit The form
         * @param
         * @return json response
         *
         */


        $('#userRoleSetupForm').submit(function () {
            event.preventDefault();

            alertify.confirm("Are You Sure To Submit This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: './roleAssignUserInsertAjax',
                        data: $("#userRoleSetupForm").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {

                                alertify.warning('Input Error!');
                            } else if (typeof data.warning != 'undefined') {
                                alertify.warning('Record Already Exists!');
                            } else {
                                alertify.success(data.message);
                                $('#userRoleSetupForm').trigger("reset");
                                setTimeout(() => location.reload(), 500);
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
                                alertify.warning(msg);
                            }

                        }


                    });

                },
                function () {
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');
        });

    });

    function clearForm() {
        $('#userRoleSetupForm').trigger("reset");
    }


    function RoleModuleDetails(id) {

        $("#moduleTableBody").html("");
        var counter = 1;
        var moduleTableBody = "";

        $.ajax({
            type: 'post',
            url: './getmodulebyrole',
            data: {
                id: id
            },
            success: function (data) {
                console.table(data);
                for (var i = 0; i < data.length; i++) {
                    console.log(data);
                    //console.log(data[i].created_by);
                    moduleTableBody += '<tr>';
                    moduleTableBody += '<td>' + counter + '</td>';
                    moduleTableBody += '<td>' + data[i]['name'] + '</td>';
                    moduleTableBody += '</tr>';
                    counter++;

                }
                // console.log(routeTableBody);
                $("#moduleTableBody").append(moduleTableBody);
            }
        });

    }

    function removeUserRole(user_id, role_id) {
        $.ajax({
            type: 'post',
            url: '../admin/removeUserRole',
            data: {
                user_id: user_id,
                role_id: role_id
            },
            success: function (data) {
                console.log(data);

                if (data === "Success") {
                    alertify.success(data);
                    reload();
                }
            }
        });
    }

    function removeModuleOfRole(role_id, module_id) {
        $.ajax({
            type: 'post',
            url: '{{ URL("admin/removeRoleModule") }}',
            data: {
                role_id: role_id,
                module_id: module_id
            },
            success: function (data) {
                console.log(data);

                if (data === "Success") {
                    alertify.success("Module Deleted!");
                    reload();
                }
            }
        });
    }

    function reload() {
        setTimeout(() => location.reload(),1000);
    }

</script>

@endsection

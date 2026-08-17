@extends('layouts.backend.master')
@section('content')



<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form id="moduleRoleSetupForm">
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                        Role Module Assign
                    </h4>

                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="role" name="role" required>
                                <option value="" selected>--SELECT ROLE--</option>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Module</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="module" name="module" required>
                                <option value="" selected>--SELECT MODULE--</option>
                                @foreach ($modules as $module)
                                <option value="{{$module->id}}">{{$module->name}}</option>
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
    <div class="col-lg-4 col-sm-6">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Route Table of Selected Module</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="roleTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Route</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="routeTableBody">

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Module Table of Selected Role</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="roleTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="moduleTableBody">

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $("#module").change(function () {
            var module_id = this.value;
            //alert(status);
            $("#routeTableBody").html("");
            var counter = 1;
            var routeTableBody = "";

            $.ajax({
                type: 'POST',
                url: '{{ URL("admin/getRouteByModule") }}',
                data: { id: module_id },
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        routeTableBody += '<tr>';
                        routeTableBody += '<td>' + counter +
                            '</td>';
                        routeTableBody += '<td>' + data[i].route + '</td>';
                        routeTableBody +=
                            '<td><button type="button" class="btn btn-danger btn-sm" style="font-size:8px;" onclick="removeModuleRoute(' + data[i]['id'] + ')">X</button></td>';
                        routeTableBody += '</tr>';

                        counter++;
                    }
                    $("#routeTableBody").append(routeTableBody);
                }
            });
        });

        $("#role").change(function () {
            let role_id = this.value;

            $("#moduleTableBody").html("");
            let counter = 1;
            let moduleTableBody = "";

            $.ajax({
                type: 'POST',
                url: '{{ URL("admin/getmodulebyrole/") }}',
                data: { id: role_id },
                success: function (data) {
                    for (let i = 0; i < data.length; i++) {
                        moduleTableBody += '<tr>';
                        moduleTableBody += '<td>' + counter + '</td>';
                        moduleTableBody += '<td>' + data[i]['name'] + '</td>';
                        moduleTableBody += '<td><button type="button" class="btn btn-danger btn-sm" style="font-size:8px;" onclick="removeRoleModule(' + role_id + ',' + data[i]['id'] + ')">X</button></td>';
                        moduleTableBody += '</tr>';

                        counter++;
                    }
                    $("#moduleTableBody").append(moduleTableBody);
                }
            });
        });


        /**
         * @name fromOnSubmit
         * @role Submit The form
         * @param
         * @return json response
         *
         */
        $('#moduleRoleSetupForm').submit(function () {
            event.preventDefault();

            alertify.confirm("Are You Sure To Submit This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: './roleModuleAssignAjax',
                        data: $("#moduleRoleSetupForm").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {

                                alertify.warning('Input Error!');
                            }else if (typeof data.warning != 'undefined') {
                                alertify.warning('Record Already Exists!');
                            } else {
                                alertify.success(data);
                                setTimeout(function () {
                                    location.reload(true);
                                }, 1000)
                                clearForm();

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
        $('#moduleRoleSetupForm').trigger("reset");
    }


    function moduleRouteDetails(id){

        $("#routeTableBody").html("");
            var counter = 1;
            var routeTableBody = "";

            $.ajax({
                type: 'post',
                url: '{{ URL("admin/getRouteByModule") }}',
                data: {
                    id:id
                },
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        routeTableBody += '<tr>';
                        routeTableBody += '<td>' + counter +'</td>';
                        routeTableBody += '<td>' +data[i].route+ '</td>';
                        routeTableBody += '</tr>';
                        counter++;

                    }
                    $("#routeTableBody").append(routeTableBody);
                }
            });
    }

    function removeModuleRoute(id) {
        // alert(id);
        $.ajax({
            method: 'POST',
            url: '{{ URL("admin/removeModuleRoute") }}',
            data: {
                id: id
            },
            success: function (data) {
                if (data === "Success") {
                    alertify.success('Route Deleted!');
                    setTimeout(() => location.reload(), 1000);
                }
            }
        });
    }

    function removeRoleModule(role_id, module_id) {
        $.ajax({
            method: 'POST',
            url: '{{ URL("/admin/removeRoleModule") }}',
            data: {
                role_id: role_id,
                module_id: module_id
            },
            success: function (data) {
                if (data === "Success") {
                    alertify.success('Module Deleted!');
                    setTimeout(() => location.reload(), 1000);
                }
            }
        });
    }

</script>


@endsection

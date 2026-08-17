@extends('layouts.backend.master')
@section('content')


<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form id="moduleSetupForm">
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                        Module Route Setup
                    </h4>


                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Module Name</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="module" name="module" required>
                                <option value="" selected>--SELECT--</option>
                                @foreach ($modules as $module)
                                <option value="{{$module->id}}">{{$module->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Route Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="route" name="route" required>
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
    <div class="col-lg-8">
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
</div>

<script>
    let reload = () => setTimeout(() => location.reload(), 1000);

    $(document).ready(function () {

        $("#module").change(function () {
            var module_id = this.value;
            var counter = 1;
            var routeTableBody = "";

            $("#routeTableBody").html("");

            $.ajax({
                type: 'POST',
                url: '{{ URL("admin/getRouteByModule") }}',
                data: { id: module_id },
                success: function (data) {
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        routeTableBody += '<tr>';
                        routeTableBody += '<td>' + counter + '</td>';
                        routeTableBody += '<td>' + data[i].route + '</td>';
                        routeTableBody +=
                            '<td><button type="button" class="btn btn-danger btn-sm" style="font-size:8px;" onclick="removeModuleRoute(' +
                            data[i]['id'] + ')">X</button></td>';
                        routeTableBody += '</tr>';
                        counter++;
                    }
                    $("#routeTableBody").append(routeTableBody);
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


        $('#moduleSetupForm').submit(function () {
            event.preventDefault();

            alertify.confirm("Are You Sure To Submit This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: './moduleDetailsInsertAjax',
                        data: $("#moduleSetupForm").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {

                                alertify.warning('Input Error!');
                            } else if (typeof data.warning != 'undefined') {
                                alertify.warning('Record Already Exists!');
                            } else {
                                //alert(data);
                                alertify.success(data.message);
                                clearForm();
                                setTimeout(function () {
                                    location.reload(true);
                                }, 1000);
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


    function removeModuleRoute(id) {
        $.ajax({
            method: 'POST',
            url: '{{ URL("admin/removeModuleRoute") }}',
            data: {
                id: id
            },
            success: function (data) {
                if (data === "Success") {
                    alertify.success('Success');
                    reload();
                }
            }
        });
    }

    function clearForm() {
        $('#moduleSetupForm').trigger("reset");
        $("#routeTableBody").html("");
    }

</script>
@endsection

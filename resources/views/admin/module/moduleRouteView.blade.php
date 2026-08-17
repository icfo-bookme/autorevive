@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> modules View</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="moduleRouteTable" class="table table-bordered" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Routes</th>
                                <th>module</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modulesRoutes as $modulesRoute)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$modulesRoute->route}}</td>
                                    <td>{{$modulesRoute->module->name}}</td>
                                    <td>{{$modulesRoute->created_by}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick="modulesRouteEdit({{$modulesRoute->id}})"><i
                                                class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-danger btn-xs" onclick="modulesRouteDelete({{$modulesRoute->id}})"><i
                                                class="fa fa-trash"></i> Delete </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th>#</th>
                                <th>module</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </tfoot> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="moduleEditModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-info">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Module Update</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="moduleUpdateForm">

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

                    <input type="hidden" id="mId" name="id" value="">

                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Route Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="route" name="route" required>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info"><i class="fa fa-check-square-o"></i> Save changes</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-times"></i>
                    Close</button>
            </div>
            </form>
        </div>
    </div>
</div>







<script>
    $(document).ready(function () {
        
        var table = $('#moduleRouteTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true
        });




        /**
         * @name fromOnSubmit
         * @module Submit The form
         * @param
         * @return json response
         *
         */

        $('#moduleUpdateForm').submit(function () {
            event.preventDefault();

            $.ajax({
                type: 'post',
                url: './moduleDetailsUpdateAjax',
                data: $('#moduleUpdateForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.warning('Something Went Wrong');
                    } else {
                         $('#moduleEditModal').modal('hide');
                        alertify.success(data);
                        setTimeout(function () {
                            location.reload(true);
                        }, 1000)


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
        });
    });

    /**
     * @name moduleEdit
     * @module fetch info and load them into modal for edit
     * @param module id
     * @return
     *
     */

    function modulesRouteEdit(id) {


        $.ajax({
            type: 'post',
            url: './getModuleDetailsByidAjax',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {

                    alertify.warning("Something went wrong");
                } else {
                    //alert(data);
                    console.log(data);
                    $('#mId').val(data.id);
                    $('#module').val(data.module_id);
                    $('#route').val(data.route);
                     $('#moduleEditModal').modal('show');

                    // clearForm();

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

    }


    /**
     * @name moduleEdit
     * @module fetch info and load them into modal for edit
     * @param module id
     * @return
     *
     */

    function modulesRouteEditSubmit() {

    }


    /**
     * @name moduleDelete
     * @module send ajax request to delete a module
     * @param module id
     * @return json response
     *
     */
    function modulesRouteDelete(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: './moduleDetailsDeleteAjax',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.warning('Something Went Wrong');
                        } else {
                            //alert(data);
                            alertify.success(data);
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000)


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
                alertify.error('Canceled');
            }).setHeader('<em> CONFIRM </em> ');

    }

</script>

@endsection

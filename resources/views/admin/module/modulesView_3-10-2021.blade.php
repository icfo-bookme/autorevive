@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> modules View</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="moduleTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>module</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @dd($modules) --}}
                            @foreach ($modules as $module)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$module->name}}</td>
                                <td>{{$module->created_by}}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs" onclick="moduleEdit({{$module->id}})"><i
                                            class="fa fa-pencil"></i> Edit </button>
                                    <button class="btn btn-danger btn-xs" onclick="moduleDelete({{$module->id}})"><i
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
                <h5 class="modal-title text-white">module Update</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="moduleUpdateForm">
                    {{-- <h4 class="form-header text-uppercase text-center">
                                <i class="fa fa-user-circle-o"></i>
                                module Insert
                            </h4> --}}
                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Module Name</label>
                        <div class="col-sm-10">
                            <input type="hidden" id="moduleId" name="id" value="">
                            <input type="text" class="form-control" id="moduleName" name="moduleName" required>
                        </div>
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

<script>
    $(document).ready(function () {
        //   $('#moduleTable').DataTable();
        // $('#moduleEditModal').modal('show');
        var table = $('#moduleTable').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
        });

        table.buttons().container()
            .appendTo('#moduleTable_wrapper .col-md-6:eq(0)');


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
                url: './moduleUpdatAjax',
                data: $('#moduleUpdateForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.warning('Something Went Wrong');
                    } else {
                        //alert(data);
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

    function moduleEdit(id) {

       
        $.ajax({
            type: 'post',
            url: './getModule',
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
                    $('#moduleId').val(data.id);
                    $('#moduleName').val(data.name);
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

    function moduleEditSubmit() {

    }


    /**
     * @name moduleDelete
     * @module send ajax request to delete a module
     * @param module id
     * @return json response
     *
     */
    function moduleDelete(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: './modulesDeleteAjax',
                    data: {
                        module_id: id
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

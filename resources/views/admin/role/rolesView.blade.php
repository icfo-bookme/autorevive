@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Roles View</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="roleTable" class="table table-bordered" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->created_by}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick="roleEdit({{$role->id}})"><i
                                                class="fa fa-pencil"></i> Edit </button>
                                        <button class="btn btn-danger btn-xs" onclick="roleDelete({{$role->id}})"><i
                                                class="fa fa-trash"></i> Delete </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>







<div class="modal fade" id="roleEditModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-info">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Role Update</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="roleUpdateForm">
                    {{-- <h4 class="form-header text-uppercase text-center">
                                <i class="fa fa-user-circle-o"></i>
                                Role Insert
                            </h4> --}}
                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Role Name</label>
                        <div class="col-sm-10">
                            <input type="hidden" id="roleId" name="id" value="">
                            <input type="text" class="form-control" id="roleName" name="roleName" required>
                        </div>
                   </div>
                   <div class="text-center">
                        <button type="submit" class="btn btn-info mx-2"><i class="fa fa-check-square-o"></i>
                            Save changes
                        </button>
                        <button type="button" class="btn btn-dark mx-2" data-dismiss="modal"><i class="fa fa-times"></i>
                            Close
                        </button>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>






























<script>
    $(document).ready(function () {
        // var table = $('#roleTable').DataTable({
        //     lengthChange: false,
        //     buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
        // });

        // table.buttons().container()
        //     .appendTo('#roleTable_wrapper .col-md-6:eq(0)');
        
        var table = $('#roleTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true
        });



        // $('#roleEditModal').modal('show');

        $('#roleUpdateForm').submit(function () {
            event.preventDefault();

            $.ajax({
                type: 'post',
                url: './roleUpdatAjax',
                data: $('#roleUpdateForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.warning('Something Went Wrong');
                    } else {
                      $('#roleEditModal').modal('hide');
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
     * @name roleEdit
     * @role fetch info and load them into modal for edit
     * @param role id
     * @return
     *
     */

    function roleEdit(id) {

        $('#roleEditModal').modal('show');
        $.ajax({
            type: 'post',
            url: './getRole',
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
                    $('#roleId').val(data.id);
                    $('#roleName').val(data.name);

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
     * @name roleDelete
     * @role send ajax request to delete a role
     * @param role id
     * @return json response
     *
     */
    function roleDelete(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: './rolesDeleteAjax',
                    data: {
                        role_id: id
                    },
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

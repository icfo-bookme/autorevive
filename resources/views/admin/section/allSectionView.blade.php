@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Section View</div>

            <div class="card-body">
                <div class="float-right mb-3">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-section-insert">New Section</button>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="classTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Section name</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="drag_able">



                            @foreach ($sections as $section)
                            <tr style="text-align:center;cursor:move;border: 1px solid #d3d3d3;background: #e6e6e6;">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$section->name}}</td>
                                <td>{{$section->created_by}}</td>

                                <td>
                                    <input type="hidden" class="original_id" value="{{ $section->id }}">
                                    <a href="javascript:void(0)" onclick="editSection({{$section->id}})"
                                        style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                        data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="deleteSection({{$section->id}})"
                                        style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                        data-toggle="tooltip" title="" data-original-title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
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


<!-- modal new subject -->
<div class="modal fade" id="modal-section-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">New Section</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sectionInsertForm">


                    <div class="form-group">
                        <label for="input-1">Secion Name</label>
                        <input type="text" class="form-control" id="section_name" placeholder="Section name" name="name"
                            required>
                    </div>


            </div>
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
            </div>
            </form>
        </div>
    </div>
</div>









<!-- modal body goes here -->
<div class="modal fade" id="modal-category-update" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Update Section</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryUpdateForm">
                    <div class="form-group">
                        <label for="input-1">Section Name</label>
                        <input type="hidden" id="categoryId" name="id" value="">
                        <input type="text" class="form-control" id="edit_category" placeholder="section name"
                            name="name" required>
                    </div>

            </div>
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    $(document).ready(function () {
        var table = $('#classTable').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            scrollY: 450,
            scrollX: true,
            scrollCollapse: true,
        });

        table.buttons().container()
            .appendTo('#classTable_wrapper .col-md-6:eq(0)');




        $('#sectionInsertForm').submit(function () {
            event.preventDefault();

            alertify.confirm('Are You Sure ?', 'Section Will Be Inserted', function () {


                $.ajax({
                    type: 'post',
                    url: '{{URl("sectionInsertAjax")}}',
                    data: $('#sectionInsertForm').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.error('Something Went Wrong');
                            $('#modal-section-insert').modal('hide');
                        } else {
                            //alert(data);
                            alertify.success(data);
                            $('#modal-section-insert').modal('hide');

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

            }, function () {
                alertify.error('Cancel')
            });
        });




        $('#categoryUpdateForm').submit(function () {
            event.preventDefault();

            $.ajax({
                type: 'post',
                url: '{{URl("sectionUpdateAjax")}}',
                data: $('#categoryUpdateForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        alertify.warning('Something Went Wrong');
                        $('#modal-category-update').modal('hide');
                    } else {
                        //alert(data);
                        alertify.success(data);
                        $('#modal-category-update').modal('hide');

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
     * @name editClass
     * @role fetch info and load them into modal for edit
     * @param class id
     * @return
     *
     */

    function editSection(id) {
        $.ajax({
            type: 'post',
            url: '{{URL("getSectionDetails")}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {

                    alertify.warning("Something went wrong");
                } else {
                    $('#categoryId').val(data.id);
                    $('#edit_category').val(data.name);
                    $('#modal-category-update').modal('show');

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
     * @name deleteClass
     * @role send ajax request to delete a class
     * @param role id
     * @return json response
     *
     */
    function deleteSection(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("sectionDeleteAjax")}}',
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

    $(function () {
        $(".drag_able").sortable({
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                const row_serial = [];
                let count = 0;

                // reorder and get row data
                $.each($('.drag_able tr'), (k, v) => {
                    // reorder serial
                    $(v).find('td:nth-child(1)').html(++count);

                    // get serial data
                    let serial_id = $(v).find('td:nth-child(1)').html();
                    let original_id = $(v).find('.original_id').val();
                    let row_serial_data = {
                        'present_serial': serial_id,
                        'original_serial': original_id,
                    }

                    row_serial.push(row_serial_data);
                });

                // send in the backend
                $.ajax({
                    url: '{{ URL("reorderSectionAjax") }}',
                    method: 'POST',
                    data: { row_serial },
                    success: data => {
                        alertify.success(data);
                    },
                    error: err => {
                        alertify.error('An error occurred!');
                        console.error(err);
                    }
                });
            }
        });
        $(".drag_able").disableSelection();
    });

</script>
@endsection

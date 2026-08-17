@extends('layouts.backend.master')
@section('content')

    <style>
        .alertify-notifier .ajs-message.ajs-error{
            color: #fff !important;
            background: rgba(217, 92, 92, 0,95);
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
        }
    </style>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> All Cash View</div>

            <div class="card-body">
                <div class="float-left mb-4 ml-3">
                    <button class="btn btn-info btn-md" data-toggle="modal" data-target="#modal-cash-insert">Cash Insert</button>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="classTable" class="table table-bordered" style="width: 100% !important;">
                        
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Cash Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Created At</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_cashes as $cash)
                            <tr style="text-align:center;">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$cash->cash_amount}}</td>
                                <td>{{$cash->description}}</td>
                                <td>{{$cash->date}}</td>
                                <td>{{$cash->created_at}}</td>
                                <td>{{$cash->createdBY->first_name}}</td>
                                <td>{{$cash->updatedBY->first_name}}</td>
                                <td>
                                    <a onclick="editCash({{$cash->id}})"
                                        style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                        data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
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


<!-- cash insert modal -->
<div class="modal fade" id="modal-cash-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px;">New Cash Insert</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cashInsertForm">

                    <div class="form-group row">
                        <label class="col-md-3">User Name:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{$username}}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3">Cash Amount:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="cash_amount" name="cash_amount" placeholder="Cash Amount" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3">Description</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="description"  name="description" placeholder="Description" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3">Date</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control"  id="date" name="date">
                        </div>
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


<!-- edit category name modal body goes here -->
<div class="modal fade" id="modal-cash-update" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px;">Edit Cash Insert</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cashUpdateForm">
                    <input type="hidden" id="cash_id" name="cash_id">

                   <div class="form-group row">
                        <label class="col-md-3">Cash Amount:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="update_cash_amount" name="cash_amount" placeholder="Cash Amount" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3">Description</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="update_description"  name="description" placeholder="Description" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3">Date</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control"  id="update_date" name="date">
                        </div>
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




<script>
$(document).ready(function () {
    var table = $('#classTable').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
        scrollY: 500,
        scrollX: true,
        scrollCollapse: true,
    });

    table.buttons().container()
    .appendTo('#classTable_wrapper .col-md-6:eq(0)');

    $('#cashInsertForm').submit(function (event) {
    event.preventDefault();
    alertify.confirm('Are You Sure ?', 'Data Will Be Inserted', function () {
    $.ajax({
        type: 'post',
        url: '{{URl("cashInsertAjax")}}',
        data: $('#cashInsertForm').serialize(),
        dataType: 'json',
        success: function (response) {
            if(response.status === true){
                alertify.success(response.message);
                    setTimeout(function () {
                        location.reload(true);
                    }, 1000)
            } else if(response.status === false){
                alertify.error(response.message);
            }  else if(response.status === "validation-error"){
                $.each(response.data, (index, value) => {
                                    alertify.error(value[0]);
                                });
            }
        },
        error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.Verify Network.';
                alertify.warning(msg);
                $('#preloader').modal('hide');
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
                alertify.warning(msg);
                $('#preloader').modal('hide');
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
                alertify.warning(msg);
                $('#preloader').modal('hide');
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
                alertify.warning(msg);
                $('#preloader').modal('hide');
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
                alertify.warning(msg);
                $('#preloader').modal('hide');
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
                alertify.warning(msg);
                $('#preloader').modal('hide');
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                alertify.warning(msg);
                $('#preloader').modal('hide');
            }
        }
    });
    }, function () {
        alertify.error('Cancelled!')
        });
    });

    
    $('#cashUpdateForm').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: 'post',
            url: '{{URl("cashUpdateAjax")}}',
            data: $('#cashUpdateForm').serialize(),
            dataType: 'json',
            success: function (response) {
                if(response.status === true){
                    alertify.success(response.message);
                    setTimeout(function () {
                        location.reload(true);
                    }, 1000)
                } else if(response.status === false){
                    alertify.error(response.message);
                }  else if(response.status === "validation-error"){
                    alertify.error(response.data.name[0]);
                }
            }

        });
    });


});

function editCash(id) {
    $.ajax({
        type: 'post',
        url: '{{URL("getCashInfo")}}',
        data: {
            id: id
        },
        dataType: 'json',
        success: function (data) {
            if (typeof data.errors !== 'undefined') {
                alertify.warning("Something went wrong");
            } else {
                $('#cash_id').val(data.id);
                $('#update_cash_amount').val(data.cash_amount);
                $('#update_description').val(data.description);
                $('#update_date').val(data.date);
                $('#modal-cash-update').modal('show');
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


</script>
@endsection

@extends('layouts.backend.master')
@section('content')
@php
$userid=Auth::user()->id;
@endphp
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
            <div class="card-header"><i class="fa fa-table"></i>Purchase Drafts</div>
            <div class="card-body">
                <div class="float-right mb-3">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-draft-insert">New Draft</button>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="itemTable" class="table table-bordered" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Draft No.</th>
                                <th>Total Amount</th>
                                <th>Note</th>
                                {{-- <th>Created By</th>
                                <th>Updated By</th> --}}
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_drafts as $draft)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{'#'.$draft->id}}</td>
                                    <td>{{$draft->amount}}</td>
                                    <td>{{$draft->note}}</td>
                                    {{-- <td>{{$draft->created_by}}</td>
                                    <td>{{$draft->updated_by}}</td> --}}
                                    <td>{{$draft->created_at}}</td>
                                    <td>

                                        {{-- @if ($userid==env('SUPERADMIN_ID') || $userid==env('HOP_ID') || $userid==env('ACCOUNTS_ID')) --}}
                                        {{-- Removed the if/else condition, added restriction by creating a separate module 'Purchase Drafts Edit' with the edit route which has been 
                                        given to hop and accounts. --}}
                                            <button class="btn btn-primary btn-xs" title="Edit" onclick="draftEdit({{$draft->id}})"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-xs" title="Delete" onclick="draftDelete({{$draft->id}})"><i class="fa fa-trash"></i></button>
                                            <button class="btn btn-info btn-xs" onclick="location.href = '{{url('draftedPurchaseSetupView',$draft->id)}}'"><i class="fa fa-check"></i></button>
                                        {{-- @endif --}}

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


<!-- add draft modal -->
<div class="modal fade" id="modal-draft-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">New Draft</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="draftInsertForm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount" min="0" step="any">
                    </div>
                    <div class="form-group">
                        <label for="note">Note (Optional)</label>
                        <textarea name="note" id="" cols="8" rows="10" class="form-control" placeholder="Enter note..."></textarea>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit draft modal body goes here -->
<div class="modal fade" id="modal-draft-update" style="display: none;" aria-hidden="true">
</div>


<script>
    $(document).ready(function () {
        var table = $('#itemTable').DataTable({
            lengthChange: false,
            stateSave: true,
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true
        });

        table.buttons().container().appendTo('#itemTable_wrapper .col-md-6:eq(0)');


    /**
     * Inserts draft
     */
    $('#draftInsertForm').submit(function(event) {
    event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Data Will Be Inserted', function() {
            $.ajax({
                type: 'post',
                url: '{{ URl('draftInsert') }}',
                data: $('#draftInsertForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === true) {
                        alertify.success(response.message);
                        $('#draftInsertForm')[0].reset();
                        $('#modal-draft-insert').modal('hide');

                        setTimeout(function() {
                            location.reload(true);
                        }, 1000);
                    } else if (response.status === false) {
                        alertify.error("<span class='text-white'>"+response.message+"</span>");
                    } else if (response.status === "validation-error") {
                        for (let key in response.data) {
                            if (response.data.hasOwnProperty(key)) {
                                alertify.error("<span class='text-white'>"+response.data[key][0]+"</span>");
                            }
                        }
                    }
                }
            });

        }, function() {
            alertify.error("<span class='text-white'>Cancelled!</span>");
        });
    });

    });



    function draftEdit(id) {
        console.log('id',id);
        $.ajax({
            type: 'post',
            url: '{{URL("getDraftEditForm")}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (response) {
                if(response.status){
                    $('#modal-draft-update').html(response.data);
                    $('#modal-draft-update').modal('show');

                    $('#draftUpdateForm').submit(function (event) {
                        event.preventDefault();
                        alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
                            $.ajax({
                                type: 'post',
                                url: '{{URl("draftUpdate")}}',
                                data: $('#draftUpdateForm').serialize(),
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status === true) {
                                        alertify.success(response.message);
                                        $('#modal-draft-update').modal('hide');
                                        $('#draftUpdateForm')[0].reset();
                                        
                                        setTimeout(function() {
                                            location.reload(true);
                                        }, 1000);
                                    } else if (response.status === false) {
                                        alertify.error("<span class='text-white'>"+response.message+"</span>");
                                    } else if (response.status === "validation-error") {
                                        for (let key in response.data) {
                                            if (response.data.hasOwnProperty(key)) {
                                                alertify.error("<span class='text-white'>"+response.data[key][0]+"</span>");
                                            }
                                        }
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
                            alertify.error("<span class='text-white'>Cancelled!</span>");
                        });
                    });

                } else{
                    console.log(response.data);
                    alertify.error("<span class='text-white'>"+response.message+"</span>");
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

    function draftDelete(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("draftDelete")}}',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === true) {
                            alertify.success(response.message);
                            setTimeout(function() {
                                location.reload(true);
                            }, 1000);
                        } else{
                            alertify.error("<span class='text-white'>"+response.message+"</span>");
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
                alertify.error("<span class='text-white'>Cancelled!</span>");
            }).setHeader('<em> CONFIRM </em> ');

    }


</script>

@endsection


@extends('layouts.backend.master')
@section('content')
@php
$userid=Auth::user()->id;
@endphp
<style>
    .footer{
            position: fixed !important;
            left: 0px !important;
            bottom: 0 !important;
        }
    .alertify-notifier .ajs-message.ajs-error{
        color: #fff !important;
        background: rgba(217, 92, 92, 0,95);
        text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
        }

    .dataTables_length {
        margin-top: 1rem;
        margin-bottom: -2.75rem;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Due Sales View</div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="dueSalesTable" class="table table-bordered" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Invoice ID</th>
                                <th>Invoice Date</th>
                                <th>Created At</th>
                                <th>Order Notes</th>
                                <th>Phone Number</th>
                                <th>Due</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- modal --}}
<div class="modal fade" id="dueCollectionModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px;">
                   Pay Due
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST" id="dueCollectionForm">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-3"> Due :</label>
                            <div class="col-md-9">
                                <input type="hidden" id="due_sales_id" name="id">
                                <input type="text" id="update_due" class="form-control square" name="payment_due" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3"> Collected Amount :</label>
                            <div class="col-md-9">

                                <input type="text" id="collected_amount" class="form-control square" name="collected_amount" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            @if ($userid==env('SUPERADMIN_ID') || $userid==env('HOP_ID') || $userid==env('ACCOUNTS_ID') || $userid==env('MANAGER_ID'))
                            {{-- Added restriction by creating a separate module 'POS due collect' with the ajax route which has been 
                            given to manager,hop and accounts. --}}
                            
                                <button type="button" class="btn btn-primary"  onclick="dueCollectionUpdate()">
                                    <i class="icon-cross2"></i> Collect
                                </button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>




<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="modalHide()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="invoice_detail_modal">
          <h6>Invoice details will go here...</h6>
        </div>
      </div>
    </div>
  </div>




<script>
    $(document).ready(function() {
        $('#dueSalesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('dueViewDatatable') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'invoice_id', name: 'invoice_id' },
                { data: 'invoice_date', name: 'invoice_date' },
                { data: 'created_at', name: 'created_at' },
                { data: 'order_notes', name: 'order_notes' },
                { data: 'phone_number', name: 'phone_number' },
                { data: 'due', name: 'due' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            dom: 'Blfrtip',  // The layout of the DataTable
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
        });
    });

    //  invoice modal
     function invoiceModal(id) {
        $.get(`invoicePrintViewUser/${id}`, function (data) {
            $('#invoice_detail_modal').html(data);
        })
        $("#invoiceModal").modal('show');
    }


    function dueCollected(id) {
        alertify.confirm("Are you sure to approve this?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{ URL("dueCollected") }}',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.warning('Something Went Wrong');
                        } else {
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

    function dueCollection(id) {
        //    $("#dueCollectionModal").modal('show');

         $.ajax({
         url: "{{ URL('getDueDetails') }}",
         method: "POST",
         data: {
         id: id
         },
         dataType:"json",
         success: function (result) {
         //alert(result);
         // console.log(result);


         $("#due_sales_id").val(id);
         $("#update_due").val(result.payment_due);
         $("#dueCollectionModal").modal('show');
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

         }


        function dueCollectionUpdate() {
            event.preventDefault();
            let getDue = $('#update_due').val();
            let getCollectedAmount = $('#collected_amount').val();
            
            if(getCollectedAmount == '' ){
                alertify.error('Collected amount can not be empty');

            }else{
                alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
                    $('#preloader').modal('show');
                    $.ajax({
                        url: "{{ URL('dueCollected') }}",
                        method: "POST",
                        data: $('#dueCollectionForm').serialize(),
                        success: function (result) {
                            if (result == "Success") {
                                alertify.success('Successfully Data Updated');
                                $('#preloader').modal('hide');
                                setTimeout(function () {
                                    location.reload(true);
                                }, 1000);
                            } else {
                                alertify.error('Error Found!');
                                $('#preloader').modal('hide');
                                setTimeout(function () {
                                    // location.reload(true);
                                }, 1000);
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
                    alertify.error('Cancel')
                });
            }
        }

</script>
@endsection

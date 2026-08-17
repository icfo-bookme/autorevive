
@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Shipment Order View</div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="shipmentOrderTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Invoice ID</th>
                                <th>Created At</th>
                                <th>Assigned At</th>
                                <th>Order Notes</th>
                                <th>Deadline At</th>
                                <th>Phone Number</th>
                                <th>Area</th>
                                <th>Priority</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr style="text-align:center;">
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <a class="custom_textDecoration"
                                            href="{{url('shipmentOrderDetailsView',$order->orders->id)}}" style="cursor: pointer">
                                            {{$order->orders ? $order->orders->first_name : ''}}
                                            {{$order->orders ? $order->orders->last_name : ''}}
                                        </a>
                                    </td>
                                    @if($order->orders->delivery_type == "delivery" || $order->orders->delivery_type == "pickup")
                                    <td>#0101{{$order->orders->id}}</td>
                                    @else
                                    <td>#0202{{$order->orders->id}}</td>
                                    @endif
                                    <td>{{$order->orders ? $order->orders->created_at : ''}}</td>
                                    <td>{{$order->orders ? $order->orders->shipment_assigned_at : ''}}</td>
                                    <td>{{$order->orders ? $order->orders->order_notes : ''}}</td>
                                    <td>{{ $order->deadline_date }}</td>
                                    <td>{{$order->orders ? $order->orders->phone_number : ''}}</td>
                                    <td>{{$order->orders ? $order->orders->area : ''}}</td>
                                    {{-- <td>{{ $order->shipment ? $order->shipment->priority : '' }}</td> --}}
                                    <td>
                                        <a class="custom_textDecoration" onclick="editPriority({{$order->id}})"
                                            style="cursor:pointer">
                                            {{ $order->priority}}
                                        </a>
                                    </td>
                                    <td>
                                        {{-- <a href="{{url('shipmentOrderDetailsView',$order->id)}}"
                                        style="padding: 5px 10px;" class="btn btn-info btn-xs border"
                                        data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fa fa-info-circle"></i>
                                        </a> --}}

                                        <a onclick="invoiceModal({{ $order->orders->id }})"
                                            style="padding: 5px 10px;color: #fff;cursor: pointer;"
                                            class="btn badge badge-primary" data-toggle="tooltip" title=""
                                            data-original-title="Invoice">
                                            Invoice
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







<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="invoice_detail_modal">
          <h6>Invoice details will go here...</h6>
        </div>
      </div>
    </div>
  </div>






{{-- edit priority modal --}}
<div class="modal fade" id="editPriorityModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px;"> Priority </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST" id="updatePriorityForm">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-md-3"> Add Priority :</label>
                            <div class="col-md-9">
                                <input type="hidden" id="id" name="id">
                                <input type="text" id="update_priority" class="form-control square"
                                    name="priority" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" onclick="priorityUpdate()">
                                <i class="icon-cross2"></i> update
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="icon-cross2"></i> Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



































<script>
    $(document).ready(function () {

        var table = $('#shipmentOrderTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
        });

    });



    //  invoice modal
     function invoiceModal(id) {
        $.get(`invoicePrintViewUser/${id}`, function (data) {
            $('#invoice_detail_modal').html(data);
        })
        $("#invoiceModal").modal('show');
    }





     function editPriority(id) {
        $.ajax({
            url: "{{ URL('getPriorityDetails') }}",
            method: "POST",
            data: {
                id: id
            },
            dataType:"json",
            success: function (result) {
                //alert(result);
                // console.log(result);
                $("#id").val(result.id);
                $("#update_priority").val(result.priority);
                $("#editPriorityModal").modal('show');
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


    function priorityUpdate() {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
            $('#preloader').modal('show');
            $.ajax({
                url: "{{ URL('updatePriorityDetails') }}",
                method: "POST",
                data: $('#updatePriorityForm').serialize(),
                success: function (result) {
                    //alert(result);
                    console.log("success")
                    if (result == "Success") {
                        alertify.success('Successfully Data Updated');
                        $('#preloader').modal('hide');
                        $("#updateRouteModal").modal('hide');
                        setTimeout(function () {

                            location.reload(true);
                        }, 1000);

                    } else {

                        alertify.error('Error Found!');
                        $('#preloader').modal('hide');
                        setTimeout(function () {

                            //   location.reload(true);
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

</script>
@endsection

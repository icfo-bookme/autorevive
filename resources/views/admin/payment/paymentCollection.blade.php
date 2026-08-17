
@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Payment Collect View</div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="pendingPaymentTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Invoice ID</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Shipment Completed At</th>
                                <th>Order Notes</th>
                                <th>Delivery Man</th>
                                <th>Total Amount</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr style="text-align:center;">
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <a class="custom_textDecoration" onclick="window.open(`{{ url('paymentCollectionDetails', $order->id) }}`)" style="cursor: pointer">
                                            {{$order->first_name}} {{$order->last_name}}
                                        </a>
                                    </td>
                                    <td>#0101{{$order->id}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->updated_at}}</td>
                                    <td>{{$order->shipment_completed_at}}</td>
                                    <td>{{$order->order_notes}}</td>
                                    <td>{{@$order->shipment->user->first_name." ".@$order->shipment->user->last_name}}</td>

                                    @if($order->delivery_type == "delivery")
                                        <td>{{@$order->total_price[0]->total+$shippingCharge->amount}}</td>
                                    @else
                                        <td>{{@$order->total_price[0]->total}}</td>
                                    @endif

                                    <td>{{$order->phone_number}}</td>
                                    <td>{{$order->city}}</td>
                                    <td>
                                        {{-- <a href="{{url('paymentCollectionDetails',$order->id)}}"
                                            style="padding: 5px 10px;" class="btn btn-info btn-xs border"
                                            data-toggle="tooltip" title="" data-original-title="Edit"> <i class="fa fa-info-circle"></i>
                                        </a> --}}

                                        <a onclick="invoiceModal({{ $order->id }})"
                                            style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"
                                            data-toggle="tooltip" title="" data-original-title="Invoice">
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


























<script>
    $(document).ready(function () {

        var table = $('#pendingPaymentTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
        });

    });



    //  function invoiceModal(){
    //     $("#invoiceModal").modal('show');
    // }
    function invoiceModal(id) {
        $.get(`invoicePrintViewUser/${id}`, function (data) {
            $('#invoice_detail_modal').html(data);
        });
        $("#invoiceModal").modal('show');
    }

</script>
@endsection


@extends('layouts.backend.master')
@section('content')
<style>
    .footer{
            position: fixed !important;
            left: 0px !important;
            bottom: 0 !important;
        }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Cancelled Sales View</div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="salesCompletedTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                {{-- <th>Sales Point</th> --}}
                                <th>Invoice ID</th>
                                <th>Invoice Date</th>
                                <th>Order Notes</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Cancelled By</th>
                                <th>Cancelled At</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)

                            <tr style="text-align:center;">
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a class="custom_textDecoration" href="{{url('completedOrderDetailsView',@$order->order->id)}}" style="cursor: pointer">
                                        {{$order->first_name}} {{$order->last_name}}
                                    </a>
                                </td>
                                {{-- <td>{{$order->order->delivery_type == 'shop' ? 'Shop' : 'Website'}}</td> --}}

                                @if($order->order->delivery_type == "delivery" || $order->order->delivery_type == "pickup")
                                    <td>#0101{{$order->order->id}}</td>
                                @else
                                    <td>#0202{{$order->order->id}}</td>
                                @endif
                                <td>{{$order->invoice_date}}</td>
                                <td>{{$order->order_notes}}</td>
                                <td>{{$order->phone_number}}</td>
                                <td>{{$order->city}}</td>
                                <td>{{$order->cancelled_by}}</td>
                                <td>{{$order->cancelled_at}}</td>
                                <td>
                                    <a onclick="invoiceModal({{ @$order->order->id }})"
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
    $(document).ready(function () {

         function modalHide(){
             $('#invoiceModal').modal('hide');
         }

         var table = $('#salesCompletedTable').DataTable({
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



</script>
@endsection

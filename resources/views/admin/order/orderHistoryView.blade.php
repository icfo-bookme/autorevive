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
            <div class="card-header"><i class="fa fa-table"></i> Order History View</div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="orderHistoryTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Invoice ID</th>
                                <th>Order Type</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Order Notes</th>
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
                                    <a class="custom_textDecoration" onclick="historyViewModal({{$order->id}})" style="cursor: pointer">
                                        {{$order->first_name}} {{$order->last_name}}
                                    </a>
                                </td>

                                @if($order->delivery_type == "delivery" || $order->delivery_type == "pickup")
                                    <td>#0101{{$order->id}}</td>
                                    @else
                                    <td>#0202{{$order->id}}</td>
                                    @endif

                                <td>{{$order->delivery_type}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->updated_at}}</td>
                                <td>{{$order->order_notes}}</td>
                                <td>{{$order->phone_number}}</td>
                                <td>{{$order->city}}</td>
                                <td>
                                    {{-- <a href="{{url('orderDetailsView',$order->id)}}" style="padding: 5px 10px;"
                                        class="btn btn-info btn-xs border" data-toggle="tooltip" title=""
                                        data-original-title="Edit">
                                        <i class="fa fa-info-circle"></i>
                                    </a> --}}

                                    <a onclick="invoiceModal({{ $order->id }})"
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






<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="historyBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
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

        var table = $('#orderHistoryTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
        });

    });

    /**
     * @name historyViewModal
     * @role fetch info and load them into modal
     * @param id
     * @return
     *
     */
    function historyViewModal(id) {

        $.ajax({
            url: '{{ url("orderHistory") }}',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            success: function (response) {
                console.log(response.data);
                let userName = "";
                if(response.data.shipment){

                    if(response.data.shipment.user){

                        if(response.data.shipment.user.first_name){
                            userName = response.data.shipment.user.first_name + " " +response.data.shipment.user.last_name;
                        }
                    }
                }
                console.log("Yes");
                console.log(response);
                let html = `
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>Created AT</th>
                                    <th>Approved AT</th>
                                    ${response.data.is_rejected ? '<th>Rejected At</th>' : ''}
                                    <th>Shipment Assigned To</th>
                                    <th>Shipment Assigned AT</th>
                                    <th>Shipment Completed AT</th>
                                    <th>Payment Collected AT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${response.data.created_at ? response.data.created_at : ''}</td>
                                    <td>${response.data.approved_at ? response.data.approved_at : ''}</td>
                                    ${response.data.is_rejected ? '<td>' + response.data.rejected_at + '</td>' : ''}
                                    <td>`+userName+`</td>
                                    <td>${response.data.shipment_assigned_at ? response.data.shipment_assigned_at : ''}</td>
                                    <td>${response.data.shipment ?response.data.shipment.completed_at ? response.data.shipment.completed_at : '' :''}</td>
                                    <td>${response.data.payment_collected_at ? response.data.payment_collected_at : ''}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>`;

                $("#historyBody").html(html);
            },
            error: function (err) {
                // alert("error");
                console.error(err);
            }
        });

        $("#historyModal").modal('show');
    }

    function invoiceModal(id) {
        $.get(`invoicePrintViewUser/${id}`, function (data) {
            $('#invoice_detail_modal').html(data);
        })
        $("#invoiceModal").modal('show');
    }

</script>
@endsection

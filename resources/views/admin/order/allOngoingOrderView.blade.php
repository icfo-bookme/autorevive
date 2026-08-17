@extends('layouts.backend.master')
@section('content')
<style>
    .footer {
        position: fixed !important;
        left: 0px !important;
        bottom: 0 !important;
    }

</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> All ongoing Order View</div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="ongoingOrderTable" class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Invoice ID</th>
                                <th>Created At</th>
                                <th>Assigned To</th>
                                <th>Deadline</th>
                                <th>Order Notes</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $isTextWhite = 0;
                            @endphp

                            @foreach ($orders as $order)
                                @isset($order->shipment->deadline_time)

                                    @if($order->shipment->deadline_time < date('Y-m-d H:i:s'))
                                        @php
                                            $style='text-align:center;background:red;color:white;';
                                            $isTextWhite=1;
                                            $remainingTime = 0;
                                        @endphp

                                    @else

                                        @php
                                        $remainingTime=(Carbon\Carbon::parse(($order->shipment->deadline_time))->diffInHours(Carbon\Carbon::now()));
                                        $isTextWhite = 0;
                                        @endphp

                                        @if($remainingTime>=3 && $remainingTime<=5)
                                            @php
                                            $style='text-align:center;background:blue;color:white;';
                                            $isTextWhite=0;
                                            @endphp
                                        @elseif($remainingTime>= 1 && $remainingTime <3)
                                            @php
                                            $style='text-align:center;background:orange;';
                                            $isTextWhite=0;
                                            @endphp
                                        @elseif($remainingTime <=1)
                                            @php
                                            $style='text-align:center;background:purple;color:white;';
                                            $isTextWhite=0;
                                            @endphp
                                        @else
                                            @php
                                            $style='text-align:center;';
                                            $isTextWhite=0;
                                            @endphp
                                        @endif

                                    @endif
                                @else
                                    @php
                                    $style='text-align:center;';
                                    $isTextWhite=0;
                                    @endphp
                                @endif

                                <tr style={{$style}}>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="custom_textDecoration {{ $isTextWhite }}">
                                        <a style="cursor:pointer; @if($isTextWhite) color: white; @else color: red; @endif"
                                            {{-- href="{{url('orderDetailsView',$order->id)}}"  --}}
                                            onclick="historyViewModal({{ $order->id }})"
                                            target="_blank">
                                            {{$order->first_name}} {{$order->last_name}}
                                        </a>
                                    </td>
                                    {{-- <td>{{sprintf("%04s",$order->id)}}</td> --}}
                                    @if($order->delivery_type == "delivery" || $order->delivery_type == "pickup")
                                    <td>#0101{{$order->id}}</td>
                                    @else
                                    <td>#0202{{$order->id}}</td>
                                    @endif
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->shipment ? @$order->shipment->user->name :"Not Assigned Yet" }}</td>
                                    <td>
                                        {{
                                            $order->shipment
                                            ?   $remainingTime > 0
                                                ?   $order->shipment->deadline_time." ".@$remainingTime." hour remaining"
                                                :   $order->shipment->deadline_time
                                            :   null
                                        }}
                                    </td>
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









{{-- invoice details --}}
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle"
    aria-hidden="true" >
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





{{-- order history modal --}}
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










































<script>


    $(document).ready(function () {

        var table = $('#ongoingOrderTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
        });
    });

    /**
     * @name editClass
     * @role fetch info and load them into modal for edit
     * @param class id
     * @return
     *
     */

    //  invoice modal
    function invoiceModal(id) {
        $.get(`invoicePrintViewUser/${id}`, function (data) {
            $('#invoice_detail_modal').html(data);
        });
        $("#invoiceModal").modal('show');
    }

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
                                    <td> ${
                                        response.data.shipment != null
                                        ? response.data.shipment.user != null
                                        ? response.data.shipment.user.first_name
                                        : ''
                                        : ''
                                        }</td>
                                    <td>${response.data.shipment_assigned_at ? response.data.shipment_assigned_at : ''}</td>
                                    <td>${response.data.shipment_completed_at ? response.data.shipment_completed_at : ''}</td>
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

</script>
@endsection

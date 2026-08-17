@extends('layouts.backend.master')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="purchaseInsertForm">
                    @csrf
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                        Shipment Order Info View
                    </h4>

                    <div class="row">
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <label>Customer Name</label>
                                        <input type="text" class="form-control" id="input-1"
                                            value=" {{$order->first_name}} {{$order->last_name}}" readonly>
                                    </td>

                                    <td>
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" id="input-1"
                                            value="{{$order->phone_number}}" readonly>
                                    </td>
                                    <td>
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="input-1" value="{{$order->email}}"
                                            readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> Country </label>
                                        <input type="text" class="form-control" id="input-1" value="{{$order->country}}"
                                            readonly>
                                    </td>
                                    <td>
                                        <label> District </label>
                                        <input type="text" class="form-control" value="{{$order->district}}" readonly>
                                    </td>

                                    <td>
                                        <label> City </label>
                                        <input type="text" class="form-control" value="{{$order->city}}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> Thana </label>
                                        <input type="text" class="form-control" id="input-1" value="{{$order->thana}}"
                                            readonly>
                                    </td>
                                    <td>
                                        <label> Area </label>
                                        <input type="text" class="form-control" value="{{$order->area}}" readonly>
                                    </td>

                                    <td>
                                        <label> Road No. </label>
                                        <input type="text" class="form-control" value="{{$order->road_no}}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> House No. </label>
                                        <input type="text" class="form-control" id="input-1"
                                            value="{{$order->house_no}}" readonly>
                                    </td>
                                    <td>
                                        <label> Flat No. </label>
                                        <input type="text" class="form-control" value="{{$order->flat_no}}" readonly>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>



                    <div class="row" id="itemInfo">

                        <table class="table table-sm">
                            <thead>
                                <tr>

                                    <th scope="col">Item</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>

                                </tr>
                            </thead>

                            <tbody>


                                @php
                                $totalAmount = 0;
                                @endphp

                                @foreach($orderDetails as $item)

                                <tr>
                                    <td>

                                        <input type="text" class="form-control" value="{{$item->item->name}}" readonly>

                                    </td>

                                    <td>
                                        <img src="{{asset($item->item->thumbnail)}}" class="img-fluid img-thumbnail"
                                            alt="..." style="height:50px;width:50px">
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control"
                                            value="{{ $item->price / $item->quantity }}" readonly>
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control" value="{{$item->quantity}}"
                                            readonly>
                                    </td>


                                    <td>

                                        <input type="text" class="form-control" value="{{ $item->price }}" readonly>

                                    </td>


                                    @php
                                    $totalAmount += $item->price;
                                    @endphp


                                </tr>

                                @endforeach

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Subtotal -</b>
                                    </td>
                                    <td><b>{{$totalAmount}}</b></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Shipping Charge -</b>
                                    </td>
                                    @php
                                    $shipmentChargeAmount = $order->is_shipment_charge_applied
                                                            ? $order->is_shipment_charge_applied
                                                            : 0;
                                    @endphp
                                    <td><b>{{ $shipmentChargeAmount }}</b></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>DISCOUNT -</b>
                                    </td>
                                    <td><b>{{@$order->discount_amount}}</b></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Total Amount -</b>
                                    </td>
                                    <td><b>{{ $totalAmount + $shipmentChargeAmount - (@$order->discount_amount) }}</b></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </form>

                <hr class="my-3 mb-4">

                <div class="row">
                    <div class="col-md-6 my-4" style="height: 300px;">
                        <div class="card shadow-sm my-2" style="border-radius: 5px">
                            <div class="card-body">
                                <h5 class="mb-3">Comment on shipment</h5>
                                <div class="form-group">
                                    <textarea class="form-control" name="comment" id="comment" cols="30"
                                        rows="7"></textarea>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary"
                                        onclick="insertComment({{ $order->id }})">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 my-4" style="overflow-y: scroll; height: 320px;">
                        @foreach ($comments as $comment)
                            <div class="card shadow-sm my-2" style="border-radius: 5px">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h6 class="text-dark">{{ $comment->user->first_name." ".$comment->user->last_name }}</h6>
                                        </div>
                                        <div class="col-sm-5">
                                            <span class="text-disabled">
                                                {{ date_format($comment->created_at, 'H:i') }}
                                                <b style="color: #000;font-size: 1.15rem;font-weight: 500;">|</b>
                                                {{ date_format($comment->created_at, 'd M Y') }}
                                            </span>
                                        </div>
                                        <div class="col-sm-12">
                                            <p>
                                                {{ $comment->comment }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="row" style="margin-top:20px">
                    <div class="col text-center">
                        <button class="btn btn-primary" onclick="shipmentOrderApproved({{ $order->id }})">Shipment Completed</button>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modal-reschedule">Shipment Reschedule</button>
                        <button class="btn btn-danger" onclick="cancelShipmentOrder({{ $order->id }})">Cancel</button>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

<!-- loader modal -->
<div class="modal" id="preloader" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <img src="{{ asset('assets/images/preloader.gif') }}"
            style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>


<!-- modal body goes here -->
<div class="modal fade" id="modal-reschedule" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Reschedule Reason</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="deliveryManAssign">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="reasonMessage" id="reasonMessage">
                    </div>
                    <br>

            </div>
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="button" onclick="shipmentOrderReschedule({{ $order->id }})" class="btn btn-success"><i
                        class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>



<script>
    function shipmentOrderApproved(id) {
        event.preventDefault();

        alertify.confirm('Are You Sure ?', 'Shipment will be completed?', function () {
            $('#preloader').modal('show');
            $.ajax({
                type: 'post',
                url: '{{URl("shipmentOrderApprovedAjax")}}',
                data: {
                    id: id,
                    // order_code: value
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#preloader').modal('hide');
                    if (typeof data.errors !== 'undefined') {
                        alertify.error('Something Went Wrong');
                    } else if (data['ORDER_CODE_ERR'] !== undefined) {
                        alertify.error('<span class="text-white">Wrong order code!</span>');
                    } else {
                        alertify.success(data);
                        setTimeout(function () {
                            location.replace(document.referrer);

                        }, 1000);
                    }
                },

                error: function (jqXHR, exception) {
                    $('#preloader').modal('show');
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
            }); // ajax - end

        }, function () {
            alertify.error('Cancel')
        });
    }


    function cancelShipmentOrder(id) {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Order Will Be Cancelled!', function () {

            $.ajax({
                url: '{{ URL("cancelShipmentAjax") }}',
                type: 'POST',
                data: {
                    id: id
                },
                success: data => {
                    if (data == 'success') {
                        alertify.success('<span class="text-white">Order Cancelled!</span>');
                        setTimeout(function () {
                            location.replace(document.referrer);
                        }, 1000)
                    }
                },
                error: err => {
                    alertify.error('<span class="text-white">Error occured!</span>');
                }
            });

        }, function () {
                alertify.error('Cancel')
        });
    }





    function shipmentOrderReschedule(id) {

        var reasonMessage = $("#reasonMessage").val();

        if (reasonMessage == "") {

        } else {
            alertify.confirm('Are You Sure ?', 'shipment will be rescheduled?', function () {
                $('#modal-reschedule').modal('hide');
                $.ajax({
                    type: 'post',
                    url: '{{URl("shipmentOrderRescheduleAjax")}}',
                    data: {
                        id: id,
                        reasonMessage: reasonMessage
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.error('Something Went Wrong');

                        } else {
                            alertify.success(data);
                            setTimeout(function () {
                                location.href = "{{ url('shipmentOrderView') }}";
                            }, 1000);

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

        }


    }

    function insertComment(order_id) {
        let comment = $('#comment').val();

        if (comment.length > 0) {
            $.ajax({
                url: '{{ URL("insertComment") }}',
                type: 'POST',
                data: {
                    order_id: order_id,
                    comment: comment,
                    _token: '{{ csrf_token() }}'
                },
                success: data => {
                    if (data.errors) {
                        alertify.error('Error occurred! Check input!');
                    }
                    alertify.success(data);
                    reload();
                },
                error: err => console.error(err)
            });
        } else {
            alertify.error('<span class="text-white">Comment box in empty!</span>');
        }
    }

    function reload() {
        setTimeout(() => location.reload(), 1000);
    }

    //    function shipmentReschedule(){
    //      $('#modal-reschedule').modal('show');
    //    }

</script>

@endsection

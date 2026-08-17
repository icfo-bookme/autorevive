@extends('layouts.backend.master')
@section('content')
<style>
    .footer{
            position: fixed !important;
            left: 0px !important;
            bottom: 0 !important;
        }
</style>
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="purchaseInsertForm">
                    @csrf
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                       Approved Order Info View
                    </h4>

                    <div class="row">
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <label>Customer Name</label>
                                         <input type="text" class="form-control" id="input-1" value=" {{$order->first_name}} {{$order->last_name}}" readonly>
                                    </td>

                                    <td>
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" id="input-1" value="{{$order->phone_number}}"
                                            readonly>
                                    </td>
                                    <td>
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="input-1" value="{{$order->email}}" readonly>
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
                                  $totalAmount  = 0;
                                @endphp

                                @foreach($orderDetails as $item)
                                {{-- @dd($item) --}}

                                <tr>
                                    <td>

                                        <input type="text"  class="form-control" value="{{$item->item->name}}" readonly>

                                    </td>

                                    <td>
                                       <img src="{{asset($item->item->thumbnail)}}" class="img-fluid img-thumbnail" alt="..." style="height:50px;width:50px">
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control" 
                                            value="{{ $item->price / $item->quantity }}" readonly>
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control" 
                                            value="{{$item->quantity}}" readonly>
                                    </td>


                                    <td>

                                        <input type="text"  class="form-control" value="{{ $item->price }}" readonly>
                                        @php
                                            $totalAmount += $item->price;

                                        @endphp

                                    </td>

                                </tr>

                                @endforeach
                               
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Subtotal =</b>
                                    </td>
                                    <td><b>{{$totalAmount}}</b></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                      <b>Shipping Charge =</b>
                                    </td>
                                    @php
                                    $shipmentCharge = $order->is_shipment_charge_applied
                                                        ? $order->is_shipment_charge_applied
                                                        : 0;
                                    @endphp
                                     <td><b>{{ $shipmentCharge }}</b></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                      <b>Discount =</b>
                                    </td>
                                     <td><b>{{ @$order->discount_amount }}</b></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Total Amount =</b>
                                    </td>
                                    <td><b>{{ $totalAmount + $shipmentCharge - (@$order->discount_amount) }}</b></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </form>

                @if($order->status == 0 )
                <div class="row" style="margin-top:20px">
                    <div class="col text-center">

                        @if ($order->delivery_type=='pickup')
                            <button class="btn btn-primary" onclick="pickupOrder()">Pickup</button>
                            <button class="btn btn-danger" onclick="cancelShipment({{ $order->id }})">Cancel</button> 
                        @else
                            <button class="btn btn-primary" onclick="shipmentOrder()">Shipment</button>
                            <button class="btn btn-danger" onclick="cancelShipment({{ $order->id }})">Cancel</button>
                        @endif
                        
                    </div>
                </div>
                @else
                <div class="row" style="margin-top:20px">
                    <div class="col text-center">
                         <div class="alert alert-success" id="alert" role="alert">
                   Order approved and delivery man assigned!
                </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>


<!-- modal body goes here -->
<div class="modal fade" id="modal-shipment" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Shipment Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
             <form id="deliveryManAssign">
                 <div class="col-md-12">
                     <select class="form-control" name="team_leader" id="team_leader">
                         <option value="">--SELECT Team Leader--</option>
                         @foreach($teamLeaders as $leader)
                         <option value="{{$leader->user->id}}">{{$leader->user->first_name." ".$leader->user->last_name}}</option>
                         @endforeach
                     </select>
                 </div>

                 <br>

                <div class="col-md-12">
                    <select class="form-control" name="deliveryman" id="deliveryMan">
                            <option value ="">--SELECT Deliveryman--</option>
                            @foreach($deliveryMan as $man)
                                <option value="{{$man->user->id}}">{{$man->user->first_name." ".$man->user->last_name}}</option>
                            @endforeach
                    </select>
                </div>

                <br>


                <div class="col-md-12">
                    <label>Deadline Date</label>
                    <input type="date" class="form-control" name="date">
                    <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">
                </div>

                <br>

                <div class="col-md-12">
                    <label>Time</label>
                    <input type="time" class="form-control" name="deadlineTime">
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="button" onclick="deliveryManAssign()" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- pickup modal body goes here -->
<div class="modal fade" id="modal-pickup" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Pickup Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
             <form id="pickupAssign">

                <div class="col-md-12">
                    <select class="form-control" name="team_leader" id="pickup_team_leader">
                        <option value="">--SELECT Team Leader--</option>
                        @foreach($teamLeaders as $leader)
                        <option value="{{$leader->user->id}}">{{$leader->user->first_name." ".$leader->user->last_name}}</option>
                        @endforeach
                    </select>
                </div>

                <br>

                <div class="col-md-12">
                    <label>Pickup Date</label>
                    <input type="date" class="form-control" name="pickup_date">
                    <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">
                </div>

                <br>

                <div class="col-md-12">
                    <label>Pickup Time</label>
                    <input type="time" class="form-control" name="pickup_time">
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="button" onclick="pickupAssign()" class="btn btn-success"><i class="fa fa-check-square-o"></i>Approve</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- @dd($order->shipment) --}}
<script>
    $(document).ready(function () {
      
        @if(isset($order->shipment->deadline_date))
        $('#team_leader').val({{ $order->team_leader_id }});

            $('input[name=date]').val('{{ $order->shipment->deadline_date }}');
            $('input[name=deadlineTime]').val('{{ explode(' ', $order->shipment->deadline_time)[1] }}');

        @endif
        
        @if(isset($order->pickup->pickup_date))
        $('#pickup_team_leader').val({{ $order->team_leader_id }});

            $('input[name=pickup_date]').val('{{ $order->pickup->pickup_date }}');
            $('input[name=pickup_time]').val('{{ explode(' ', $order->pickup->pickup_time)[1] }}');

        @endif


    });

          function cancelShipment(id) {
             event.preventDefault();
             alertify.confirm('Are You Sure ?', 'Order Will Be Cancelled!', function () {

                $.ajax({
                    type: 'post',
                    url: '{{URl("cancelShipmentAjax")}}',
                    data: {
                        id:id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.error('Something Went Wrong');

                        }else {
                            //alert(data);
                            alertify.success(data);
                            setTimeout(function () {
                                location.replace(document.referrer);;
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
       }




        function deliveryManAssign() {
            event.preventDefault();
            alertify.confirm('Are You Sure ?', 'Delivery man will be assigned.', function () {
                $.ajax({
                    type: 'post',
                    url: '{{URl("deliveryManAssignAjax")}}',
                    data: $('#deliveryManAssign').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            alertify.error('Something Went Wrong');
                        } else {
                            $('#modal-shipment').modal('hide');
                            $('#deliveryManAssign').trigger('reset');

                            alertify.success(data);

                            setTimeout(function () {
                                location.replace(document.referrer);
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
        function pickupAssign() {
            event.preventDefault();
            alertify.confirm('Are You Sure ?', 'Pickup will be approved', function () {
                $.ajax({
                    type: 'post',
                    url: '{{URl("pickupAjax")}}',
                    data: $('#pickupAssign').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            alertify.error('Something Went Wrong');
                        } else {
                            $('#modal-pickup').modal('hide');
                            $('#pickupAssign').trigger('reset');

                            alertify.success(data);

                            setTimeout(function () {
                                location.replace(document.referrer);
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

        function shipmentOrder($id){
           $('#modal-shipment').modal('show');
        }

        function pickupOrder($id){
           $('#modal-pickup').modal('show');
        }


</script>

@endsection

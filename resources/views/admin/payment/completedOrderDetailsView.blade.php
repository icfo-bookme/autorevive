
@extends('layouts.backend.master')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="purchaseInsertForm">
                    @csrf
                    @if (@$isCancelled == 1)
                        <h4 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                        Cancelled Sales Info View
                        </h4>
                    @else
                        <h4 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                        Completed Order Info View
                        </h4>   
                    @endif

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
                                    <td colspan="2">
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
                                    <td>
                                        <label> Thana </label>
                                        <input type="text" class="form-control" id="input-1" value="{{$order->thana}}"
                                            readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> Area </label>
                                        <input type="text" class="form-control" value="{{$order->area}}" readonly>
                                    </td>

                                    <td>
                                        <label> Road No. </label>
                                        <input type="text" class="form-control" value="{{$order->road_no}}" readonly>
                                    </td>
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

                                <tr>
                                    {{-- <td> --}}
                                        {{-- <p><strong>Approved at:</strong> {{$order->approved_at}}</p>
                                        <p><strong>Shipment Assigned at:</strong> {{$order->shipment_assigned_at}}</p> --}}
                                        {{-- <p><strong>Shipment Completed at:</strong> {{$order->completed_}}</p> --}}
                                        {{-- <p><strong>Payment Collected at:</strong> {{$order->payment_collected_at}}</p> --}}
                                    {{-- </td> --}}
                                    <td>
                                        {{-- @dd($order) --}}
                                        <label for="">Approved At</label>
                                        <input type="text" class="form-control" value="{{$order->approved_at}}" readonly>
                                    </td>
                                    <td>
                                        <label for="">Shipment Assigned At</label>
                                        <input type="text" class="form-control" value="{{$order->shipment_assigned_at}}" readonly>
                                    </td>
                                    <td>
                                        <label for="">Shipment Completed At</label>
                                        <input type="text" class="form-control" value="{{$order->shipment_completed_at}}" readonly>
                                    </td>
                                    <td>
                                        <label for="">Payment Collected At</label>
                                        <input type="text" class="form-control" value="{{$order->payment_collected_at}}" readonly>
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

                                <tr>
                                    <td>

                                        <input type="text"  class="form-control" value="{{$item->item->name}}" readonly>
                                        {{-- <br/> --}}
                                        <div class="text-left">
                                            <span class="badge badge-info text-white py-1 px-2 mt-1">{{ @$item->purchase_item_barcodes->barcode }}</span>
                                        </div>

                                    </td>

                                    <td>
                                        @if (isset($item->item->thumbnail))
                                            <img src="{{asset($item->item->thumbnail)}}" class="img-fluid img-thumbnail" alt="..." style="height:50px;width:50px">
                                        @else
                                            <p> x </p>
                                        @endif
                                            
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control"
                                            value="{{ $item->price / $item->quantity }}" readonly>
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control" value="{{ $item->quantity }}" readonly>
                                    </td>

                                    <td>

                                        <input type="text"  class="form-control" value="{{ $item->price }}" readonly>

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
                                    <td><b>{{ $totalAmount + @$shipmentChargeAmount - (@$order->discount_amount) }}</b></td>
                                </tr>

                                @if($order->payment_due > 0 && $order->is_due_paid == 0)

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Paid -</b>
                                    </td>
   
                                    <td style="color: #000"><b>{{ ($totalAmount + (@$shipmentChargeAmount  -@$order->discount_amount)) - @$order->payment_due }}</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Due -</b>
                                    </td>

                                    
                                    <td style="color: #000"><b> {{@$order->payment_due }} </b></td>
                                </tr>


                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Due Paid -</b>
                                    </td>

                                    
                                    <td style="color: #000"><b> {{$totalPaid }} </b></td>
                                </tr>


                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Remaining Due -</b>
                                    </td>

                                    
                                    <td style="color: #000"><b> {{$dueAmount - $totalPaid }} </b></td>
                                </tr>

                                @endif


                                @if (@$isCancelled == 1)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right' style="background-color:#C70909">
                                        <b>Return money (to customer) -</b>
                                    </td>

                                    
                                    <td style="color: #000"><b> {{ (($totalAmount + (@$shipmentChargeAmount  -@$order->discount_amount)) - @$order->payment_due) + $totalPaid }} </b></td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                        <div class="mx-auto">
                            <div class="row" style="margin:20px 20px">
                                @foreach ($paymentMethods as $paymentMethod)

                                   <div class="col-lg-3">
                                    <div class="icheck-material-primary">
                                        <input type="radio" class="radio" id="{{$paymentMethod->id}}" name="payment_method_id" value="{{$paymentMethod->id}}" @if(@$paymentDetails->payment_method_id == $paymentMethod->id)checked @endif>
                                        <label for="{{$paymentMethod->id}}">{{$paymentMethod->payment_method}}</label>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>



            </div>
        </div>
    </div>
</div>



<script>
          function paymentCollect(id) {
             event.preventDefault();
             alertify.confirm('Are You Sure ?', 'payment will be collected?', function () {

            $.ajax({
                type: 'post',
                url: '{{URl("paymentCollectedAjax")}}',
                data: {
                    id:id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.error('Something Went Wrong');

                    }else {

                        alertify.success(data);
                        setTimeout(function () {
                           location.href = "{{ url('collectPayment') }}";
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

</script>

@endsection

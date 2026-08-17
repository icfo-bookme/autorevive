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
                       Cancelled Order Info View
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

                                <tr>
                                    <td>

                                        <input type="text"  class="form-control" value="{{$item->item->name}}" readonly>

                                    </td>

                                    <td>
                                       <img src="{{asset($item->item->thumbnail)}}" class="img-fluid img-thumbnail" alt="..." style="height:50px;width:50px">
                                    </td>
                                    
                                    <td>
                                        <input type="number" step="any" class="form-control"
                                            value="{{$item->price / $item->quantity}}"
                                            readonly>
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control" value="{{$item->quantity}}" readonly>
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
                                     $shipmentCharge = $order->is_shipment_charge_applied
                                                            ? $shippingCharge->amount
                                                            : 0;
                                     @endphp
                                     <td><b>{{ $shipmentCharge }}</b></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2" class='float-right'>
                                        <b>Total Amount -</b>
                                    </td>
                                    <td><b>{{$totalAmount + $shipmentCharge}}</b></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </form>

                {{-- @if($order->is_shipment == 0)
                <div class="row" style="margin-top:20px">
                    <div class="col text-center">
                        <button class="btn btn-primary" onclick="shipmentOrderApproved({{ $order->id }})">Shipment Approved</button>
                        <button class="btn btn-danger" onclick="cancelShipmentOrder({{ $order->id }})">Cancel</button>
                    </div>
                </div>
                @else

                 <div class="row" style="margin-top:20px">
                    <div class="col text-center">
                         <div class="col text-center">
                         <div class="alert alert-success" id="alert" role="alert">
                            Data inserted in sales table!
                        </div>
                    </div>
                </div>

                @endif --}}


            </div>
        </div>
    </div>
</div>


{{-- <!-- modal body goes here -->
<div class="modal fade" id="modal-shipment" style="display: none;" aria-hidden="true">
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
                <select class="form-control" name="deliveryman" id="deliveryMan">            
                        <option value ="">--SELECT Deliveryman--</option>                  
                        @foreach($deliveryMan as $man)
                            <option value ="{{$man->id}}">{{$man->name}}</option>
                            
                        @endforeach
                </select>
              </div><br>


              <div class="col-md-12">
               <label>Date</label>   
               <input type="date" class="form-control" name="date">
               <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">
              </div><br>

              <div class="col-md-12">
               <label>Deadline</label>   
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
</div> --}}

@endsection
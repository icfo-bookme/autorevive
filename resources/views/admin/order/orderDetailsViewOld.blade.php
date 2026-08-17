@extends('layouts.backend.master')
@section('content')
<style>
    .footer {
        position: fixed !important;
        left: 0px !important;
        bottom: 0 !important;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
               <div class="row">
                   <div class="col-lg-8">
                        <form id="purchaseInsertForm">
                            @csrf
                            <h4 class="form-header text-uppercase text-center">
                                <i class="fa fa-user-circle-o"></i>
                                Order Info View
                            </h4>
                            <input type="hidden" name="deliveryType" id="deliveryType" value="{{$order->delivery_type}}">
                            <input type="hidden" name="shippingCharge" id="shippingCharge" value="{{$shippingCharge['amount']}}">
                            <input type="hidden" name="isShipmentChargeApplied" id="isShipmentChargeApplied" value="{{$shippingCharge['amount']}}">

                            <div class="row">
                                <div class="table-responsive">
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
                                                    <input type="email" class="form-control" id="input-1"
                                                        value="{{$order->email}}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label> Country </label>
                                                    <input type="text" class="form-control" id="input-1"
                                                        value="{{$order->country}}" readonly>
                                                </td>
                                                <td>
                                                    <label> District </label>
                                                    <input type="text" class="form-control" value="{{$order->district}}"
                                                        readonly>
                                                </td>

                                                <td>
                                                    <label> City </label>
                                                    <input type="text" class="form-control" value="{{$order->city}}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label> Thana </label>
                                                    <input type="text" class="form-control" id="input-1"
                                                        value="{{$order->thana}}" readonly>
                                                </td>
                                                <td>
                                                    <label> Area </label>
                                                    <input type="text" class="form-control" value="{{$order->area}}" readonly>
                                                </td>

                                                <td>
                                                    <label> Road No. </label>
                                                    <input type="text" class="form-control" value="{{$order->road_no}}"
                                                        readonly>
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
                                                    <input type="text" class="form-control" value="{{$order->flat_no}}"
                                                        readonly>
                                                </td>
                                            </tr>

                                            @if($order->rescheduleReason)

                                            @foreach($order->rescheduleReason as $reason)

                                            <tr>

                                                <td>
                                                    <label> Reschedule Reason </label>
                                                    <input type="text" class="form-control" id="input-1"
                                                        value="{{$reason->reason}}" readonly>
                                                </td>
                                                <td>
                                                    <label> Created By </label>
                                                    <input type="text" class="form-control" value="{{$reason->created_by}}"
                                                        readonly>
                                                </td>

                                                <td>
                                                    <label> Created At </label>
                                                    <input type="text" class="form-control" value="{{$reason->created_at}}"
                                                        readonly>
                                                </td>
                                            </tr>

                                            @endforeach



                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                                <div class="row col-lg-4 mt-4">
                                    <input type="text" class="form-control" name="remarks" id="remarks" required placeholder="Add Remarks" onkeyup="addRemarks(this.value)">
                                </div>


                                <div class="row col-lg-12 mt-4">
                                    <label for="">Item List<span class="must">*</span></label>
                                    <select class="valid js-select2" id="itemId" name="items"
                                            onchange="selectProduct(this.value)" required="" aria-invalid="false">
                                        <option value="">Select Item</option>
                                        @foreach ($allProducts as $product)
                                            <option value="{{$product->id }},{{$product->barcode}}">{{ $product->item->name }} {!! "&nbsp;" !!} ({{ $product->barcode}})  {!! "&nbsp;" !!} {!! "&nbsp;" !!} {{$product->stock->quantity ?? "0"}} {{$product->stock->uom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            <div class="row" id="itemInfo">

                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Image</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>

                                                <th>Price</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="selected_tbl">


                                            @foreach($orderDetails as $item)

                                            <tr id="item_{{$item->item->id}}" data-price="{{$item->item->sales_price}}">
                                                <td class="" id="item_{{$item->item->id}}_title" style="max-width: 20%; white-space: break-spaces;">{{$item->item->name}}</td>
                                                <td class="whiteSpace_normal"><img src="{{asset($item->item->thumbnail)}}" width="50" height="50"></td>
                                                <td class="whiteSpace_normal" style="min-width: 200px;">
                                                    <button class="btn btn-danger btn-sm text-white"
                                                        onclick="decreaseItemCount(event,{{$item->item->id}},{{$item->item->sales_price}})"
                                                        style="cursor: pointer;">-</button>
                                                    <input id="item_{{$item->item->id}}_count"
                                                        onkeyup="changeTotal({{$item->item->sales_price}}, 'item_{{$item->item->id}}_count', 'item_{{$item->item->id}}_total')"
                                                        type="text" class="form-control w-50 d-inline-block" value="{{$item->quantity}}" min="1" readOnly>
                                                    <button class="btn btn-success btn-sm text-white"
                                                        onclick="increaseItemCount(event,{{$item->item->id}},{{$item->item->sales_price}})"
                                                        style="cursor: pointer">+</button>
                                                </td>
                                                <td >
                                                    <input id="item_{{$item->item->id}}_unit"
                                                    onkeyup="changeUnit(this.value, 'item_{{$item->item->id}}_count', 'item_{{$item->item->id}}_total',{{$item->item->id}})"
                                                    type="text" class="form-control w-50 d-inline-block" value="{{$item->unit_price}}" min="1">
                                                </td>
                                                <td class="whiteSpace_normal" id="item_{{$item->item->id}}_total">{{$item->unit_price * $item->quantity}}</td>
                                                <td class="whiteSpace_normal">
                                                    <span onclick="removeItem({{$item->item->id}})" class="badge badge-danger py-3 px-2"
                                                        style="cursor: pointer;min-width:45px">X</span>
                                                </td>
                                            </tr>



                                            @endforeach


                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </form>
                   </div>
                   <div class="col-lg-4">
                       <div class="invoice" style="background-color: #FFF; padding: 15px;">

                            <div id="invoiceElement">

                            <main id="mainDiv">
                            <style>
                                body{
                                    background:#fff;
                                    }
                            </style>
                                <div class="div" style="display: flex; justify-content: space-between; align-items: baseline;">
                                    <div class="invoice-img" style="display: inline-block;">
                                        <h3 style="color: #3989c6;font-size: 18px;line-height: 20px;">Date : {{Carbon\Carbon::parse($order->created_at)->format('d-m-y')}}</h3>
                                        <h3 style="color: #3989c6;font-size: 18px;line-height: 20px;">INVOICE TO:</h3>
                                        <p style="color: black;font-size: 14px;">Name: {{$order->first_name}} {{$order->last_name}}</p>
                                        <p style="color: black;font-size: 14px;">Phone: {{$order->phone_number}}</p>
                                        <p style="color: black;font-size: 14px;">Email: {{$order->email}}  </p>
                                    </div>
                                    <div class="address-shop" style="float: right;">
                                        <h3 style="color: #3989c6;font-size: 18px;">INVOICE #0101{{$order->id}}</h3>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;border: 1px solid #757575">
                                        <thead>
                                            <tr>
                                                <th style="padding: 15px 8px;background-color: black;color: #fff;">#</th>
                                                <th style="padding: 15px 8px;background-color: black;color: #fff;">ITEM</th>
                                                <th style="padding: 15px 8px;background-color: black;color: #fff;">QUANTITY</th>
                                                <th style="padding: 15px 8px;background-color: black;color: #fff;">UNIT PRICE</th>
                                                <th style="padding: 15px 8px;background-color: black;color: #fff;">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="selected_tbl_invoice">
                                            @php
                                            $totalAmount = 0;
                                            $iterationValue = 0;
                                            @endphp
                                            @foreach($orderDetails as $item)
                                            <tr id="item_invoice_{{$item->item->id}}">
                                                <td class="order_serial_td_{{$loop->iteration}}" style="padding: 12px 8px;color: black;">{{$loop->iteration}}</td>
                                                <td style="padding: 12px 8px;max-width: 200px;white-space: break-spaces;color: black;"> {{$item->item->name}}</td>
                                                <td id="item_invoice_{{$item->item->id}}_count" style="padding: 12px 8px;color: black;">{{$item->quantity}}</td>
                                                <td  id="item_invoice_{{$item->item->id}}_unit_price" style="padding: 12px 8px;color: black;">৳{{$item->price/$item->quantity}}</td>
                                                <td id="item_invoice_{{$item->item->id}}_total" style="color: black">৳{{$item->price}}</td>
                                            </tr>
                                            @php
                                                   $iterationValue = $loop->iteration;
                                                   $totalAmount = $totalAmount+$item->price;
                                            @endphp
                                            @endforeach
                                            <input type="hidden" name="order_serial" class="order_serial" id="order_serial" value="{{$iterationValue}}">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2" style="color: black;">SUBTOTAL</td>
                                                <td id="totalAmountInvoice" style="color: black;">৳{{$totalAmount}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2" style="color: black;">SHIPPING CHARGES</td>
                                                <td id="shippingChargeInvoice" style="color: black;">৳{{ $order->is_shipment_charge_applied }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2" style="color: black;">Discount</td>
                                                <td id="" style="color: black;">৳{{$order->discount_amount}}</td>
                                            </tr> --}}
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2" style="color: black;">GRAND TOTAL</td>
                                                <td id="totalAmountWithShippingInvoice" style="color: black;">৳{{ $totalAmount + $order->is_shipment_charge_applied }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    </div>
                                    <div id="spaceDiv">
                                        <div>
                                            <p style="border-bottom: 1px solid #000;font-size: 16px; width: 70px; color: #000;">Remarks</p>
                                            <p style="font-size: 16px;color: #000;">
                                                <span id="addRemarks" style="font-size: 14px !important;"></span></p>
                                        </div>
                                        <div style="display: flex;justify-content: space-between;align-items: center; margin-top: 70px;">
                                              <div>
                                                <p style="border-bottom: 1px solid #000;font-size: 16px; width: 100px;  color: #000;">Received By</p>
                                              </div>
                                              <div>
                                                <p style="border-bottom: 1px solid #000;font-size: 16px; width: 130px;color: #000;">Yours Sincerely</p>
                                                <p style="font-size: 16px; width: 130px;color: #000; text-align: center; line-height: 16px;">Automart</p>
                                              </div>
                                        </div>
                                    </div>
                                </div>

                            </main>

                            </div>


                        <div class="row no-print">
                                <div class="col-lg-12">
                                <div class="float-sm-right">
                                    <a href="javascript:void(0)" class="btn btn-primary m-1" onclick="printDiv('invoiceElement')"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>

                    </div>
                   </div>
               </div>

               <div class="mx-auto my-3">
                   <div class="col-lg-12 pt-4">
                       <div class="form-check form-check-inline">
                           <input class="form-check-input" type="checkbox" name="highlights" value="1">
                           <label class="form-check-label">highlight</label>
                       </div>
                   </div>
               </div>

                <div class="row" style="margin:20px 20px;">
                    <div class="col text-center">
                        @if ($order->delivery_type=='pickup')
                            <button class="btn btn-primary" onclick="pickupApproved({{ $order->id }})">Approve</button>
                            <button class="btn btn-danger" onclick="cancelOrder({{ $order->id }})">Cancel</button>
                        @else
                            <button class="btn btn-primary" onclick="shipmentOrder()">Shipment</button>
                            <button class="btn btn-primary" onclick="orderApproved({{ $order->id }})">Approve</button>
                            <button class="btn btn-danger" onclick="cancelOrder({{ $order->id }})">Cancel</button>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- assign team leader modal --}}
<!-- modal body goes here -->
<div class="modal fade" id="team_leader_modal" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Delivery Approve Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="team_leader_assign_form">
                    <div class="col-md-12">
                        <select class="form-control" name="team_leader_id" id="team_leader_id">
                            <option value="">--SELECT Team Leader--</option>

                            @foreach($teamLeaders as $leader)
                            <option value="{{$leader->user->id}}">{{$leader->user->first_name." ".$leader->user->last_name}}</option>
                            @endforeach

                        </select>
                    </div><br>

                    <div class="col-md-12">
                        <label>Deadline Date</label>
                        <input type="date" class="form-control" name="date">
                        <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">
                    </div><br>

                    <div class="col-md-12">
                        <label>Time</label>
                        <input type="time" class="form-control" name="deadlineTime">
                    </div>


            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" onclick="teamLeaderAssign({{ $order->id }})"
                    class="btn btn-success save_change_btn"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


{{-- assign pickup team leader modal --}}
<div class="modal fade" id="pickup_team_leader_modal" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Pickup Approve Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pickup_team_leader_assign_form">
                    <div class="col-md-12">
                        <select class="form-control" name="team_leader_id" id="team_leader_id">
                            <option value="">--SELECT Team Leader--</option>

                            @foreach($teamLeaders as $leader)
                            <option value="{{$leader->user->id}}">{{$leader->user->first_name." ".$leader->user->last_name}}</option>
                            @endforeach

                        </select>
                    </div><br>

                    <div class="col-md-12">
                        <label>Pickup Date</label>
                        <input type="date" class="form-control" name="pickupDate">
                        <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">
                    </div><br>

                    <div class="col-md-12">
                        <label>Pickup Time</label>
                        <input type="time" class="form-control" name="pickupTime">
                    </div>


            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" onclick="pickupTeamLeaderAssign({{ $order->id }})"
                    class="btn btn-success save_change_btn"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- shipment team leader & delivery man modal --}}
<!-- shipment modal body goes here -->
<div class="modal fade" id="modal-shipment" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Direct Shipment Modal</h4>
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
                    </div><br>

                    <div class="col-md-12">
                        <select class="form-control" name="deliveryman" id="deliveryMan">
                            <option value="">--SELECT Deliveryman--</option>
                            @foreach($deliveryMan as $man)

                            <option value="{{$man->user->id}}">{{$man->user->first_name." ".$man->user->last_name}}</option>
                            @endforeach
                        </select>
                    </div><br>

                    <div class="col-md-12">
                        <label>Deadline Date</label>
                        <input type="date" class="form-control" name="date">
                        <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">
                    </div><br>

                    <div class="col-md-12">
                        <label>Time</label>
                        <input type="time" class="form-control" name="deadlineTime">
                    </div>


            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" onclick="deliveryManAssign({{ $order->id }})"
                    class="btn btn-success save_change_btn"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- loader modal -->
<div class="modal" id="preloader" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <img src='{{asset('assets/images/preloader.gif')}}'
            style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>


<script>

    $(document).ready(function(){
        $(".js-select2").select2({
            closeOnSelect: true
        });

        $('#selected_tbl_invoice').on("DOMSubtreeModified", function () {
            calculateTotal();
        });

    });


    function selectProduct(id) {
        /*
            if item isn't selected yet, add row
            else, increase quantity by 1
        */
        if (!itemAlreadySelected(id)) {
            $.ajax({
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                url: '{{ URL("/getProductByIdAjax") }}',
                success: data => {
                    if (Object.keys(data).length > 0) {
                        let orderSerial = parseInt($('#order_serial').val());
                         orderSerial += 1;
                        $('#order_serial').val(orderSerial);

                        $('#selected_tbl').append(`<tr id="item_${data.id}" data-price="${data.sales_price}">

                            <td class="whiteSpace_normal" id="item_${data.id}_title">${data.name}</td>
                            <td class="whiteSpace_normal"><img src="../${data.thumbnail}" width="50" height="50"></td>
                            <td class="whiteSpace_normal" style="min-width: 200px;">
                                <button class="btn btn-danger btn-sm text-white"
                                    onclick="decreaseItemCount(event,${data.id}, ${data.sales_price})"
                                    style="cursor: pointer;">-</button>
                                <input id="item_${data.id}_count"
                                    onkeyup="changeTotal(${data.sales_price}, 'item_${data.id}_count', 'item_${data.id}_total')"
                                    type="text" class="form-control w-50 d-inline-block" value="1" min="1">
                                <button class="btn btn-success btn-sm text-white"
                                    onclick="increaseItemCount(event,${data.id}, ${data.sales_price})"
                                    style="cursor: pointer">+</button>
                            </td>
                            <td>
                                <input id="item_${data.id}_unit"
                                                    onkeyup="changeUnit(this.value, 'item_${data.id}_count', 'item_${data.id}_total',${data.id})"
                                                    type="text" class="form-control w-50 d-inline-block" value="${data.sales_price}" min="1">
                            </td>
                            <td class="whiteSpace_normal" id="item_${data.id}_total">${data.sales_price}</td>
                            <td class="whiteSpace_normal">
                                <span onclick="removeItem(${data.id})" class="badge badge-danger py-3 px-2"
                                    style="cursor: pointer;min-width:45px">X</span>
                            </td>
                        </tr>`);


                        $('#selected_tbl_invoice').append(`<tr id="item_invoice_${data.id}" data-price="${data.sales_price}">
                            <td class="whiteSpace_normal order_serial_id_${orderSerial}">${orderSerial}</td>
                            <td class="whiteSpace_normal" id="item_invoice_${data.id}_title">${data.name}</td>
                                    <td id="item_invoice_${data.id}_count" type="text" style="padding: 12px 8px;">1</td>
                            <td class="whiteSpace_normal" id="item_invoice_${data.id}_unit_price">৳${data.sales_price}</td>
                            <td class="whiteSpace_normal" id="item_invoice_${data.id}_total">৳${data.sales_price}</td>

                        </tr>`)
                        alertify.success("Item added!");
                    }

                },
                error: err => {
                    alertify.error(err);
                }
            });
        } else {
            // increaseItemCount(id);
        }
    }

    function removeItem(id) {
        if ($('#selected_tbl tr').length  <= 1) {
            return alertify.error("<span class='text-white'>Cannot delete the last item from the order!</span>");
        }

        let item_id = `#item_${id}`;
        let item_invoice_id = `#item_invoice_${id}`;

        if ($(item_id).remove()) {
            alertify.error('Item removed!');
        }
        $(item_invoice_id).remove();
        calculateTotal();

        // let i = 1;
        // $('#selected_tbl_invoice').children().each(function(){
        // $('td:first').text(i);
        // i++;
        // })
    }

    function increaseItemCount(event,id, amount) {

        amount = parseInt($(`#item_${id}_unit`).val());

        event.preventDefault();
        event.stopImmediatePropagation();
        let item_id = `#item_${id}_count`;
        let item_invoice_id = `#item_invoice_${id}_count`;
        let present_count = Number($(item_id).val());
        let present_total = Number($(`#item_${id}_total`).html());
        let total = Number($(`#item_${id}_total`).html());
        $(item_id).val(present_count += 1);
        $(item_invoice_id).text(present_count);

        total += amount;

        $(`#item_${id}_total`).html("৳"+total);

        $(`#item_invoice_${id}_total`).html("৳"+total);
        $(`#item_${id}_total`).html(amount * $(item_id).val());

        //Update invoice
        calculateTotal();
    }

    function decreaseItemCount(event,id, amount) {
        event.preventDefault();
        event.stopImmediatePropagation();
        let item_id_count = `#item_${id}_count`;
        let item_invoice_id = `#item_invoice_${id}_count`;
        let present_count = Number($(item_id_count).val());
        let total = Number($(`#item_${id}_total`).html());

        if (present_count <= 0) {
            present_count = 0;
            $(item_id_count).val(present_count);
            $(item_invoice_id).val(present_count);
            $(`#item_${id}_total`).html("0");
            $(`#item_invoice_${id}_total`).html("0");
        } else {
            present_count -= 1;
            $(item_id_count).val(present_count);
            $(item_invoice_id).text(present_count);

            total -= amount;
            $(`#item_${id}_total`).html(total);
            $(`#item_invoice_${id}_total`).html("৳"+total);
        }
         //Update invoice
         calculateTotal();
    }

       // to calculate total (when table data changes)
    function calculateTotal() {
        let shipping = Number($('#shippingChargeInvoice').text().split('৳')[1]);

        subtotal = 0;
        document.querySelectorAll('#selected_tbl tr').forEach(e => {
            let id = `#${e.id}_total`;
            subtotal += Number($(id).text());
        });

        if (subtotal == 0) {
            $('#totalAmountWithShipping').text(`৳${0}`);
            $('#totalAmountInvoice').text(`৳${0}`);
            $('#totalAmountWithShippingInvoice').text(`৳${0}`);
        } else {
            if($('#deliveryType').val() == "pickup"){
                shipping = 0;
                $('#shippingChargeInvoice').text(`৳${0}`);
            } else{
                if(subtotal >= 3000){
                    shipping = 0;
                    $('#shippingChargeInvoice').text(`৳${0}`);
                } else{
                    shipping = Number($('#shippingCharge').val());
                    $('#shippingChargeInvoice').text(`৳${shipping}`);
                }
            }

            $('#isShipmentChargeApplied').val(shipping);

            grand_total = subtotal + shipping;

            $('#totalAmountWithShipping').text(`৳${grand_total}`);
            $('#totalAmountInvoice').text(`৳${subtotal}`);
            $('#totalAmountWithShippingInvoice').text(`৳${grand_total}`);
        }
    }

    function changeTotal(price, thisId, target) {
        let count = $(`#${thisId}`).val();
        if (count <= 0) {
            $(`#${thisId}`).val("0");
            $(`#${target}`).text("0");
        }
        let total = price * count;
        $(`#${target}`).text(total);


    }


    function changeUnit(price, thisId, target,id) {

        let count = $(`#${thisId}`).val();



        if (count <= 0) {
            $(`#${thisId}`).val("0");
            $(`#${target}`).text("0");
        }
        let total = price * count;
        $(`#${target}`).text(total);


        $(`#item_invoice_${id}_unit_price`).html("৳"+price);
        $(`#item_invoice_${id}_total`).html("৳"+total);


    }


    function itemAlreadySelected(id) {
        let item_id = `#item_${id}`;
        if ($(item_id).html()) {
            return true;
        }
        return false;
    }

    function invoiceFunc(id){
        console.log(id)
        $.get(`../invoicePrintViewUser/${id}`, function (data) {
                $('#showInvoice').html(data);
            });
    }

    function orderApproved(id) {
        event.preventDefault();
        $('#team_leader_modal').modal('show');
    }

    function pickupApproved(id) {
        event.preventDefault();
        $('#pickup_team_leader_modal').modal('show');
    }


    function removeItemFromOrder(orderId, itemId) {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Item will be remove from order!', function () {
            if (document.querySelectorAll('.items_details_list').length  <= 1) {
                return alertify.error("<span class='text-white'>Cannot delete the last item from the order!</span>");
            }

            $.ajax({
                type: 'post',
                url: '{{URl("removeItemFromOrderAjax")}}',
                data: {
                    order_id: orderId,
                    item_id: itemId
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.error('Something Went Wrong');

                    } else {
                        //alert(data);
                        alertify.success(data);
                        setTimeout(function () {
                            location.reload();
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

    function addRemarks(val) {
        console.log('hamidaaaaa');
        $('#addRemarks').text(val);
    }


    function cancelOrder(id) {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Order Will Be Canceled!', function () {

            $.ajax({
                type: 'post',
                url: '{{URl("cancelShipmentAjax")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.error('Something Went Wrong');

                    } else {
                        //alert(data);
                        alertify.success(data);
                        setTimeout(function () {
                            location.replace(document.referrer);
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


    function shipmentOrder($id) {
        $('#modal-shipment').modal('show');
    }


    function getOrderDetail() {
        let orderDetail = {};
        let items_details_list = [];

        document.querySelectorAll('#selected_tbl tr').forEach(e => {
            let item_details = {
                title: $(`#${e.id}_title`).text(),
                quantity: $(`#${e.id}_count`).val(),
                product_id: e.id.split('_')[1],
                unit_price: $(`#${e.id}_unit`).val(),
                price: $(`#${e.id}_total`).text(),
            };

            items_details_list.push(item_details);
        });
        orderDetail['items_details_list'] = items_details_list;

        return orderDetail;
    }



    function teamLeaderAssign(id) {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Team leader will be assigned.', function () {
            $('#preloader').modal('show');
            // document.querySelector('.save_change_btn').disabled = true;
            let orderDetail = JSON.stringify(getOrderDetail());
            let highlights = $("input[name='highlights']:checked").val();
            let isShipmentChargeApplied = $("#isShipmentChargeApplied").val();
            let remarks = $("#remarks").val();

            $.ajax({
                type: 'post',
                url: '{{URl("teamLeaderAssignAjax")}}',
                data: $('#team_leader_assign_form').serialize() + "&orderDetail="+encodeURIComponent(orderDetail) + "&highlights="+highlights+ "&isShipmentChargeApplied="+isShipmentChargeApplied+ "&remarks="+remarks,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#preloader').modal('hide');
                    if (typeof data.errors !== 'undefined') {
                        console.log(typeof data.errors);

                        $.each(data.errors, function(propName, propVal) {
                            alertify.error(propVal[0]);
                            });

                    } else {
                        $('#team_leader_modal').modal('hide');
                        $('#team_leader_assign_form').trigger('reset');
                        alertify.success(data.message);

                        setTimeout(function () {
                            location.replace(document.referrer);
                        }, 1000)
                    }
                },
                error: function (jqXHR, exception) {
                    $('#preloader').modal('hide');
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

    function pickupTeamLeaderAssign(id) {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Team leader will be assigned.', function () {
            $('#preloader').modal('show');
            // document.querySelector('.save_change_btn').disabled = true;
            let orderDetail = JSON.stringify(getOrderDetail());
            let highlights = $("input[name='highlights']:checked").val();
            let remarks = $('#remarks').val();
            // let isShipmentChargeApplied = $("#isShipmentChargeApplied").val();
            $.ajax({
                type: 'post',
                url: '{{URl("pickupTeamLeaderAssignAjax")}}',
                data: $('#pickup_team_leader_assign_form').serialize() + "&orderDetail="+encodeURIComponent(orderDetail) + "&highlights="+highlights+ "&remarks="+remarks,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#preloader').modal('hide');
                    if (typeof data.errors !== 'undefined') {
                        console.log(typeof data.errors);

                        $.each(data.errors, function(propName, propVal) {
                            alertify.error(propVal[0]);
                            });

                    } else {
                        $('#pickup_team_leader_modal').modal('hide');
                        $('#pickup_team_leader_assign_form').trigger('reset');
                        alertify.success(data);
                         setTimeout(function () {
                            location.replace(document.referrer);
                          }, 1000)
                    }
                },
                error: function (jqXHR, exception) {
                    $('#preloader').modal('hide');
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


    function deliveryManAssign(id) {

        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Delivery man will be assigned.', function () {
            $('#preloader').modal('show');
            document.querySelector('.save_change_btn').disabled = true;
            let orderDetail = JSON.stringify(getOrderDetail());
            let highlights = $("input[name='highlights']:checked").val();
            let isShipmentChargeApplied = $("#isShipmentChargeApplied").val();
            let remarks = $("#remarks").val();
            
            const data = $('#deliveryManAssign').serialize()+"&id="+id + "&orderDetail="+encodeURIComponent(orderDetail) + "&highlights="+highlights+ "&isShipmentChargeApplied="+isShipmentChargeApplied+ "&remarks="+remarks;
            console.log("old structure",data);

            $.ajax({
                type: 'post',
                url: '{{URl("orderApproveAjax")}}',
                data: $('#deliveryManAssign').serialize()+"&id="+id + "&orderDetail="+encodeURIComponent(orderDetail) + "&highlights="+highlights+ "&isShipmentChargeApplied="+isShipmentChargeApplied+ "&remarks="+remarks,
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                         $.each(data.errors, function(propName, propVal) {
                            alertify.error(propVal[0]);
                        });

                        $('#preloader').modal('hide');

                    } else {

                        $.ajax({
                            type: 'post',
                            url: '{{URl("deliveryManAssignAjax")}}',
                            data: $('#deliveryManAssign').serialize(),
                            dataType: 'json',
                            success: function (data) {
                                $('#preloader').modal('hide');

                                // document.querySelector('.save_change_btn').disabled = false;

                                    if (typeof data.errors !== 'undefined') {
                                        $.each(data.errors, function(propName, propVal) {
                                                    alertify.error(propVal[0]);
                                            });
                                    } else {
                                        $('#modal-shipment').modal('hide');
                                        $('#deliveryManAssign').trigger('reset');
                                        alertify.success(data);
                                        setTimeout(function () {
                                            location.replace(document.referrer);
                                        }, 1000)
                                    }
                            },

                            error: function (jqXHR, exception) {
                                $('#preloader').modal('hide');

                                // document.querySelector('.save_change_btn').disabled = false;

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
 <script>

    function printDiv(divName){
            var getDivName = document.getElementById('mainDiv');
            getDivName.style.marginTop = "200px";
            $('#spaceDiv').css("margin-top", "400px");
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
             setTimeout(function() {
                 location.reload();
          }, 1000);

		}

 </script>

@endsection

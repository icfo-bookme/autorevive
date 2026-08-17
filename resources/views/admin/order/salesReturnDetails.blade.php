@extends('layouts.backend.master')
@section('content')
@php
$userid=Auth::user()->id;
@endphp
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }

        .whiteSpace_normal {
            white-space: normal !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .must {
            color: red;
            font-size: 15px;
            font-weight: bold
        }

        .table td,
        .table th {
            font-size: 12px !important;
        }

        .screenFull {
            display: block;
            z-index: 9999;
            position: fixed;
            width: 100% !important;
            height: 100% !important;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            overflow: auto;
        }

        .btn__size {
            width: 30px !important;
            height: 30px !important;
            border-radius: 50%;
        }

        .custom__btn {
            background: #efefef;
            border: none;
        }

        .btn__size i {
            color: #585858;
        }

        @media only screen and (min-width: 1025px) and (max-width: 1150px) {
            .authorSign{
                margin-left: 5px
            }
        }
        @media only screen and (min-width: 576px) and (max-width: 890px) {
            .authorSign{
                margin-left: 5px
            }
        }

    </style>

    <?php
        $paymentdue = $order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount - $order->advance_payment - ($sale->collected_payment + $sale->sales_due_payment->sum('paid_amount'));
    ?>


<input type="hidden" name="" id="hiddenOrderId" value="{{$order->id}}">

    <div class="conatiner">
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Sales Return View</h5>
                    </div>
                    <div class="card-body">
                        <form id="item_detail_form" action="">
                            <div class="form-group row">
                                <div class="col-sm-4 mb-3">
                                    <label for="input-10" class="col-form-label">First Name<span
                                            class="must">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        required="required" value="{{$order['first_name']}}" onkeyup="firstName(this.value)" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{$order['last_name']}}" onkeyup="lastName(this.value)" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Phone Number<span
                                            class="must">*</span></label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        required="required" value="{{$order['phone_number']}}" onkeyup="phone(this.value)" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Email</label readOnly>
                                    <input type="text" class="form-control" id="email" value="{{$order['email']}}" name="email" required="required"
                                        onkeyup="emailHandler(this.value)" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Country</label>
                                    <input type="text" class="form-control" value="{{$order['country']}}" id="country" name="country" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">District</label>
                                    <input type="text" class="form-control" value="{{$order['district']}}" id="district" name="district" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">City</label>
                                    <input type="text" class="form-control" value="{{$order['city']}}" id="city" name="city" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Thana</label>
                                    <input type="text" class="form-control" value="{{$order['thana']}}" id="thana" name="thana" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Area</label>
                                    <input type="text" class="form-control" value="{{$order['area']}}" id="area" name="area" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Road No</label>
                                    <input type="text" class="form-control" value="{{$order['road_no']}}" id="road_no" name="road_no" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">House No</label>
                                    <input type="text" class="form-control" id="house_no" value="{{$order['house_no']}}" name="house_no" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Flat No</label>
                                    <input type="text" class="form-control" id="flat_no" value="{{$order['flat_no']}}" name="flat_no" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Car Number</label>
                                    <input type="text" class="form-control" id="car_no" value="{{$order['car_no']}}" name="car_no" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Order Notes</label>
                                    <textarea class="form-control" rows="2" id="order_notes" value="" name="order_notes"
                                        spellcheck="true" readOnly>{{$order['order_notes']}}</textarea>
                                </div>
                                {{-- <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Customer Notes</label>
                                    <textarea class="form-control" rows="2" id="customer_notes" value="" name="customer_notes"
                                        spellcheck="true" onkeyup="customerNotes(this.value)" readOnly>{{$order['customer_notes']}}</textarea>
                                </div> --}}
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Remarks</label>
                                    <textarea class="form-control" rows="2" id="remarks" value="" name="remarks"
                                        spellcheck="true" onkeyup="addRemarks(this.value)" >{{$order->remarks}}</textarea>
                                </div>

                                <div class="clearfix"></div>

                                {{-- @if ($order->delivery_type == "shop") --}}
                                    <div class="col-lg-12 pt-4">
                                        <label class="col-form-label">How Did You Hear About AUTOMART?</label>
                                        <br />

                                        @foreach ($referrals as $referral)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="referral_method[]" value="{{ $referral->id }}" disabled
                                                    @foreach (@$customerreferrals as $ref)
                                                        @if ($ref->referral_id == $referral->id) checked @endif
                                                    @endforeach
                                                >
                                                <label class="form-check-label">{{ $referral->referral_method }}</label>
                                            </div>
                                        @endforeach

                                    </div>

                                <div class="col-lg-12 pt-4">
                                    <label for="">Item Search By Barcode</label>
                                    <input type="text" class="form-control" name="barcode" id="barcode">
                                </div>

                                <div class="col-lg-12 pt-4">
                                    <label for="">Item List<span class="must">*</span></label>
                                    <select class="valid js-select2" id="itemId" name="items"
                                            onchange="selectProduct(this.value)" required="" aria-invalid="false">
                                        <option value="">Select Item</option>
                                        @foreach ($allProducts as $product)
                                            <option value="{{$product->id }},{{$product->barcode}}">{{ $product->item->name }} {!! "&nbsp;" !!} ({{ $product->barcode}})  {!! "&nbsp;" !!} {!! "&nbsp;" !!} {{$product->stock->quantity ?? "0"}} {{$product->stock->uom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 px-5 pb-5">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Image</th>
                                            <th>Stock</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selected_tbl">
                                    @foreach ($orderDetails as $details)
                                        <tr id="item_{{ $details->barcode_id }}"
                                            data-price="{{ $details->unit_price }}">

                                            <td class="whiteSpace_normal"
                                                id="item_{{ $details->barcode_id }}_title">
                                                {{ $details->item->name }}</td>
                                            <td class="whiteSpace_normal"><img
                                                    src="../{{ $details->item->thumbnail }}" width="50"
                                                    height="50"></td>
                                            <td class="whiteSpace_normal" style="text-align:center!important;">
                                                {{ $details->stocks->quantity }}</td>
                                            <input type="hidden" id="item_{{ $details->barcode_id }}_hiddenStockForLog" value="{{$details->stocks->quantity}}">
                                            <input type="hidden" id="item_{{ $details->barcode_id }}_hiddenRegularPrice" value="{{$details->purchase_item_barcodes->regular_price}}">
                                            <td class="whiteSpace_normal" style="min-width: 200px;">
                                                <button class="btn btn-danger btn-sm text-white"
                                                    onclick="decreaseItemCount({{ $details->barcode_id }})"
                                                    style="cursor: pointer;">-</button>
                                                <input id="item_{{ $details->barcode_id }}_count"
                                                    onkeyup="changeTotal($details->unit_price, 'item_{{ $details->barcode_id }}_count', 'item_{{ $details->barcode_id }}_total')"
                                                    type="text" class="form-control w-50 d-inline-block"
                                                    value="{{ $details->quantity }}" readonly>
                                                <button class="btn btn-success btn-sm text-white"
                                                    onclick="increaseItemCount({{ $details->barcode_id }}, {{ $details->stocks->quantity }})"
                                                    style="cursor: pointer">+</button>
                                            </td>
                                            <td class="whiteSpace_normal"
                                                data-item-id="{{ $details->barcode_id }}"
                                                data-item-regular-price="${data.regular_price}">
{{--                                                Regular Price (BDT.--}}
{{--                                                {{ $details->purchase_item_barcodes->regular_price }})--}}
                                                <input type="number" name="product_unit_price"
                                                    id="item_{{ $details->barcode_id }}_regular_price"
                                                    class="form-control product_unit_price"
                                                    min="{{ $details->unit_price }}"
                                                    value="{{ $details->unit_price }}"
                                                    onkeyup="setMinimumUnitPrice({{ $details->barcode_id }})"/>
                                            </td>
                                            <td class="whiteSpace_normal" style="text-align:center!important;"
                                                id="item_{{ $details->barcode_id }}_total">
                                                {{ $details->price }}</td>
                                            <td class="whiteSpace_normal">
                                                <span onclick="removeItem({{ $details->barcode_id }},'{{$details->purchase_item_barcodes->barcode}}')"
                                                    class="badge badge-danger py-3 px-2"

                                                    style="cursor: pointer;min-width:45px">X</span>
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
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="hiddenTotalPrice" value="{{$order->total_price[0]->total}}">
                        <input type="hidden" id="hiddenPaidAmount" value="{{$sale->sales_due_payment->sum('paid_amount')}}">
                        <ul class="list-group top-left-calculation-part" style="box-shadow: none">
                            <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b> <span
                                    class="float-right" id="totalAmount" onclick="changeTotal({{ $details->product_id }})">৳{{$order->total_price[0]['total']}} </span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span
                                    class="float-right" id="shippingCharge">৳{{$order->is_shipment_charge_applied}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Discount (In amount) :</b> <span
                                    class="float-right" id="discountAmount">৳{{$order->discount_amount}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Advance Payment :</b> <span
                                    class="float-right" id="advancePayment">৳{{$order->advance_payment}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span class="float-right"
                                    id="totalAmountWithShipping">৳{{$order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount - $order->advance_payment}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Paid Amount :</b> <span class="float-right"
                                            id="collectedPaymentOrderDetails">৳{{$sale->collected_payment + $sale->sales_due_payment->sum('paid_amount')}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Payment Due :</b> <span class="float-right"
                                                    id="paymentDueOrderDetails">৳{{$order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount - $order->advance_payment - ($sale->collected_payment + $sale->sales_due_payment->sum('paid_amount'))}}</span></li>

                        </ul>
                        <div class="form-group">
                            <label for="checkDiscount">Advanced Payment</label>
                            <input type="number" class="form-control" name="advancedPayment" id="advancedPayment"
                                value="{{$order->advance_payment}}" readonly
                                required placeholder="Advanced Payment">
                        </div>
                        <div class="form-group">
                            <label for="shippingCharge">Shipping Charge</label>
                            <input type="number" class="form-control" name="checkShipping" id="checkShipping" min="0"
                                value="{{$order->is_shipment_charge_applied}}"
                                placeholder="shipping charge">
                        </div>
                        <div class="form-group">
                            <label for="checkDiscount">Discount</label>
                            <input type="number" class="form-control" name="checkDiscount" id="checkDiscount" min="0"
                                value="{{$order->discount_amount}}"
                                placeholder="Discount amount">
                        </div>
                        <div class="form-group">
                            <label for="collectedPayment">Collected Payment</label>
                            <input type="number" class="form-control" name="collectedPayment" id="collectedPayment" min="0"
                                value="{{$sale->collected_payment + $sale->sales_due_payment->sum('paid_amount')}}"
                                {{-- readonly --}}
                                required placeholder="Collected Payment">
                        </div>

                        <div class="mx-auto my-3">
                            <div class="row">

                                <input type="hidden" id="hiddenPaymentMethodId" value="{{$paymentDetails->payment_method_id}}">
                                @foreach ($paymentMethods as $paymentMethod)
                                    <div class="col-lg-6">
                                        <div class="icheck-material-primary mr-2">
                                            <input type="radio" class="radio" id="{{ $paymentMethod->id }}"
                                                name="payment_method_id" value="{{ $paymentMethod->id }}" @if (@$paymentDetails->payment_method_id == $paymentMethod->id) checked @endif>
                                            <label for="{{ $paymentMethod->id }}">{{ $paymentMethod->payment_method }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <input type="text" class="form-control" name="remarks" id="remarks" required placeholder="Add Remarks" onkeyup="remarks(this.value)" value = "{{$order->remarks}}">
                        </div> --}}

                        <div class="text-center">
                            {{-- @if ($userid==env('SUPERADMIN_ID') || $userid==env('HOP_ID') || $userid==env('ACCOUNTS_ID') || $userid==env('MANAGER_ID')) --}}
                            {{-- Removed the if/else condition, added restriction by creating a separate module 'POS Sale Update' with the ajax route which has been 
                            given to manager,hop and accounts. --}}
                                <button id="checkOut" class="btn btn-secondary btn-round waves-effect waves-light m-1 shadow"> Sale Update </button>
                                <button class="btn btn-outline-danger btn-round waves-effect waves-light m-1 shadow" onclick="cancelSale({{ $order->id }},{{$sale->id}})"> Cancel </button>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>

                <?php if($paymentdue <= 0){ ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                            <div class="invoice p-3" id="invoiceMaxiMin" style="background-color: #FFF;">

                                <div id="invoiceElement" >

                                    <div class="text-right" id="maxiMizeMin">
                                        <button id="maximize" class="custom__btn btn__size" onclick="maximize()"><i
                                                class="fa fa-window-restore" aria-hidden="true"></i></button>
                                        <button id="minimize" class="custom__btn btn__size" onclick="minimize()"><i
                                                class="fa fa-minus" aria-hidden="true"></i></button>

                                    </div>

                                    <main id="invoiceDiv">
                                        <style>
                                            body{
                                                background:#fff;
                                                }
                                        </style>
                                        <div class="d-flex justify-content-between">

                                            <div class="invoice-img">
                                                {{-- <h3 style="color: #3989c6;font-size: 14px; line-height: 18px" id="dateFormat"></h3> --}}
                                                <h3 style="color: #3989c6;font-size: 14px; line-height: 18px">DATE: {{$sale->invoice_date}}</h3>
                                                <h3 style="color: #3989c6;font-size: 14px; line-height: 18px">INVOICE TO:</h3>
                                                <p style="font-size: 11px;color: black;">Name- <span id="firstName">{{$order->first_name}} </span><span
                                                        id="lastName">{{$order->last_name}}</span></p>
                                                <p style="font-size: 11px;color: black;">Contact Number - <span id="phone">{{$order->phone_number}}</span></p>
                                                <p style="font-size: 11px;color: black;">Email - <span id="emailAddress">{{$order->email}}</span></p>

                                            </div>
                                            <div class="address-shop">

                                                <h3 style="color: #3989c6;font-size: 14px;line-height: 18px">INVOICE
                                                    @if($order->delivery_type == "delivery" || $order->delivery_type == "pickup")
                                                        #0101{{$order->id}}</#01>
                                                    @else
                                                        #0202{{$order->id}}</#02>
                                                    @endif
                                                </h3>
                                            </div>

                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="background: black !important;color: #fff;">Product</th>
                                                    <th style="background: black !important;color: #fff;">Quantity</th>
                                                        <th style="background: black !important;color: #fff;">Unit Price</th>
                                                        <th style="background: black !important;color: #fff;">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tbody id="selected_tbl_invoice">
                                                @foreach ($orderDetails as $detail)
                                                    <tr id="item_invoice_{{$detail->barcode_id}}" data-price="{{$detail->unit_price}}">
                                                        <td class="whiteSpace_normal"
                                                            id="item_invoice_{{$detail->barcode_id}}_title">{{$detail->product_name}}</td>
                                                        <td class="whiteSpace_normal" id="item_invoice_{{$detail->barcode_id}}_count">{{$detail->quantity}}</td>
                                                        <td class="whiteSpace_normal"
                                                            id="item_invoice_{{$detail->barcode_id}}_unit_price">
                                                            ৳{{$detail->unit_price}}</td>
                                                        <td class="whiteSpace_normal"
                                                            id="item_invoice_{{$detail->barcode_id}}_total">
                                                            ৳{{$detail->price}}</td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                </tbody>

                                                <tfoot class="invoice_footer">
                                                    <tr>

                                                        <td colspan="3" class="text-right">Sub Total</td>
                                                        <td><span class="float-right"
                                                                id="totalAmountInvoice">৳{{$order->total_price[0]['total']}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td colspan="3" class="text-right">Shipping</td>
                                                        <td><span class="float-right"
                                                                id="shippingChargeInvoice">৳{{$order->is_shipment_charge_applied}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">Discount</td>
                                                        <td><span class="float-right"
                                                                id="discountAmountInvoice">৳{{$order->discount_amount}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">Advance Payment</td>
                                                        <td><span class="float-right"
                                                                id="advancedPaymentInvoice">৳{{$order->advance_payment}}</span>
                                                        </td>
                                                        </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">Grand Total</td>
                                                        <td><span class="float-right"
                                                                id="totalAmountWithShippingInvoice">৳{{$order->total_price[0]['total'] + $order->is_shipment_charge_applied - $order->discount_amount - $order->advance_payment}}</span>
                                                                </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">Paid Amount</td>
                                                        <td><span class="float-right"
                                                                id="collectedPaymentInvoice">৳{{$sale->collected_payment + $sale->sales_due_payment->sum('paid_amount')}}</span>
                                                                </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">Payment Due</td>
                                                        <td><span class="float-right" id="paymentDueInvoice">৳{{$order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount - $order->advance_payment - ($sale->collected_payment + $sale->sales_due_payment->sum('paid_amount'))}}</span></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div>
                                            <p style="border-bottom: 1px solid #000;font-size: 16px;color: black; width: 75px;">Remarks</p>
                                            <p style="font-size: 16px;color: black;">
                                                <span id="addRemarks" style="font-size: 14px !important;">{{$order->remarks}}</span>
                                            </p>
                                        </div>
                                        <div id="spaceDiv">
                                            {{-- <div>
                                                <p style="border-bottom: 1px solid #000;font-size: 16px; width: 70px; color: #000;">Remarks</p>
                                                <p style="font-size: 16px;color: #000;">
                                                    <span id="addRemarks" style="font-size: 14px !important;">{{$order->remarks}}</span> </p>

                                            </div> --}}
                                            <div style="display: flex;justify-content: space-between; margin-top: 50px;">
                                                <div>
                                                    <p style="border-bottom: 1px solid #000;font-size: 16px; width: 100px;  color: #000;">Received By</p>
                                                </div>
                                                <div class="authorSign">
                                                    <p style="border-bottom: 1px solid #000;font-size: 16px; width: 130px;color: #000;">Yours Sincerely</p>
                                                    <p style="font-size: 16px; width: 130px;color: #000; text-align: center; line-height: 16px;">Automart</p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <p style="font-size: 16px;text-align: justify;color: black;margin-top: 40px;">Customer
                                                    Notes - <span id="customerNotes" style="font-size: 14px !important;">{{$order->customer_notes}}</span></p> --}}
                                        {{-- <p style="font-size: 16px;color: black;margin-top: 60px;">Remarks -
                                            <span id="addRemarks" style="font-size: 14px !important;">{{$order->remarks}}</span>
                                        </p> --}}
                                        <div class="row no-print">
                                            <div class="col-lg-12">
                                                <div class="float-sm-right">
                                                    <a href="javascript:void(0)" id="previewBtn" class="btn btn-primary m-1"
                                                        onclick="printDiv('invoiceElement')"><i class="fa fa-print"></i>
                                                        Print</a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </main>
                            </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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


    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle"
        aria-hidden="true">
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
     let showPaymentDue = 0;
        $(document).ready(function(){
             $("input[type=number]").on('wheel.disableScroll', function (e) {
                    e.preventDefault()
            });
        })

        let selectedBarcodes = [];

        //Store previously booked barcodes
        let orderedProductBarcodes = JSON.parse('{!! json_encode($orderedProductBarcodes) !!}');
        orderedProductBarcodes.forEach(barcode => {
            selectedBarcodes.push(barcode);
        });

        function printDiv(divName) {
            let check_shipping = $('#checkShipping').val();
            let check_dicount = $('#checkDiscount').val();
            let collected_payment = $('#collectedPayment').val();
            let advance_payment = $('#advancedPayment').val();
            console.log("check_shipping", check_shipping);
            console.log("check_dicount", check_dicount);
            console.log("collected_payment", collected_payment);
            console.log("advance_payment", advance_payment);
            // console.log("collected_payment", collected_payment);
            // return advance_payment;
            if(check_shipping == 0){
                $('#shippingChargeInvoice').parent().parent()[0].remove();
            }
            if(check_dicount == 0){
                $('#discountAmountInvoice').parent().parent()[0].remove();
            }
            if(advance_payment == 0){
                $('#advancedPaymentInvoice').parent().parent()[0].remove();
            }
            if(collected_payment == 0){
                $('#collectedPaymentInvoice').parent().parent()[0].remove();
            }
            $('#maxiMizeMin').hide();
            $('#previewBtn').hide();
            $('.donwloadBtn').hide();
            $('#invoiceDiv').css("margin-top", "200px");
            $('#spaceDiv').css("margin-top", "400px");

            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            setTimeout(function() {
                let dueValue = Number($('#paymentDueOrderDetails').text().split('৳')[1]);
                if(dueValue > 0){
                    location.href = "{{ url('salesDueView') }}";
                }else{
                    location.href = "{{ url('salesCompletedView') }}";
                }
            }, 1000);
        }

        function firstName(val) {
            $('#firstName').text(val);
        }

        function lastName(val) {
            $('#lastName').text(" " + val);
        }

        function phone(val) {
            $('#phone').text(val);
        }

        function emailHandler(val) {
            $('#emailAddress').text(val);
        }

        function customerNotes(val) {
            $('#customerNotes').text(val);
        }

        function addRemarks(val) {
            $('#addRemarks').text(val);
        }

        let d = new Date();
        let month = d.getMonth() + 1;
        let day = d.getDate();
        let year = d.getFullYear();
        $('#dateFormat').append(`<p>Date: ${day}/${month}/${year} </p>`)

        // maximize and minimize
        $('#minimize').hide();

        function maximize() {
            $('#invoiceMaxiMin').addClass('screenFull');
            $('#maximize').hide();
            $('#minimize').show();
        }

        function minimize() {
            $('#invoiceMaxiMin').removeClass('screenFull');
            $('#maximize').show();
            $('#minimize').hide();
        }

        let base_url = '{{ URL('/') }}';

        $(document).ready(function() {
            $('#selected_tbl_invoice').on("DOMSubtreeModified", function() {
                $('#shippingChargeInvoice').text("৳" + $('#checkShipping').val());
                $('#discountAmountInvoice').text("৳" + $('#checkDiscount').val());
                calculateTotal();
            });

            $('#selected_tbl').on("DOMSubtreeModified", function() {
                $('#shippingChargeInvoice').text("৳" + $('#checkShipping').val());
                $('#discountAmountInvoice').text("৳" + $('#checkDiscount').val());
                calculateTotal();
            });
            

            // sale
            $('#checkOut').on('click', () => {
                checkOut();
            });

            // oncheck add/remove shipping charge
            $('#checkShipping').change(function() {
                let checkShipping = Number($('#checkShipping').val());
                if (this.checked) {
                    $('#shippingCharge').text("৳" + checkShipping);
                } else {
                    $('#shippingCharge').text("৳" + checkShipping);
                }
                calculateTotal();
                $('#checkShipping').val(checkShipping);
            });

            $('#checkDiscount').change(function() {
                let checkDiscount = Number($('#checkDiscount').val());
                $('#discountAmount').text("৳" + checkDiscount);
                $('#discountAmountInvoice').text("৳" + $('#checkDiscount').val());

                calculateTotal();
                $('#checkDiscount').val(checkDiscount);
            });

            $('#checkShipping').change(function() {
                let checkShipping = Number($('#checkShipping').val());
                $('#shippingChargeInvoice').text("৳" + checkShipping);

                calculateTotal();
                $('#checkShipping').val(checkShipping);
            });

            $('#collectedPayment').change(function() {
                let collectedPayment = Number($('#collectedPayment').val());
                $('#collectedPaymentInvoice').text("৳" +collectedPayment);
                $('#collectedPaymentOrderDetails').text("৳" + collectedPayment);

                let totalAmount = Number($('#totalAmountWithShipping').text().split('৳')[1]);
                let paymentDue = totalAmount - collectedPayment;
                $('#paymentDueOrderDetails').text('৳'+paymentDue);
                $('#paymentDueInvoice').text('৳'+paymentDue);

                calculateTotal();
                $('#collectedPayment').val(collectedPayment);
            });

            $('#advancedPayment').change(function() {
                let advancedPayment = Number($('#advancedPayment').val());
                $('#advancedPaymentInvoice').text("৳" +advancedPayment);
                $('#advancedPayment').text("৳" + advancedPayment);

                let totalAmount = Number($('#totalAmountWithShipping').text().split('৳')[1]);
                let paymentDue = totalAmount - advancedPayment;
                $('#paymentDueOrderDetails').text('৳'+paymentDue);
                $('#paymentDueInvoice').text('৳'+paymentDue);

                calculateTotal();
                $('#advancedPayment').val(advancedPayment);
            });

            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: false
            });

        });

        /*
            ========================
            =====|My Functions|=====
            ========================
        */

        $(document).on('change', '.product_unit_price', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let unit_price_value = Number($(this).val());
            let item_id = $(this).parent().attr('data-item-id');
            let item_regular_price = Number($(this).parent().attr('data-item-regular-price'));

            if(unit_price_value < 0){
                alertify.error("Price cannot be negative!!");
                $(this).val(item_regular_price);
            } else{
                let present_count = Number($("#item_" + item_id + "_count").val());
                let total_price = (unit_price_value * present_count).toFixed(2);
                $("#item_" + item_id + "_total").html(total_price);
                $("#item_invoice_" + item_id + "_total").html("৳" + total_price);
                $("#item_invoice_" + item_id + "_unit_price").html("৳" + unit_price_value);
                $("#item_" + item_id).attr("data-price", unit_price_value);

                //Update invoice
                calculateTotal();
            }
        })

        /**
         * Item search by barcode (route placed in PurchaseController)
         * @param barcode
         */
        var barcode_length = 10;
        $('[name="barcode"]').keyup(function (e) {
            let input_length = $(this).val().length;
            if (input_length >= barcode_length && ( e.keyCode == 13 || e.keyCode == 86)) {
                barcode = e.target.value;
                if(!selectedBarcodes.includes(barcode)){
                    $.ajax({
                        url: '{{ URL('itemSearchByBarcode') }}',
                        type: 'POST',
                        data: {
                            barcode:barcode
                        },
                        success: response => {
                            if(response.status === true){
                                if(response.data.stockData.quantity == 0){
                                    alertify.error("Item Stock Out!");
                                } else {
                                    selectedBarcodes.push(barcode);
                                    $('#barcode').val('');
                                    itemData = response.data.itemData;
                                    barcodeData = response.data.barcodeData;
                                    stockData = response.data.stockData;

                                    $('#selected_tbl').append(`<tr id="item_${barcodeData.id}" data-price="${barcodeData.sales_price}">

                                        <td class="whiteSpace_normal" id="item_${barcodeData.id}_title">${itemData.name}</td>
                                        <td class="whiteSpace_normal"><img src="../${itemData.thumbnail}" width="50" height="50"></td>
                                        <td class="whiteSpace_normal" style="text-align:center!important;">${stockData.quantity}</td>
                                        <td class="whiteSpace_normal" style="min-width: 200px;">
                                            <button class="btn btn-danger btn-sm text-white"
                                                onclick="decreaseItemCount(${barcodeData.id})"
                                                style="cursor: pointer;">-</button>
                                            <input id="item_${barcodeData.id}_count"
                                                onkeyup="changeTotal(${barcodeData.sales_price}, 'item_${barcodeData.id}_count', 'item_${barcodeData.id}_total')"
                                                type="text" class="form-control w-50 d-inline-block" value="1" readonly>
                                            <button class="btn btn-success btn-sm text-white"
                                                onclick="increaseItemCount(${barcodeData.id}, ${stockData.quantity})"
                                                style="cursor: pointer">+</button>
                                        </td>
                                        <td class="whiteSpace_normal" data-item-id="${barcodeData.id}" data-item-regular-price="${barcodeData.regular_price}">
                                            <!-- Regular Price (BDT. ${barcodeData.regular_price})-->
                                            <input type="number" name="product_unit_price" id="item_${barcodeData.id}_regular_price" class="form-control product_unit_price" min="${barcodeData.sales_price}" value="${barcodeData.sales_price}" onkeyup="setMinimumUnitPrice(${barcodeData.id})"/>
                                            </td>
                                        <td class="whiteSpace_normal" style="text-align:center!important;" id="item_${barcodeData.id}_total">${barcodeData.sales_price}</td>
                                        <td class="whiteSpace_normal">
                                            <span onclick="removeItem(${barcodeData.id},'${barcodeData.barcode}')" class="badge badge-danger py-3 px-2"
                                                style="cursor: pointer;min-width:45px">X</span>
                                        </td>
                                    </tr>`);


                                    $('#selected_tbl_invoice').append(`<tr id="item_invoice_${barcodeData.id}" data-price="${barcodeData.sales_price}">
                                        <td class="whiteSpace_normal" id="item_invoice_${barcodeData.id}_title">${itemData.name}</td>
                                        <td class="whiteSpace_normal" id="item_invoice_${barcodeData.id}_count">${1}</td>
                                        <td class="whiteSpace_normal" id="item_invoice_${barcodeData.id}_unit_price">৳${barcodeData.sales_price}</td>
                                        <td class="whiteSpace_normal" id="item_invoice_${barcodeData.id}_total">৳${barcodeData.sales_price}</td>

                                    </tr>`);

                                    // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
                                    calculateTotal();

                                    alertify.success("Item added!");
                                }
                            } else{
                                $('#barcode').val('');
                                alertify.error(response.message);
                            }

                        },
                        error: function (jqXHR, exception) {
                            $('#barcode').val('');
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
                } else{
                    alertify.error("Product already in the list!");
                    $('#barcode').val('');
                }
            }
        });

        function selectProduct(purchaseData) {
            const splitedPurchaseData = purchaseData.split(',');
            purchaseItemBarcodeId = splitedPurchaseData[0];
            barcode = splitedPurchaseData[1];

            if(!selectedBarcodes.includes(barcode)){
                $.ajax({
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        purchaseItemBarcodeId: purchaseItemBarcodeId
                    },
                    url: '{{ URL('/getProductByPurchaseItemBarcodeId') }}',
                    success: response => {
                        if(response.status){
                            if(response.data.stockData.quantity == 0){
                                alertify.error("Item Stock Out!");
                            } else {

                                selectedBarcodes.push(barcode);
                                let purchaseItemBarcodeData = response.data.purchaseItemBarcodeData;
                                let itemData = response.data.itemData;
                                let stockData = response.data.stockData;

                                $('#selected_tbl').append(`<tr id="item_${purchaseItemBarcodeId}" data-price="${purchaseItemBarcodeData.sales_price}">

                                    <td class="whiteSpace_normal" id="item_${purchaseItemBarcodeId}_title">${itemData.name}</td>
                                    <td class="whiteSpace_normal"><img src="../${itemData.thumbnail}" width="50" height="50"></td>
                                    <td class="whiteSpace_normal" style="text-align:center!important;">${stockData.quantity}</td>
                                    <td class="whiteSpace_normal" style="min-width: 200px;">
                                        <button class="btn btn-danger btn-sm text-white"
                                            onclick="decreaseItemCount(${purchaseItemBarcodeId})"
                                            style="cursor: pointer;">-</button>
                                        <input id="item_${purchaseItemBarcodeId}_count"
                                            onkeyup="changeTotal(${purchaseItemBarcodeData.sales_price}, 'item_${purchaseItemBarcodeId}_count', 'item_${purchaseItemBarcodeId}_total')"
                                            type="text" class="form-control w-50 d-inline-block" value="${stockData.quantity < 1 ? stockData.quantity.toFixed(2) : 1}" readonly>
                                        <button class="btn btn-success btn-sm text-white"
                                            onclick="increaseItemCount(${purchaseItemBarcodeId}, ${stockData.quantity})"
                                            style="cursor: pointer">+</button>
                                    </td>
                                    <td class="whiteSpace_normal" data-item-id="${purchaseItemBarcodeId}" data-item-regular-price="${purchaseItemBarcodeData.regular_price}">
                                        <!-- Regular Price (BDT. ${purchaseItemBarcodeData.regular_price})-->
                                        <input type="number" name="product_unit_price" id="item_${purchaseItemBarcodeId}_regular_price" class="form-control product_unit_price" min="${purchaseItemBarcodeData.sales_price}" value="${purchaseItemBarcodeData.sales_price}" onkeyup="setMinimumUnitPrice(${purchaseItemBarcodeId})"/>
                                        </td>
                                    <td class="whiteSpace_normal" style="text-align:center!important;" id="item_${purchaseItemBarcodeId}_total">
                                        ${stockData.quantity < 1 
                                            ? purchaseItemBarcodeData.sales_price * stockData.quantity 
                                            : purchaseItemBarcodeData.sales_price}
                                    </td>
                                    <td class="whiteSpace_normal">
                                        <span onclick="removeItem(${purchaseItemBarcodeId},'${purchaseItemBarcodeData.barcode}')" class="badge badge-danger py-3 px-2"
                                            style="cursor: pointer;min-width:45px">X</span>
                                    </td> 
                                </tr>`);


                                $('#selected_tbl_invoice').append(`<tr id="item_invoice_${purchaseItemBarcodeId}" data-price="${purchaseItemBarcodeData.sales_price}">
                                    <td class="whiteSpace_normal" id="item_invoice_${purchaseItemBarcodeId}_title">${itemData.name}</td>
                                    <td class="whiteSpace_normal" id="item_invoice_${purchaseItemBarcodeId}_count">
                                        ${stockData.quantity < 1 ? stockData.quantity : 1}
                                    </td>
                                    <td class="whiteSpace_normal" id="item_invoice_${purchaseItemBarcodeId}_unit_price">৳${purchaseItemBarcodeData.sales_price}</td>
                                    <td class="whiteSpace_normal" id="item_invoice_${purchaseItemBarcodeId}_total">
                                        ৳${stockData.quantity < 1 
                                            ? purchaseItemBarcodeData.sales_price * stockData.quantity 
                                            : purchaseItemBarcodeData.sales_price}
                                    </td>

                                </tr>`);

                                // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
                                calculateTotal();

                                alertify.success("Item added!");
                            }
                        }
                    },
                    error: err => {
                        alertify.error(err);
                    }
                });
            }else {
                alertify.error("Item is already in the list!");
            }
        }

        /**
        * This function is set minimun unit price(1)
        */
        function setMinimumUnitPrice(id) {
            let unitPrice = `#item_${id}_regular_price`;
            $(unitPrice).on("input", function() {
                if (/^0/.test(this.value)) {
                    this.value = this.value.replace(/^0/, "1")
                }
            })
        }

        function removeItem(itemId,itemBarcode) {
            let item_id = `#item_${itemId}`;
            let item_invoice_id = `#item_invoice_${itemId}`;

            if ($("#selected_tbl table tbody tr").length != 1 && $("#selected_tbl_invoice tr").length != 1 ) {

                if ($(item_id).remove() && $(item_invoice_id).remove()) {
                    alertify.error("<span class='text-white'>Item removed!</span>");
                }
                let index = selectedBarcodes.indexOf(itemBarcode);
                if (index > -1) {
                    selectedBarcodes.splice(index, 1);
                }
            }else{
                // alertify.error("<span class='text-white'>Can't remove last Item! You can CANCEL the sale.</span>");
                alertify.alert('Sorry!',"Can't remove last Item! You can always CANCEL the sale.");

            } 

            // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
            calculateTotal();  
        }

        function increaseItemCount(id, stock_quantity) {
            let amount = Number($("#item_" + id + "_regular_price").val());
            let item_id = `#item_${id}_count`;
            let item_invoice_id = `#item_invoice_${id}_count`;

            let present_count = Number($(item_id).val());
            // console.log('1',present_count);
            let present_total = Number($(`#item_${id}_total`).html());
            let total = Number($(`#item_${id}_total`).html());

            present_count += 0.25;
            // console.log('2',present_count);
            present_count = present_count.toFixed(2);
            // console.log('3',present_count);
            // console.log('4',stock_quantity);
            if(present_count > stock_quantity){
              console.log("can not be greater than stock");
            }else{
                $(item_id).val(present_count);
                $(item_invoice_id).html(present_count);

                total += amount;
                let increaseTotal=amount * $(item_id).val();
                $(`#item_${id}_total`).html(increaseTotal.toFixed(2));
                $(`#item_invoice_${id}_total`).html("৳" + increaseTotal.toFixed(2));
                // $(`#item_${id}_total`).html(amount * $(item_id).val());
            }

            // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
            calculateTotal();

        }

        function decreaseItemCount(id) {
            let amount = Number($("#item_" + id + "_regular_price").val());
            let item_id_count = `#item_${id}_count`;
            let item_invoice_id = `#item_invoice_${id}_count`;

            let present_count = Number($(item_id_count).val());
            let total = Number($(`#item_${id}_total`).html());

            if (present_count <= 0) {
                present_count = 0;
                $(item_id_count).val(present_count);
                $(item_invoice_id).html(present_count);

                $(`#item_${id}_total`).html("0");
                $(`#item_invoice_${id}_total`).html("৳0");

            } else {
                present_count -= 0.25;
                present_count = present_count.toFixed(2);
                $(item_id_count).val(present_count);
                $(item_invoice_id).html(present_count);

                total -= amount;
                let decreaseTotal= amount * $(item_id_count).val();
                $(`#item_${id}_total`).html(decreaseTotal.toFixed(2));
                $(`#item_invoice_${id}_total`).html("৳" + decreaseTotal.toFixed(2));
            }

            // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
            calculateTotal();
        }

        function changeTotal(price, thisId, target) {
            let count = $(`#${thisId}`).val();
            if (count <= 0) {
                $(`#${thisId}`).val("0");
                $(`#${target}`).text("0");
            }
            let total = price * count;
            $(`#${target}`).text(total.toFixed(2));

            // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
            calculateTotal();
        }

        function itemAlreadySelected(id) {
            let item_id = `#item_${id}`;
            if ($(item_id).html()) {
                return true;
            }
            return false;
        }

        // to calculate total (when table data changes)
        function calculateTotal() {
            let subtotal = Number($('#totalAmount').text().split('৳')[1]);
            // console.log(subtotal);
            let shipping = Number($('#shippingCharge').text().split('৳')[1]);
            let discount = Number($('#discountAmount').text().split('৳')[1]);
            let paid_amount = Number($('#collectedPayment').val());
            let advanced_amount = Number($('#advancedPayment').val());
            let advanced_invoice_amount = Number($('#advancedPaymentInvoice').val());
            let final_payment_due = Number($('#paymentDueOrderDetails').val());

            let grand_total = subtotal + shipping;

            subtotal = 0;
            document.querySelectorAll('#selected_tbl tr').forEach(e => {
                let id = `#${e.id}_total`;
                subtotal += Number($(id).text());
            });

            if (subtotal == 0) {
                $('#totalAmount').text(`৳${0}`);
                $('#totalAmountWithShipping').text(`৳${0}`);
                $('#totalAmountInvoice').text(`৳${0}`);
                $('#totalAmountWithShippingInvoice').text(`৳${0}`);
                $('#paymentDueOrderDetails').text(`৳${0}`);
                $('#paymentDueInvoice').text(`৳${0}`);
            } else {
                grand_total = (subtotal + shipping) - discount;
                let advance_payment = Number($('#advancedPayment').text().split('৳')[1]);
                let advancedpayment= grand_total - advance_payment;
                let payment_due = advancedpayment - paid_amount;

                grand_total_updated = grand_total - Number($('#advancedPayment').val());
                final_payment_due = grand_total_updated - paid_amount;

                $('#totalAmount').text(`৳${subtotal.toFixed(2)}`);
                $('#totalAmountWithShipping').text(`৳${grand_total_updated.toFixed(2)}`);
                $('#totalAmountInvoice').text(`৳${subtotal.toFixed(2)}`);
                $('#totalAmountWithShippingInvoice').text(`৳${grand_total_updated.toFixed(2)}`);

                $('#paymentDueOrderDetails').text(`৳${final_payment_due.toFixed(2)}`);
                $('#paymentDueInvoice').text(`৳${final_payment_due.toFixed(2)}`);

                $('#collectedPaymentInvoice').text('৳'+paid_amount.toFixed(2));
                $('#advancePayment').text('৳'+advanced_amount);
                $('#advancedPaymentInvoice').text('৳'+advanced_amount);
            }
        }



        function getOrderDetail() {
            // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
            calculateTotal();

            let orderDetail = {};
            let items_details_list = [];

            orderDetail['first_name'] = $('#first_name').val();
            orderDetail['last_name'] = $('#last_name').val();
            orderDetail['phone_number'] = $('#phone_number').val();
            orderDetail['company_name'] = $('#company_name').val();
            orderDetail['email'] = $('#email').val();
            orderDetail['city'] = $('#city').val();
            orderDetail['country'] = $('#country').val();
            orderDetail['district'] = $('#district').val();
            orderDetail['thana'] = $('#thana').val();
            orderDetail['area'] = $('#area').val();
            orderDetail['road_no'] = $('#road_no').val();
            orderDetail['house_no'] = $('#house_no').val();
            orderDetail['flat_no'] = $('#flat_no').val();
            orderDetail['car_no'] = $('#car_no').val();
            orderDetail['order_notes'] = $('#order_notes').val();
            // orderDetail['customer_notes'] = $('#customer_notes').val();
            orderDetail['shippingChargeApplied'] = $('#checkShipping').val();
            orderDetail['discountAmount'] = $('#checkDiscount').val();
            orderDetail['totalAmount'] = Number($('#totalAmount').text().split('৳')[1]);
            orderDetail['totalAmountWithShipping'] = Number($('#totalAmountWithShipping').text().split('৳')[1]);
            orderDetail['paymentDue'] = Number($('#paymentDueOrderDetails').text().split('৳')[1]);
            orderDetail['collectedPayment'] = Number($('#collectedPayment').val());
            orderDetail['advanced_payment'] = Number($('#advancedPayment').val());
            orderDetail['hidden_order_id'] = Number($('#hiddenOrderId').val());
            orderDetail['remarks'] = $('#remarks').val();
            orderDetail['hiddenTotalPrice'] = Number($('#hiddenTotalPrice').val());
            orderDetail['hiddenPaidAmount'] = Number($('#hiddenPaidAmount').val());
            orderDetail['hiddenPaymentMethodId'] = Number($('#hiddenPaymentMethodId').val());

            document.querySelectorAll('#selected_tbl tr').forEach(e => {
                let item_details = {
                    title: $(`#${e.id}_title`).text(),
                    quantity: $(`#${e.id}_count`).val(),
                    barcode_id: e.id.split('_')[1],
                    price: $(`#${e.id}`).data('price'),
                    stock_for_log: $(`#${e.id}_hiddenStockForLog`).val(),
                    regular_price_for_log: $(`#${e.id}_hiddenRegularPrice`).val(),
                };

                items_details_list.push(item_details);
                console.log(item_details, items_details_list);
            });

            orderDetail['items_details_list'] = items_details_list;

            return orderDetail;
        }

        function checkOut() {
            let dueValue = Number($('#paymentDueOrderDetails').text().split('৳')[1]);
            if(dueValue >= 0){

                alertify.confirm("Are You Sure To Update This?",
                function() {
                    $('#preloader').modal('show');
                    let payment_method = $("input[class='radio']:checked").val();
                    let highlights = $("input[name='highlights']:checked").val();
                    let referral_method = [];
                    $('input[name="referral_method[]"] ').each(function() {
                        if (this.checked) {
                            referral_method.push($(this).val());
                        }
                    });

                    $.ajax({
                        url: '{{ URL('salesUpdate') }}',
                        type: 'POST',
                        data: {
                            orderDetail: getOrderDetail(),
                            payment_method: payment_method,
                            referral_method: referral_method,
                            highlights: highlights
                        },
                        success: data => {
                            console.log(data);
                            $('#preloader').modal('hide');

                            if (data.message == "Success") {

                                if(dueValue <= 0){
                                    alertify.success(data.message);
                                    printDiv('invoiceElement');
                                    $('#firstName').text('');
                                    $('#emailAddress').text('');
                                    $('#phone').text('');
                                }else{
                                    setTimeout(function(){
                                        if(dueValue > 0){
                                            location.href = "{{ url('salesDueView') }}";
                                        }else{
                                            location.href = "{{ url('salesCompletedView') }}";
                                        }
                                    },300);
                                }

                            } else {
                                if (typeof data == 'object') {
                                    alertify.error(
                                        "<span class='text-white'>An error occured! Please check you input!</span>"
                                        );
                                    $.each(data, (k, v) => {
                                        if (k == 'errors') {
                                            $.each(v, (key, val) => {
                                                setTimeout(() => {
                                                    alertify.error(
                                                        `<span class='text-white'>${val[0]}</span>`
                                                        );
                                                }, 1000);
                                            });
                                        }
                                    });
                                }
                            }
                        },
                        error: function(jqXHR, exception) {
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
                },
                function() {
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');

            } else {
                msg = "Payment due cannot be Negative!";
                alertify.error(
                    `<span class='text-white'>${msg}</span>`
                );
            }

        }

        function cancelSale(id,saleId) {
            event.preventDefault();
            alertify.confirm('Are You Sure ?', 'Sale Will Be Canceled!', function () {
                $.ajax({
                    type: 'post',
                    url: '{{URl("cancelSale")}}',
                    data: {
                        id: id,
                        saleId: saleId
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            alertify.error('Something Went Wrong');
                        } else {
                            alertify.success(data);
                            setTimeout(function () {
                                location.href = "{{ url('cancelledSalesView') }}";
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


    </script>

@endsection

@extends('layouts.backend.master')
@section('content')
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

    <div class="conatiner">
        {{-- sale log block --}}
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                            Sales Log View
                        </h6>
                        <h6 class="form-header text-center">
                            Invoice: #0202{{$saleLog['order_id']}}
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="item_detail_form" action="">
                            <div class="form-group row">
                                <div class="col-sm-4 mb-3">
                                    <label for="input-10" class="col-form-label">First Name<span
                                            class="must">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{$saleLog['first_name']}}" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{$saleLog['last_name']}}" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Phone Number<span
                                            class="must">*</span></label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{$saleLog['phone_number']}}" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Email</label readOnly>
                                    <input type="text" class="form-control" id="email" value="{{$saleLog['email']}}" name="email" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Country</label>
                                    <input type="text" class="form-control" value="{{$saleLog['country']}}" id="country" name="country" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">District</label>
                                    <input type="text" class="form-control" value="{{$saleLog['district']}}" id="district" name="district" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">City</label>
                                    <input type="text" class="form-control" value="{{$saleLog['city']}}" id="city" name="city" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Thana</label>
                                    <input type="text" class="form-control" value="{{$saleLog['thana']}}" id="thana" name="thana" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Area</label>
                                    <input type="text" class="form-control" value="{{$saleLog['area']}}" id="area" name="area" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Road No</label>
                                    <input type="text" class="form-control" value="{{$saleLog['road_no']}}" id="road_no" name="road_no" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">House No</label>
                                    <input type="text" class="form-control" id="house_no" value="{{$saleLog['house_no']}}" name="house_no" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Flat No</label>
                                    <input type="text" class="form-control" id="flat_no" value="{{$saleLog['flat_no']}}" name="flat_no" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Car Number</label>
                                    <input type="text" class="form-control" id="car_no" value="{{$saleLog['car_no']}}" name="car_no" readOnly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Order Notes</label>
                                    <textarea class="form-control" rows="2" id="order_notes" name="order_notes" readOnly>{{$saleLog['order_notes']}}</textarea>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Remarks</label>
                                    <textarea class="form-control" rows="2" id="remarks" name="remarks" readOnly>{{$saleLog->remarks}}</textarea>
                                </div>

                                <div class="clearfix"></div>
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
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selected_tbl">
                                    @foreach ($saleDetailsLog as $details)
                                        <tr id="item_{{ $details->barcode_id }}" data-price="{{ $details->unit_price }}">

                                            <td class="whiteSpace_normal" id="item_{{ $details->barcode_id }}_title"> {{ $details->product_name }}<br>({{@$details->purchase_item_barcodes_log->barcode}})</td>
                                            <td class="whiteSpace_normal"><img src="../../{{ $details->item_log->thumbnail }}" width="50" height="50"></td>
                                            <td class="whiteSpace_normal" style="min-width: 200px;">
                                                <button class="btn btn-danger btn-sm text-white" style="cursor: pointer;" disabled>-</button>
                                                <input id="item_{{ $details->barcode_id }}_count" type="text" class="form-control w-50 d-inline-block"
                                                    value="{{ @$details->quantity }}" readonly>
                                                <button class="btn btn-success btn-sm text-white" style="cursor: pointer" disabled>+</button>
                                            </td>
                                            <td class="whiteSpace_normal"
                                                data-item-id="{{ $details->barcode_id }}"
                                                data-item-regular-price="${data.regular_price}">
                                                {{-- Regular Price (BDT.
                                                {{ $details->regular_price }}) --}}
                                                <input type="number" name="product_unit_price"
                                                    id="item_{{ $details->barcode_id }}_regular_price"
                                                    class="form-control product_unit_price"
                                                    value="{{ $details->unit_price }}" readonly/>
                                            </td>
                                            <td class="whiteSpace_normal" style="text-align:center!important;"
                                                id="item_{{ $details->barcode_id }}_total">
                                                {{ $details->price }}
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
                        <ul class="list-group top-left-calculation-part" style="box-shadow: none">
                            <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b> <span
                                    class="float-right" id="totalAmount">৳{{$saleLog->total_price}} </span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span
                                    class="float-right" id="shippingCharge">৳{{$saleLog->is_shipment_charge_applied}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Discount (In amount) :</b> <span
                                    class="float-right" id="discountAmount">৳{{$saleLog->discount_amount}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Advance Payment :</b> <span
                                    class="float-right" id="advancePayment">৳{{$saleLog->advance_payment}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span class="float-right"
                                    id="totalAmountWithShipping">৳{{$saleLog->total_price + $saleLog->is_shipment_charge_applied - $saleLog->discount_amount - $saleLog->advance_payment}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Paid Amount :</b> <span class="float-right"
                                            id="collectedPaymentOrderDetails">৳{{$saleLog->collected_payment + $saleLog->paid_amount}}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Payment Due :</b> <span class="float-right"
                                                    id="paymentDueOrderDetails">৳{{$saleLog->total_price + $saleLog->is_shipment_charge_applied - $saleLog->discount_amount - $saleLog->advance_payment - ($saleLog->collected_payment + $saleLog->paid_amount)}}</span></li>

                        </ul>
                        <div class="form-group">
                            <label for="checkDiscount">Advanced Payment</label>
                            <input type="number" class="form-control" name="advancedPayment" id="advancedPayment"
                                value="{{$saleLog->advance_payment}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="shippingCharge">Shipping Charge</label>
                            <input type="number" class="form-control" name="checkShipping" id="checkShipping"
                                value="{{$saleLog->is_shipment_charge_applied}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="checkDiscount">Discount</label>
                            <input type="number" class="form-control" name="checkDiscount" id="checkDiscount"
                                value="{{$saleLog->discount_amount}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="collectedPayment">Collected Payment</label>
                            <input type="number" class="form-control" name="collectedPayment" id="collectedPayment"
                                value="{{$saleLog->collected_payment + $saleLog->paid_amount}}" readonly>
                        </div>

                        <div class="mx-auto my-3">
                            <div class="row">
                                @foreach ($paymentMethods as $paymentMethod)
                                    <div class="col-lg-6">
                                        <div class="icheck-material-primary mr-2">
                                            <input type="radio" class="radio" id="{{ $paymentMethod->id }}"
                                                name="payment_method_id_log" value="{{ $paymentMethod->id }}" @if ($saleLog->payment_method == $paymentMethod->id) checked @endif disabled>
                                                <label for="{{ $paymentMethod->id }}">{{ $paymentMethod->payment_method }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- present sale block --}}
        <div class="row justify-content-center mt-5">
            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="form-header text-uppercase text-center">
                                <i class="fa fa-user-circle-o"></i>
                                Present Sales Log View
                            </h6>
                            <h6 class="form-header text-center">
                                Invoice: #0202{{$order['id']}}
                            </h6>
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
                                    <div class="col-sm-4 mb-3">
                                        <label for="input-11" class="col-form-label">Remarks</label>
                                        <textarea class="form-control" rows="2" id="remarks" value="" name="remarks"
                                            spellcheck="true" onkeyup="addRemarks(this.value)" readOnly>{{$order->remarks}}</textarea>
                                    </div>
    
                                    <div class="clearfix"></div>
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
                                            </tr>
                                        </thead>
                                        <tbody id="selected_tbl">
                                            @foreach ($orderDetails as $details)
                                                <tr id="item_{{ $details->barcode_id }}" data-price="{{ $details->unit_price }}">
                                                    <td class="whiteSpace_normal"
                                                        id="item_{{ $details->barcode_id }}_title">
                                                        {{ $details->item->name }}<br>({{@$details->purchase_item_barcodes->barcode}})</td>
                                                    <td class="whiteSpace_normal"><img
                                                        src="../../{{ $details->item->thumbnail }}" width="50" height="50"></td>
                                                        
                                                    <td class="whiteSpace_normal" style="text-align:center!important;">
                                                        {{ @$details->stocks->quantity }}</td>
                                                    <td class="whiteSpace_normal" style="min-width: 200px;">
                                                        <button class="btn btn-danger btn-sm text-white"
                                                            onclick="decreaseItemCount({{ $details->barcode_id }})"
                                                            style="cursor: pointer;" disabled>-</button>
                                                        <input id="item_{{ $details->barcode_id }}_count"
                                                            onkeyup="changeTotal($details->unit_price, 'item_{{ $details->barcode_id }}_count', 'item_{{ $details->barcode_id }}_total')"
                                                            type="text" class="form-control w-50 d-inline-block"
                                                            value="{{ @$details->quantity }}" readonly>
                                                        <button class="btn btn-success btn-sm text-white"
                                                            onclick="increaseItemCount({{ $details->barcode_id }}, {{ @$details->stocks->quantity }})"
                                                            style="cursor: pointer" disabled>+</button>
                                                    </td>
                                                    <td class="whiteSpace_normal" data-item-id="{{ $details->barcode_id }}"
                                                        data-item-regular-price="${data.regular_price}">
                                                        <input type="number" name="product_unit_price"
                                                            id="item_{{ $details->barcode_id }}_regular_price"
                                                            class="form-control product_unit_price"
                                                            min="{{ $details->unit_price }}"
                                                            value="{{ $details->unit_price }}"
                                                            readOnly
                                                            onkeyup="setMinimumUnitPrice({{ $details->barcode_id }})"/>
                                                    </td>
                                                    <td class="whiteSpace_normal" style="text-align:center!important;"
                                                        id="item_{{ $details->barcode_id }}_total">
                                                        {{ $details->price }}</td>
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
                        <div class="card-header"><h5>Order Details</h5></div>
                        <div class="card-body">
                            <ul class="list-group top-left-calculation-part" style="box-shadow: none">
                                <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b>
                                    <span class="float-right" id="totalAmount" onclick="changeTotal({{ $details->product_id }})">
                                        ৳{{$order->total_price[0]['total']}}
                                    </span>
                                </li>
                                <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b>
                                    <span class="float-right" id="shippingCharge">
                                        ৳{{$order->is_shipment_charge_applied}}
                                    </span>
                                </li>
                                <li class="list-group-item mb-1"><b class="text-uppercase">Discount (In amount) :</b>
                                    <span class="float-right" id="discountAmount">
                                        ৳{{$order->discount_amount}}
                                    </span>
                                </li>
                                <li class="list-group-item mb-1"><b class="text-uppercase">Advance Payment :</b>
                                    <span class="float-right" id="advancePayment">
                                        ৳{{$order->advance_payment}}
                                    </span>
                                </li>
                                <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b>
                                    <span class="float-right" id="totalAmountWithShipping">
                                        ৳{{$order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount - $order->advance_payment}}
                                    </span>
                                </li>
                                <li class="list-group-item mb-1"><b class="text-uppercase">Paid Amount :</b>
                                    <span class="float-right" id="collectedPaymentOrderDetails">
                                        ৳{{$sale->collected_payment + $sale->sales_due_payment->sum('paid_amount')}}
                                    </span>
                                </li>
                                <li class="list-group-item mb-1"><b class="text-uppercase">Payment Due :</b>
                                    <span class="float-right" id="paymentDueOrderDetails">
                                        ৳{{$order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount - $order->advance_payment - ($sale->collected_payment + $sale->sales_due_payment->sum('paid_amount'))}}
                                    </span>
                                </li>
                            </ul>

                            <div class="form-group">
                                <label for="checkDiscount">Advanced Payment</label>
                                <input type="number" class="form-control" name="advancedPayment" id="advancedPayment"
                                    value="{{$order->advance_payment}}" readonly required placeholder="Advanced Payment">
                            </div>
                            <div class="form-group">
                                <label for="shippingCharge">Shipping Charge</label>
                                <input type="number" class="form-control" name="checkShipping" id="checkShipping"
                                    value="{{$order->is_shipment_charge_applied}}" readonly placeholder="shipping charge">
                            </div>
                            <div class="form-group">
                                <label for="checkDiscount">Discount</label>
                                <input type="number" class="form-control" name="checkDiscount" id="checkDiscount"
                                    value="{{$order->discount_amount}}" readonly placeholder="Discount amount">
                            </div>
                            <div class="form-group">
                                <label for="collectedPayment">Collected Payment</label>
                                <input type="number" class="form-control" name="collectedPayment" id="collectedPayment"
                                    value="{{$sale->collected_payment + $sale->sales_due_payment->sum('paid_amount')}}" 
                                    required readonly placeholder="Collected Payment">
                            </div>
    
                            <div class="mx-auto my-3">
                                <div class="row">
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <div class="col-lg-6">
                                            <div class="icheck-material-primary mr-2">
                                                <input type="radio" class="radio" id="{{ $paymentMethod->id }}"
                                                    name="payment_method_id" disabled value="{{ $paymentMethod->id }}" @if (@$paymentDetails->payment_method_id == $paymentMethod->id) checked @endif>
                                                <label for="{{ $paymentMethod->id }}">{{ $paymentMethod->payment_method }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 
            <!-- @php 
            $salesArray = collect([
                [
                    'collected_payment' => $sale->collected_payment,
                    'created_at' => \Carbon\Carbon::parse($sale->updated_at)->format('d-m-Y H:i:s'),
                    'sales_by' => $sale->sales_by,
                    'table' => 'sales',
                    'priority' => 2
                ]
            ]);

            $salesArray->push([
                'collected_payment' => 0,
                'created_at' => \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y H:i:s'),
                'sales_by' => $sale->sales_by,
                'table' => 'sales',
                'priority' => 1
            ]);

            $saleNewLogsArray = $saleNewLogs->map(function($log) {
                return [
                    'collected_payment' => $log->collected_payment,
                    'created_at' => \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i:s'),
                    'sales_by' => $log->sales_by,
                    'table' => 'sales_new_logs',
                    'priority' => 1
                ];
            });

            $mergedSalesLogs = $salesArray->merge($saleNewLogsArray)
                ->sortBy(function ($log) {
                    return \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $log['created_at'])->timestamp;
                })
                ->sortBy('priority')
                ->values(); 
            
            $allPaymentsArray = $allPayments->map(function($log) {
                $collectedByName = 'N/A';
                if (isset($log->collected_by_user)) {
                    $collectedByUser = $log->collected_by_user;
                    $collectedByName = $collectedByUser ? $collectedByUser->first_name . ' ' . $collectedByUser->last_name : 'N/A';
                }

                return [
                    'created_at' => \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i:s'),
                    'type' => 'Due Payment',
                    'paid_amount' => number_format($log->paid_amount, 2),
                    'collected_by' => $collectedByName,
                    'source_table' => $log->source_table,
                    'due_collected_at' => \Carbon\Carbon::parse($log->due_collected_at)->format('d-m-Y H:i:s')
                ];
            })
            ->values(); 

            $total_balance = $order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount;
            $sale_collected_payment = 0;
            $sale_advance_payment = $booking->isEmpty() ? 0 : $booking->first()->advance_payment;
            
            foreach ($mergedSalesLogs as $log) {
                if ($log['table'] === 'sales' && $log['priority'] == 2) {
                    $sale_collected_payment = $log['collected_payment'];
                    break; 
                }
            }

            if ($sale_advance_payment > 0) {
                $total_balance -= $sale_advance_payment;
            }
            
            if ($sale_collected_payment > 0) {
                $total_balance -= $sale_collected_payment;
            }

            foreach ($allPaymentsArray as $log) {
                if ($log['source_table'] == 'sales_due_payment') {
                    $total_balance -= (float) str_replace(',', '', $log['paid_amount']);
                }
            }

            $status = $total_balance <= 0 ? 'Completed' : 'Pending';
            $badgeClass = $total_balance <= 0 ? 'badge-success' : 'badge-warning';
        @endphp -->
        --}}

        {{-- 
        <!-- <div class="row mt-5">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div class="text-center flex-grow-1">
                            <h5 class="form-header text-uppercase mb-0">
                                <i class="fa fa-user-circle-o"></i> Payment History 
                            </h5>
                            <h6 class="form-header mb-0 text-dark">Invoice: #0202{{$order['id']}}</h6>
                        </div>

                        <div class="small-card bg-light px-2 py-1 rounded shadow-sm">
                            <h6 class="mb-1">Due: <span class="text-danger">৳{{ number_format($total_balance, 2) }}</span></h6>
                            <h6 class="mb-1">Status:  
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            </h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>PAYMENT</th>
                                        <th>TOTAL</th>
                                        <th>AMOUNT</th>
                                        <th>REMAINING BALANCE</th>
                                        <th>COLLECTED BY</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                        @php
                                            $total_balance = $order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount;
                                            $table_balance = $total_balance;
                                        @endphp

                                        @if ($sale_advance_payment > 0)
                                            @php $table_balance -= $sale_advance_payment; @endphp
                                            <tr>
                                                <td>{{ optional($booking->first())->created_at ? $booking->first()->created_at->format('d-m-y H:i:s') : 'N/A' }}</td>
                                                <td>Advance Payment</td>
                                                <td>৳{{ number_format($total_balance, 2) }}</td>
                                                <td>৳{{ number_format($sale_advance_payment, 2) }}</td>
                                                <td>৳{{ number_format($table_balance, 2) }}</td>
                                                <td>{{ optional($booking->first())->created_by ?? 'N/A' }}</td>
                                            </tr>
                                        @endif

                                        @if (count($mergedSalesLogs) > 2)
                                            @for ($i = 0; $i < count($mergedSalesLogs) - 1; $i++)
                                                @php
                                                    $temp_array = [];
                                                    $temp_total_due_amount = 0;
                                                @endphp

                                                @foreach ($allPaymentsArray as $log) 
                                                    @if(isset($mergedSalesLogs[$i + 1]) &&
                                                        $log['source_table'] == 'sales_due_payment_log' &&
                                                        $log['created_at'] == $mergedSalesLogs[$i]['created_at'])
                                                        @php
                                                            $temp_total_due_amount += floatval(str_replace(',', '', $log['paid_amount']));
                                                            $temp_array[] = $log; 
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @foreach ($temp_array as $log)
                                                    @if ($table_balance > 0)
                                                        @php 
                                                            $total_balance = $table_balance;
                                                            $paid_amount = floatval(str_replace(',', '', $log['paid_amount']));
                                                            $table_balance -= min($paid_amount, $table_balance);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($log['due_collected_at'])->format('d-m-y H:i:s') }}</td>
                                                            <td>{{ $log['type'] }}</td>
                                                            <td>৳{{ number_format($total_balance, 2) }}</td>
                                                            <td>৳{{ number_format($paid_amount, 2) }}</td>
                                                            <td>৳{{ number_format($table_balance, 2) }}</td>
                                                            <td>{{ $log['collected_by'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                                @if ($table_balance > 0)
                                                    @php 
                                                        $total_balance = $table_balance;
                                                        $temp_collected_payment = $mergedSalesLogs[$i+1]['collected_payment'] - ($mergedSalesLogs[$i]['collected_payment'] + $temp_total_due_amount);
                                                    @endphp
                                                    
                                                    @if ($temp_collected_payment != 0) 
                                                        @php
                                                            $table_balance -= min($temp_collected_payment, $table_balance);
                                                        @endphp

                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($mergedSalesLogs[$i]['created_at'])->format('d-m-y H:i:s') }}</td>
                                                            <td>Collected Payment</td>
                                                            <td>৳{{ number_format($total_balance, 2) }}</td>
                                                            <td>৳{{ number_format($temp_collected_payment, 2) }}</td>
                                                            <td>৳{{ number_format($table_balance, 2) }}</td>
                                                            <td>{{ $mergedSalesLogs[$i]['sales_by'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endfor
                                            @php
                                                $temp_array = []; 
                                            @endphp
                                            @foreach ($allPaymentsArray as $log) 
                                                @if($log['source_table'] == 'sales_due_payment')
                                                    @php
                                                        $temp_array[] = $log; 
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @foreach ($temp_array as $log)
                                                    @if ($table_balance > 0)
                                                        @php 
                                                            $total_balance = $table_balance;
                                                            $paid_amount = floatval(str_replace(',', '', $log['paid_amount']));
                                                            $table_balance -= min($paid_amount, $table_balance);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($log['created_at'])->format('d-m-y H:i:s') }}</td>
                                                            <td>{{ $log['type'] }}</td>
                                                            <td>৳{{ number_format($total_balance, 2) }}</td>
                                                            <td>৳{{ number_format($paid_amount, 2) }}</td>
                                                            <td>৳{{ number_format($table_balance, 2) }}</td>
                                                            <td>{{ $log['collected_by'] }}</td>
                                                        </tr>
                                                    @endif
                                            @endforeach

                                        @elseif (count($mergedSalesLogs) == 2)
                                            $temp_collected_payment = mergedSalesLogs[1]['collected_payment'];
                                            @if ($temp_collected_payment != 0 && $table_balance > 0)
                                                @php $table_balance -= $temp_collected_payment @endphp
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($mergedSalesLogs[count($mergedSalesLogs) - 1]['created_at'])->format('d-m-y H:i:s') }}</td>
                                                    <td>Collected Payment</td>
                                                    <td>৳{{ number_format($total_balance, 2) }}</td>
                                                    <td>৳{{ number_format($temp_collected_payment, 2) }}</td>
                                                    <td>৳{{ number_format($table_balance, 2) }}</td>
                                                    <td>{{ $mergedSalesLogs[count($mergedSalesLogs) - 1]['sales_by'] }}</td>
                                                </tr>
                                            @endif
                                            @foreach ($allPaymentsArray as $log)
                                                @if ($table_balance > 0 && $log['source_table'] == 'sales_due_payment')
                                                    @php 
                                                        $total_balance = $table_balance;
                                                        $paid_amount = floatval(str_replace(',', '', $log['paid_amount']));
                                                        $table_balance -= min($paid_amount, $table_balance);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($log['created_at'])->format('d-m-y H:i:s') }}</td>
                                                        <td>{{ $log['type'] }}</td>
                                                        <td>৳{{ number_format($total_balance, 2) }}</td>
                                                        <td>৳{{ number_format($paid_amount, 2) }}</td>
                                                        <td>৳{{ number_format($table_balance, 2) }}</td>
                                                        <td>{{ $log['collected_by'] }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                        
                                            
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        --}}

    <!-- loader modal -->
    <div class="modal" id="preloader" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <img src="{{ asset('assets/images/preloader.gif') }}"
                style="display: block;margin: auto;margin-top:50%;width: 10%;">
        </div>
    </div>

    <script>

        $(document).ready(function() {

            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: false
            });

        });

    </script>

@endsection

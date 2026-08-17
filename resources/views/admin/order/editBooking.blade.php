@extends('layouts.backend.master')
@section('content')
@php
$userid=Auth::user()->id;
@endphp
    <style>
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
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Booking</h5>
                    </div>
                    <div class="card-body">
                        <form id="item_detail_form" action="">
                            <input type="hidden" name="booking_id" id="bookingId" value="{{ $bookingData['id'] }}">
                            <input type="hidden" name="advance_payment_id" id="advancePaymentId"
                                value="{{ $advancePaymentData['id'] }}">
                            <input type="hidden" name="customer_id" id="customerId" value="{{ $customerId['id'] }}">

                            <div class="form-group row">
                                <div class="col-sm-4 mb-3">
                                    <label for="input-10" class="col-form-label">First Name<span
                                            class="must">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        required="required" value="{{ $bookingData['first_name'] }}"
                                        onkeyup="firstName(this.value)" readonly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Last Name<span
                                            class="must">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        required="required" value="{{ $bookingData['last_name'] }}"
                                        onkeyup="lastName(this.value)" readonly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Phone Number<span
                                            class="must">*</span></label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        required="required" value="{{ $bookingData['phone_number'] }}" onkeyup="phone(this.value)" readonly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Email<span class="must">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email" required="required"
                                        value="{{ $bookingData['email'] }}" onkeyup="emailHandler(this.value)" readonly>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        value="{{ $bookingData['country'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">District</label>
                                    <input type="text" class="form-control" id="district" name="district"
                                        value="{{ $bookingData['district'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ $bookingData['city'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Thana</label>
                                    <input type="text" class="form-control" id="thana" name="thana"
                                        value="{{ $bookingData['thana'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Area</label>
                                    <input type="text" class="form-control" id="area" name="area"
                                        value="{{ $bookingData['area'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Road No</label>
                                    <input type="text" class="form-control" id="road_no" name="road_no"
                                        value="{{ $bookingData['road_no'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">House No</label>
                                    <input type="text" class="form-control" id="house_no" name="house_no"
                                        value="{{ $bookingData['house_no'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Flat No</label>
                                    <input type="text" class="form-control" id="flat_no" name="flat_no"
                                        value="{{ $bookingData['flat_no'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Car Number</label>
                                    <input type="text" class="form-control" id="car_no" name="car_no"
                                        value="{{ $bookingData['car_no'] }}">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Booking Notes</label>
                                    <textarea class="form-control" rows="2" id="order_notes" name="order_notes"
                                        spellcheck="true">{{ $bookingData['booking_notes'] }}</textarea>
                                </div>
                                {{-- <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Customer Notes</label>
                                    <textarea class="form-control" rows="2" id="customer_notes"  onkeyup="customerNotes(this.value)" name="customer_notes"
                                        spellcheck="true">{{ $bookingData['customer_notes'] }}</textarea>
                                </div> --}}
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Remarks</label>
                                    <textarea class="form-control" rows="2" id="remarks" name="remarks" onkeyup="addRemarks(this.value)" 
                                        spellcheck="true">{{ $bookingData->remarks }}</textarea>
                                </div>

                                <div class="col-lg-12 pt-4">
                                    <label class="col-form-label">How Did You Hear About AUTOMART?</label>
                                    <br />

                                    @foreach ($referrals as $referral)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="referral_method[]" value="{{ $referral->id }}" disabled
                                                @if ($customerreferrals != null)
                                                    @foreach (@$customerreferrals as $ref)
                                                        @if ($ref->referral_id == $referral->id) checked @endif
                                                    @endforeach
                                                @endif
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
                                        @foreach ($bookingDetailsData as $bookingDetail)
                                            <tr id="item_{{ $bookingDetail->barcode_id }}"
                                                data-price="{{ $bookingDetail->unit_price }}">

                                                <td class="whiteSpace_normal"
                                                    id="item_{{ $bookingDetail->barcode_id }}_title">
                                                    {{ $bookingDetail->product_name }}</td>
                                                <td class="whiteSpace_normal"><img
                                                        src="../{{ $bookingDetail->product_detail->thumbnail }}" width="50"
                                                        height="50"></td>
                                                <td class="whiteSpace_normal" style="text-align:center!important;">
                                                    {{ $bookingDetail->stocks->quantity }}</td>
                                                <td class="whiteSpace_normal" style="min-width: 200px;">
                                                    <button class="btn btn-danger btn-sm text-white"
                                                        onclick="decreaseItemCount({{ $bookingDetail->barcode_id }})"
                                                        style="cursor: pointer;">-</button>
                                                    <input id="item_{{ $bookingDetail->barcode_id }}_count"
                                                        onkeyup="changeTotal({{$bookingDetail->unit_price}}, 'item_{{ $bookingDetail->barcode_id }}_count', 'item_{{ $bookingDetail->barcode_id }}_total')"
                                                        type="text" class="form-control w-50 d-inline-block"
                                                        value="{{ $bookingDetail->quantity }}" min="1" readOnly>
                                                    <button class="btn btn-success btn-sm text-white"
                                                        onclick="increaseItemCount({{ $bookingDetail->barcode_id }}, {{ $bookingDetail->stocks->quantity }})"
                                                        style="cursor: pointer">+</button>
                                                </td>
                                                <td class="whiteSpace_normal"
                                                    data-item-id="{{ $bookingDetail->barcode_id }}"
                                                    data-item-regular-price="{{$bookingDetail->unit_price}}">
                                                    Regular Price (BDT.
                                                    {{ $bookingDetail->purchase_item_barcodes->regular_price }})
                                                    <input type="number" name="product_unit_price"
                                                        id="item_{{ $bookingDetail->barcode_id }}_regular_price"
                                                        class="form-control product_unit_price"
                                                        min="{{ $bookingDetail->unit_price }}"
                                                        value="{{ $bookingDetail->unit_price }}" 
                                                        onkeyup="setMinimumUnitPrice({{ $bookingDetail->barcode_id }})"/>
                                                </td>
                                                <td class="whiteSpace_normal" style="text-align:center!important;"
                                                    id="item_{{ $bookingDetail->barcode_id }}_total">
                                                    {{ $bookingDetail->total_price }}</td>
                                                <td class="whiteSpace_normal">
                                                    <span onclick="removeItem({{ $bookingDetail->barcode_id}},'{{$bookingDetail->purchase_item_barcodes->barcode}}')"
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
                        <ul class="list-group" style="box-shadow: none">
                            <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b> <span
                                    class="float-right"
                                    id="totalAmount">৳{{ $advancePaymentData['payable_amount'] + $advancePaymentData['paid_amount'] + $bookingData['discount_amount'] - $bookingData['shipping_amount'] }}</span>
                            </li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span
                                    class="float-right" id="shippingCharge">৳{{ $bookingData['shipping_amount'] }}</span>
                            </li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Discount Amount :</b> <span
                                class="float-right"
                                id="discountAmountOrderDetails">৳{{ $bookingData['discount_amount'] }}</span>
                            </li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Advance Payment :</b> <span
                                    class="float-right"
                                    id="advancePaymentOrderDetails">৳{{ $advancePaymentData['paid_amount'] }}</span>
                            </li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span class="float-right"
                                    id="totalAmountWithShipping">৳{{ $advancePaymentData['payable_amount'] }}</span>
                            </li>
                        </ul>

                        <div class="form-group">
                            <label for="shippingCharge">Shipping Charge:</label>
                            <input type="number" min="0" class="form-control" name="checkShipping" id="checkShipping"
                                placeholder="Enter shipping charge" value="{{ $bookingData['shipping_amount'] }}">
                        </div>
                        <div class="form-group">
                            <label for="discountAmount">Discount (In Amount):</label>
                            <input type="number" min="0" class="form-control" name="discountAmount" id="discountAmount"
                                placeholder="Enter discount amount" value="{{ $bookingData['discount_amount'] }}">
                        </div>
                        <div class="form-group">
                            <label for="shippingCharge">Advance Payment:</label>
                            <input type="number" min="0" class="form-control" name="advancePayment" id="advancePayment"
                                placeholder="Enter advance payment" value="{{ $advancePaymentData['paid_amount'] }}"
                                required>
                        </div>


                        <div class="mx-auto my-3">
                            <div class="row">
                                @foreach ($paymentMethods as $paymentMethod)
                                    <div class="col-lg-6">
                                        <div class="icheck-material-primary mr-2">
                                            <input type="radio" class="radio" id="{{ $paymentMethod->id }}"
                                                name="payment_method_id" value="{{ $paymentMethod->id }}" @if ($paymentMethod->id == $advancePaymentData['payment_method_id']) checked @endif>
                                            <label
                                                for="{{ $paymentMethod->id }}">{{ $paymentMethod->payment_method }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <input type="text" class="form-control" name="remarks" id="remarks" required placeholder="Add Remarks" onkeyup="remarks(this.value)" value = "{{$bookingData->remarks}}">
                        </div> --}}

                        @if ($userid==env('SUPERADMIN_ID') || $userid==env('HOP_ID') || $userid==env('ACCOUNTS_ID'))
                            <button id="checkOut"
                                class="btn btn-secondary btn-round waves-effect waves-light m-1 shadow btn-block"><i
                                    class="fa fa-refresh"></i> Update
                            </button>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                        <div class="invoice p-3" id="invoiceMaxiMin" style="background-color: #FFF;">

                            <div id="invoiceElement" style="background: #fff !important;">
                                <div class="text-right" id="maxiMizeMin">
                                    <button id="maximize" class="custom__btn btn__size" onclick="maximize()"><i
                                            class="fa fa-window-restore" aria-hidden="true"></i></button>
                                    <button id="minimize" class="custom__btn btn__size" onclick="minimize()"><i
                                            class="fa fa-minus" aria-hidden="true"></i></button>

                                </div>

                                <main id="invoiceDiv" style="background: #fff !important;">
                                   <style>
                                        body{
                                              background:#fff;
                                        }
                                   </style>
                                    <div class="d-flex justify-content-between">
                                        <div class="invoice-img">
                                            <h3 style="color: #3989c6;font-size: 14px; line-height: 18px" id="dateFormat"></h3>
                                            <h3 style="color: #3989c6;font-size: 14px; line-height: 18px">INVOICE TO:</h3>
                                            <p style="font-size: 11px;color: black;">Name- <span id="firstName">{{$bookingData->first_name}} </span><span
                                                    id="lastName">{{$bookingData->last_name}}</span></p>
                                            <p style="font-size: 11px;color: black;">Number - <span id="phone">{{$bookingData->phone_number}}</span></p>
                                            <p style="font-size: 11px;color: black;">Email - <span id="emailAddress">{{$bookingData->email}}</span></p>
                                        </div>
                                        <div class="address-shop">
                                            <h3 style="color: #3989c6;font-size: 14px;line-height: 18px">INVOICE #0303{{$bookingData['id']}}</h3>
                                            <p style="font-size: 11px" id="dateFormat"></p>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="border: 1px solid black !important;">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: black !important;color: #fff;border: 1px solid black !important;">Product</th>
                                                    <th style="background-color: black !important;color: #fff;border: 1px solid black !important;">Quantity</th>
                                                    <th style="background-color: black !important;color: #fff;border: 1px solid black !important;">Unit Price</th>
                                                    <th style="background-color: black !important;color: #fff;border: 1px solid black !important;">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tbody id="selected_tbl_invoice">
                                                @foreach ($bookingDetailsData as $detail)
                                                    <tr id="item_invoice_{{ $detail->barcode_id }}"
                                                        data-price="{{ $detail->unit_price }}">
                                                        <td class="whiteSpace_normal"
                                                            id="item_invoice_{{ $detail->barcode_id }}_title">
                                                            {{ $detail->product_name }}
                                                        </td>
                                                        
                                                        <td class="whiteSpace_normal" id="item_invoice_{{ $detail->barcode_id }}_count">
                                                            {{ $detail->quantity }}
                                                        </td>

                                                        <td class="whiteSpace_normal"
                                                            id = "item_invoice_{{ $detail->barcode_id }}_unit_price">
                                                            ৳{{ $detail->unit_price}}</td>
                                                        <td class="whiteSpace_normal"
                                                            id="item_invoice_{{ $detail->barcode_id }}_total">
                                                            ৳{{ $detail->unit_price * $detail->quantity }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>

                                                    <td colspan="3" style="text-align:center;color: black !important;">Sub Total</td>
                                                    <td style="color: black !important;"><span class="float-right"
                                                            id="totalAmountInvoice">৳{{ $advancePaymentData['payable_amount'] + $advancePaymentData['paid_amount'] + $bookingData['discount_amount'] - $bookingData['shipping_amount'] }}</span>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td colspan="3" style="text-align:center; color: black !important;">Shipping</td>
                                                    <td style="color: black !important;"><span class="float-right"
                                                            id="shippingChargeInvoice">৳{{ $bookingData['shipping_amount'] }}</span>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td colspan="3" style="text-align:center;color: black !important;">Advance Payment</td>
                                                    <td style="color: black !important;"><span class="float-right"
                                                            id="advancePaymentInvoice">৳{{ $advancePaymentData['paid_amount'] }}</span>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td colspan="3" style="text-align:center;color: black !important;">Discount</td>
                                                    <td style="color: black !important;"><span class="float-right"
                                                            id="discountAmountInvoice">৳{{ $bookingData['discount_amount'] }}</span>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td colspan="3" style="text-align:center;color: black !important;">Payment(Due)</td>
                                                    <td style="color: black !important;"><span class="float-right"
                                                            id="totalAmountWithShippingInvoice">৳{{ $advancePaymentData['payable_amount'] }}</span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                     <div id="spaceDiv">
                                            {{-- <div>
                                                <p style="border-bottom: 1px solid #000;font-size: 16px; width: 70px; color: #000;">Remarks</p>
                                                <p style="font-size: 16px;color: #000;">
                                                    <span id="addRemarks" style="font-size: 14px !important;">{{$bookingData->remarks}}</span></p>
                                            </div> --}}
                                            <div style="display: flex;justify-content: space-between; margin-top: 70px;">
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
                                            Notes - <span id="customerNotes" style="font-size: 14px !important;">{{$bookingData->customer_notes}}</span></p> --}}

                                        <div>
                                            <p style="border-bottom: 1px solid #000;font-size: 16px;color: black; width: 75px;margin-top: 60px;">Remarks</p>
                                            <p style="font-size: 16px;color: black;">
                                                <span id="addRemarks" style="font-size: 14px !important;">{{$bookingData->remarks}}</span>
                                            </p>
                                        </div>

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
        let selectedBarcodes = [];


        //Store previously booked barcodes
        let bookedProductBarcodes = JSON.parse('{!! json_encode($bookedProductBarcodes) !!}');
        bookedProductBarcodes.forEach(barcode => {
                selectedBarcodes.push(barcode);
        });

        function printDiv(divName) {
            let check_shipping = $('#checkShipping').val();
            let check_dicount = $('#discountAmount').val();
            let collected_advancepayment = $('#advancePayment').val();
            console.log("check_shipping", check_shipping);
            console.log("check_dicount", check_dicount);
            console.log("advancePayment", collected_advancepayment);
            // console.log("collected_payment", collected_payment);
            //return collected_advancepayment;
            if(check_shipping == 0){
                $('#shippingChargeInvoice').parent().parent()[0].remove();
            }
            if(check_dicount == 0){
                $('#discountAmountInvoice').parent().parent()[0].remove();
            }
            if(collected_advancepayment == 0){
                $('#advancePaymentInvoice').parent().parent()[0].remove();
            }
            $('#maxiMizeMin').hide();
            $('#previewBtn').hide();
            $('.donwloadBtn').hide();
            var getDivName = document.getElementById('invoiceDiv');
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
                calculateTotal();
            });

            // sale
            $('#checkOut').on('click', () => {
                checkOut();
            });

            // onchange count, change price
            $('tr td:nth-child(3) input').on('change', () => {
                //
            });
            
            // -------------commented by kawsar on 24-12-2022 at 6:41 -----------
            // oncheck add/remove shipping charge
            // $('#checkShipping').change(function() {
            //     let checkShipping = Number($('#checkShipping').val());
            //     $('#shippingCharge').text("৳" + $('#checkShipping').val());
            //     $('#shippingChargeInvoice').text("৳" + $('#checkShipping').val());
            //     calculateTotal();
            //     $('#checkShipping').val(checkShipping);
            // });
            //----------------------------------------------
            $('#checkShipping').change(function () {
                let checkShipping = Number($('#checkShipping').val());
                $('#shippingCharge').text("৳" + checkShipping);
                $('#shippingChargeInvoice').text("৳" + checkShipping);

                calculateTotal();
                $('#checkShipping').val(checkShipping);
            });

            // $('#advancePayment').change(function() {
            //     let checkAdvancePayment = Number($('#advancePayment').val());
            //     $('#advancePaymentOrderDetails').text("৳" + $('#advancePayment').val());
            //     $('#advancePaymentInvoice').text("৳" + $('#advancePayment').val());
            //     calculateTotal();
            //     $('#advancePayment').val(checkAdvancePayment);
            // });

            $('#advancePayment').change(function() {
                let advancePayment = Number($('#advancePayment').val());
                $('#advancePaymentOrderDetails').text("৳" + advancePayment);
                $('#advancePaymentInvoice').text("৳" + advancePayment);
                calculateTotal();
                $('#advancePayment').val(advancePayment);
            });

            $('#discountAmount').change(function() {
                let checkDiscountPayment = Number($('#discountAmount').val());
                $('#discountAmountOrderDetails').text("৳" + checkDiscountPayment);
                $('#discountAmountInvoice').text("৳" + $('#discountAmount').val());
                calculateTotal();
                $('#discountAmount').val(checkDiscountPayment);
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

            if (unit_price_value < item_regular_price) {
                alertify.error("Please input price greater than regular price");
                $(this).val(item_regular_price);
            } else {
                let present_count = Number($("#item_" + item_id + "_count").val());
                let total_price = (unit_price_value * present_count).toFixed(2);
                $("#item_" + item_id + "_total").html(total_price);
                $("#item_invoice_" + item_id + "_unit_price").html(unit_price_value);
                $("#item_invoice_" + item_id + "_total").html("৳" + total_price);
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
                                            Regular Price (BDT. ${barcodeData.regular_price})
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
                                        Regular Price (BDT. ${purchaseItemBarcodeData.regular_price})
                                        <input type="number" name="product_unit_price" id="item_${purchaseItemBarcodeId}_regular_price" class="form-control product_unit_price" min="${purchaseItemBarcodeData.sales_price}" value="${purchaseItemBarcodeData.sales_price}" onkeyup="setMinimumUnitPrice(${purchaseItemBarcodeId})"/>
                                        </td>
                                    <td class="whiteSpace_normal" style="text-align:center!important;" id="item_${purchaseItemBarcodeId}_total">${purchaseItemBarcodeData.sales_price}</td>
                                    <td class="whiteSpace_normal">
                                        <span onclick="removeItem(${purchaseItemBarcodeId},'${purchaseItemBarcodeData.barcode}')" class="badge badge-danger py-3 px-2"
                                            style="cursor: pointer;min-width:45px">X</span>
                                    </td>
                                </tr>`);


                                $('#selected_tbl_invoice').append(`<tr id="item_invoice_${purchaseItemBarcodeId}" data-price="${purchaseItemBarcodeData.sales_price}">
                                    <td class="whiteSpace_normal" id="item_invoice_${purchaseItemBarcodeId}_title">${itemData.name}</td>
                                    <td class="whiteSpace_normal" id="item_invoice_${purchaseItemBarcodeId}_count">${1}</td>
                                    <td class="whiteSpace_normal" id="item_invoice_${purchaseItemBarcodeId}_unit_price">৳${purchaseItemBarcodeData.sales_price}</td>
                                    <td class="whiteSpace_normal" id="item_invoice_${purchaseItemBarcodeId}_total">৳${purchaseItemBarcodeData.sales_price}</td>

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
            if ($(item_id).remove() && $(item_invoice_id).remove()) {
                alertify.error('Item removed!');
            }
            let index = selectedBarcodes.indexOf(itemBarcode);
            if (index > -1) {
                selectedBarcodes.splice(index, 1);
            }

            // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
            calculateTotal();
        }

        function increaseItemCount(id, stock_quantity) {
            let amount = Number($("#item_" + id + "_regular_price").val());
            let item_id = `#item_${id}_count`;
            let item_invoice_id = `#item_invoice_${id}_count`;

            let present_count = Number($(item_id).val());
            let present_total = Number($(`#item_${id}_total`).html());
            let total = Number($(`#item_${id}_total`).html());

            present_count += 0.25;
            present_count = present_count.toFixed(2);
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
                calculateTotal();
            }
            
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
            let shipping = Number($('#shippingCharge').text().split('৳')[1]);
            let advance_payment = Number($('#advancePaymentOrderDetails').text().split('৳')[1]);
            let discount_amount = Number($('#discountAmountOrderDetails').text().split('৳')[1]);
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
            } else {
                grand_total = (subtotal + shipping) - (advance_payment + discount_amount);
                $('#totalAmount').text(`৳${subtotal.toFixed(2)}`);
                $('#totalAmountWithShipping').text(`৳${grand_total.toFixed(2)}`);
                $('#totalAmountInvoice').text(`৳${subtotal.toFixed(2)}`);
                $('#totalAmountWithShippingInvoice').text(`৳${grand_total.toFixed(2)}`);
            }
        }

        function getBookingDetail() {
            // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
            calculateTotal();
            
            let orderDetail = {};
            let items_details_list = [];
            let authUser = @json(session('authUser', Auth::user()));

            if (authUser) {
                authUser = authUser.first_name
            } else {
                authUser = null;
            }

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
            orderDetail['totalAmount'] = Number($('#totalAmount').text().split('৳')[1]);
            orderDetail['totalAmountWithShipping'] = Number($('#totalAmountWithShipping').text().split('৳')[1]);
            orderDetail['advancePayment'] = Number($('#advancePayment').val());
            orderDetail['discountAmount'] = Number($('#discountAmount').val());
            orderDetail['bookingId'] = Number($('#bookingId').val());
            orderDetail['advancePaymentId'] = Number($('#advancePaymentId').val());
            orderDetail['customerId'] = Number($('#customerId').val());
            orderDetail['remarks'] = $('#remarks').val();

            document.querySelectorAll('#selected_tbl tr').forEach(e => {
                let item_details = {
                    title: $(`#${e.id}_title`).text(),
                    quantity: $(`#${e.id}_count`).val(),
                    barcode_id: e.id.split('_')[1],
                    price: $(`#${e.id}`).data('price'),
                };

                items_details_list.push(item_details);
            });

            orderDetail['items_details_list'] = items_details_list;
            orderDetail['updated_by'] = authUser;


            return orderDetail;
        }

        function checkOut() {
            alertify.confirm("Are You Sure To Proceed?",
                function() {
                    $('#preloader').modal('show');
                    let payment_method = $("input[class='radio']:checked").val();
                    let referral_method = [];
                    $('input[name="referral_method[]"] ').each(function() {
                        if (this.checked) {
                            referral_method.push($(this).val());
                        }
                    });

                    $.ajax({
                        url: '{{ URL('bookingUpdate') }}',
                        type: 'POST',
                        data: {
                            bookingDetail: getBookingDetail(),
                            payment_method: payment_method,
                            referral_method: referral_method
                        },
                        success: response => {
                            $('#preloader').modal('hide');

                            if (response.status === true) {
                                alertify.success(response.message);
                                printDiv('invoiceElement');
                                $('#firstName').text('');
                                $('#emailAddress').text('');
                                $('#phone').text('');

                                window.location.href = '../bookedOrdersView/';

                            } else if (response.status == "validation-error") {
                                $.each(response.data, (index, value) => {
                                    alertify.error(value[0]);
                                });
                            } else {
                                alertify.error(response.message);
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
        }

    </script>

@endsection

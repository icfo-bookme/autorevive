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

        .alertify-notifier .ajs-message.ajs-error {
            color: #fff !important;
            background: rgba(217, 92, 92, 0, 95);
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0, 5);
        }

        /* phone auto suggetion */
        .autocomplete {
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 12.5px;
            right: 12.5px;
            max-height: 300px;
            overflow-y: auto;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        .footer {
            position: fixed !important;
            left: 0px !important;
            bottom: 0 !important;
        }

        .itemListContainer {
            /* min-height: 450px; */
            max-height: 450px;
            overflow-y: auto;

        }

        .singleItem {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
        }

        .itemDetails {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .itemName {
            font-size: 14px;
            color: #000;
            margin: 0 !important;
        }

        .orderItemImg {
            width: 60px;
            height: 60px;
        }

        .itemPrice {
            padding-right: 10px;
        }


        @media only screen and (min-width: 1025px) and (max-width: 1150px) {
            .authorSign {
                margin-left: 5px
            }
        }

        @media only screen and (min-width: 576px) and (max-width: 890px) {
            .authorSign {
                margin-left: 5px
            }
        }
    </style>



    <div class="conatiner">
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Info View</h5>
                    </div>
                    <div class="card-body">
                        <form id="item_detail_form" action="">
                            @csrf
                            {{-- <input type="hidden" name="deliveryType" id="deliveryType" value="{{$order->delivery_type}}">
                            <input type="hidden" name="shippingCharge" id="shippingCharge" value="{{$shippingCharge['amount']}}">
                            <input type="hidden" name="isShipmentChargeApplied" id="isShipmentChargeApplied" value="{{$shippingCharge['amount']}}"> --}}
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label>Customer Name</label>
                                                    <input type="text" class="form-control" id="customer_name"
                                                        value=" {{ $order->first_name }} {{ $order->last_name }}" readonly>
                                                </td>

                                                <td>
                                                    <label>Phone Number</label>
                                                    <input type="text" class="form-control" id="phone_number"
                                                        value="{{ $order->phone_number }}" readonly>
                                                </td>
                                                <td>
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        value="{{ $order->email }}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label> Country </label>
                                                    <input type="text" class="form-control" id="country"
                                                        value="{{ $order->country }}" readonly>
                                                </td>
                                                <td>
                                                    <label> District </label>
                                                    <input type="text" class="form-control" id="district"
                                                        value="{{ $order->district }}" readonly>
                                                </td>

                                                <td>
                                                    <label> City </label>
                                                    <input type="text" class="form-control" id="city" value="{{ $order->city }}"
                                                        readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label> Thana </label>
                                                    <input type="text" class="form-control" id="thana"
                                                        value="{{ $order->thana }}" readonly>
                                                </td>
                                                <td>
                                                    <label> Area </label>
                                                    <input type="text" class="form-control" id="area" value="{{ $order->area }}"
                                                        readonly>
                                                </td>

                                                <td>
                                                    <label> Road No. </label>
                                                    <input type="text" class="form-control" id="road_no" value="{{ $order->road_no }}"
                                                        readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label> House No. </label>
                                                    <input type="text" class="form-control" id="house_no"
                                                        value="{{ $order->house_no }}" readonly>
                                                </td>
                                                <td>
                                                    <label> Flat No. </label>
                                                    <input type="text" class="form-control" id="flat_no"
                                                        value="{{ $order->flat_no }}" readonly>
                                                </td>
                                            </tr>

                                            @if ($order->rescheduleReason)
                                                @foreach ($order->rescheduleReason as $reason)
                                                    <tr>

                                                        <td>
                                                            <label> Reschedule Reason </label>
                                                            <input type="text" class="form-control" id="input-1"
                                                                value="{{ $reason->reason }}" readonly>
                                                        </td>
                                                        <td>
                                                            <label> Created By </label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $reason->created_by }}" readonly>
                                                        </td>

                                                        <td>
                                                            <label> Created At </label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $reason->created_at }}" readonly>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="row col-lg-4 mt-4">
                                <input type="text" class="form-control" name="remarks" id="remarks" required
                                    placeholder="Add Remarks" onkeyup="addRemarks(this.value)">
                            </div>
                            <div class="col-lg-12 pt-4">
                                <label class="col-form-label">How Did You Hear About AUTOMART?</label>
                                <br />
                                @foreach ($referrals as $referral)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="referral_method[]"
                                            value="{{ $referral->id }}"
                                            {{-- @foreach (@$customerreferrals as $ref)
                                                    @if ($ref->referral_id == $referral->id) checked @endif
                                                @endforeach --}}>
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
                                        <option value="{{ $product->id }},{{ $product->barcode }}">
                                            {{ $product->item->name }} {!! '&nbsp;' !!}
                                            ({{ $product->barcode }}) {!! '&nbsp;' !!} {!! '&nbsp;' !!}
                                            {{ $product->stock->quantity ?? '0' }} {{ $product->stock->uom }}</option>
                                    @endforeach
                                </select>
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

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin:20px 20px;">
                        <div class="col text-center">

                            <!-- @if ($order->delivery_type == 'pickup')
                                <button class="btn btn-primary" onclick="pickupApproved({{ $order->id }})">Approve</button>
                            @else
                                <button class="btn btn-primary" onclick="orderApproved()">Approve</button>
                                <button class="btn btn-primary" onclick="shipmentOrder()">Shipment</button>
                            @endif -->


                            @if ($order->delivery_type == 'pickup')
                                <button class="btn btn-primary" onclick="pickupApproved({{ $order->id }})">Approve</button>
                            @else
                                <button class="btn btn-primary" onclick="orderApproved()">Approve</button>
                                <button class="btn btn-primary" onclick="shipmentOrder()">Shipment</button>
                            @endif

                            <button class="btn btn-danger" onclick="cancelOrder({{ $order->id }})">Cancel</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <div>
                                    <h6 class="text-uppercase text-center">
                                        Ordered Item List
                                    </h6>
                                    <hr>
                                </div>
                                <div class="itemListContainer">
                                    @foreach ($orderDetails as $item)
                                        <div class="singleItem">
                                            <div class="itemDetails">
                                                <div>
                                                    <img class="img-thumbnail orderItemImg"
                                                        src="{{ asset($item->item->thumbnail) }}" alt="Order Item">
                                                </div>
                                                <div style="margin-left: 7px;" class="pt-2">
                                                    <p class="itemName">{{ $item->item->name }}</p>
                                                    <p>Qty: {{ $item->quantity }}X{{ $item->unit_price }}</p>
                                                </div>
                                            </div>
                                            <div class="itemPrice">
                                                <p class="fw-bold">৳{{ $item->unit_price * $item->quantity }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group top-left-calculation-part" style="box-shadow: none">
                            <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b> <span
                                    class="float-right" id="totalAmount">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span
                                    class="float-right" id="shippingCharge">৳{{ $order->is_shipment_charge_applied }}</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Discount (In amount) :</b> <span
                                    class="float-right" id="discountAmount">৳0</span></li>
                            {{-- <li class="list-group-item mb-1"><b class="text-uppercase">Advance Payment :</b> <span
                                    class="float-right" id="advancePayment">৳0</span></li> --}}
                            <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span
                                    class="float-right" id="totalAmountWithShipping">৳0</span></li>
                            {{-- <li class="list-group-item mb-1"><b class="text-uppercase">Paid Amount :</b> <span
                                    class="float-right" id="collectedPaymentOrderDetails">৳0</span></li> --}}
                            {{-- <li class="list-group-item mb-1"><b class="text-uppercase">Payment Due :</b> <span
                                    class="float-right" id="paymentDueOrderDetails">৳0</span></li> --}}
                        </ul>
                        <div class="form-group">
                            <label for="shippingCharge">Shipping Charge</label>
                            <input type="number" class="form-control" name="checkShipping" id="checkShipping"
                                min="0" placeholder="shipping charge" value="{{ $order->is_shipment_charge_applied }}">
                        </div>
                        <div class="form-group">
                            <label for="checkDiscount">Discount</label>
                            <input type="number" class="form-control" value="0" name="checkDiscount" id="checkDiscount"
                                min="0" placeholder="Discount amount">
                        </div>
                        {{-- <div class="form-group">
                            <label for="collectedPayment">Collected Payment</label>
                            <input type="number" class="form-control" name="collectedPayment" id="collectedPayment"
                                min="0" required placeholder="Collected Payment">
                        </div> --}}

                        {{-- <div class="mx-auto my-3">
                            <div class="row">
                                @foreach ($paymentMethods as $paymentMethod)
                                    <div class="col-lg-6">
                                        <div class="icheck-material-primary mr-2">

                                            <input type="radio" class="radio" id="{{ $paymentMethod->id }}"
                                                name="payment_method_id" value="{{ $paymentMethod->id }}"
                                                @if ($paymentMethod->payment_method == 'Cash') checked @endif>

                                            <label
                                                for="{{ $paymentMethod->id }}">{{ $paymentMethod->payment_method }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div> --}}

                        <div class="mx-auto my-3">
                            <div class="col-lg-12 pt-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="highlights" value="1">
                                    <label class="form-check-label">highlight</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="invoice p-3" id="invoiceMaxiMin" style="background-color: #FFF;">

                                <div id="invoiceElement">

                                    <div class="text-right" id="maxiMizeMin">
                                        <button id="maximize" class="custom__btn btn__size" onclick="maximize()"><i
                                                class="fa fa-window-restore" aria-hidden="true"></i></button>
                                        <button id="minimize" class="custom__btn btn__size" onclick="minimize()"><i
                                                class="fa fa-minus" aria-hidden="true"></i></button>

                                    </div>

                                    <main id="invoiceDiv">
                                        <style>
                                            body {
                                                background: #fff;
                                            }
                                        </style>
                                        <div class="d-flex justify-content-between">
                                            <div class="invoice-img">
                                                <div
                                                    style="display: flex;justify-content: space-between;align-items: center; margin-bottom: 10px">
                                                    <h3 style="color: #3989c6;font-size: 14px;padding-top: 10px;"
                                                        id="dateFormat">DATE:</h3>
                                                    <?php
                                                        $invoiceDate = $order->created_at->toDateString();
                                                    ?>
                                                    <input type="date" class="form-control" id="invoice_date"
                                                        name="invoice_date" required max="{{ date('Y-m-d') }}"
                                                        value="{{ $invoiceDate }}" style="margin-left: 10px;">
                                                </div>

                                                <h3 style="color: #3989c6;font-size: 14px; line-height: 18px">INVOICE TO:
                                                </h3>
                                                <p style="font-size: 11px;color: black;">Name - {{$order->first_name}} {{$order->last_name}}<span
                                                        id="firstName"></span> <span id="lastName"></span></p>
                                                <p style="font-size: 11px;color: black;">Contact Number - {{$order->phone_number}}<span
                                                        id="phone"></span></p>
                                                <p style="font-size: 11px;color: black;">Email - {{$order->email}}<span
                                                        id="emailAddress"></span></p>

                                            </div>
                                            <div class="address-shop">
                                                <h3 style="color: #3989c6;font-size: 14px;line-height: 18px">INVOICE #0101{{$order->id}}</h3>

                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="background: black !important;color: #fff;">Product</th>
                                                        <th style="background: black !important;color: #fff;">Quantity</th>
                                                        <th style="background: black !important;color: #fff;">Unit Price
                                                        </th>
                                                        <th style="background: black !important;color: #fff;">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tbody id="selected_tbl_invoice">

                                                </tbody>
                                                </tbody>
                                                <tfoot class="invoice_footer">
                                                    <tr>

                                                        <td colspan="3" class="text-right">Sub Total</td>
                                                        <td><span class="float-right" id="totalAmountInvoice">৳0</span>
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td colspan="3" class="text-right">Shipping</td>
                                                        <td><span class="float-right"
                                                                id="shippingChargeInvoice">৳{{ $order->is_shipment_charge_applied }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">Discount</td>
                                                        <td><span class="float-right" id="discountAmountInvoice">৳0</span>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td colspan="3" class="text-right">Advance Payment</td>
                                                        <td><span class="float-right" id="advancePaymentInvoice">৳0</span>
                                                        </td>
                                                    </tr> --}}
                                                    <tr>
                                                        <td colspan="3" class="text-right">Grand Total</td>
                                                        <td><span class="float-right"
                                                                id="totalAmountWithShippingInvoice">৳0</span></td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td colspan="3" class="text-right">Paid Amount</td>
                                                        <td><span class="float-right"
                                                                id="collectedPaymentInvoice">৳0</span></td>
                                                    </tr> --}}
                                                    {{-- <tr>
                                                        <td colspan="3" class="text-right">Payment Due</td>
                                                        <td><span class="float-right" id="paymentDueInvoice">৳0</span>
                                                        </td>
                                                    </tr> --}}
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div id="spaceDiv">
                                            <div
                                                style="display: flex;justify-content: space-between; margin-top: 50px;">
                                                <div>
                                                    <p
                                                        style="border-bottom: 1px solid #000;font-size: 16px; width: 100px;  color: #000;">
                                                        Received By</p>
                                                </div>
                                                <div class="authorSign">
                                                    <p
                                                        style="border-bottom: 1px solid #000;font-size: 16px; width: 130px;color: #000;">
                                                        Yours Sincerely</p>
                                                    <p
                                                        style="font-size: 16px; width: 130px;color: #000; text-align: center; line-height: 16px;">
                                                        Automart</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <p
                                                style="border-bottom: 1px solid #000;font-size: 16px;color: black; width: 75px;margin-top: 60px;">
                                                Remarks</p>
                                            <p style="font-size: 16px;color: black;">
                                                <span id="addRemarks" style="font-size: 14px !important;"></span>
                                            </p>
                                        </div>
                                        <div class="row no-print">
                                            <div class="col-lg-12">
                                                <div class="float-sm-right">
                                                    <a href="javascript:void(0)" id="previewBtn"
                                                        class="btn btn-primary m-1"
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




    <div class="modal fade" id="modal-shipment" style="display: none;" aria-hidden="true" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title" style="font-size: 18px;">Direct Shipment Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="directShipmentAssignForm">
                        <div class="col-md-12">
                            <select class="form-control" name="team_leader" id="team_leader" required>
                                <option value="">--SELECT Team Leader--</option>

                                @foreach ($teamLeaders as $leader)
                                    <option value="{{ $leader->user->id }}">
                                        {{ $leader->user->first_name . ' ' . $leader->user->last_name }}</option>
                                @endforeach

                            </select>
                        </div><br>

                        <div class="col-md-12">
                            <select class="form-control" name="deliveryman" id="deliveryMan" required>
                                <option value="">--SELECT Deliveryman--</option>
                                @foreach ($deliveryMan as $man)
                                    <option value="{{ $man->user->id }}">
                                        {{ $man->user->first_name . ' ' . $man->user->last_name }}</option>
                                @endforeach
                            </select>
                        </div><br>

                        <div class="col-md-12">
                            <label>Deadline Date</label>
                            <input type="date" class="form-control" name="date" required>
                            <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">
                        </div><br>

                        <div class="col-md-12">
                            <label>Time</label>
                            <input type="time" class="form-control" name="deadlineTime" required>
                        </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save </button>  
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-approve" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title" style="font-size: 18px;">Delivery Approve Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="orderApproveForm">
                        <div class="col-md-12">
                            <select class="form-control" name="team_leader_id" id="team_leader_id" required>
                                <option value="">--SELECT Team Leader--</option>
    
                                @foreach($teamLeaders as $leader)
                                <option value="{{$leader->user->id}}">{{$leader->user->first_name." ".$leader->user->last_name}}</option>
                                @endforeach
    
                            </select>
                        </div><br>
    
                        <div class="col-md-12">
                            <label>Deadline Date</label>
                            <input type="date" class="form-control" name="date" required>
                            <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">
                        </div><br>
    
                        <div class="col-md-12">
                            <label>Time</label>
                            <input type="time" class="form-control" name="deadlineTime" required>
                        </div>
    
    
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-pickup" style="display: none;" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title" style="font-size: 18px;">Pickup Approve Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="pickupApproveForm">
                        <input type="hidden" class="form-control" value="{{ $order->id }}" name="order_id">

                        <div class="col-md-12">
                            <select class="form-control" name="team_leader_id" id="team_leader_id" required>
                                <option value="">--SELECT Team Leader--</option>

                                @foreach ($teamLeaders as $leader)
                                    <option value="{{ $leader->user->id }}">
                                        {{ $leader->user->first_name . ' ' . $leader->user->last_name }}</option>
                                @endforeach

                            </select>
                        </div><br>

                        <div class="col-md-12">
                            <label>Pickup Date</label>
                            <input type="date" class="form-control" name="pickupDate" required>
                        </div><br>

                        <div class="col-md-12">
                            <label>Pickup Time</label>
                            <input type="time" class="form-control" name="pickupTime" required> 
                        </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save </button>
                </div>
                </form>
            </div>
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

    <link rel="stylesheet" href="{{ asset('css/invoiceSearch.css') }}">
    <script>
        $(document).ready(function() {
            $(function() {
                $('#itemId').select2({
                    matcher: function(params, data) {
                        if ($.trim(params.term) === '') {
                            return data;
                        }

                        keywords = (params.term).split(" ");
                        for (var i = 0; i < keywords.length; i++) {
                            if (((data.text).toUpperCase()).indexOf((keywords[i])
                            .toUpperCase()) == -1 && ((data.id).toUpperCase()).indexOf((
                                    keywords[i]).toUpperCase()) == -1) {
                                return null;
                            }
                        }
                        return data;
                    }
                });
            });

            $("input[type=number]").on('wheel.disableScroll', function(e) {
                e.preventDefault();
            });
        })

        let selectedBarcodes = [];

        function printDiv(divName) {
            let check_shipping = $('#checkShipping').val();
            let check_dicount = $('#checkDiscount').val();
            // let collected_payment = $('#collectedPayment').val();
            console.log("check_shipping", check_shipping);
            console.log("check_dicount", check_dicount);
            // console.log("initilalAdvance", initialAdvancePayment);
            // console.log("collected_payment", collected_payment);
            if(check_shipping == 0){
                $('#shippingChargeInvoice').parent().parent()[0].remove();
            }
            if(check_dicount == 0){
                $('#discountAmountInvoice').parent().parent()[0].remove();
            }
            $('#maxiMizeMin').hide();
            $('#previewBtn').hide();
            $('.donwloadBtn').hide();
            $('#invoiceDiv').css("margin-top", "200px");
            $('#spaceDiv').css("margin-top", "400px");
            $('#dateFormat').append(`<span style="margin-left: 10px">` + $('#invoice_date').val() + ` </span>`);
            $('#invoice_date').hide();

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

        // let d = new Date();
        // let month = d.getMonth() + 1;
        // let day = d.getDate();
        // let year = d.getFullYear();
        // $('#dateFormat').append(`<p>Date: ${day}/${month}/${year} </p>`);

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

        //  autofill input in salesview

        function autoFill(val) {
            let mble_num = val;
            console.log('mble_num', mble_num)
            $.ajax({
                url: '{{ url('getUserDataToAutofill') }}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                    mble_num: mble_num
                },
                success: function(response) {

                    $('input[name="referral_method[]"]').prop('checked', false);
                    if (response.data.allUsers != null) {
                        $('#first_name').val(response.data.allUsers.first_name).attr("readonly", true);
                        $('#last_name').val(response.data.allUsers.last_name).attr("readonly", true);
                        $('#firstName').text(response.data.allUsers.first_name);
                        if (response.data.allUsers.last_name != null) {
                            $('#lastName').text(" " + response.data.allUsers.last_name);
                        }
                        $('#emailAddress').text(response.data.allUsers.email);
                        $('#company_name').val("");
                        $('#email').val(response.data.allUsers.email).attr("readonly", true);
                        $("#phone_number").val(response.data.allUsers.phone).attr("readonly", true);
                        $('#country').val(response.data.allUsers.country);
                        $('#district').val(response.data.allUsers.district);
                        $('#city').val(response.data.allUsers.city);
                        $('#thana').val(response.data.allUsers.thana);
                        $('#area').val(response.data.allUsers.area);
                        $('#road_no').val(response.data.allUsers.road_no);
                        $('#house_no').val(response.data.allUsers.house_no);
                        $('#flat_no').val(response.data.allUsers.flat_no);
                        $('#car_no').val(response.data.allUsers.car_no);
                        $('input[name="referral_method[]"]').prop("disabled", true);
                        $.each(response.data.referrals, function(index, value) {
                            $('input[name="referral_method[]"][value="' + value.referral_id + '"]')
                                .prop('checked', true);
                        });
                    } else {
                        $("#phone_number").attr("readonly", false);
                    }
                },
                error: function() {
                    alert("error");
                }
            });
        }

        let base_url = '{{ URL('/') }}';

        $(document).ready(function() {
            $('#selected_tbl_invoice').on("DOMSubtreeModified", function() {
                let checkDiscount = Number($('#checkDiscount').val());
                $('#discountAmountInvoice').text("৳" + checkDiscount);

                let checkShipping = Number($('#checkShipping').val());
                $('#shippingChargeInvoice').text("৳" + checkShipping);
                calculateTotal();
            });

            // sale
            $('#checkOut').on('click', () => {
                checkOut();
            });

            $('#checkDiscount').change(function() {
                let checkDiscount = Number($('#checkDiscount').val());
                $('#discountAmount').text("৳" + checkDiscount);
                $('#discountAmountInvoice').text("৳" + checkDiscount);

                calculateTotal();
                $('#checkDiscount').val(checkDiscount);
            });

            $('#checkShipping').change(function() {
                let checkShipping = Number($('#checkShipping').val());
                $('#shippingCharge').text("৳" + checkShipping);
                $('#shippingChargeInvoice').text("৳" + checkShipping);

                calculateTotal();
                $('#checkShipping').val(checkShipping);
            });

            // $('#collectedPayment').change(function() {
            //     let collectedPayment = Number($('#collectedPayment').val());
            //     $('#collectedPaymentInvoice').text("৳" + collectedPayment);
            //     $('#collectedPaymentOrderDetails').text("৳" + collectedPayment);

            //     let totalAmount = Number($('#totalAmountWithShipping').text().split('৳')[1]);
            //     let paymentDue = totalAmount - collectedPayment;
            //     $('#paymentDueOrderDetails').text('৳' + paymentDue);
            //     $('#paymentDueInvoice').text('৳' + paymentDue);

            //     calculateTotal();
            // });

            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: false
            });

        });


        $(document).on('change', '.product_unit_price', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let unit_price_value = Number($(this).val());
            let item_id = $(this).parent().attr('data-item-id');
            let item_regular_price = Number($(this).parent().attr('data-item-regular-price'));

            if (unit_price_value < 0) {
                alertify.error("Price cannot be negative!!");
                $(this).val(item_regular_price);
            } else {
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
        $('[name="barcode"]').keyup(function(e) {
            let input_length = $(this).val().length;
            if (input_length >= barcode_length && (e.keyCode == 13 || e.keyCode == 86)) {
                barcode = e.target.value;
                if (!selectedBarcodes.includes(barcode)) {
                    $.ajax({
                        url: '{{ URL('itemSearchByBarcode') }}',
                        type: 'POST',
                        data: {
                            barcode: barcode
                        },
                        success: response => {
                            if (response.status === true) {
                                if (response.data.stockData.quantity == 0) {
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

                                    </tr>`)
                                    alertify.success("Item added!");
                                }
                            } else {
                                $('#barcode').val('');
                                alertify.error(response.message);
                            }

                        },
                        error: function(jqXHR, exception) {
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
                } else {
                    alertify.error("Product already in the list!");
                    $('#barcode').val('');
                }
            }
        });

        function selectProduct(purchaseData) {
            const splitedPurchaseData = purchaseData.split(',');
            purchaseItemBarcodeId = splitedPurchaseData[0];
            barcode = splitedPurchaseData[1];

            if (!selectedBarcodes.includes(barcode)) {
                $.ajax({
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        purchaseItemBarcodeId: purchaseItemBarcodeId
                    },
                    url: '{{ URL('/getProductByPurchaseItemBarcodeId') }}',
                    success: response => {
                        if (response.status) {
                            if (response.data.stockData.quantity == 0) {
                                alertify.error("Item Stock Out!");
                            } else {
                                selectedBarcodes.push(barcode);
                                let purchaseItemBarcodeData = response.data.purchaseItemBarcodeData;
                                let itemData = response.data.itemData;
                                let stockData = response.data.stockData;
                                console.log(stockData.quantity);

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
                                            type="text" class="form-control w-50 d-inline-block" value="1" readonly>
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

                                </tr>`)
                                alertify.success("Item added!");
                            }
                        }
                    },
                    error: err => {
                        alertify.error(err);
                    }
                });
            } else {
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

        function removeItem(itemId, itemBarcode) {
            let item_id = `#item_${itemId}`;
            let item_invoice_id = `#item_invoice_${itemId}`;
            if ($(item_id).remove() && $(item_invoice_id).remove()) {
                alertify.error('Item removed!');
            }
            let index = selectedBarcodes.indexOf(itemBarcode);
            if (index > -1) {
                selectedBarcodes.splice(index, 1);
            }
        }

        function increaseItemCount(id, stock_quantity) {
            console.log("stock_quantity", stock_quantity);
            let amount = Number($("#item_" + id + "_regular_price").val());
            let item_id = `#item_${id}_count`;
            let item_invoice_id = `#item_invoice_${id}_count`;

            let present_count = Number($(item_id).val());
            let present_total = Number($(`#item_${id}_total`).html());
            let total = Number($(`#item_${id}_total`).html());

            present_count += 0.25;
            present_count = present_count.toFixed(2);
            if (present_count > stock_quantity) {
                console.log("can not be greater than stock");
            } else {
                $(item_id).val(present_count);
                $(item_invoice_id).html(present_count);

                total += amount;
                let increaseTotal = amount * $(item_id).val();
                $(`#item_${id}_total`).html(increaseTotal.toFixed(2));
                $(`#item_invoice_${id}_total`).html("৳" + increaseTotal.toFixed(2));
                // $(`#item_${id}_total`).html(amount * $(item_id).val());
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
                let decreaseTotal = amount * $(item_id_count).val();
                $(`#item_${id}_total`).html(decreaseTotal.toFixed(2));
                $(`#item_invoice_${id}_total`).html("৳" + decreaseTotal.toFixed(2));

            }
        }

        function changeTotal(price, thisId, target) {
            let count = $(`#${thisId}`).val();
            if (count <= 0) {
                $(`#${thisId}`).val("0");
                $(`#${target}`).text("0");
            }
            let total = (price * count);
            $(`#${target}`).text(total.toFixed(2));
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
            let discount = Number($('#discountAmount').text().split('৳')[1]);
            // let paid_amount = Number($('#collectedPayment').val());

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


                grand_total = (subtotal + shipping) - discount;
                // let advance_payment = Number($('#advancePayment').text().split('৳')[1]);
                // grand_total -= advance_payment;


                // let payment_due = grand_total - paid_amount;

                $('#totalAmount').text(`৳${subtotal.toFixed(2)}`);
                $('#totalAmountWithShipping').text(`৳${grand_total.toFixed(2)}`);
                $('#totalAmountInvoice').text(`৳${subtotal.toFixed(2)}`);
                $('#totalAmountWithShippingInvoice').text(`৳${grand_total.toFixed(2)}`);
                // $('#collectedPaymentInvoice').text('৳' + paid_amount.toFixed(2));
                // $('#paymentDueInvoice').text('৳' + payment_due.toFixed(2));
                // $('#paymentDueOrderDetails').text('৳' + payment_due.toFixed(2));
            }
        }

        function getOrderDetail() {
            let orderDetail = {};
            let items_details_list = [];

            orderDetail['first_name'] = "<?php echo $order->first_name ?>";
            orderDetail['last_name'] = "<?php echo $order->last_name ?>";
            orderDetail['customer_name'] = $('#customer_name').val();
            orderDetail['phone_number'] = $('#phone_number').val();
            orderDetail['email'] = $('#email').val();
            orderDetail['country'] = $('#country').val();
            orderDetail['district'] = $('#district').val();
            orderDetail['city'] = $('#city').val();
            orderDetail['thana'] = $('#thana').val();
            orderDetail['area'] = $('#area').val();
            orderDetail['road_no'] = $('#road_no').val();
            orderDetail['house_no'] = $('#house_no').val();
            orderDetail['flat_no'] = $('#flat_no').val();
            orderDetail['shippingChargeApplied'] = Number($('#checkShipping').val());
            orderDetail['discountAmount'] = Number($('#checkDiscount').val());
            orderDetail['totalAmount'] = Number($('#totalAmount').text().split('৳')[1]);
            orderDetail['totalAmountWithShipping'] = Number($('#totalAmountWithShipping').text().split('৳')[1]);
            // orderDetail['paymentDue'] = Number($('#paymentDueOrderDetails').text().split('৳')[1]);
            // orderDetail['collectedPayment'] = Number($('#collectedPayment').val());
            // orderDetail['advancePayment'] = Number($('#advancePayment').text().split('৳')[1]);
            orderDetail['invoiceDate'] = $('#invoice_date').val();
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
            console.log('orderDetail ---majharul', orderDetail);

            return orderDetail;
        }

        function checkOut() {
            alertify.confirm("Are You Sure To Submit This?",
                function() {
                    // $('#preloader').modal('show');
                    let payment_method = $("input[class='radio']:checked").val();
                    let highlights = $("input[name='highlights']:checked").val();
                    let referral_method = [];
                    $('input[name="referral_method[]"] ').each(function() {
                        if (this.checked) {
                            referral_method.push($(this).val());
                        }
                    });
                    const data= {
                            orderDetail: getOrderDetail(),
                            payment_method: payment_method,
                            referral_method: referral_method,
                            highlights: highlights
                        }
                    console.log('data ---majharul', data);

                    // $.ajax({
                    //     url: '{{ URL('salesInsert') }}',
                    //     type: 'POST',
                    //     data: {
                    //         orderDetail: getOrderDetail(),
                    //         payment_method: payment_method,
                    //         referral_method: referral_method,
                    //         highlights: highlights
                    //     },
                    //     success: data => {
                    //         console.log("success data", data);
                    //         $('#preloader').modal('hide');

                    //         if (data.message == "Sale completed successfully") {

                    //             alertify.success(data.message);
                    //             printDiv('invoiceElement');
                    //             $('#firstName').text('');
                    //             $('#emailAddress').text('');
                    //             $('#phone').text('');
                    //         } else if (data.status == false) {
                    //             alertify.error("<span class='text-white'>Please Select Item!</span>");
                    //         } else {
                    //             if (typeof data == 'object') {
                    //                 alertify.error(
                    //                     "<span class='text-white'>An error occured! Please check your input!</span>"
                    //                 );
                    //                 $.each(data, (k, v) => {
                    //                     if (k == 'errors') {
                    //                         $.each(v, (key, val) => {
                    //                             setTimeout(() => {
                    //                                 alertify.error(
                    //                                     `<span class='text-white'>${val[0]}</span>`
                    //                                 );
                    //                             }, 1000);
                    //                         });
                    //                     }
                    //                 });
                    //             }
                    //         }
                    //     },
                    //     error: function(jqXHR, exception) {
                    //         $('#preloader').modal('hide');
                    //         var msg = '';
                    //         if (jqXHR.status === 0) {
                    //             msg = 'Not connect.Verify Network.';
                    //             alertify.warning(msg);

                    //         } else if (jqXHR.status == 404) {
                    //             msg = 'Requested page not found. [404]';
                    //             alertify.warning(msg);
                    //         } else if (jqXHR.status == 500) {
                    //             msg = 'Internal Server Error [500].';
                    //             alertify.warning(msg);
                    //         } else if (exception === 'parsererror') {
                    //             msg = 'Requested JSON parse failed.';
                    //             alertify.warning(msg);
                    //         } else if (exception === 'timeout') {
                    //             msg = 'Time out error.';
                    //             alertify.warning(msg);
                    //         } else if (exception === 'abort') {
                    //             msg = 'Ajax request aborted.';
                    //             alertify.warning(msg);
                    //         } else {
                    //             msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    //             alertify.warning(msg);
                    //         }
                    //     }
                    // });
                },
                function() {
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');
        }

        function shipmentOrder() {
            event.preventDefault();
            const tbody = document.getElementById("selected_tbl");
            const trCount = tbody.querySelectorAll("tr").length;
            if(trCount == 0){
                alertify.error("<span class='text-white'>Please Select Item!</span>");
            }
            else{
                $('#modal-shipment').modal('show');
            }        
        }

        function orderApproved() {
            event.preventDefault();
            const tbody = document.getElementById("selected_tbl");
            const trCount = tbody.querySelectorAll("tr").length;
            if(trCount == 0){
                alertify.error("<span class='text-white'>Please Select Item!</span>");
            }
            else{
                $('#modal-approve').modal('show');
            }            
        }

        function pickupApproved() {
            event.preventDefault();
            const tbody = document.getElementById("selected_tbl");
            const trCount = tbody.querySelectorAll("tr").length;
            if(trCount == 0){
                alertify.error("<span class='text-white'>Please Select Item!</span>");
            }
            else{
                $('#modal-pickup').modal('show');
            }
        }

        $(document).ready(function(){

            //Direct Shipment Assign Ajax
            $("#directShipmentAssignForm").submit(function(event){
                event.preventDefault();
                alertify.confirm('Are You Sure ?', 'Delivery man will be assigned.', function() {
                    $('#modal-shipment').modal('hide');
                    $('#preloader').modal('show');
                    let orderDetail = JSON.stringify(getOrderDetail());
                    let highlights = $("input[name='highlights']:checked").val();
                    let paymentMethod = $("input[class='radio']:checked").val();
                    let referralMethod = [];
                    $('input[name="referral_method[]"] ').each(function() {
                        if (this.checked) {
                            referralMethod.push($(this).val());
                        }
                    });

                    $.ajax({
                        type: 'post',
                        url: '{{ URl('directShipmentAssignAjax') }}',
                        data: $('#directShipmentAssignForm').serialize() + "&orderDetail=" + encodeURIComponent(orderDetail) + 
                                "&highlights=" + highlights + "&paymentMethod=" + paymentMethod + "&referralMethod=" + referralMethod,
                        dataType: 'json',
                        success: function(data) {
                            
                            if (typeof data.errors !== 'undefined') {
                                $.each(data.errors, function(propName, propVal) {
                                    alertify.error(propVal[0]);
                                });
                                $('#preloader').modal('hide');

                            } else {
                                $('#directShipmentAssignForm').trigger('reset');

                                alertify.success(data);
                                setTimeout(function() {
                                    location.replace(document.referrer);
                                }, 1000)
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

                }, function() {
                    alertify.error('Cancel')
                });

            });


            //Order Approve Ajax
            $("#orderApproveForm").submit(function(event){
                event.preventDefault();
                alertify.confirm('Are You Sure ?', 'Team leader will be assigned.', function() {
                    $('#modal-approve').modal('hide');
                    $('#preloader').modal('show');
                    let orderDetail = JSON.stringify(getOrderDetail());
                    let paymentMethod = $("input[class='radio']:checked").val();
                    let highlights = $("input[name='highlights']:checked").val();
                    let referralMethod = [];
                    $('input[name="referral_method[]"] ').each(function() {
                        if (this.checked) {
                            referralMethod.push($(this).val());
                        }
                    });
                    
                    $.ajax({
                        type: 'post',
                        url: '{{ URl('orderApproveAjax') }}',
                        data: $('#orderApproveForm').serialize() + "&orderDetail=" + encodeURIComponent( orderDetail ) + 
                                "&highlights=" + highlights + "&paymentMethod=" + paymentMethod + "&referralMethod=" + referralMethod,
                        dataType: 'json',
                        success: response => {
                            if (response.status === true) {
                                $('#orderApproveForm').trigger('reset');

                                alertify.success(response.message);
                                setTimeout(function() {
                                    location.replace(document.referrer);
                                }, 1000)

                            } else if (response.status == false) {
                                alertify.error("<span class='text-white'>Please Select Item!</span>");

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

                }, function() {
                    alertify.error('Cancel')
                });

            });


            //Pickup Approve Ajax
            $("#pickupApproveForm").submit(function(event){
                event.preventDefault();
                alertify.confirm('Are You Sure ?', 'Team leader will be assigned.', function() {
                    $('#modal-pickup').modal('hide');
                    $('#preloader').modal('show');

                    let orderDetail = JSON.stringify(getOrderDetail());
                    let paymentMethod = $("input[class='radio']:checked").val();
                    let highlights = $("input[name='highlights']:checked").val();
                    let referralMethod = [];
                    $('input[name="referral_method[]"] ').each(function() {
                        if (this.checked) {
                            referralMethod.push($(this).val());
                        }
                    });

                    $.ajax({
                        type: 'post',
                        url: '{{ URl('pickupApproveAjax') }}',
                        data: $('#pickupApproveForm').serialize() + "&orderDetail=" + encodeURIComponent(
                                orderDetail) + "&highlights=" + highlights + "&paymentMethod=" +
                                paymentMethod + "&referralMethod=" + referralMethod,
                        dataType: 'json',
                        success: response => {
                            if (response.status === true) {
                                $('#pickupApproveForm').trigger('reset');

                                alertify.success(response.message);
                                setTimeout(function() {
                                    location.replace(document.referrer);
                                }, 1000)

                            } else if (response.status == false) {
                                alertify.error("<span class='text-white'>Please Select Item!</span>");

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

                }, function() {
                    alertify.error('Cancel')
                });
            });



        });



        // function deliveryManAssign(id) {
        //     event.preventDefault();
        //     alertify.confirm('Are You Sure ?', 'Delivery man will be assigned.', function() {
        //         // $('#preloader').modal('show');
        //         document.querySelector('.save_change_btn').disabled = true;
        //         let orderDetail = JSON.stringify(getOrderDetail());
        //         let highlights = $("input[name='highlights']:checked").val();
        //         let paymentMethod = $("input[class='radio']:checked").val();
        //         let referralMethod = [];
        //             $('input[name="referral_method[]"] ').each(function() {
        //                 if (this.checked) {
        //                     referralMethod.push($(this).val());
        //                 }
        //             });
        //         const data= $('#deliveryManAssign').serialize() + 
        //                     "&orderDetail=" + encodeURIComponent( orderDetail) + 
        //                     "&highlights=" + highlights + 
        //                     "&paymentMethod=" + paymentMethod + 
        //                     "&referralMethod=" + referralMethod;
        //         console.log('data ---deliveryManAssign', data);         
        //         // $.ajax({
        //         //     type: 'post',
        //         //     url: '{{ URl('orderApproveAjax') }}',
        //         //     data: $('#deliveryManAssign').serialize() + "&orderDetail=" + encodeURIComponent(
        //         //             orderDetail) + "&highlights=" + highlights + "&paymentMethod=" +
        //         //             paymentMethod + "&referralMethod=" + referralMethod,
        //         //     dataType: 'json',
        //         //     success: function(data) {
        //         //         if (typeof data.errors !== 'undefined') {
        //         //             $.each(data.errors, function(propName, propVal) {
        //         //                 alertify.error(propVal[0]);
        //         //             });
        //         //             $('#preloader').modal('hide');
        //         //         } else {
        //         //             $.ajax({
        //         //                 type: 'post',
        //         //                 url: '{{ URl('deliveryManAssignAjax') }}',
        //         //                 data: $('#deliveryManAssign').serialize(),
        //         //                 dataType: 'json',
        //         //                 success: function(data) {
        //         //                     $('#preloader').modal('hide');
        //         //                     // document.querySelector('.save_change_btn').disabled = false;
        //         //                     if (typeof data.errors !== 'undefined') {
        //         //                         $.each(data.errors, function(propName, propVal) {
        //         //                             alertify.error(propVal[0]);
        //         //                         });
        //         //                     } else {
        //         //                         $('#modal-shipment').modal('hide');
        //         //                         $('#deliveryManAssign').trigger('reset');
        //         //                         alertify.success(data);
        //         //                         setTimeout(function() {
        //         //                             location.replace(document.referrer);
        //         //                         }, 1000)
        //         //                     }
        //         //                 },
        //         //                 error: function(jqXHR, exception) {
        //         //                     $('#preloader').modal('hide');
        //         //                     var msg = '';
        //         //                     if (jqXHR.status === 0) {
        //         //                         msg = 'Not connect.Verify Network.';
        //         //                         alertify.warning(msg);
        //         //                     } else if (jqXHR.status == 404) {
        //         //                         msg = 'Requested page not found. [404]';
        //         //                         alertify.warning(msg);
        //         //                     } else if (jqXHR.status == 500) {
        //         //                         msg = 'Internal Server Error [500].';
        //         //                         alertify.warning(msg);
        //         //                     } else if (exception === 'parsererror') {
        //         //                         msg = 'Requested JSON parse failed.';
        //         //                         alertify.warning(msg);
        //         //                     } else if (exception === 'timeout') {
        //         //                         msg = 'Time out error.';
        //         //                         alertify.warning(msg);
        //         //                     } else if (exception === 'abort') {
        //         //                         msg = 'Ajax request aborted.';
        //         //                         alertify.warning(msg);
        //         //                     } else {
        //         //                         msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //         //                         alertify.warning(msg);
        //         //                     }
        //         //                 }
        //         //             });
        //         //         }
        //         //     },
        //         //     error: function(jqXHR, exception) {
        //         //         var msg = '';
        //         //         if (jqXHR.status === 0) {
        //         //             msg = 'Not connect.Verify Network.';
        //         //             alertify.warning(msg);
        //         //         } else if (jqXHR.status == 404) {
        //         //             msg = 'Requested page not found. [404]';
        //         //             alertify.warning(msg);
        //         //         } else if (jqXHR.status == 500) {
        //         //             msg = 'Internal Server Error [500].';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'parsererror') {
        //         //             msg = 'Requested JSON parse failed.';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'timeout') {
        //         //             msg = 'Time out error.';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'abort') {
        //         //             msg = 'Ajax request aborted.';
        //         //             alertify.warning(msg);
        //         //         } else {
        //         //             msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //         //             alertify.warning(msg);
        //         //         }
        //         //     }
        //         // });
        //     }, function() {
        //         alertify.error('Cancel')
        //     });
        // }



        // function teamLeaderAssign(id) {
        //     event.preventDefault();
        //     alertify.confirm('Are You Sure ?', 'Team leader will be assigned.', function() {
        //        // $('#preloader').modal('show');
        //         document.querySelector('.save_change_btn').disabled = true;
        //         let paymentMethod = $("input[class='radio']:checked").val();
        //         let highlights = $("input[name='highlights']:checked").val();
        //         let referralMethod = [];
        //         $('input[name="referral_method[]"] ').each(function() {
        //             if (this.checked) {
        //                 referralMethod.push($(this).val());
        //             }
        //         });
        //         let orderDetail = JSON.stringify(getOrderDetail());
        //         // const data= {
        //         //         orderDetail: getOrderDetail(),
        //         //         paymentMethod: paymentMethod,
        //         //         referralMethod: referralMethod,
        //         //         highlights: highlights
        //         //     }

        //         const data= $('#team_leader_assign_form').serialize() + "&orderDetail=" + encodeURIComponent(
        //                     orderDetail) + "&highlights=" + highlights + "&paymentMethod=" +
        //                     paymentMethod + "&referralMethod=" + referralMethod;
        //         console.log('data ---teamLeaderAssign', data); 
                
        //         // $.ajax({
        //         //     type: 'post',
        //         //     url: '{{ URl('teamLeaderAssignAjax') }}',
        //         //     data: $('#team_leader_assign_form').serialize() + "&orderDetail=" + encodeURIComponent(
        //         //             orderDetail) + "&highlights=" + highlights + "&paymentMethod=" +
        //         //             paymentMethod + "&referralMethod=" + referralMethod,
        //         //     dataType: 'json',
        //         //     success: function(data) {
        //         //         console.log(data);
        //         //         $('#preloader').modal('hide');
        //         //         if (typeof data.errors !== 'undefined') {
        //         //             console.log(typeof data.errors);

        //         //             $.each(data.errors, function(propName, propVal) {
        //         //                 alertify.error(propVal[0]);
        //         //             });

        //         //         } else {
        //         //             $('#team_leader_modal').modal('hide');
        //         //             $('#team_leader_assign_form').trigger('reset');
        //         //             alertify.success(data.message);

        //         //             setTimeout(function() {
        //         //                 location.replace(document.referrer);
        //         //             }, 1000)
        //         //         }
        //         //     },
        //         //     error: function(jqXHR, exception) {
        //         //         $('#preloader').modal('hide');
        //         //         var msg = '';
        //         //         if (jqXHR.status === 0) {
        //         //             msg = 'Not connect.Verify Network.';
        //         //             alertify.warning(msg);
        //         //         } else if (jqXHR.status == 404) {
        //         //             msg = 'Requested page not found. [404]';
        //         //             alertify.warning(msg);
        //         //         } else if (jqXHR.status == 500) {
        //         //             msg = 'Internal Server Error [500].';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'parsererror') {
        //         //             msg = 'Requested JSON parse failed.';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'timeout') {
        //         //             msg = 'Time out error.';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'abort') {
        //         //             msg = 'Ajax request aborted.';
        //         //             alertify.warning(msg);
        //         //         } else {
        //         //             msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //         //             alertify.warning(msg);
        //         //         }
        //         //     }
        //         // });

        //     }, function() {
        //         alertify.error('Cancel')
        //     });
        // }

        // function pickupTeamLeaderAssign(id) {
        //     event.preventDefault();
        //     alertify.confirm('Are You Sure ?', 'Team leader will be assigned.', function() {
        //         // $('#preloader').modal('show');
        //         document.querySelector('.save_change_btn').disabled = true;
        //         let paymentMethod = $("input[class='radio']:checked").val();
        //         let highlights = $("input[name='highlights']:checked").val();
        //         let referralMethod = [];
        //         $('input[name="referral_method[]"] ').each(function() {
        //             if (this.checked) {
        //                 referralMethod.push($(this).val());
        //             }
        //         });
        //         let orderDetail = JSON.stringify(getOrderDetail());
        //         // const data= {
        //         //         orderDetail: getOrderDetail(),
        //         //         paymentMethod: paymentMethod,
        //         //         referralMethod: referralMethod,
        //         //         highlights: highlights
        //         //     }

        //         const data= $('#pickup_team_leader_assign_form').serialize() + "&orderDetail=" + encodeURIComponent(
        //                     orderDetail) + "&highlights=" + highlights + "&paymentMethod=" +
        //                     paymentMethod + "&referralMethod=" + referralMethod;
        //         console.log('data ---pickupTeamLeaderAssign', data); 

        //         // $.ajax({
        //         //     type: 'post',
        //         //     url: '{{ URl('pickupTeamLeaderAssignAjax') }}',
        //         //     data: $('#pickup_team_leader_assign_form').serialize() + "&orderDetail=" + encodeURIComponent(
        //         //             orderDetail) + "&highlights=" + highlights + "&paymentMethod=" +
        //         //             paymentMethod + "&referralMethod=" + referralMethod,
        //         //     dataType: 'json',
        //         //     success: function(data) {
        //         //         console.log(data);
        //         //         $('#preloader').modal('hide');
        //         //         if (typeof data.errors !== 'undefined') {
        //         //             console.log(typeof data.errors);

        //         //             $.each(data.errors, function(propName, propVal) {
        //         //                 alertify.error(propVal[0]);
        //         //             });

        //         //         } else {
        //         //             $('#pickup_team_leader_modal').modal('hide');
        //         //             $('#pickup_team_leader_assign_form').trigger('reset');
        //         //             alertify.success(data);
        //         //             setTimeout(function() {
        //         //                 location.replace(document.referrer);
        //         //             }, 1000)
        //         //         }
        //         //     },
        //         //     error: function(jqXHR, exception) {
        //         //         $('#preloader').modal('hide');
        //         //         var msg = '';
        //         //         if (jqXHR.status === 0) {
        //         //             msg = 'Not connect.Verify Network.';
        //         //             alertify.warning(msg);
        //         //         } else if (jqXHR.status == 404) {
        //         //             msg = 'Requested page not found. [404]';
        //         //             alertify.warning(msg);
        //         //         } else if (jqXHR.status == 500) {
        //         //             msg = 'Internal Server Error [500].';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'parsererror') {
        //         //             msg = 'Requested JSON parse failed.';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'timeout') {
        //         //             msg = 'Time out error.';
        //         //             alertify.warning(msg);
        //         //         } else if (exception === 'abort') {
        //         //             msg = 'Ajax request aborted.';
        //         //             alertify.warning(msg);
        //         //         } else {
        //         //             msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //         //             alertify.warning(msg);
        //         //         }
        //         //     }
        //         // });

        //     }, function() {
        //         alertify.error('Cancel')
        //     });
        // }

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


    </script>

@endsection

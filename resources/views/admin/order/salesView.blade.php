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

        .alertify-notifier .ajs-message.ajs-error{
            color: #fff !important;
            background: rgba(217, 92, 92, 0,95);
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
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
            max-height: 287px;
            overflow-y: auto;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
       }
      .autocomplete-items div {
        padding: 7px 8px;
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
                        <h5>Sales</h5>
                    </div>
                    <div class="card-body">
                        <form id="item_detail_form" action="">
                            <div class="form-group row">
                                <div class="col-sm-4 mb-3">
                                    <label for="input-10" class="col-form-label">First Name<span
                                            class="must">*</span></label>
                                    <!-- <input type="text" class="form-control" id="first_name" name="first_name"
                                           required="required" onkeyup="firstName(this.value)"> -->
                                           <input type="text" class="form-control" id="first_name" name="first_name"
                                        required="required" onkeyup="validateFirstName(this)">
                                        <small id="first_name_error" class="form-text text-danger" style="display:none">
                                            Please input letters </small>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        onkeyup="lastName(this.value)">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Phone Number<span
                                            class="must">*</span></label>
                                    <input autocomplete="off" type="text" class="form-control " id="phone_number" name="phone_number"
                                           required="required" onchange="autoFill(this.value)"
                                           onkeyup="phone(this.value)">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" required="required"
                                           onkeyup="emailHandler(this.value)">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">District</label>
                                    <input type="text" class="form-control" id="district" name="district">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Thana</label>
                                    <input type="text" class="form-control" id="thana" name="thana">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Area</label>
                                    <input type="text" class="form-control" id="area" name="area">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Road No</label>
                                    <input type="text" class="form-control" id="road_no" name="road_no">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">House No</label>
                                    <input type="text" class="form-control" id="house_no" name="house_no">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Flat No</label>
                                    <input type="text" class="form-control" id="flat_no" name="flat_no">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Car Number</label>
                                    <input type="text" class="form-control" id="car_no" name="car_no">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Order Notes</label>
                                    <textarea class="form-control" rows="2" id="order_notes" name="order_notes"
                                              spellcheck="true"></textarea>
                                </div>
                                {{-- <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Customer Notes</label>
                                    <textarea class="form-control" rows="2" id="customer_notes" name="customer_notes"
                                              spellcheck="true" onkeyup="customerNotes(this.value)"></textarea>
                                </div> --}}
                                <div class="col-sm-4 mb-3">
                                    <label for="input-11" class="col-form-label">Remarks</label>
                                    <textarea class="form-control" rows="2" id="remarks" name="remarks"
                                              spellcheck="true" onkeyup="addRemarks(this.value)"></textarea>
                                </div>

                                <input type="hidden" name="hiddenBookingId" value="0" id="hiddenBookingId">


                                <div class="clearfix"></div>
                                <div class="col-lg-12 pt-4">
                                    <label class="col-form-label">How Did You Hear About AUTOMART?</label>
                                    <br/>
                                    @foreach ($referrals as $referral)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="referral_method[]"
                                                   value="{{ $referral->id }}"
                                                {{-- @foreach (@$customerreferrals as $ref)
                                                    @if ($ref->referral_id == $referral->id) checked @endif
                                                @endforeach --}}
                                            >
                                            <label class="form-check-label">{{ $referral->referral_method }}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-lg-12 pt-4">
                                    <label for="">Booking List (Select a booking)</label>
                                    <select class="valid js-select2" id="bookingId" name="booking"
                                            onchange="selectBooking(this.value)" required="" aria-invalid="false">
                                        <option value="">Select Booking</option>
                                        @foreach ($bookingData as $booking)
                                            <option value="{{ $booking->id }}">#0303{{ $booking->id }}</option>
                                        @endforeach
                                    </select>
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
                                    class="float-right" id="totalAmount">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b> <span
                                    class="float-right" id="shippingCharge">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Discount (In amount) :</b> <span
                                    class="float-right" id="discountAmount">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Advance Payment :</b> <span
                                    class="float-right" id="advancePayment">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span
                                    class="float-right"
                                    id="totalAmountWithShipping">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Paid Amount :</b> <span
                                    class="float-right"
                                    id="collectedPaymentOrderDetails">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Payment Due :</b> <span
                                    class="float-right"
                                    id="paymentDueOrderDetails">৳0</span></li>
                        </ul>
                        <div class="form-group">
                            <label for="shippingCharge">Shipping Charge</label>
                            <input type="number" class="form-control" name="checkShipping" value="0" id="checkShipping" min="0"
                                   placeholder="shipping charge">
                        </div>
                        <div class="form-group">
                            <label for="checkDiscount">Discount</label>
                            <input type="number" class="form-control" name="checkDiscount" id="checkDiscount" value="0" min="0"
                                   placeholder="Discount amount">
                        </div>
                        <div class="form-group">
                            <label for="collectedPayment">Collected Payment</label>
                            <input type="number" class="form-control" name="collectedPayment" value="0" id="collectedPayment"
                                   min="0"
                                   required placeholder="Collected Payment">
                        </div>

                        <div class="mx-auto my-3">
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
                        </div>

                        <div class="mx-auto my-3">
                            <div class="col-lg-12 pt-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="highlights" value="1">
                                    <label class="form-check-label">highlight</label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <input type="text" class="form-control" name="remarks" id="remarks" required placeholder="Add Remarks" onkeyup="remarks(this.value)">
                        </div> --}}

                        <button id="checkOut"
                                class="btn btn-secondary btn-round waves-effect waves-light m-1 shadow btn-block">Sale
                        </button>
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
                                                <div style="display: flex;justify-content: space-between;align-items: center; margin-bottom: 10px">
                                                    <h3 style="color: #3989c6;font-size: 14px;padding-top: 10px;" id="dateFormat">DATE:</h3>
                                                    <input type="date" class="form-control" id="invoice_date"
                                                           name="invoice_date" required max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" style="margin-left: 10px;">
                                                </div>

                                                <h3 style="color: #3989c6;font-size: 14px; line-height: 18px">INVOICE TO:</h3>
                                                <p style="font-size: 11px;color: black;">Name - <span
                                                        id="firstName"></span> <span
                                                        id="lastName"></span></p>
                                                <p style="font-size: 11px;color: black;">Contact Number - <span
                                                        id="phone"></span></p>
                                                <p style="font-size: 11px;color: black;">Email - <span
                                                        id="emailAddress"></span></p>

                                            </div>
                                            <div class="address-shop">
                                                <h3 style="color: #3989c6;font-size: 14px;line-height: 18px">INVOICE
                                                    #0202{{$lastInsertedRow['id'] + 1}}</h3>

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

                                                </tbody>
                                                </tbody>
                                                <tfoot class="invoice_footer">
                                                <tr>

                                                    <td colspan="3" class="text-right">Sub Total</td>
                                                    <td><span class="float-right" id="totalAmountInvoice">৳0</span></td>
                                                </tr>
                                                <tr>

                                                    <td colspan="3" class="text-right">Shipping</td>
                                                    <td><span class="float-right" id="shippingChargeInvoice">৳0</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-right">Discount</td>
                                                    <td><span class="float-right" id="discountAmountInvoice">৳0</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-right">Advance Payment</td>
                                                    <td><span class="float-right" id="advancePaymentInvoice">৳0</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-right">Grand Total</td>
                                                    <td><span class="float-right"
                                                              id="totalAmountWithShippingInvoice">৳0</span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-right">Paid Amount</td>
                                                    <td><span class="float-right"
                                                              id="collectedPaymentInvoice">৳0</span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-right">Payment Due</td>
                                                    <td><span class="float-right"
                                                              id="paymentDueInvoice">৳0</span></td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div>
                                            <p style="border-bottom: 1px solid #000;font-size: 16px;color: black; width: 75px;margin-top: 15px;">Remarks</p>
                                            <p style="font-size: 16px;color: black;">
                                                <span id="addRemarks" style="font-size: 14px !important;"></span>
                                            </p>
                                        </div>

                                        <div id="spaceDiv">
                                            <div
                                                style="display: flex;justify-content: space-between; margin-top: 60px;">
                                                <div>
                                                    <p style="border-bottom: 1px solid #000;font-size: 16px; width: 100px;  color: #000;">
                                                        Received By</p>
                                                </div>
                                                <div class="authorSign">
                                                    <p style="border-bottom: 1px solid #000;font-size: 16px; width: 130px;color: #000;">
                                                        Yours Sincerely</p>
                                                    <p style="font-size: 16px; width: 130px;color: #000; text-align: center; line-height: 16px;">
                                                        Automart</p>
                                                </div>
                                            </div>
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

    <link rel="stylesheet" href="{{asset('css/invoiceSearch.css')}}">
    <script>
        let initialAdvancePayment = 0;
        $(document).ready(function(){
            $(function () {
                $('#itemId').select2({
                    matcher: function (params, data) {
                        if ($.trim(params.term) === '') {
                            return data;
                        }

                        keywords=(params.term).split(" ");
                        for (var i = 0; i < keywords.length; i++) {
                            if (((data.text).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1 && ((data.id).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1){
                                return null;
                            }
                        }
                        return data;
                    }
                });
            });

            $("input[type=number]").on('wheel.disableScroll', function (e) {
                    e.preventDefault();
                });
        })

        let selectedBarcodes = [];

        function printDiv(divName) {
            let check_shipping = $('#checkShipping').val();
            let check_dicount = $('#checkDiscount').val();
            let collected_payment = $('#collectedPayment').val();
            console.log("check_shipping", check_shipping);
            console.log("check_dicount", check_dicount);
            console.log("initilalAdvance", initialAdvancePayment);
            console.log("collected_payment", collected_payment);
            if(check_shipping == 0){
                $('#shippingChargeInvoice').parent().parent()[0].remove();
            }
            if(check_dicount == 0){
                $('#discountAmountInvoice').parent().parent()[0].remove();
            }
            if(initialAdvancePayment == 0){
                $('#advancePaymentInvoice').parent().parent()[0].remove();
            }
            if(collected_payment == 0){
                $('#collectedPaymentInvoice').parent().parent()[0].remove();
            }
            $('#maxiMizeMin').hide();
            $('#previewBtn').hide();
            $('.donwloadBtn').hide();
            $('#invoiceDiv').css("margin-top", "200px");
            $('#spaceDiv').css("margin-top", "400px");
            $('#dateFormat').append(`<span style="margin-left: 10px">`+$('#invoice_date').val()+` </span>`);
            $('#invoice_date').hide();

            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            setTimeout(function () {
                location.reload();
            }, 1000);
        }

        // function firstName(val) {
        //     $('#firstName').text(val);
        // }

        function validateFirstName(inputElement) {
    var value = inputElement.value;
    var errorMessage = document.getElementById('first_name_error');

    
    var validNamePattern = /^[A-Za-z. ]+$/;

    
    if (!validNamePattern.test(value)) {
        errorMessage.style.display = 'block';  
    } else {
        errorMessage.style.display = 'none';  
    }
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
            console.log('mble_num',mble_num)
            $.ajax({
                url: '{{ url('getUserDataToAutofill') }}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                    mble_num: mble_num
                },
                success: function (response) {

                    $('input[name="referral_method[]"]').prop('checked', false);
                    if (response.data.allUsers != null) {
                        $('#first_name').val(response.data.allUsers.first_name).attr("readonly", true);
                        $('#last_name').val(response.data.allUsers.last_name).attr("readonly", true);
                        $('#firstName').text(response.data.allUsers.first_name);
                        if(response.data.allUsers.last_name != null){
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
                        $.each(response.data.referrals, function (index, value) {
                            $('input[name="referral_method[]"][value="' + value.referral_id + '"]').prop('checked', true);
                        });
                    } else {
                        $("#phone_number").attr("readonly", false);
                    }
                },
                error: function () {
                    alert("error");
                }
            });
        }

        let base_url = '{{ URL('/') }}';

        $(document).ready(function () {
            $('#selected_tbl_invoice').on("DOMSubtreeModified", function () {
                let checkDiscount = Number($('#checkDiscount').val());
                console.log("checkDiscount 1", checkDiscount);
                $('#discountAmountInvoice').text("৳" + checkDiscount);

                let checkShipping = Number($('#checkShipping').val());
                $('#shippingChargeInvoice').text("৳" + checkShipping);
                calculateTotal();
            });

            // sale
            $('#checkOut').on('click', () => {
                checking();
            });

            $('#checkDiscount').change(function () {
                let checkDiscount = Number($('#checkDiscount').val());
                console.log("checkDiscount 2", checkDiscount);


                $('#discountAmount').text("৳" + checkDiscount);
                $('#discountAmountInvoice').text("৳" + checkDiscount);

                calculateTotal();
                $('#checkDiscount').val(checkDiscount);
            });

            $('#checkShipping').change(function () {
                let checkShipping = Number($('#checkShipping').val());
                $('#shippingCharge').text("৳" + checkShipping);
                $('#shippingChargeInvoice').text("৳" + checkShipping);

                calculateTotal();
                $('#checkShipping').val(checkShipping);
            });

            $('#collectedPayment').change(function () {
                let collectedPayment = Number($('#collectedPayment').val());
                $('#collectedPaymentInvoice').text("৳" + collectedPayment);
                $('#collectedPaymentOrderDetails').text("৳" + collectedPayment);

                let totalAmount = Number($('#totalAmountWithShipping').text().split('৳')[1]);
                let paymentDue = totalAmount - collectedPayment;
                $('#paymentDueOrderDetails').text('৳' + paymentDue);
                $('#paymentDueInvoice').text('৳' + paymentDue);

                calculateTotal();
                $('#collectedPayment').val(collectedPayment);
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
        function selectBooking(id) {
            $.ajax({
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                url: '{{ URL("/getBookingInfoForSale") }}',
                success: response => {
                    $('input[name="referral_method[]"]').prop('checked', false).prop("disabled", true);
                    if (response.status === true) {
                        $("#first_name").val(response.data.bookingData.first_name).attr("readonly", true);
                        $("#last_name").val(response.data.bookingData.last_name).attr("readonly", true);
                        $("#phone_number").val(response.data.bookingData.phone_number).attr("readonly", true);
                        $("#email").val(response.data.bookingData.email).attr("readonly", true);
                        $("#country").val(response.data.bookingData.country);
                        $("#district").val(response.data.bookingData.district);
                        $("#city").val(response.data.bookingData.city);
                        $("#thana").val(response.data.bookingData.thana);
                        $("#area").val(response.data.bookingData.area);
                        $("#road_no").val(response.data.bookingData.road_no);
                        $("#house_no").val(response.data.bookingData.house_no);
                        $("#flat_no").val(response.data.bookingData.flat_no);
                        $("#car_no").val(response.data.bookingData.car_no);
                        $("#order_notes").val(response.data.bookingData.booking_notes);
                        // $("#customer_notes").val(response.data.bookingData.customer_notes);
                        $("#remarks").val(response.data.bookingData.remarks);
                        $('input[name="payment_method_id"][value="' + response.data.advancePaymentData.payment_method_id + '"]').prop('checked', true);
                        $.each(response.data.customerreferrals, function (index, value) {
                            $('input[name="referral_method[]"][value="' + value.referral_id + '"]').prop('checked', true);
                        });

                        //Loading products
                        let productsDiv = '';

                        $.each(response.data.bookingDetailsData, function (index, value) {
                            if(value.stocks.quantity == 0){
                                alertify.error("Item Stock Out!");
                            } else {
                                selectedBarcodes.push(value.purchase_item_barcodes.barcode);
                                productsDiv += `<tr id="item_${value.barcode_id}" data-price="${value.unit_price}">

                                        <td class="whiteSpace_normal" id="item_${value.barcode_id}_title">${value.product_detail.name}</td>
                                        <td class="whiteSpace_normal"><img src="${value.product_detail.thumbnail}" width="50" height="50"></td>
                                        <td class="whiteSpace_normal" style="text-align:center!important;">${value.stocks.quantity}</td>
                                        <td class="whiteSpace_normal" style="min-width: 200px;">
                                            <button class="btn btn-danger btn-sm text-white"
                                                onclick="decreaseItemCount(${value.barcode_id})"
                                                style="cursor: pointer;">-</button>
                                            <input id="item_${value.barcode_id}_count"
                                                onkeyup="changeTotal(${value.unit_price}, 'item_${value.barcode_id}_count', 'item_${value.barcode_id}_total')"
                                                type="text" class="form-control w-50 d-inline-block" value="${value.quantity}" readonly>
                                            <button class="btn btn-success btn-sm text-white"
                                                onclick="increaseItemCount(${value.barcode_id}, ${value.stocks.quantity})"
                                                style="cursor: pointer">+</button>
                                        </td>
                                        <td class="whiteSpace_normal" data-item-id="${value.barcode_id}" data-item-regular-price="${value.purchase_item_barcodes.regular_price}">
                                            Regular Price (BDT. ${value.purchase_item_barcodes.regular_price})
                                            <input type="number" name="product_unit_price" id="item_${value.barcode_id}_regular_price" class="form-control product_unit_price" min="${value.unit_price}" value="${value.unit_price}"
                                            onkeyup="setMinimumUnitPrice(${value.barcode_id})"
                                            />
                                            </td>
                                        <td class="whiteSpace_normal" style="text-align:center!important;" id="item_${value.barcode_id}_total">${value.unit_price * value.quantity}</td>
                                        <td class="whiteSpace_normal">
                                            <span onclick="removeItem(${value.barcode_id},'${value.purchase_item_barcodes.barcode}')" class="badge badge-danger py-3 px-2"
                                                style="cursor: pointer;min-width:45px">X</span>
                                        </td>
                                    </tr>`;
                                }
                        })

                        $('#selected_tbl').html(productsDiv);

                        //Loading calculation for top right portion
                        $('#shippingCharge').text("৳" + response.data.bookingData.shipping_amount);
                        $('#checkShipping').val(response.data.bookingData.shipping_amount);
                        $('#discountAmount').text("৳" + response.data.bookingData.discount_amount);
                        $('#checkDiscount').val(response.data.bookingData.discount_amount);
                        $('#advancePayment').text("৳" + response.data.advancePaymentData.paid_amount);
                        initialAdvancePayment=response.data.advancePaymentData.paid_amount;
                        $('#advancePaymentInvoice').text("৳" + response.data.advancePaymentData.paid_amount);

                        $('#hiddenBookingId').val(Number(response.data.bookingData.id));

                        //Loading calculation for bottom right invoice
                        $("#firstName").text(response.data.bookingData.first_name);
                        $("#lastName").text(response.data.bookingData.last_name);
                        $("#phone").text(response.data.bookingData.phone_number);
                        $("#emailAddress").text(response.data.bookingData.email);
                        $("#addRemarks").text(response.data.bookingData.remarks);

                        let invoiceDiv = '';
                        $.each(response.data.bookingDetailsData, function (index, value) {
                            invoiceDiv += `<tr id="item_invoice_${value.barcode_id}" data-price="${value.unit_price}">
                                    <td class="whiteSpace_normal" id="item_invoice_${value.barcode_id}_title">${value.product_detail.name}</td>
                                    <td class="whiteSpace_normal" id="item_invoice_${value.barcode_id}_count">${value.quantity}</td>
                                    <td class="whiteSpace_normal" id="item_invoice_${value.barcode_id}_unit_price">৳${value.unit_price}</td>
                                    <td class="whiteSpace_normal" id="item_invoice_${value.barcode_id}_total">৳${value.quantity * value.unit_price}</td>
                                </tr>`
                        });

                        $('#selected_tbl_invoice').html(invoiceDiv);

                        $('#totalAmountWithShipping').text("৳" + response.data.advancePaymentData.payable_amount);
                        $('#totalAmountWithShippingInvoice').text("৳" + response.data.advancePaymentData.payable_amount);
                        calculateTotal();
                    }
                },
                error: err => {
                    alertify.error(err);
                }
            });
        }

        $(document).on('change', '.product_unit_price', function (e) {
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

                // Call calculateTotal() for the calculation of the top right Order Details portion and invoice
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
                                        <td class="whiteSpace_normal"><img src="${itemData.thumbnail}" width="50" height="50"></td>
                                        <td class="whiteSpace_normal" style="text-align:center!important;">${stockData.quantity}</td>
                                        <td class="whiteSpace_normal" style="min-width: 200px;">
                                            <button class="btn btn-danger btn-sm text-white"
                                                onclick="decreaseItemCount(${barcodeData.id})"
                                                style="cursor: pointer;">-</button>
                                            <input id="item_${barcodeData.id}_count"
                                                onkeyup="changeTotal(${barcodeData.sales_price}, 'item_${barcodeData.id}_count', 'item_${barcodeData.id}_total')"
                                                type="text" class="form-control w-50 d-inline-block" value="${stockData.quantity < 1 ? Number(stockData.quantity).toFixed(2) : 1}" readonly>
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
                                                style="cursor: pointer;min-width:45px">X
                                            </span>
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
                            console.log(stockData.quantity);
                            // let pArray = [];
                            // let pCount = response.data.itemData.id;
                            // pArray.push(...pArray, pCount);
                            // checking(pArray);
                            

                                $('#selected_tbl').append(`<tr id="item_${purchaseItemBarcodeId}" data-price="${purchaseItemBarcodeData.sales_price}">

                                    <td class="whiteSpace_normal" id="item_${purchaseItemBarcodeId}_title">${itemData.name}</td>
                                    <td class="whiteSpace_normal"><img src="${itemData.thumbnail}" width="50" height="50"></td>
                                    <td class="whiteSpace_normal" style="text-align:center!important;">${stockData.quantity}</td>
                                    <td class="whiteSpace_normal" style="min-width: 200px;">
                                        <button class="btn btn-danger btn-sm text-white"
                                            onclick="decreaseItemCount(${purchaseItemBarcodeId})"
                                            style="cursor: pointer;">-</button>
                                        <input id="item_${purchaseItemBarcodeId}_count"
                                            onkeyup="changeTotal(${purchaseItemBarcodeData.sales_price}, 'item_${purchaseItemBarcodeId}_count', 'item_${purchaseItemBarcodeId}_total')"
                                            type="text" class="form-control w-50 d-inline-block" value="${stockData.quantity < 1 ? Number(stockData.quantity).toFixed(2) : 1}" readonly>
                                        <button class="btn btn-success btn-sm text-white"
                                            onclick="increaseItemCount(${purchaseItemBarcodeId}, ${stockData.quantity})"
                                            style="cursor: pointer">+</button>
                                    </td>
                                    <td class="whiteSpace_normal" data-item-id="${purchaseItemBarcodeId}" data-item-regular-price="${purchaseItemBarcodeData.regular_price}">
                                        <!--Regular Price (BDT. ${purchaseItemBarcodeData.regular_price})-->
                                        <input type="number" name="product_unit_price" id="item_${purchaseItemBarcodeId}_regular_price" class="form-control product_unit_price" min="${purchaseItemBarcodeData.sales_price}" value="${purchaseItemBarcodeData.sales_price}" onkeyup="setMinimumUnitPrice(${purchaseItemBarcodeId})"/>
                                    </td>
                                    <td class="whiteSpace_normal" style="text-align:center!important;" 
                                        id="item_${purchaseItemBarcodeId}_total">
                                        ${stockData.quantity < 1 
                                            ? purchaseItemBarcodeData.sales_price * stockData.quantity 
                                            : purchaseItemBarcodeData.sales_price}
                                    </td>
                                    <td class="whiteSpace_normal">
                                        <span onclick="removeItem(${purchaseItemBarcodeId},'${purchaseItemBarcodeData.barcode}')" class="badge badge-danger py-3 px-2"
                                            style="cursor: pointer;min-width:45px">X
                                        </span>
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
            console.log("stock_quantity", stock_quantity);
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
                $(item_invoice_id).html( present_count);

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
            let total = (price * count);
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


        //When Item table data changes: Triggers the calculation of the top right Order Details portion and invoice 
        function calculateTotal() {
            let subtotal = Number($('#totalAmount').text().split('৳')[1]);
            let shipping = Number($('#shippingCharge').text().split('৳')[1]);
            let discount = Number($('#discountAmount').text().split('৳')[1]);
            let paid_amount = Number($('#collectedPayment').val());

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
                let advance_payment = Number($('#advancePayment').text().split('৳')[1]);
                grand_total -= advance_payment;


                let payment_due = grand_total - paid_amount;

                $('#totalAmount').text(`৳${subtotal.toFixed(2)}`);
                $('#totalAmountWithShipping').text(`৳${grand_total.toFixed(2)}`);
                $('#totalAmountInvoice').text(`৳${subtotal.toFixed(2)}`);
                $('#totalAmountWithShippingInvoice').text(`৳${grand_total.toFixed(2)}`);
                $('#collectedPaymentInvoice').text('৳' + paid_amount.toFixed(2));
                $('#paymentDueInvoice').text('৳' + payment_due.toFixed(2));
                $('#paymentDueOrderDetails').text('৳' + payment_due.toFixed(2));
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
            orderDetail['shippingChargeApplied'] = Number($('#checkShipping').val());
            orderDetail['discountAmount'] = Number($('#checkDiscount').val());
            orderDetail['totalAmount'] = Number($('#totalAmount').text().split('৳')[1]);
            orderDetail['totalAmountWithShipping'] = Number($('#totalAmountWithShipping').text().split('৳')[1]);
            orderDetail['hiddenBookingId'] = Number($('#hiddenBookingId').val());
            orderDetail['paymentDue'] = Number($('#paymentDueOrderDetails').text().split('৳')[1]);
            orderDetail['collectedPayment'] = Number($('#collectedPayment').val());
            orderDetail['advancePayment'] = Number($('#advancePayment').text().split('৳')[1]);
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

            return orderDetail;
        }

        // Done by Dip 
        function checking(){
            let getOrderDetailChecking = getOrderDetail();
            let productListCount = getOrderDetailChecking.items_details_list.length;
            if(productListCount > 0){
                checkOut();
            }
            else{
                alertify.error("<span class='text-white'>Please Select Item!</span>");
            }
        }

        function checkOut() {
            alertify.confirm("Are You Sure To Submit This?",
                function () {
                    $('#preloader').modal('show');
                    let payment_method = $("input[class='radio']:checked").val();
                    let highlights = $("input[name='highlights']:checked").val();
                    let referral_method = [];
                    $('input[name="referral_method[]"] ').each(function () {
                        if (this.checked) {
                            referral_method.push($(this).val());
                        }
                    });

                    $.ajax({
                        url: '{{ URL('salesInsert') }}',
                        type: 'POST',
                        data: {
                            orderDetail: getOrderDetail(),
                            payment_method: payment_method,
                            referral_method: referral_method,
                            highlights: highlights
                        },
                        success: data => {
                            console.log("success data", data);
                            $('#preloader').modal('hide');

                            if (data.message == "Sale completed successfully") {

                                alertify.success(data.message);
                                printDiv('invoiceElement');
                                $('#firstName').text('');
                                $('#emailAddress').text('');
                                $('#phone').text('');
                            } else if (data.status == false) {
                                alertify.error("<span class='text-white'>Please Select Item!</span>");
                            } else {
                                if (typeof data == 'object') {
                                    alertify.error(
                                        "<span class='text-white'>An error occured! Please check your input!</span>"
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
                },
                function () {
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');
        }

    </script>

    {{--phone auto sugetion  --}}
    <script>
        function autoPhoneNumSuggetion(phoneInput) {
         let phoneNumList;

          var currentFocus;
          /*execute a function when someone writes in the text field:*/
          phoneInput.addEventListener('input', async function (e) {
            const res = await fetch('{{ url('/searchPhoneNumber') }}');
            const phoneNumList=await res.json();
            var a,
              b,
              i,
              val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
              return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement('DIV');
            a.setAttribute('id', this.id + 'autocomplete-list');
            a.setAttribute('class', 'autocomplete-items');
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            phoneNumList.map((num)=>{
               if (num.phone.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement('DIV');
                /*make the matching letters bold:*/
                b.innerHTML = '<strong>' + num.phone.substr(0, val.length) + '</strong>';
                b.innerHTML += num.phone.substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + num.phone + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener('click', function (e) {
                  /*insert the value for the autocomplete text field:*/
                phoneInput.value = this.getElementsByTagName('input')[0].value;
                autoFill(phoneInput.value);
                phone(phoneInput.value)
                closeAllLists();
                });
                a.appendChild(b);
              }
            })

          });
          /*execute a function presses a key on the keyboard:*/
          phoneInput.addEventListener('keydown', function (e) {
            var x = document.getElementById(this.id + 'autocomplete-list');
            if (x) x = x.getElementsByTagName('div');
            if (e.keyCode == 40) {
              /*If the arrow DOWN key is pressed,increase the currentFocus variable:*/
              currentFocus++;
              /*and and make the current item more visible:*/
              addActive(x);
            } else if (e.keyCode == 38) {
              //up
              /*If the arrow UP key is pressed,decrease the currentFocus variable:*/
              currentFocus--;
              /*and and make the current item more visible:*/
              addActive(x);
            } else if (e.keyCode == 13) {
              /*If the ENTER key is pressed, prevent the form from being submitted,*/
              e.preventDefault();
              if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
              }
            }
          });
          function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = x.length - 1;
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add('autocomplete-active');
          }
          function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
              x[i].classList.remove('autocomplete-active');
            }
          }
          function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,except the one passed as an argument:*/
            var x = document.getElementsByClassName('autocomplete-items');
            for (var i = 0; i < x.length; i++) {
              if (elmnt != x[i] && elmnt != phoneInput) {
                x[i].parentNode.removeChild(x[i]);
              }
            }
          }
          /*execute a function when someone clicks in the document:*/
          document.addEventListener('click', function (e) {
            closeAllLists(e.target);
          });
        }

        autoPhoneNumSuggetion(document.getElementById('phone_number'));
      </script>


@endsection

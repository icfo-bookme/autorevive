@extends('layouts.master')

@php
$shippingChargeAmount = $shippingCharge ? $shippingCharge->amount : 0;
@endphp
{{-- @section('title')
  HOME
@endsection --}}
@section('content')
    <style>
        .must {
            color: red;
            font-size: 15px;
            font-weight: bold
        }

    </style>
    {{-- @include('partials.navBar') --}}
    {{-- <div id="fullNav">

        @include('partials.navBar')
        @section('styles')
        <link href="{{asset('styles/check_out.css')}}" rel="stylesheet" type="text/css">

    @endsection


    <div> --}}
    @include('partials.header')

    @if (isset($anchor))
        <input type="hidden" name="anchor" id="anchor" value="{{ $anchor }}">
    @endif
    <style>
        .req {
            display: none;
        }

        .ctrlq.fb-button,
        .ctrlq.fb-close {
            /* position: fixed;
                right: 20px;
                bottom: 20px;
                cursor: pointer; */
            display: none !important;
        }

        .close-icon  {
            font-size: 15px;
            border: 1px solid #ebebeb;
            width: 20px;
            height: 20px;
            display: block;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
        }
        .close-icon:hover {
            background: #c70909;
            border-color: #c70909;
            color: #ffffff;
        }
        .custom-modal-content{
            border-radius: 5px !important;
        }

    </style>

    <!--================Checkout Area =================-->
    <section class=" section_gap">
        <div class="container">
            {{-- <div class="alert alert-success" id="alert" role="alert" style="visibility: hidden;">
        Your order has been accepted
      </div> --}}


            {{-- <div class="alert alert-danger" id="alert-item-problem" role="alert" style="visibility: hidden;">

      </div> --}}

            @if (Auth::user() != null)
                @php
                    $username = Auth::user()->first_name;
                    $lastname = Auth::user()->last_name;

                    $email = Auth::user()->email;
                    $phone = Auth::user()->phone;
                    $address = Auth::user()->address;
                    $country = Auth::user()->country;
                    $district = Auth::user()->district;
                    $city = Auth::user()->city;
                    $thana = Auth::user()->thana;
                    $area = Auth::user()->area;
                    $road_no = Auth::user()->road_no;
                    $house_no = Auth::user()->house_no;
                    $flat_no = Auth::user()->flat_no;
                @endphp
            @endisset

            <input type="hidden" name="shippingChargeAmount" id="shippingChargeAmount"
                value={{ $shippingChargeAmount }}>
            <div class="billing_details">
                <div class="row my-5">
                    {{-- @if (\Auth::check() == false) --}}
                    <div class="col-lg-5 mb-3">
                        <h3 class="checkout_form_heading">Billing Details</h3>
                        {{-- <button type="button" onclick="() => window.navigator.vibrate([1000]); alert('Vibrated!')">Click</button> --}}
                        <form class="row contact_form" action="#" method="post" id="checkoutForm">
                            <div class="col-md-6  mb-20 form-group p_star">
                                <label for="" class="custom__label">First Name <span
                                    class="must">*</span></label>
                                <input type="text" class="form-control" id="first_name" value="{{ @$username }}"
                                    name="first_name" required>
                                {{-- {{ isset($username) ? "value=$username`" : "" }} name="first_name" required> --}}
                            </div>
                            <div class="col-md-6 mb-20 form-group p_star">
                                <label for="" class="custom__label">Last Name <span
                                    class="must">*</span></label>
                                <input type="text" class="form-control" id="last_name" value="{{ @$lastname }}"
                                    name="last_name">
                            </div>
                            {{-- <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">Company Name</label>
                                <input type="text" class="form-control" id="company" name="company">
                            </div> --}}
                            <div class="col-md-6 mb-20 form-group p_star">
                                <label for="" class="custom__label">Phone Number<span
                                        class="must">*</span></label>
                                <input type="text" class="form-control" id="number" name="number" required
                                    onchange="autoFill(this.value)" value="{{ @$phone }}">
                                <span class="text-danger" id="numberErrMssg" style="display: none">Number is required</span>

                            </div>
                            <div class="col-md-6 mb-20 form-group p_star">
                                <label for="" class="custom__label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ @$email }}">
                            </div>
                            <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    value="{{ @$country }}">
                            </div>
                            <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">District</label>
                                <input type="text" class="form-control" id="district" name="district"
                                    value="{{ @$district }}">
                            </div>
                            <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    value="{{ @$city }}">
                            </div>
                            <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">Thana</label>
                                <input type="text" class="form-control" id="thana" name="thana"
                                    value="{{ @$thana }}">
                            </div>
                            <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">Area</label>
                                <input type="text" class="form-control" id="area" name="area"
                                    value="{{ @$area }}">
                            </div>
                            <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">Road no.</label>
                                <input type="text" class="form-control" id="road" name="road"
                                    value="{{ @$road_no }}">
                            </div>
                            <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">House no.</label>
                                <input type="text" class="form-control" id="house" name="house"
                                    value="{{ @$house_no }}">
                            </div>
                            <div class="col-md-6 mb-20 form-group">
                                <label for="" class="custom__label">Flat no.</label>
                                <input type="text" class="form-control" id="flat" name="flat"
                                    value="{{ @$flat_no }}">
                            </div>


                            <div class="col-md-12 form-group">
                                <label for="" class="custom__label">Order Notes</label>
                                <textarea class="form-control" name="notes" id="notes" rows="3" col="5"></textarea>
                            </div>
                        </form>
                    </div>
                    {{-- @endif --}}
                    <div class="col-lg-7 mb-3">
                        <div class="order_box" id="order_box">
                            <h3 class="checkout_form_heading">Your Order</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width:100%" id="orderTable">
                                    <tr>
                                        <th>Product</th>
                                        <th>Image</th>
                                        <th style="text-align:right;">Quantity</th>
                                        <th style="text-align:right;">Total</th>
                                        <th style="text-align:right;">Action</th>
                                    </tr>

                                    @isset($cart)
                                        @foreach ($cart->items as $itemKey => $allItems)

                                            <tr>

                                                <td><a href="{{ URL('singleProductDetails', $allItems['item']->id) }}"
                                                        class="text-danger">{{ $allItems['item']->name }}</a></td>

                                                <td>
                                                    <img class="img-thumbnail"
                                                        src="{{ asset($allItems['item']->thumbnail) }}" alt=""
                                                        style="width:50px;height:50px; object-fit: contain;">
                                                </td>


                                                <td class="responsive__width">

                                                    <div style="display: none">
                                                        <span class="item_product_id"
                                                            id="item_product_id_{{ $allItems['item']->id }}">{{ $itemKey }}</span>
                                                        <span class="item_title"
                                                            id="item_title_{{ $allItems['item']->id }}">{{ $allItems['item']->name }}</span>
                                                        <span class="item_price"
                                                            id="item_price_{{ $allItems['item']->id }}">{{ $allItems['price'] }}</span>
                                                        <span class="item_quantity"
                                                            id="item_quantity_{{ $allItems['item']->id }}">{{ $allItems['qty'] }}</span>
                                                    </div>

                                                    <span class="badge badge-primary ml-2 hide__sm mb-2 dcr__btn"
                                                        style="background: crimson;cursor:pointer;padding: 12px;margin-top: 10px; width: 35px;height: 35px;border-radius: 50%;"
                                                        onclick="minusQuantity('quantityCheckout{{ $loop->iteration }}','priceCheckout{{ $loop->iteration }}','priceTdCheckout{{ $loop->iteration }}',{{ $allItems['item']->sales_price }},{{ $shippingChargeAmount }},{{ $itemKey }})"><i
                                                            class="fa fa-minus text-white" aria-hidden="true"></i></span>
                                                    <span class="badge badge-success mr-2 ml__15 mble__span incr__btn"
                                                        style="margin: 0 10px 10px; background: rgb(71, 114, 6);cursor:pointer;padding: 12px;margin-bottom: 10px;display: none;border-radius: 50%; width: 35px;height: 35px"
                                                        onclick="quantityWiseChangeValue('quantityCheckout{{ $loop->iteration }}','priceCheckout{{ $loop->iteration }}','priceTdCheckout{{ $loop->iteration }}',{{ $allItems['item']->sales_price }},{{ $shippingChargeAmount }},{{ $itemKey }})"><i
                                                            class="fa fa-plus text-white" aria-hidden="true"></i></span>
                                                    <input type="number" min="1"
                                                        class="form-control w-50 width_sm_100 d-inline-block text-center width__full"
                                                        onchange="quantityWiseChangeValue('quantityCheckout{{ $loop->iteration }}','priceCheckout{{ $loop->iteration }}','priceTdCheckout{{ $loop->iteration }}',{{ $allItems['item']->sales_price }},{{ $shippingChargeAmount }})"
                                                        id="quantityCheckout{{ $loop->iteration }}" name="quantity[]"
                                                        value="{{ $allItems['qty'] }}" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" name="title[]"
                                                        value="{{ $allItems['item']->name }}">
                                                    <input type="hidden" min="1" class="form-control form-control-sm"
                                                        name="price[]" value="{{ $allItems['price'] }}"
                                                        id="priceCheckout{{ $loop->iteration }}">
                                                    <input type="hidden" min="1" class="form-control form-control-sm"
                                                        name="product_id[]" value="{{ $itemKey }}">
                                                    <span class="badge badge-primary ml-2 ml__15 mble__span dcr__btn"
                                                        style="margin: 0 10px 10px 0;background: crimson;cursor:pointer;padding: 12px;margin-top: 10px;display: none;border-radius: 50%; width: 35px;height:35px;"
                                                        onclick="minusQuantity('quantityCheckout{{ $loop->iteration }}','priceCheckout{{ $loop->iteration }}','priceTdCheckout{{ $loop->iteration }}',{{ $allItems['item']->sales_price }},{{ $shippingChargeAmount }},{{ $itemKey }})"><i
                                                            class="fa fa-minus text-white" aria-hidden="true"></i></span>
                                                    <span class="badge badge-success mr-2 ml__15 hide__sm mt-2 incr__btn"
                                                        style="background: rgb(71, 114, 6);cursor:pointer;padding: 12px;margin-bottom: 10px;width: 35px;height: 35px;border-radius: 50%;"
                                                        onclick="quantityWiseChangeValue('quantityCheckout{{ $loop->iteration }}','priceCheckout{{ $loop->iteration }}','priceTdCheckout{{ $loop->iteration }}',{{ $allItems['item']->sales_price }},{{ $shippingChargeAmount }},{{ $itemKey }})"><i
                                                            class="fa fa-plus text-white" aria-hidden="true"></i></span>
                                                </td>

                                                <td style="text-align:right;" id="priceTdCheckout{{ $loop->iteration }}">
                                                    ৳{{ $allItems['price'] }}</td>
                                                <td style="float: right">
                                                    <button type="button" class="btn btn-danger form-control-sm"
                                                        onclick="removeItem({{ $itemKey }})" style="border: none"><i
                                                            class="fa fa-times" aria-hidden="true"></i></button>
                                                </td>


                                            </tr>

                                        @endforeach
                                    @endisset
                                </table>
                            </div>


                            @isset($cart)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="pickup" name="dtype" value="pickup">
                                    <label class="form-check-label" for="pickup">Pickup</label>
                                </div>
                                <div class="form-check form-check-inline mb-2">
                                    <input class="form-check-input" type="radio" id="delivery" name="dtype" value="delivery"
                                        checked>
                                    <label class="form-check-label" for="delivery">Delivery</label>
                                </div>
                                {{-- demo for UI changes --}}
                                <div class="row" id="subTotal">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-8">
                                        <ul class="list-group">
                                            <li class="list-group-item mb-1"><b class="text-uppercase">Subtotal :</b>
                                                <span class="float-right"
                                                    id="totalAmountCheckout">৳{{ $cart->totalPrice }}</span>
                                            </li>
                                            @if ($cart->totalPrice >= 3000)
                                                <li class="list-group-item mb-1" id="pickUpCheck"><b
                                                        class="text-uppercase">Shipping :</b>
                                                    <span class="float-right" id="shippingCharge">৳ 0</span>
                                                </li>
                                            @else
                                                <li class="list-group-item mb-1" id="pickUpCheck"><b
                                                        class="text-uppercase">Shipping :</b>
                                                    <span class="float-right"
                                                        id="shippingCharge">৳{{ $shippingChargeAmount }}</span>
                                                </li>
                                            @endif
                                            {{-- <li class="list-group-item mb-1"><b class="text-uppercase">Shipping :</b>
                                                <span
                                                    class="float-right"
                                                    id="shippingCharge">৳{{$shippingChargeAmount}}</span></li> --}}
                                            {{-- <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span
                                                    class="float-right"
                                                    id="totalAmountWithChargeCheckout">৳{{$cart->totalPrice >= 3000 ?$cart->totalPrice : $cart->totalPrice + $shippingChargeAmount}}</span></a>
                                            </li> --}}
                                            <li class="list-group-item mb-1"><b class="text-uppercase">Total :</b> <span
                                                    class="float-right" id="totalAmountWithChargeCheckout">৳</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endisset
                            <div id="buttonSubmitCart">
                                @isset($cart)
                                    <div class="payment_item mb-5">
                                        <div class="creat_account py-3">
                                            <input type="submit" class="btn btn-primary btn-lg btn-block"
                                                onclick="submitCheckout();" value="Place Order">
                                            <input type="button" class="btn btn-secondary btn-lg btn-block"
                                                onclick="clearCart();" value="Clear Cart">
                                        </div>

                                    @endisset
                                </div>
                            </div>

                        </div>
                        </form>


                    </div>
                </div>
</section>



<!-- loader modal -->
<div class="modal" id="preloader" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <img src='{{ asset('assets/images/preloader.gif') }}'
            style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>

<div class="modal" id="preloader" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <img src='{{ asset('assets/images/preloader.gif') }}'
            style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>


<!-- confirm notice modal -->
<div class="modal" id="notice-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content animated flipInX">
            <div class="modal-body p-1">
                <div class="text-center" style="padding: 60px 0">
                    <img src="{{ asset('mazley_assets/img/logo/automax-lg.png') }}" width="150" alt="">
                </div>
                <div class="alert alert-success " role="alert" style="background: #092c63;">
                    <div class="alert-message">
                        <span style="color: #b4bdca;"><strong style="color: lightgreen;"> <i
                                    class="fa fa-check mr-2"></i> Your Order is
                                Successfull!!!</strong> You can login and see order History</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success btn-lg" data-dismiss="modal"
                    style="background: #092c63;border: 1px solid #092c63;">OK
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="confirm-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content animated flipInX custom-modal-content ">
            <div class="modal-header d-flex justify-content-between">
                <div>
                    <em> Place Order </em>
                </div>
                <div>
                    <a class="close-icon" onclick="orderCancel();"data-dismiss="modal">
                        <i class="ion-android-close"></i>
                    </a>
                </div>
                
            </div>
            <div class="modal-body p-1">            
                <div class="alert" role="alert" >
                    <div class="alert-message">
                        <span style="color: #474747;"> Are You Sure To Place this order?</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" onclick="orderCancel();" class="btn btn-danger btn-sm" data-dismiss="modal"
                    style="background: #c70909;border: 1px solid #c70909;">Cancel
                </button>
                <button type="button" onclick="orderConfirm();"  class="btn btn-success btn-sm" data-dismiss="modal"
                    style="background: #092c63;border: 1px solid #092c63;">Place Order
                </button>
            </div>
        </div>
    </div>
</div>


<!--================End Checkout Area =================-->
<!--================Just a comment =================-->
@endsection
@section('scripts')

<script>
    const app_url = '{{ env('APP_URL') }}';
    $(document).ready(function() {
        loadCartData();
        calculateTotal();
        $(document).click(function(e) {
            if (!$(e.target).is('.categories_title')) {
                $('.categories_menu_toggle ').css("display", "none")
            }
        });
        $('input[name=dtype]').change(function() {
            if (this.value == 'pickup') {
                $("#pickUpCheck").css("display", "none");
            } else if ((this.value == 'delivery')) {
                $("#pickUpCheck").css("display", "block");
            }
            calculateTotalCharge(this.value);
        });


    });

    function calculateTotalCharge(delivery_type) {
        let value = 0,
            shippingCost = 0;
        let totalAmountCharge = $("input[name='price[]']")
            .map(function() {
                return $(this).val();
            }).get();

        for (var i = 0; i < totalAmountCharge.length; i++) {
            value += parseInt(totalAmountCharge[i]);
        }

        if (delivery_type == "pickup") {
            shippingCost = 0;
        } else {
            if (value >= 3000) {
                shippingCost = 0;
            } else {
                shippingCost = $('#shippingChargeAmount').val();
            }
        }
        $('#shippingCharge').html('৳' + shippingCost);

        $('#totalAmountWithChargeCheckout').html('৳' + (value + parseInt(shippingCost)));
    }


    function logout() {
        $.ajax({
            url: "{{ URL('logout') }}",
            type: 'POST',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            success: data => location.reload(),
            error: err => console.error(err)
        })
    }


    function loadCartData() {
        $.ajax({
            // url: 'http://automax.test/getSidecartData',
            url: app_url + '/getSidecartData',
            type: 'get',
            success: function(response) {
                $('#sideNavCartData').html(response);
            },
            error: function() {
                alert("error");
            }
        });
    }

    function autoFill(val) {
        let mble_num = val;
        $.ajax({
            url: '{{ url('getUserDeatailsToAutofill') }}',
            type: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
                mble_num: mble_num
            },
            success: function(response) {

                if (response.matchedUserInfo != null) {
                    $('#first_name').val(response.matchedUserInfo.first_name);
                    $('#last_name').val(response.matchedUserInfo.last_name);
                    // $('#company_name').val("");
                    $('#email').val(response.matchedUserInfo.email);
                    $('#country').val(response.matchedUserInfo.country);
                    $('#district').val(response.matchedUserInfo.district);
                    $('#city').val(response.matchedUserInfo.city);
                    $('#thana').val(response.matchedUserInfo.thana);
                    $('#area').val(response.matchedUserInfo.area);
                    $('#road_no').val(response.matchedUserInfo.road_no);
                    $('#house_no').val(response.matchedUserInfo.house_no);
                    $('#flat_no').val(response.matchedUserInfo.flat_no);
                    $('#car_no').val(response.matchedUserInfo.car_no);
                }
            },
            error: function() {
                alert("error");
            }
        });
    }

    function submitCheckout() {
        $('#confirm-modal').modal('show');
    }

    function orderConfirm() {
                event.preventDefault();
                let deliveryType = $('input[type="radio"]:checked').val();
                $('#preloader').modal('show');
                var formData = new FormData();
                formData.append('first_name', $("#first_name").val());
                formData.append('last_name', $("#last_name").val());
                // formData.append('company', $("#company").val());
                formData.append('number', $("#number").val());
                formData.append('email', $("#email").val());
                formData.append('country', $("#country").val());
                formData.append('district', $("#district").val());
                formData.append('city', $("#city").val());
                formData.append('thana', $("#thana").val());
                formData.append('area', $("#area").val());
                formData.append('road', $("#road").val());
                formData.append('house', $("#house").val());
                formData.append('flat', $("#flat").val());
                formData.append('notes', $("#notes").val());
                formData.append('subTotal', Number($('#totalAmountCheckout').text().split('৳')[1]));
                let count = 0;
                $('input[name^="quantity"]').each(function() {
                    formData.append('quantity[' + count + ']', $(this).val());
                    count++;

                });
                count = 0;
                $('input[name^="title"]').each(function() {
                    formData.append('title[' + count + ']', $(this).val());
                    count++;

                });

                count = 0;
                $('input[name^="price"]').each(function() {

                    formData.append('price[' + count + ']', $(this).val());
                    count++;

                });


                count = 0;
                $('input[name^="product_id"]').each(function() {

                    formData.append('product_id[' + count + ']', $(this).val());
                    count++;

                });

                formData.append('dtype', deliveryType);


                $.ajax({
                    url: '{{ URL('checkoutDone') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    timeout: 600000,
                    success: function(response) {
                        if (response.errors) {
                            $('#preloader').modal('hide');
                            if(response.errors.first_name){
                                alertify.error("First name is required");
                            }
                            if(response.errors.last_name){
                                alertify.error("Last name is required");
                            }
                            if(response.errors.phone_number){
                                alertify.error("Phone number is required");
                            }
                            // alertify.error(response.errors.first_name[0]);
                            // alertify.error(response.errors.phone_number[0]);
                        } else if (typeof(response) == 'object') {
                            $('#preloader').modal('hide');
                            alertify.alert(
                                "<span class='text-warning'>Warning!!!</span>",
                                "Your required " + response.problemProductName.toLowerCase() +
                                " quantity can't be less than " + response.minimumQuantity,
                                function() {
                                    //
                                }
                            );
                        } else {
                            $('#preloader').modal('hide');
                            $('#checkoutForm').trigger("reset");
                            $("#alert").css("visibility", "visible");
                            $('#notice-modal').modal('show');

                            setTimeout(function() {
                                location.href = "{{ url('/myAccountView') }}";
                            }, 2000);
                        }
                    },
                    error: function() {
                        $('#preloader').modal('hide');
                    }
                });
            }

    function orderCancel(){
        alertify.error('Cancel');
    }

    // function submitCheckout() {
    //     event.preventDefault();
    //     let deliveryType = $('input[type="radio"]:checked').val();
    //     alertify.confirm("Are You Sure To Place this order?",
    //         function() {
    //             $('#preloader').modal('show');
    //             var formData = new FormData();
    //             formData.append('first_name', $("#first_name").val());
    //             formData.append('last_name', $("#last_name").val());
    //             // formData.append('company', $("#company").val());
    //             formData.append('number', $("#number").val());
    //             formData.append('email', $("#email").val());
    //             formData.append('country', $("#country").val());
    //             formData.append('district', $("#district").val());
    //             formData.append('city', $("#city").val());
    //             formData.append('thana', $("#thana").val());
    //             formData.append('area', $("#area").val());
    //             formData.append('road', $("#road").val());
    //             formData.append('house', $("#house").val());
    //             formData.append('flat', $("#flat").val());
    //             formData.append('notes', $("#notes").val());
    //             formData.append('subTotal', Number($('#totalAmountCheckout').text().split('৳')[1]));
    //             let count = 0;
    //             $('input[name^="quantity"]').each(function() {
    //                 formData.append('quantity[' + count + ']', $(this).val());
    //                 count++;

    //             });
    //             count = 0;
    //             $('input[name^="title"]').each(function() {
    //                 formData.append('title[' + count + ']', $(this).val());
    //                 count++;

    //             });

    //             count = 0;
    //             $('input[name^="price"]').each(function() {

    //                 formData.append('price[' + count + ']', $(this).val());
    //                 count++;

    //             });


    //             count = 0;
    //             $('input[name^="product_id"]').each(function() {

    //                 formData.append('product_id[' + count + ']', $(this).val());
    //                 count++;

    //             });

    //             formData.append('dtype', deliveryType);


    //             $.ajax({
    //                 url: '{{ URL('checkoutDone') }}',
    //                 type: 'POST',
    //                 data: formData,
    //                 dataType: 'json',
    //                 enctype: 'multipart/form-data',
    //                 processData: false,
    //                 cache: false,
    //                 contentType: false,
    //                 timeout: 600000,
    //                 success: function(response) {
    //                     if (response.errors) {
    //                         $('#preloader').modal('hide');
    //                         if(response.errors.first_name){
    //                             alertify.error("First name is required");
    //                         }
    //                         if(response.errors.last_name){
    //                             alertify.error("Last name is required");
    //                         }
    //                         if(response.errors.phone_number){
    //                             alertify.error("Phone number is required");
    //                         }
    //                         // alertify.error(response.errors.first_name[0]);
    //                         // alertify.error(response.errors.phone_number[0]);
    //                     } else if (typeof(response) == 'object') {
    //                         $('#preloader').modal('hide');
    //                         alertify.alert(
    //                             "<span class='text-warning'>Warning!!!</span>",
    //                             "Your required " + response.problemProductName.toLowerCase() +
    //                             " quantity can't be less than " + response.minimumQuantity,
    //                             function() {
    //                                 //
    //                             }
    //                         );
    //                     } else {
    //                         $('#preloader').modal('hide');
    //                         $('#checkoutForm').trigger("reset");
    //                         $("#alert").css("visibility", "visible");
    //                         $('#notice-modal').modal('show');

    //                         setTimeout(function() {
    //                             location.href = "{{ url('/myAccountView') }}";
    //                         }, 2000);
    //                     }
    //                 },
    //                 error: function() {
    //                     $('#preloader').modal('hide');
    //                 }
    //             });
    //         },

    //         function() {
    //             alertify.error('Cancel');
    //         }).setHeader('<em> Place Order </em> ');


    // }



    // $("#checkoutForm").submit(function() {
    //     event.preventDefault();
    //     $('#preloader').modal('show');
    //     //alert($('input[type="radio"]:checked').val());
    //     // var base_url = {!! json_encode(url('/')) !!}
    //     var base_url = '{{ URL('/') }}';

    //     $.ajax({
    //         //   url: './checkoutDone',
    //         url: '{{ URL('checkoutDone') }}',
    //         type: 'POST',
    //         //   data:$("#checkoutForm").serialize()+"&_token={{ csrf_token() }}",
    //         data: {
    //             ...getUserData(),
    //             ...getAllProductInfo(),
    //             _token: '{{ csrf_token() }}',
    //             dtype: $("input[name=dtype]").val(),
    //         },
    //         success: function(response) {
    //             console.log(typeof(response));
    //             if (typeof response == 'undefined') {
    //                 alert("error");
    //                 $('#preloader').hide();
    //             } else if (typeof(response) == 'object') {
    //                 $('#preloader').modal('hide');
    //                 alertify
    //                     .alert("<span class='text-warning'>Warning!!!</span>",
    //                         "Your required " + response.problemProductName.toLowerCase() +
    //                         " quantity can't be less than " + response.minimumQuantity,
    //                         function() {
    //                             // alertify.message('OK');
    //                         });
    //                 // alertify.error();

    //             } else {
    //                 $('#preloader').modal('hide');
    //                 $('#checkoutForm').trigger("reset");
    //                 $("#alert").css("visibility", "visible");
    //                 $('#notice-modal').modal('show');

    //                 setTimeout(function() {
    //                     location.href = "{{ url('/') }}";
    //                 }, 2000);
    //             }
    //         },
    //         error: function() {
    //             $('#preloader').modal('hide');
    //         }
    //     });
    // });


    function getAllProductInfo() {
        let item_product_id = [];
        let item_title = [];
        let item_price = [];
        let item_quantity = [];

        $.each($('.item_product_id'), (k, v) => {
            item_product_id.push($('.item_product_id')[k].innerText);
            item_title.push($('.item_title')[k].innerText);
            item_price.push($('.item_price')[k].innerText);
            item_quantity.push($('.item_quantity')[k].innerText);
        });

        return {
            product_id: item_product_id,
            title: item_title,
            price: item_price,
            quantity: item_quantity,
        }
    }

    function getUserData() {
        return {
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            // company: $('#company').val(),
            number: $('#number').val(),
            email: $('#email').val(),
            country: $('#country').val(),
            district: $('#district').val(),
            city: $('#city').val(),
            thana: $('#thana').val(),
            area: $('#area').val(),
            road: $('#road').val(),
            house: $('#house').val(),
            flat: $('#flat').val(),
            notes: $('#notes').val()
        }
    }

    function removeItem(id) {
        $.ajax({
            url: '{{ url('removeItemFromCart') }}',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "item_id": id
            },
            success: function(response) {
                // let billing_info = getBillingInfo();
                // console.log(billing_info);

                /**
                 *
                 *
                 *
                 *
                 *
                 * THE PROBLEM OCCURS FROM HERE. LOADED DATA CANNOT BE SERIALIZED
                 * ONCE IT IS LOADED THROUGH $(selector).load()
                 *
                 *
                 *
                 *
                 *
                 */
                $("#orderTable").load(location.href + " #orderTable>*", function() {
                    calculateTotal();
                });

                // $("#subTotal").load(location.href+" #subTotal>*","");
                // $('#buttonSubmitCart').load(location.href+" #buttonSubmitCart>*","");
                // $('#fullNav').load(location.href+" #fullNav>*","");

                // setBillingInfo(billing_info);
                // console.log(billing_info['first_name']);
            },
            error: function() {
                // alert("error");
            }
        });
    }

    function getBillingInfo() {
        let dataHolder = {
            first_name: $('#first').val(),
            last_name: $('#last').val(),
            // company: $('#company').val(),
            number: $('#number').val(),
            email: $('#email').val(),
            address_1: $('#add1').val(),
            // address_2: $('#add2').val(),
            city: $('#city').val(),
            message: $('#message').val()
        };

        return dataHolder;
    }

    function setBillingInfo(dataObj) {
        $('#first').val(dataObj['first_name']);
        $('#last').val(dataObj['last_name']);
        // $('#company').val(dataObj['company']);
        $('#number').val(dataObj['number']);
        $('#email').val(dataObj['email']);
        $('#add1').val(dataObj['address_1']);
        // $('#add2').val(dataObj['address_2']);
        $('#city').val(dataObj['city']);
        $('#message').val(dataObj['message']);
    }


    function clearCart() {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', ' Do you want to remove all the items from your cart?', function() {
            $('#preloader').modal('show');
            $.ajax({
                url: '{{ url('clearCart') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    $('#preloader').modal('show');
                    setTimeout(function() {
                        location.href = "{{ url('/') }}";
                    }, 2000);
                },
                error: function() {
                    $('#preloader').modal('hide');
                }
            });

        }, function() {
            alertify.error('Cancel')
        });

    }


    function quantityWiseChangeValue(quantityId, priceId, tdId, price, shippingCharge, productId) {
        addToCart(productId);
        var value = 0;
        var quantityVal = parseInt($('#' + quantityId).val()) + 1;
        $('#' + quantityId).val(quantityVal);
        var total = price * quantityVal;
        $('#' + priceId).val(total);
        $('#' + tdId).html('৳' + total);

        $('#item_price_' + productId).html(total);
        $('#item_quantity_' + productId).html(quantityVal);

        var totalAmount = $("input[name='price[]']")
            .map(function() {
                return $(this).val();
            }).get();

        for (var i = 0; i < totalAmount.length; i++) {
            value += parseInt(totalAmount[i]);
        }

        $('#totalAmountCheckout').html('৳' + value);

        // if (value >= 3000) {
        //     var charge = 0;
        //     $("#shippingCharge").html('৳ 0');
        //     $('#totalAmountWithChargeCheckout').html('৳' + (value + charge));
        // } else {
        //     $("#shippingCharge").html('৳' + shippingCharge);
        //     $('#totalAmountWithChargeCheckout').html('৳' + (value + shippingCharge));
        // }
        calculateTotalCharge($('input[name=dtype]:checked').val());
    }


    var globalDataArray = new Array();
    var globalTotalPages;

    function addToCart(id) {
        var base_url = "{{ URL('/') }}";

        $.ajax({
            url: base_url + '/addToCart',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                // console.log(response);
                $("#cartSymbol").text(response.cart.totalQty);
                $('#cartSymbolTwo').text(response.cart.totalQty);
                $("#totalCartAmount").text('৳' + response.cart.totalPrice);

                //     $.ajax({
                //     url: '{{ url('getSidecartData') }}',
                //     type: 'get',
                //     success: function (response) {
                //       $('#sideNavCartData').html(response);
                //     },
                //     error: function () {
                //     alert("error");
                //     }
                // });


            },
            error: function() {
                alert("error");
            }
        });
    }


    function decreaseToCart(id) {
        // var base_url = {!! json_encode(url('/')) !!};
        var base_url = "{{ URL('/') }}";

        $.ajax({
            url: base_url + '/decreaseToCart',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                // console.log(response);
                $("#cartSymbol").text(response.cart.totalQty);
                $('#cartSymbolTwo').text(response.cart.totalQty);
                $("#totalCartAmount").text(response.cart.totalPrice);

                //     $.ajax({
                //     url: '{{ url('getSidecartData') }}',
                //     type: 'get',
                //     success: function (response) {
                //       $('#sideNavCartData').html(response);
                //     },
                //     error: function () {
                //     alert("error");
                //     }
                // });


            },
            error: function() {
                alert("error");
            }
        });
    }


    function minusQuantity(quantityId, priceId, tdId, price, shippingCharge, productId) {
        var quantityVal = parseInt($('#' + quantityId).val());

        if (quantityVal > 1) {

            decreaseToCart(productId);
            var value = 0;
            var xVal = quantityVal - 1;

            $('#' + quantityId).val(xVal);
            var total = price * xVal;
            $('#' + priceId).val(total);
            $('#' + tdId).html('৳' + total);

            $('#item_price_' + productId).html(total);
            $('#item_quantity_' + productId).html(xVal);

            var totalAmount = $("input[name='price[]']")
                .map(function() {
                    return $(this).val();
                }).get();

            for (var i = 0; i < totalAmount.length; i++) {

                value += parseInt(totalAmount[i]);
            }


            $('#totalAmountCheckout').html('৳' + value);
            // $('#totalAmountWithChargeCheckout').html('৳' + (value + shippingCharge));
            // if (value >= 3000) {
            //     var charge = 0;
            //     $("#shippingCharge").html('৳ 0');
            //     $('#totalAmountWithChargeCheckout').html('৳' + (value + charge));
            // } else {
            //     $("#shippingCharge").html('৳' + shippingCharge);
            //     $('#totalAmountWithChargeCheckout').html('৳' + (value + shippingCharge));
            // }
            calculateTotalCharge($('input[name=dtype]:checked').val());

        } else {

        }

    }

    function calculateTotal() {
        let total = 0;
        if ($('#shippingCharge').html()) {
            let shippingCharge = Number($('#shippingCharge').html().split('৳')[1]);
            for (let i = 1; i < $('#orderTable tbody tr').length; i++) {
                total += Number(
                    $($('#orderTable tbody tr')[i])
                    .find('td:nth-child(4)')
                    .html()
                    .split('৳')[1]
                );
            }
            let grandTotal = total + shippingCharge;
            $('#totalAmountCheckout').html('৳' + total);
            // $('#totalAmountWithChargeCheckout').html('৳' + grandTotal);
            calculateTotalCharge($('input[name=dtype]:checked').val());

        }
    }
</script>
<script>
    if ($(window).width() <= 700) {
        $("#custom_id_sm").css("display", "block");
    }
</script>
@endsection


@push('footerasset')

{{-- <script src="{{ asset('styles/bootstrap4/popper.js') }}"></script>
    <script src="{{ asset('styles/bootstrap4/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/TweenMax.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/TimelineMax.min.js') }}"></script>
    <script src="{{ asset('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/animation.gsap.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
    <script src="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
    <script src="{{ asset('plugins/easing/easing.js') }}"></script>
    <script src="{{ asset('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('plugins/parallax-js-master/parallax.min.js') }}"></script>
    <script src="{{ asset('js/shop_custom.js') }}"></script> --}}

@endpush

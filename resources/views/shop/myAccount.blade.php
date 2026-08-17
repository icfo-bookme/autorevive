@extends('layouts.master')

@section('content')

@if (isset($anchor))
<input type="hidden" name="anchor" id="anchor" value="{{ $anchor }}">
@endif

@if (isset($message))
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <strong>Thank You!</strong> {{$message}}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
{{-- <style>
    .table td,
    .table th {
        padding: 3px;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        text-align: left;
    }

    .table td,
    .table th {
        white-space: normal;
        border-top: 1px solid #dee2e6;
    }

    .card .table td,
    .card .table th {
        padding-right: 5px;
        padding-left: 5px;
        /* text-align: center; */
    }

    @media only screen and (max-width: 575px){
        .table td,
    .table th {
        padding: 3px;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        text-align: left;
    }

    .table td,
    .table th {
        white-space: normal;
        border-top: 1px solid #dee2e6;
    }

    .card .table td,
    .card .table th {
        padding-right: 5px;
        padding-left: 5px;
        /* text-align: center; */
    }

    }



</style> --}}
{{-- <div class="container">
    <div class="row" style="margin: 80px 0px;">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header" style="border-top: 2px solid #0e8ce4">
                    <h4 class="card-title text-center mb-0"><i aria-hidden="true" class="fa fa-shopping-bag"></i> Order
                        Information</h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center py-3">
                        <div class="col-sm-7">

                            <table class="table table-bordered table-responsive " style="width:100%;">
                                <tbody>
                                    <tr class="bg-secondary text-white"style="text-align:center;font-size:14px; ">
                                        <td class="py-3"> Sr. No. </td>
                                        <td class="py-3">Date</td>
                                        <td class="py-3"> Customer</td>
                                        <td class="py-3">Total Product</td>
                                        <td class="py-3">Status</td>
                                        <td class="py-3">Action</td>
                                    </tr>

                                    @foreach($orderHistory as $order)
                                    <tr style="text-align:center;font-size:16px;" class="mb-3">
                                        <td class="py-3">{{ $loop->iteration }}</td>
                                        <td class="py-3">{{$order->created_at}}</td>
                                        <td class="py-3">{{$order->first_name}} {{$order->last_name}}</td>
                                        <td class="py-3">{{$order->order_details->where('soft_delete',0)->count()}}</td>
                                        <td class="py-3">
                                            @if(($order->is_approve == 0) && ($order->is_rejected == 0) && ($order->status == 0) && ($order->shipment_assigned == 0) && ($order->is_shipment == 0) && ($order->is_payment == 0))
                                            <button class="badge badge-info">
                                            Pending
                                            </button>
                                            @elseif(($order->is_approve == 0) && ($order->is_rejected == 1) && ($order->status == 0) && ($order->shipment_assigned == 0) && ($order->is_shipment == 0) && ($order->is_payment == 0))
                                                <button class="badge badge-danger">
                                                    Cancelled
                                                </button>
                                            @elseif(($order->is_approve == 1) && ($order->is_rejected == 0) && ($order->status == 0) && ($order->shipment_assigned == 0) && ($order->is_shipment == 0) && ($order->is_payment == 0))
                                            <button class="badge badge-primary">
                                                    Approved
                                            </button>
                                            @elseif(($order->is_approve == 1) && ($order->is_rejected == 0) && ($order->status == 0) && ($order->shipment_assigned == 1) && ($order->is_shipment == 0) && ($order->is_payment == 0))

                                             <button class="badge badge-primary">
                                                 Assigned for Shipment
                                             </button>

                                             @elseif(($order->is_approve == 1) && ($order->is_rejected == 0) &&($order->status == 1) && ($order->shipment_assigned == 1) &&($order->is_shipment == 1) && ($order->is_payment == 1))

                                             <button class="badge badge-success">
                                                 Delivered
                                             </button>


                                            @endif</td>
                                        <td class="py-3">

                                               <button class="btn badge badge-secondary"
                                                onclick='productDetails({{ $order->id }})' style="cursor: pointer">Details</button>
                                                @if(($order->is_approve == 0) && ($order->is_rejected == 0) && ($order->status == 0) && ($order->shipment_assigned == 0) && ($order->is_shipment == 0) && ($order->is_payment == 0))
                                                <button class="btn btn badge badge-danger"
                                                onclick='cancelOrder({{ $order->id }})' style="cursor: pointer">Cancel Order</button>
                                                @endif

                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>



                      <div class="col-sm-5"  id="productDetails">

                    </div>




                    </div>
                </div>
            </div>
        </div>
    </div>

</div> --}}

<div id="accountApp"></div>

<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 25px">
        <div class="modal-header p-0" style="border: none;">
        <button type="button" class="close__btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div id="invoice_detail_modal" class="modal-body">
            <h6>hellow from modal</h6>

        </div>
        {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
    </div>
    </div>
</div>


<script src="{{asset('react/app.js')}}"></script>







@section('scripts')
<script>
    $(document).ready(function () {
        loadCartData();
        // window.addEventListener('mouseup', function(event){
        //     const box = document.getElementById('box1');
        //     if(event.target !=box && event.target.parentNode != box){
        //         box.style.display = 'none';
        //     }
        // })
        
        
    });

    function loadCartData() {
        $.ajax({
            url: '{{ URL("getSidecartData") }}',
            type: 'get',
            success: function (response) {

                $('#sideNavCartData').html(response);

            },
            error: function () {
                alert("error");
            }
        });
    }

    function printDiv(divName) {
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

    function productDetails(id){
    $.ajax({
    url: 'productDetailsByAccount',
    type: 'get',
    data:{  "_token": "{{ csrf_token() }}",id:id} ,
    success: function (data) {
      console.log("productDetails", data);
	  $('#productDetails').empty();
	  $('#productDetails').html(data);
    },

        error: function () {
      alert("error");
    }
  });

}



function cancelOrder(id) {
             event.preventDefault();
             alertify.confirm('Are You Sure ?', ' Do you want to cancel this order?', function () {

            $.ajax({
                type: 'post',
                url: '{{URl("cancelShipmentAjax")}}',
                data: {
                    id:id,_token:'{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.error('Something Went Wrong');

                    }else {
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



   function quantityWiseChangeValue(quantityId,priceId,tdId,price,shippingCharge,productId){
     addToCart(productId);
     var value = 0;
     var quantityVal = parseInt($('#'+quantityId).val())+1;
     $('#'+quantityId).val(quantityVal);
     var total        =  price*quantityVal;
     $('#'+priceId).val(total);
     $('#'+tdId).html('৳'+total);
     var totalAmount = $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();

        for ( var i = 0; i < totalAmount.length; i++) {
          value += parseInt(totalAmount[i]);
        }


        $('#totalAmount').html('৳'+value);
        $('#totalAmountWithCharge').html('৳'+(value+shippingCharge));

    }







  var globalDataArray      = new Array();
  var globalTotalPages ;

  function addToCart(id){
  var base_url =  {!! json_encode(url('/')) !!}

  $.ajax({
    url: base_url+'/addToCart',
    type: 'POST',
    data:{  "_token": "{{ csrf_token() }}",id:id} ,
    success: function (response) {
    // console.log(response);
      $("#cartSymbol").text(response.cart.totalQty);
      $('#cartSymbolTwo').text(response.cart.totalQty);
      $("#totalCartAmount").text(response.cart.totalPrice);

            $.ajax({
            url: '{{url("getSidecartData")}}',
            type: 'get',
            success: function (response) {
              $('#sideNavCartData').html(response);
            },
            error: function () {
            alert("error");
            }
        });


    },
    error: function () {
      alert("error");
    }
  });
  }



  function decreaseToCart(id){
  var base_url =  {!! json_encode(url('/')) !!}

  $.ajax({
    url: base_url+'/decreaseToCart',
    type: 'POST',
    data:{  "_token": "{{ csrf_token() }}",id:id} ,
    success: function (response) {
    // console.log(response);
      $("#cartSymbol").text(response.cart.totalQty);
      $('#cartSymbolTwo').text(response.cart.totalQty);
      $("#totalCartAmount").text(response.cart.totalPrice);

            $.ajax({
            url: '{{url("getSidecartData")}}',
            type: 'get',
            success: function (response) {
              $('#sideNavCartData').html(response);
            },
            error: function () {
            alert("error");
            }
        });


    },
    error: function () {
      alert("error");
    }
  });
  }



  function removeItem(id){
      $.ajax({
          url: '{{ url("removeItemFromCart") }}',
          type: 'POST',
          data:{
            "_token"  : "{{ csrf_token() }}",
            "item_id" : id
          },
          success: function (response) {

            $.ajax({
            url: '{{url("getSidecartData")}}',
            type: 'get',
            success: function (response) {
              $('#sideNavCartData').html(response);
              var totalPrice = $('#getTotalAmount').val();
              var totalQuantity = $('#getTotalQuantity').val();

              if(totalQuantity>0){
              $("#cartSymbol").text(totalQuantity);
              $('#cartSymbolTwo').text(totalQuantity);
              $("#totalCartAmount").text(totalPrice);
              }else{
                   $("#cartSymbol").text(0);
                   $('#cartSymbolTwo').text(0);
                   $("#totalCartAmount").text(0);
              }

            },
            error: function () {
            alert("error");
            }
        });


          },
          error: function () {
            // alert("error");
          }
        });
    }



//open cart
    function openNav() {

    if ($(window).width() <= 700) {
		var size = '100vw';
    }else{
        var size = '35vw';
    }

     document.getElementById("mySidenav").style.width = size;


    $.ajax({
            url: '{{url("getSidecartData")}}',
            type: 'get',
            success: function (response) {

              $('#sideNavCartData').html(response);

            },
            error: function () {
            alert("error");
            }
        });



    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }







    function minusQuantity(quantityId,priceId,tdId,price,shippingCharge,productId){
    var quantityVal = parseInt($('#'+quantityId).val());

    if (quantityVal > 1) {
     decreaseToCart(productId);
     var value = 0;

     $('#'+quantityId).val(quantityVal-1);
     var total        =  price*quantityVal;
     $('#'+priceId).val(total);
     $('#'+tdId).html('৳'+total);
     var totalAmount = $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();

        for ( var i = 0; i < totalAmount.length; i++) {
          value += parseInt(totalAmount[i]);
        }


        $('#totalAmount').html('৳'+value);
        $('#totalAmountWithCharge').html('৳'+(value+shippingCharge));

    }else{

    }

  }

  function getInvoiceDetails(id) {
        axios(`invoicePrintViewUser/${id}`).then(({ data }) => {
            console.log("data console", data)
            document.getElementById('invoice_detail_modal').innerHTML = data;
        });
  }



</script>
{{-- <script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
<script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
<script src="{{asset('js/shop_custom.js')}}"></script> --}}
@endsection



@endsection
{{-- @include('partials.footer') --}}
{{--
@push('footerasset')

<script src="{{asset('styles/bootstrap4/popper.js')}}"></script>
<script src="{{asset('styles/bootstrap4/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/TweenMax.min.js')}}"></script>
<script src="{{asset('plugins/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('plugins/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('plugins/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('plugins/slick-1.8.0/slick.js')}}"></script>
<script src="{{asset('plugins/easing/easing.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>

@endpush --}}

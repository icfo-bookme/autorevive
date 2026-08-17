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


<div id="app"></div>








<div class="home_section_bg" id="carSearch">
    {{-- @include('components.search_result') --}}
</div>


{{-- loader - start --}}
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        {{-- <div id="loaderModal"></div> --}}
        {{-- <div class="spinner-border m-5"></div> --}}
        <div class="d-flex justify-content-centerm my-5">
            <div class="spinner-border" id="loaderModalTemp" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        {{-- ||| --}}
    </div>
</div>
{{-- loader - end --}}

<!--home section bg area start-->

<div class="clearfix"></div>

{{-- <script
        src="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Create-Responsive-Scrolling-Bootstrap-Tabs/jquery.scrolling-tabs.js"></script> --}}


<script>
    $(document).ready(function () {
        // window.addEventListener('mouseup', function(event){
        //     const box = document.getElementById('box1');
        //     if(event.target !=box && event.target.parentNode != box){
        //         box.style.display = 'none';
        //     }
        // })

        // $('.owl-carousel').owlCarousel({
        //     loop: true,
        //     margin: 10,
        //     nav: true,
        //     responsive: {
        //         0: {
        //             items: 1
        //         },
        //         600: {
        //             items: 3
        //         },
        //         1000: {
        //             items: 5
        //         }
        //     }
        // })

        // load cart data
        // $.ajax({
        //     url: '{{url("getSidecartData")}}',
        //     type: 'get',
        //     success: function (response) {
        //         $('#sideNavCartData').html(response);
        //     },
        //     error: function () {
        //         alert("error");
        //     }
        // });


        /*
            ----------------------------
                Item search dropdowns
            ----------------------------
        */
        // $('#car_company').change(function () {
        //     let company_id = $('#car_company').val();

        //     if (company_id.length <= 0) {
        //         $('#car_brand').html(`<option value=""> SELECT BRAND</option>`);
        //     } else {
        //         $.ajax({
        //             url: '{{ URL("getBrandByCompanyIdAjax") }}',
        //             type: 'POST',
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 id: company_id
        //             },
        //             success: data => {
        //                 $('#car_brand').html('');
        //                 $('#car_model').html('');
        //                 $('#car_model').append(`<option value="">Please select</option>`);
        //                 if (Object.keys(data).length > 0) {
        //                     $.each(data, (key, val) => {
        //                         $('#car_brand').append(
        //                             `<option value="${val.id}">${val.car_brand}</option>`
        //                         );
        //                     });
        //                 } else {
        //                     $('#car_brand').html(
        //                         `<option value="">No option for this company</option>`);
        //                 }
        //             },
        //             error: err => {
        //                 console.error(err);
        //             }
        //         });
        //     }
        // });

        // $('#car_brand').change(function () {
        //     let brand_id = $('#car_brand').val();

        //     if (brand_id.length <= 0) {
        //         $('#car_model').html(`<option value=""> SELECT Model</option>`);
        //     } else {
        //         $.ajax({
        //             url: '{{ URL("getModelByBrandIdAjax") }}',
        //             type: 'POST',
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 id: brand_id
        //             },
        //             success: data => {
        //                 if (Object.keys(data).length > 0) {
        //                     $('#car_model').html('');
        //                     $.each(data, (key, val) => {
        //                         $('#car_model').append(
        //                             `<option value="${val.id}">${val.car_model}</option>`
        //                         );
        //                     });
        //                 } else {
        //                     $('#car_model').html(
        //                         `<option value="">No option for this brand</option>`);
        //                 }
        //             },
        //             error: err => {
        //                 console.error(err);
        //             }
        //         });
        //     }
        // });

        // $('#carSearchForm').submit(function () {
        //     event.preventDefault();

        //     // if no dropdown is selected, show error
        //     if ($('#car_company').val().length == 0 || $('#car_brand').val().length == 0 || $(
        //             '#car_model').val().length == 0) {
        //         alertify.alert('Please check input');
        //     } else {
        //         let car_company = $('#car_company').val();
        //         let car_brand = $('#car_brand').val();
        //         let car_model = $('#car_model').val();

        //         $("#carSearch").empty();

        //         $("#myModal").modal('show');
        //         $("#carSearch").load("./searchCar?company_id=" + car_company + "&brand_id=" +
        //             car_brand + "&model_id=" + car_model);
        //         setInterval(function () {
        //             $("#myModal").modal('hide');
        //         }, 2000);
        //     }
        // });

    });

    $(document).ready(function () {

        


        let slider = $("#slider__new");

        if ($("[name='anchor']").length) {
            window.location = '#' + $("[name='anchor']").val();
        }

        slider.not('.slick-initialized').slick({
            autoplay: true,
            vertical: false,
            dots: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            customPaging: function (slider, i) {},
            responsive: [{
                    breakpoint: 320,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                }, {
                    breakpoint: 360,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                },
                {
                    breakpoint: 375,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                },
                {
                    breakpoint: 384,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                },
                {
                    breakpoint: 412,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                },
                {
                    breakpoint: 414,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        arrows: false,
                        vertical: true,
                    },
                }
            ]
        });
    })




    function quantityWiseChangeValue(quantityId, priceId, tdId, price, shippingCharge, productId) {
        addToCart(productId);
        var value = 0;
        var quantityVal = parseInt($('#' + quantityId).val()) + 1;
        $('#' + quantityId).val(quantityVal);
        var total = price * quantityVal;
        $('#' + priceId).val(total);
        $('#' + tdId).html('৳' + total);
        var totalAmount = $("input[name='price[]']")
            .map(function () {
                return $(this).val();
            }).get();

        for (var i = 0; i < totalAmount.length; i++) {
            value += parseInt(totalAmount[i]);
        }


        $('#totalAmount').html('৳' + value);
        $('#totalAmountWithCharge').html('৳' + (value + shippingCharge));

    }







    var globalDataArray = new Array();
    var globalTotalPages;

    // function addToCart(id) {
    //     var base_url = "{{ url('/') }}";

    //     $.ajax({
    //         url: base_url + '/addToCart',
    //         type: 'POST',
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             id: id
    //         },
    //         success: function (response) {
    //             // console.log(response);
    //             alertify.success('Added To the Cart');

    //             $("#cartSymbol").text(response.cart.totalQty);
    //             $('#cartSymbolTwo').text(response.cart.totalQty);
    //             $("#totalCartAmount").text('৳' + response.cart.totalPrice);

    //             $.ajax({
    //                 url: '{{url("getSidecartData")}}',
    //                 type: 'get',
    //                 success: function (response) {
    //                     $('#sideNavCartData').html(response);

    //                 },
    //                 error: function () {
    //                     alert("error");
    //                 }
    //             });


    //         },
    //         error: function () {
    //             alert("error");
    //         }
    //     });
    // }



    // function decreaseToCart(id) {
    //     var base_url = "{{ url('/') }}";

    //     $.ajax({
    //         url: base_url + '/decreaseToCart',
    //         type: 'POST',
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             id: id
    //         },
    //         success: function (response) {
    //             // console.log(response);
    //             $("#cartSymbol").text(response.cart.totalQty);
    //             $('#cartSymbolTwo').text(response.cart.totalQty);
    //             $("#totalCartAmount").text(response.cart.totalPrice);

    //             $.ajax({
    //                 url: '{{url("getSidecartData")}}',
    //                 type: 'get',
    //                 success: function (response) {
    //                     $('#sideNavCartData').html(response);
    //                 },
    //                 error: function () {
    //                     alert("error");
    //                 }
    //             });


    //         },
    //         error: function () {
    //             alert("error");
    //         }
    //     });
    // }



    // function removeItem(id) {
    //     $.ajax({
    //         url: '{{ url("removeItemFromCart") }}',
    //         type: 'POST',
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "item_id": id
    //         },
    //         success: function (response) {

    //             $.ajax({
    //                 url: '{{url("getSidecartData")}}',
    //                 type: 'get',
    //                 success: function (response) {
    //                     $('#sideNavCartData').html(response);
    //                     var totalPrice = $('#getTotalAmount').val();
    //                     var totalQuantity = $('#getTotalQuantity').val();

    //                     if (totalQuantity > 0) {
    //                         $("#cartSymbol").text(totalQuantity);
    //                         $('#cartSymbolTwo').text(totalQuantity);
    //                         $("#totalCartAmount").text(totalPrice);
    //                     } else {
    //                         $("#cartSymbol").text(0);
    //                         $('#cartSymbolTwo').text(0);
    //                         $("#totalCartAmount").text(0);
    //                     }

    //                 },
    //                 error: function () {
    //                     alert("error");
    //                 }
    //             });


    //         },
    //         error: function () {
    //             // alert("error");
    //         }
    //     });
    // }



    //open cart
    // function openNav() {

    //     if ($(window).width() <= 700) {
    //         var size = '100vw';
    //     } else {
    //         var size = '35vw';
    //     }

    //     document.getElementById("mySidenav").style.width = size;


    //     $.ajax({
    //         url: '{{url("getSidecartData")}}',
    //         type: 'get',
    //         success: function (response) {

    //             $('#sideNavCartData').html(response);

    //         },
    //         error: function () {
    //             alert("error");
    //         }
    //     });



    // }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }







    function minusQuantity(quantityId, priceId, tdId, price, shippingCharge, productId) {
        var quantityVal = parseInt($('#' + quantityId).val());

        if (quantityVal > 1) {
            decreaseToCart(productId);
            var value = 0;

            $('#' + quantityId).val(quantityVal - 1);
            var total = price * quantityVal;
            $('#' + priceId).val(total);
            $('#' + tdId).html('৳' + total);
            var totalAmount = $("input[name='price[]']")
                .map(function () {
                    return $(this).val();
                }).get();

            for (var i = 0; i < totalAmount.length; i++) {
                value += parseInt(totalAmount[i]);
            }


            $('#totalAmount').html('৳' + value);
            $('#totalAmountWithCharge').html('৳' + (value + shippingCharge));

        } else {

        }

    }

</script>

<script src="{{asset('react/app.js')}}"></script>
@endsection

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
<script src="{{ asset('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('plugins/parallax-js-master/parallax.min.js') }}"></script>


@endpush

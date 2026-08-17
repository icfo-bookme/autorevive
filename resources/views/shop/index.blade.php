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







{{-- home_section_bg --}}
<div class="" id="carSearch">

    {{-- @include('components.search_result') --}}
</div>


{{-- loader - start --}}
<div id="myModal" class="modal fade">
    <div class="modal-dialog">

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


<script>

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

{{-- <script src="{{asset('styles/bootstrap4/popper.js')}}"></script>
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
<script src="{{ asset('plugins/parallax-js-master/parallax.min.js') }}"></script> --}}


@endpush

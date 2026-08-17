<!DOCTYPE html>
<html lang="zxx" class="no-js">
<?php
 use Illuminate\Support\Str;
 $cart = Session::has('cart') ? Session::get('cart') : null;
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Automart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('mazley_assets/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('mazley_assets/owl-carousel/owl.theme.default.min.css')}}">
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('mazley_assets/owl-carousel/owl.carousel.min.js')}}">
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset('css/search.css')}}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('mazley_assets/img/favicon-32x32.png')}}">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('mazley_assets/css/plugins.css')}}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('mazley_assets/css/style.css')}}">
    <script src="{{asset('/js/master.js')}}"></script>
    <script>
        $(function () {
    $("#searchPost").autocomplete({
        source: "{{URL('/searchProducts')}}",
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        let URL = '{{ url('/') }}'
        var itemImage = URL + "/" + item.image;
        console.log(itemImage);

        var inner_html = ' <div style="height:100%;width:100%;"><a href="' + item.url + '"> '
        inner_html += '<div class="list_item_container" ><div class="image">'
        inner_html += '<img style="height:60px;width:60px;" src="' + itemImage +
            '"></div><div class="label">'
        inner_html += '<h4 class="text-truncate text-dot">' + item.name + '</h4>'
        inner_html += '</div></div></a></div>';
        return $("<li></li>")
            .data("item.autocomplete", item)
            .append(inner_html)
            .appendTo(ul);
    };
});

    </script>
    @yield('styles')
    <style>
        .btn__cart__float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 20px;
            right: 20px;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            z-index: 2;
        }

        .btn__cart__float i {
            font-size: 25px;
        }

    </style>
</head>

<body>

@if(Auth::user() != null)
<input type="hidden" id="logged" value="{{ Auth::user()->id }}">
@else
<input type="hidden" id="logged" value="0">
@endif


    {{-- <div id="fullNav">
        @include('partials.navBar')
     <div> --}}
    @yield('slider')
    @yield('content')
    @yield('scripts')

    <footer class="footer_widgets">
        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="copyright_area">
                            <p>Copyright &copy; 2020 <a href="#">Automart</a> All Right Reserved.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="footer_payment text-right">
                            <img src="{{asset('mazley_assets/img/icon/payment.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>


<script src="{{asset('mazley_assets/js/plugins.js')}}"></script>
<script src="{{asset('mazley_assets/js/main.js')}}"></script>



{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


{{-- @include('partials.script') --}}
@stack('footerasset')

{{-- <script src="{{asset('js/shop_custom.js')}}"></script> --}}
<script>
    if ($(window).width() <= 700) {
        $("#custom_id_sm").css("display", "block");
    }

</script>
<script>
        $(document).ready(function () {
        window.addEventListener('mouseup', function(event){
            const box = document.getElementById('box1');
            if(event.target !=box && event.target.parentNode != box){
                box.style.display = 'none';
            }
        })

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
</script>





<script>
    var btn = $('#button');

    $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });


    function searchProductByCategory(id) {

        $.ajax({
            url: '{{url("searchProductByCategory")}}',
            type: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (data) {

                $('#allProducts').empty();
                $('#pregination').empty();
                $('#allProducts').html(data);
            },

            error: function () {
                alert("error");
            }
        });
    }
    $(document).ready(function () {

        $("#openSideCartId").click(function () {
            $(".mini_cart").addClass('active');
            $(".off_canvars_overlay").addClass('active');
        });

        // $('.collapse__click').click(function(e){


        //     if ($(this).hasClass("activado")) {
        //         $(this).removeClass("activado");
        //         $(this).children("ul").slideUp();
        //     } else {
        //         $(".menu li ul").slideUp();
        //         $(".menu li").removeClass("activado");
        //         $(this).addClass("activado");
        //         $(this).children("ul").slideDown();
        //     }
        // })



    });



    function collapse(id) {
        //e.preventDefault();

        var varClass = "#collapseLi"+id;



        if ($(varClass).hasClass("activado")) {
            $(varClass).removeClass("activado");
            $(varClass)
                .children("ul")
                .slideUp();
        } else {
            $(".menu li ul").slideUp();
            $(".menu li").removeClass("activado");
            $(varClass).addClass("activado");
            $(varClass)
                .children("ul")
                .slideDown();
        }

        // $(".menu li ul li a").click(function () {
        // window.location.href = $(this).attr("href");
        // });
    }



</script>

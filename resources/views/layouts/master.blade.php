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
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" >
    <meta name="app-url" content="{{ env('APP_URL') . '/' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-control" content="public">
    <title>Automart</title>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mazley_assets/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mazley_assets/owl-carousel/owl.theme.default.min.css') }}">
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('mazley_assets/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/alertify.min.js') }}"></script>
    {{-- <script src="{{asset('css/alertify.min.css')}}"></script> --}}
    {{-- <script src="{{asset('css/default.min.css')}}"></script> --}}
    {{-- <script src="{{asset('css/semantic.min.css')}}"></script> --}}
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    {{-- <script src="{{asset('css/bootstrap.min.css')}}"></script> --}}
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('mazley_assets/img/favicon-32x32.png') }}">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('mazley_assets/css/plugins.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('mazley_assets/css/style.css?v=0.5') }}">
    <link rel="stylesheet" href="{{ asset('css/xzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.raty.min.css') }}">
    <script src="{{ asset('js/jquery.raty.min.js') }}"></script>

    <script src="{{ asset('mazley_assets/js/masternew.js') }}"></script>

    <script>
        $(function() {
            var totalRows = 0;
            var totalIteration = 1;
            if ($("#searchPost")[0]) {
                $("#searchPost").autocomplete({
                    //  source: "{{ URL('/searchProducts?category=') }}",

                    source: function(request, response) {
                        $.ajax({
                            url: "{{ URL('searchProducts') }}",
                            dataType: "json",
                            data: {
                                term: request.term,
                                category: $("#select_category").children("option:selected")
                                    .val()
                            },
                            success: function(data) {

                                if (!data.length) {
                                    var result = [{
                                        image: '',
                                        name: 'no item found',
                                        url: '',
                                        row: '0'
                                    }];
                                    response(result);
                                } else {
                                    totalRows = data.length;
                                    totalIteration = 1;

                                    response(data);
                                }

                            }
                        });
                    },
                    extraParams: {
                        category: 4,
                    }
                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                    let URL = '{{ url('/') }}';
                    var itemImage = URL + "/" + item.image;
                    let resultLength = 25;
                    let itemName = item.name;

                    if (item.name.length > resultLength) {
                        itemName = item.name.substring(0, resultLength) + '...';
                    } else {
                        itemName = item.name;
                    }

                    var inner_html = '<div style="height:100%;width:100%;"><a href="' + item.url + '">'
                    inner_html += '<div class="list_item_container" ><div class="image">'
                    if (item.image != '') {
                        inner_html += '<img style="height:45px;width:45px;object-fit: contain;" src="' +
                            itemImage +
                            '"></div><div class="label">'
                    }

                    inner_html += '<h4 class="text-truncate text-dot">' + itemName + '</h4>'


                    inner_html += '</div></div></a></div>';

                    if (item.row == 0) {
                        inner_html +=
                            '<div data-toggle="modal" data-target="#exampleModal" style="height:100%;width:100%;background:white"><button class="btn btn-danger btn-block" style="height: 60px;background: #C70909">Request A Product</button></div>';

                    } else if (totalIteration == totalRows) {

                        inner_html +=
                            '<div data-toggle="modal" data-target="#exampleModal" style="height:100%;width:100%;background:white"><button class="btn btn-danger btn-block" style="height: 60px;background: #C70909">Request A Product</button></div>';

                        totalIteration = 1;
                    } else {

                        totalIteration++;
                    }

                    return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append(inner_html)
                        .appendTo(ul);
                };
            }

        });


        $(function() {
            if ($("#searchBarMobile")[0]) {
                $("#searchBarMobile").autocomplete({
                    //  source: "{{ URL('/searchProducts?category=') }}",
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ URL('searchProducts') }}",
                            dataType: "json",
                            data: {
                                term: request.term,
                                category: $("#select_category").children("option:selected")
                                    .val()
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    extraParams: {
                        category: 4
                    }
                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                    let URL = '{{ url('/') }}'
                    var itemImage = URL + "/" + item.image;
                    let resultLength = 25;
                    let itemName = item.name;

                    if (item.name.length > resultLength) {
                        itemName = item.name.substring(0, resultLength) + '...';
                    } else {
                        itemName = item.name;
                    }

                    var inner_html = '<div style="height:100%;width:100%;"><a href="' + item.url + '">'
                    inner_html += '<div class="list_item_container" ><div class="image">'
                    inner_html += '<img style="height:60px;width:60px;object-fit: contain;" src="' + itemImage +
                        '"></div><div class="label">'
                    inner_html += '<h4 class="text-truncate text-dot">' + itemName + '</h4>'
                    inner_html += '</div></div></a></div>';
                    return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append(inner_html)
                        .appendTo(ul);
                };
            }
        });

        function openSidebarParentCategory(categoryId) {
            $(`#subcat_${categoryId}`).parent().parent().children("ul").slideDown()
        }
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

        .req {
            position: fixed;
            bottom: 30px;
            left: 20px;
            width: 170px;
            height: 40px;
            z-index: 2 !important;
        }

        .show {
            display: block !important;
        }

        .showContent {
            /* visibility: hidden; */
            display: none;
        }

    </style>
</head>

<body>

    @if (Auth::user() != null)
        <input type="hidden" id="logged" value="{{ Auth::user()->id }}">
        <input type="hidden" id="logged_user_name" value="{{ Auth::user()->first_name }}">
    @else
        <input type="hidden" id="logged" value="0">
        <input type="hidden" id="logged_user_name" value="">
    @endif


    <a href="https://www.facebook.com/automartltd/" target="_blank" title="Send us a message on Facebook"
        class="ctrlq fb-button"></a>
    <a href="" class="req" data-toggle="modal" data-target="#exampleModal"><img
            src="{{ asset('mazley_assets/img/req__content.png') }}"></a>

    @yield('slider')
    @yield('content')
    @include('partials.footer')

    @yield('scripts')


</body>


<script src="{{ asset('mazley_assets/js/plugins.js') }}"></script>
<script src="{{ asset('mazley_assets/js/main.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}


{{-- @include('partials.script') --}}
@stack('footerasset')
<script>
    $('#category__goryTitle').click(function() {
        $('#allCategoryBox').toggleClass("show");
        $('.contenedor-menu ').toggleClass('showContent');
    });

    $(document).mouseup(function(e) {
        var container = $("#catgoryMenu");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {

            $('#allCategoryBox ').removeClass("show");
            $('.contenedor-menu ').removeClass('showContent')


        }
    });


    $(document).ready(function() {

        $(document).click(function(e) {
            if (!$(e.target).is('.categories_title')) {
                $('.categories_menu_toggle ').css("display", "none");
            }
        });

        if ($(window).width() < 960) {
            window.onload = function() {
                $('.ctrlq.fb-button').css("bottom", "80px")
            };
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 80) {
                    $('.btn__cart__float').css("bottom", "215px")
                    $('.fb-button').css("bottom", "165px");
                    $('.req').css("bottom", "165px");
                } else {
                    $('.btn__cart__float').css("bottom", "80px")
                    $('.fb-button').css("bottom", "30px");
                    $('.req').css("bottom", "30px");

                }
            });
        } else {
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                    $('.btn__cart__float').css("bottom", "220px");
                    $('.fb-button').css("bottom", "150px");
                    $('.req').css("bottom", "150px");
                } else {
                    $('.btn__cart__float').css("bottom", "20px");
                    $('.fb-button').css("bottom", "100px");
                    $('.req').css("bottom", "20px");
                }
            });
        }


        $("#openSideCartId").click(function() {
            $(".mini_cart").addClass('active');
            $(".off_canvars_overlay").addClass('active');
        });

        // stop searchbar redirect
        $("#searchPost").keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $("#searchBarMobile").keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

    });
</script>
<script src="{{ asset('js/xzoom.min.js') }}"></script>
<script src="{{ asset('mazley_assets/js/jquery.mousewheel.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.bigImage').xzoom({
            lensCollision: true,
            defaultScale: -1, //-100%
            smoothScale: 6,
            smoothZoomMove: 6,
            tint: '#fff',
        });
        $('.modal_tab_img > .item_modal_image').xzoom({
            zoomWidth: 200,
            title: true,
            tint: '#333',
            Xoffset: 15,
            lensShape: 'circle',
        });

        $(document).ready(function() {
            document.addEventListener("contextmenu", function(e) {
                if (e.target.nodeName === "IMG") {
                    e.preventDefault();
                }
            }, false);
        });
    });
</script>

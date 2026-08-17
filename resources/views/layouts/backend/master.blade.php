@include('partials.backend.header')


<body>
    <link rel="stylesheet" href="{{asset('css/invoiceSearch.css')}}">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>

        var pusher = new Pusher('d0ca855f1967975e3912', {
            authEndpoint :'broadcasting/auth',
            cluster: 'ap2',
            encrypted :true,
            auth:{

                headers : {
                'X-CSRF-Token':'{{csrf_token()}}'
                }
            }
            });

        var channel = pusher.subscribe('private-shipment-completed.1');
        channel.bind('shipment-completed', function(data) {
           // alert(JSON.stringify(data));

           var totalNotification = parseInt($("#notificationTotal").text());

           $("#notificationTotal").text(++totalNotification);

            var notification =      '<li class="list-group-item">';
                notification+=      '<a href="{{URL('')}}/'+data.route+'">';
                notification+=      '<div class="media">';
                notification+=      '<i class="zmdi zmdi-notifications-active fa-2x mr-3 text-danger"></i>';
                notification+=      '<div class="media-body">';
                notification+=      '<h6 class="mt-0 msg-title">New Shipment Completed</h6>';
                notification+=      '<p class="msg-info">'+data.message+'</p>';
                notification+=      '</div>';
                notification+=      '</div>';
                notification+=      '</a>';
                notification+=      '</li>';

            $("#notificationBody").append(notification);




           console.log(data.message);
        });





        var channel = pusher.subscribe('private-testChannel');
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });


        $(function () {
            $("#searchInvoice").autocomplete({
                source: "{{URL('/searchInvoiceAdmin')}}",
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                let URL = '{{ url('/') }}'
                var itemImage = URL + "/" + item.image;

                 console.log(item);
                // var inner_html = ' <div style="height:100%;width:100%;padding-top: 30px"><a href="' + item.url + '"> '
                // inner_html += '<div class="list_item_container" ><div class=""style="float: left;display: inline-block;padding-right: 10px">'
                // inner_html += '<h6>' + item.name +
                //     '</h6></div><div class="label px-3" style="float: left;display: inline-block;color: #555;background: #d4d4d4;width:auto;border-radius: 25px">'
                //         inner_html += item.order_code+'</div><div class="label">'

                // inner_html += '</div></div></a></div>';

                let ord_date = new Date(item.created_at);
                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

                inner_html = `<a href="${item.url}">
                    <div class="item-container">
                        <div class="invoice-info">
                            <h5 class="customer-name">${item.name.charAt(0).toUpperCase() + item.name.slice(1)}</h5>
                            <p style="color: #555"><span class="invoice-no">Invoice #${item.order_code}</span> |
                                <span class="date-invoice">
                                    ${ord_date.getDate()} ${monthNames[ord_date.getMonth()]} ${ord_date.getFullYear()}
                                </span>
                                <span class="date-invoice float-right bg-success text-white mx-2">
                                   ${item.status}
                                </span>
                            </p>
                            <p class='address-info'>${item.address}</p>
                        </div>
                   </div>
                </a>`;
                return $("<li class='pl-4 py-2'></li>")
                    .data("item.autocomplete", item)
                    .append(inner_html)
                    .appendTo(ul);
            };
        });


    </script>

    {{-- search result dropdown style --}}
    <style>
        #ui-id-1 {
            display: none;
            position: relative;
            top: -612px;
            left: 316px;
            width: 100px;
            max-height: 450px;
            overflow-y: scroll;
        }
    </style>

    <!-- start loader -->
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- end loader -->

    <!-- Start wrapper-->
    <div id="wrapper">

        <!--Start sidebar-wrapper-->
        @include('partials.backend.sidebar')
        <!--End sidebar-wrapper-->

        <!--Start topbar header-->
        @include('partials.backend.navbar')
        <!--End topbar header-->

        <div class="clearfix"></div>

        <div class="content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!--End content-wrapper-->
        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->


        <!--Start footer-->
        @include('partials.backend.footer')
        <!--End footer-->



        <!--start color switcher-->
        <div class="right-sidebar">
            <div class="switcher-icon">
                <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
            </div>
            <div class="right-sidebar-content">


                <p class="mb-0">Header Colors</p>
                <hr>

                <div class="mb-3">
                    <button type="button" id="default-header" class="btn btn-outline-primary">Default Header</button>
                </div>

                <ul class="switcher">
                    <li id="header1"></li>
                    <li id="header2"></li>
                    <li id="header3"></li>
                    <li id="header4"></li>
                    <li id="header5"></li>
                    <li id="header6"></li>
                </ul>

                <p class="mb-0">Sidebar Colors</p>
                <hr>

                <div class="mb-3">
                    <button type="button" id="default-sidebar" class="btn btn-outline-primary">Default Header</button>
                </div>

                <ul class="switcher">
                    <li id="theme1"></li>
                    <li id="theme2"></li>
                    <li id="theme3"></li>
                    <li id="theme4"></li>
                    <li id="theme5"></li>
                    <li id="theme6"></li>
                </ul>

            </div>
        </div>
        <!--end color switcher-->

    </div>
    <!--End wrapper-->
    @routes

    <!-- scripts -->
    @include('partials.backend.scripts')
    <!-- end scripts -->

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

</body>
</html>

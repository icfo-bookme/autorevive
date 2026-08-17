@extends('layouts.backend.master')
@section('content')
    <style>
        .card .table td,
        .card .table th {
            padding-right: 5px !important;
            padding-left: 5px !important;

        }

        .select2-container .select2-selection--single {
            box-sizing: border-box !important;
            cursor: pointer !important;
            display: block !important;
            height: 37px !important;
            user-select: none !important;
            -webkit-user-select: none !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            display: block !important;
            padding-top: 4px !important;
            padding-left: 15px !important;
            padding-right: 20px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px !important;
            position: absolute !important;
            top: 5px !important;
            right: 1px !important;
            width: 20px !important;
        }

    </style>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="purchaseInsertForm">
                        @csrf
                        <h4 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                            Purchase Setup
                        </h4>




                        <div class="row" id="itemInfo">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Car Number</th>

                                            </tr>
                                        </thead>

                                        <tbody id="product_list">
                                            <tr>
                                                <td class="my-3">
                                                    <input type="text" class="form-control" id="first_name" name="first_name[]" placeholder="first name">
                                                </td>

                                                <td class="my-3">
                                                    <input type="text" class="form-control" id="last_name" name="last_name[]" placeholder="last name">
                                                </td>

                                                <td class="my-3">
                                                    <input type="email" class="form-control" id="email" name="email[]" placeholder="email">
                                                </td>

                                                {{-- sales price is the offer price --}}
                                                <td class="my-3">
                                                    <input type="text" class="form-control" id="phone_number" name="phone_number[]" placeholder="phone number" required="required">
                                                </td>

                                                <td class="my-3">
                                                    <input type="text" class="form-control" id="car_no" name="car_no[]" placeholder="car number">
                                                </td>


                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 my-3">

                                <button type="button" class="btn btn-primary" id="add-row" onclick="addRow()">
                                    <div class="fonticon-wrap">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </button>

                                <button type="button" class="btn btn-danger" id="delete-row" onclick="deleteRow()">
                                    <div class="fonticon-wrap">
                                        <i class="icon-minus"></i>
                                    </div>
                                </button>

                            </div>

                        </div>

                        <div class="form-footer text-center">
                            <button type="button" class="btn btn-success" onclick="submitPurchase()"><i
                                    class="fa fa-check-square-o"></i> SAVE</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="clearForm()"><i
                                    class="fa fa-times"></i>Cancel</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="barcode-display-div"></div>

    <div class="modal" id="preloader" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <img src="{{ asset('assets/images/preloader.gif') }}"
                style="display: block;margin: auto;margin-top:50%;width: 10%;">
        </div>
    </div>

    <div class="modal fade" id="warningModalPurchase" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        style="overflow: scroll" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header" style="padding: 3px 15px !important;">
                    <h4 class="modal-title " style="font-size: 18px;">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div style="display:flex;justify-content: center;align-items:center;">
                        <img src="{{ asset('assets/images/warning.jpg') }}" alt="" style="width: 130px;height: 130px;">
                    </div>
                    <h6 class="text-danger text-center">Please SELECT any item from the dropdown option to purchase</h6>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(function() {
                $('#itemSelect').select2({
                    matcher: function(params, data) {
                        if ($.trim(params.term) === '') {
                            return data;
                        }

                        keywords = (params.term).split(" ");

                        for (var i = 0; i < keywords.length; i++) {
                            if (((data.text).toUpperCase()).indexOf((keywords[i])
                            .toUpperCase()) == -1)
                                return null;
                        }
                        return data;
                    }
                });
            });

            /* this portion is edited by Kawsar on 07-01-2020
            __________start here_______________*/
            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: false
            });

            var date = new Date();

            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();

            if (month < 10) month = "0" + month;
            if (day < 10) day = "0" + day;

            var today = year + "-" + month + "-" + day;
            $("#date").attr("value", today);
            $("input[type=number]").on('wheel.disableScroll', function(e) {
                e.preventDefault()
            });
        });

        var count = 0;
        const getDataArr = [];
        var dataArr = [];
        var itemIdCount = [];
        var itemCountInitial = [];

        function test(a) {
            var x = (a.value || a.options[a.selectedIndex].value); //crossbrowser solution =)
            getDataArr.push(x);
            console.log("getDataArr", getDataArr);
        }

        function addRow() {
            let itemId = 0;
            let disabledStatus = "";
            var markup = "";
            markup += "<tr>";
            markup += '<td>';
            markup +=
                '<input type="text" class="form-control" id="first_name" name="first_name[]" placeholder="first name">';
            markup += '</td>'
            markup += '<td>';
            markup +=
                '<input type="text" class="form-control" id="last_name" name="last_name[]" placeholder="last name">';
            markup += '</td>';

            markup += '<td>';
            markup +=
                '<input type="email" class="form-control" id="email" name="email[]" placeholder="email">';
            markup += '</td>';

            markup += '<td>';
            markup +=
                '<input type="text" class="form-control" id="phone_number" name="phone_number[]" placeholder="phone number" required="required">';
            markup += '</td>';

            markup += '<td>';
            markup +=
                '<input type="text" class="form-control" id="car_no" name="car_no[]" placeholder="car number">';
            markup += '</td>';

            markup += "</tr>";
            $("#itemInfo table tbody").append(markup);
            itemIdCount.push(count);
            $('#itemSelect' + count).select2();
            $('#itemSelect' + count).select2({
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    keywords = (params.term).split(" ");

                    for (var i = 0; i < keywords.length; i++) {
                        if (((data.text).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1)
                            return null;
                    }
                    return data;
                }
            });

            count++;
        }

        function deleteRow() {
            if ($("#itemInfo table tbody tr").length != 1) {
                $("#itemInfo table tbody tr:last").remove();
                itemIdCount.pop();
            }
        }
        function submitPurchase() {
            alertify.confirm("Are You Sure To Submit This?",
                    function() {
                        $('#preloader').modal('show');
                        var formData = new FormData($('#purchaseInsertForm')[0]);
                        console.log("form data", formData);
                        $.ajax({
                            type: 'post',
                            url: './addCustomer',
                            data: formData,
                            dataType: 'json',
                            enctype: 'multipart/form-data',
                            processData: false,
                            cache: false,
                            contentType: false,
                            timeout: 600000,
                            success: function(response) {
                                console.log(response);
                                $('#preloader').modal('hide');

                                if (response.status === true) {
                                    document.getElementById("purchaseInsertForm").reset();
                                    // let printContents = document.getElementById("barcode-display-div").innerHTML = response.data;
                                    //   var originalContents = document.body.innerHTML;
                                    //   document.body.innerHTML = printContents;
                                    //   window.print();
                                    //   document.body.innerHTML = originalContents;
                                    //   document.getElementById("barcode-display-div").innerHTML = null;

                                    //Loop over barcode images and download
                                    let a, fileName;
                                    response.data.forEach(image => {
                                        console.log(image);
                                        // create link, set href to blob
                                        fileName = image.split('/')[1];
                                        a = document.createElement('a');
                                        a.title = fileName;
                                        a.href = image;
                                        a.style.display = 'none';
                                        a.setAttribute("download", fileName);
                                        a.setAttribute("target", "_blank");
                                        // document.body.appendChild(a);

                                        // click item
                                        a.click();
                                    })
                                    setTimeout(function() {
                                        location.reload();
                                    }, 4000);

                                } else if (response.status === 'validation-error') {
                                    $.each(response.data, function(index, value) {
                                        alertify.error(value[0]);
                                    })
                                } else {
                                    alertify.error(response.message);
                                }
                            },

                            error: function(jqXHR, exception) {
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
                    }).setHeader('<em> CONFIRM </em> ')
        }

        function totalAmount() {
            var totalAmount = $('#total_amount').val();
            var paidAmount = $('#paid_amount').val()
            if (paidAmount == 0) {
                $('#due_amount').val(totalAmount)
            } else {

            }
        }

        function paidAmount() {
            var totalAmount = $('#total_amount').val();
            var paidAmount = $('#paid_amount').val()
            $('#due_amount').val(totalAmount - paidAmount)
        }

        function setTotalAmount(jqElem) {

            let total = 0;
            $.each($("#itemInfo table tbody tr"), (k, v) => {
                let cost = Number($(v).find('td:nth-child(2) input')[0].value);
                let quantity = Number($(v).find('td:nth-child(7) input')[0].value);
                let row_total = cost * quantity;
                console.log("hamida", cost, quantity, row_total);
                total += row_total;
            });

            $('#total_amount').val(total);
            totalAmount();
            paidAmount();


        }

        function clearForm() {
            $('#purchaseInsertForm').trigger('reset');
            history.go(0);
        }


        // function selectProduct(id) {
        //     $.ajax({
        //         type: 'post',
        //         url: '{{ URL('getPricesById') }}',
        //         data: {
        //             id: id
        //         },
        //         dataType: 'json',
        //         success: function (data) {
        //             console.log("hamida",data.cost_price, data.regular_price, data.sales_price);
        //             if (typeof data.errors !== 'undefined') {
        //                 alertify.warning("Something went wrong");
        //             } else {
        //                 $('#cost_price').val(data.cost_price);
        //                 $('#regular_price').val(data.regular_price);
        //                 $('#sales_price').val(data.sales_price);
        //             }

        //         },
        //         error: err => {
        //             alertify.error(err);
        //         }
        //     });
        // }
    </script>
@endsection

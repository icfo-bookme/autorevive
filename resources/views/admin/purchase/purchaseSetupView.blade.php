@extends('layouts.backend.master')
@section('content')
    <style>
        .card .table td,
        .card .table th {
            padding-right: 5px !important;
            padding-left: 5px !important;

        }

        .must {
            color: red;
            font-size: 15px;
            font-weight: bold
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

        .alertify-notifier .ajs-message.ajs-error{
            color: #fff !important;
            background: rgba(217, 92, 92, 0,95);
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
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

                        <div class="row my-3">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="py-3">
                                                    <label>Vendor<span class="must">*</span></label><br>
                                                    <select class="form-control form-control-sm js-select2" name="vendor_id"
                                                        id="vendor_id">
                                                        <option selected value="">---select vendor---</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </td>


                                                <td class="py-3">
                                                    <label>Invoice Number<span class="must">*</span></label>
                                                    <input type="text" class="form-control" id="input-1"
                                                        name="invoice_number" placeholder="invoice number" required>
                                                </td>
                                                <td class="py-3">
                                                    <label>Invoice Date</label>
                                                    <input type="date" class="form-control" id="date"
                                                        name="purchase_date" required max="{{date('Y-m-d')}}">
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="py-3">
                                                    <label>Total Amount </label>
                                                    <input type="number" step="any" min='0' class="form-control"
                                                        onkeyup="totalAmount()" id="total_amount" name="total_amount"
                                                        placeholder="Total Amount" required readonly>
                                                </td>
                                                <td class="py-3">
                                                    <label>Paid Amount </label>
                                                    <input type="number" step="any" min='0' class="form-control"
                                                        onkeyup="paidAmount()" id="paid_amount" value="0" min="0"
                                                        name="paid_amount" placeholder="Paid Amount" required>
                                                </td>
                                                <td class="py-3">
                                                    <label>Due Amount </label>
                                                    <input type="number" step="any" min='0' class="form-control"
                                                        id="due_amount" name="due_amount" value="0" placeholder="Due Amount"
                                                        required readonly>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



                        <div class="row" id="itemInfo">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Item</th>
                                                <th scope="col">Cost Price</th>
                                                <th scope="col">Regular Price</th>
                                                <th scope="col">Offer Price</th>
                                                <th scope="col">Wholesale Price</th>
                                                <th scope="col">Mrp</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Publish Status</th>
                                                <th scope="col">Uom</th>
                                                {{--<th scope="col">Print Barcode</th>--}}
                                                {{-- <th scope="col">Expired Date</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody id="product_list">
                                            <tr>
                                                <td class="my-3">
                                                    {{-- <select class="form-control js-select2" id="itemSelect" name="item_id[]"
                                                        style="min-width: 140px;" onchange="selectProduct(this.value)"> --}}
                                                    <select onchange="test(this)" class="form-control js-select2" id="itemSelect" name="item_id[]"
                                                        style="min-width: 140px;">
                                                        <option selected value="">---select Item---</option>
                                                        @foreach ($items as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="my-3">
                                                    <input type="number" step="any" min='0' class="form-control cost_price"
                                                        id="cost_price" name="cost_price[]" placeholder="Cost Price" required
                                                        style="min-width: 80px" oninput="setTotalAmount(this)">
                                                </td>

                                                <td class="my-3">
                                                    <input type="number" step="any" min='0' class="form-control"
                                                           id="regular_price" name="regular_price[]" placeholder="Regular price"
                                                           required>
                                                </td>

                                                {{-- sales price is the offer price --}}
                                                <td class="my-3">
                                                    <input type="number" step="any" min='0' class="form-control"
                                                        id="sales_price" name="sales_price[]" placeholder="Offer Price"
                                                        required>
                                                </td>

                                                <td class="my-3">
                                                    <input type="number" step="any" min='0' class="form-control"
                                                        id="wholesale_price" name="wholesale_price[]" placeholder="Wholesale Price"
                                                        required>
                                                </td>

                                                <td class="my-3">
                                                    <input type="number" step="any" min='0' class="form-control"
                                                        id="input-1" name="mrp[]" placeholder="mrp" required
                                                        style="min-width: 80px">
                                                </td>


                                                <td class="my-3">
                                                    <input type="number" step="any" min='0' class="form-control quantity"
                                                        oninput="setTotalAmount(this)" id="input-1" name="quantity[]"
                                                        placeholder="quantity" required style="min-width: 80px">
                                                </td>
                                                <td>
                                                    <select class="form-control" name="is_published[]">
                                                        <option value="1">Publish</option>
                                                        <option value="0">Pending</option>
                                                    </select>
                                                </td>


                                                <td class="my-3">

                                                    <select name="uom[]" id="uom" class="form-control"
                                                        style="min-width: 90px">
                                                        <option value="" selected>--SELECT--</option>
                                                        <option value="Kg">Kg</option>
                                                        <option value="gm">gm</option>
                                                        <option value="Lt">Lt</option>
                                                        <option value="ml">ml</option>
                                                        <option value="Pound">Pound</option>
                                                        <option value="Pieces" selected>Pieces</option>
                                                        <option value="Box">Box</option>
                                                        <option value="Dozen">Dozen</option>
                                                        <option value="Sqft">Sqft</option>
                                                        <option value="Set">Set</option>
                                                    </select>

                                                </td>

{{--                                                <td class="my-3">--}}
{{--                                                    <input type="number" min='0' class="form-control quantity"--}}
{{--                                                           name="print_barcode[]" placeholder="Number of copy"--}}
{{--                                                           required style="min-width: 80px">--}}
{{--                                                </td>--}}



                                                {{-- <td class="my-3">
                                                    <input type="date" class="form-control" id="input-1"
                                                        name="expired_date[]" placeholder="Expired Date" required style="">
                                                </td> --}}


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

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mt-4">
                                    <label class="form-check-label">Challan Image</label>
                                </div>
                                <div class="form-group my-2">
                                    <input type="file" id = "input_img" name="input_img" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label for="remarks" class="col-form-label">Remarks</label>
                                <textarea class="form-control" rows="2" id="remarks" name="remarks" spellcheck="true" placeholder="Add Notes Here..."></textarea>
                            </div>
                        </div>

                        <div class="mx-auto">
                            <div class="col-lg-12 pt-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="highlights" value="1">
                                    <label class="form-check-label">Highlight</label>
                                </div>
                            </div>
                        </div>

                         {{-- <div class="mx-auto my-3">
                             <div class="col-lg-12 pt-4">
                                 <div class="form-check form-check-inline">
                                     <input class="form-check-input" type="checkbox" name="sales_price_show_in_barcode" value="1">
                                     <label class="form-check-label">Offer Price Show In Barcode</label>
                                 </div>
                             </div>
                         </div> --}}


                        <div class="form-footer text-center">
                            <button type="button" class="btn btn-success" onclick="submitPurchase()"><i
                                    class="fa fa-check-square-o"></i> PURCHASE</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="clearForm()"><i
                                    class="fa fa-times"></i>Cancel</button>
                            {{-- <button type="button" class="btn btn-info" onclick="submitDraftedPurchase()"><i
                                    class="fa fa-file"></i> DRAFT</button> --}}
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id = "barcode-display-div"></div>

    <div class="modal" id="preloader" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <img src="{{ asset('assets/images/preloader.gif') }}"
                 style="display: block;margin: auto;margin-top:50%;width: 10%;">
        </div>
    </div>
    
    <div class="modal fade" id="warningModalPurchase" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" style="overflow: scroll" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header" style="padding: 3px 15px !important;">
                    <h4 class="modal-title " style="font-size: 18px;">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                     <div style="display:flex;justify-content: center;align-items:center;">
                        <img src="{{asset('assets/images/warning.jpg')}}" alt="" style="width: 130px;height: 130px;">
                     </div>
                    <h6 class="text-danger text-center">Please SELECT any item from the dropdown option to purchase</h6>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(function () {
                $('#itemSelect').select2({
                    matcher: function (params, data) {
                        if ($.trim(params.term) === '') {
                            return data;
                        }

                        keywords=(params.term).split(" ");

                        for (var i = 0; i < keywords.length; i++) {
                            if (((data.text).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1)
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
            $("input[type=number]").on('wheel.disableScroll', function (e) {
                    e.preventDefault()
            });
        });

        var count = 0;
        const getDataArr = [];
        var dataArr = [];
        var itemIdCount = [];
        var itemCountInitial = [];
        function test(a) {
            var x = (a.value || a.options[a.selectedIndex].value);  //crossbrowser solution =)
            getDataArr.push(x);
            console.log("getDataArr", getDataArr);
        }

        function addRow() {
            let itemId = 0;
            let disabledStatus = "";
            var markup = "";
            markup += "<tr>";
            markup += '<td>';
            markup += '<select class="form-control form-control-sm js-select2" onchange="test(this)" id="itemSelect' + count +
                '" name="item_id[]">';
            markup += '<option selected value="">---select Item---</option>';
            markup +='@foreach ($items as $item)';
            itemId = "{{ $item->id }}";
            disabledStatus = "";
            if(getDataArr.includes(itemId)){
                disabledStatus = "disabled";
            }
            markup += '<option value="{{ $item->id }}" '+disabledStatus+'>{{ $item->name }}</option>';
            markup += '@endforeach ';
            markup += '</select>';
            markup += '</td>';

            markup += '<td>';
            markup +=
                '<input type="number" step="any" min="0" class="form-control cost_price" oninput="setTotalAmount(this)" id="cost_price" name="cost_price[]" placeholder="Cost Price" required>';
            markup += '</td>';

            markup += '<td>';
            markup +=
                '<input type="number" step="any" min="0" class="form-control" id="regular_price" name="regular_price[]" placeholder="Regular price" required>';
            markup += '</td>';

            markup += '<td>';
            markup +=
                '<input type="number" step="any" min="0" class="form-control" id="sales_price" name="sales_price[]" placeholder="Offer price" required>';
            markup += '</td>';

            markup += '<td>';
            markup +=
                '<input type="number" step="any" min="0" class="form-control" id="wholesale_price" name="wholesale_price[]" placeholder="Wholesale Price" required>';
            markup += '</td>';

            markup += '<td>';
            markup +=
                '<input type="number" step="any" min="0" class="form-control" id="input-1" name="mrp[]" placeholder="mrp" required>';
            markup += '</td>';


            markup += '<td>';
            markup +=
                '<input type="number" step="any" min="0" class="form-control quantity" oninput="setTotalAmount(this)" id="input-1" name="quantity[]" placeholder="quantity" required>';
            markup += '</td>';

            markup +=
                '<td><select class="form-control" name="is_published[]"><option value="1">Publish</option><option value="0">Pending</option></select></td>';

            markup += '<td>';
            markup += '<select name="uom[]" id="uom" class="form-control">';
            markup += '<option value="" selected>--SELECT--</option>';
            markup += '<option value="Kg">Kg</option>';
            markup += '<option value="gm">gm</option>';
            markup += '<option value="Lt">Lt</option>';
            markup += '<option value="ml">ml</option>';
            markup += '<option value="Pound">Pound</option>';
            markup += '<option value="Pieces" selected>Pieces</option>';
            markup += '<option value="Box">Box</option>';
            markup += '<option value="Dozen">Dozen</option>';
            markup += '<option value="Sqft">Sqft</option>';
            markup += '<option value="Set">Set</option>';
            markup += '</select>';
            markup += '</td>';

            // markup += '<td>';
            // markup +=
            //     '<input type="number" min="0" class="form-control"  name="print_barcode[]" placeholder="Number of copy" required>';
            // markup += '</td>';

            // markup += '<td>';
            // markup +=
            //     '<input type="date" class="form-control" id="input-1" name="expired_date[]" placeholder="Expired Date" required>';
            // markup += '</td>';


            markup += "</tr>";
            $("#itemInfo table tbody").append(markup);
            itemIdCount.push(count);
            $('#itemSelect' + count).select2();
            $('#itemSelect'+count).select2({
                matcher: function (params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    keywords=(params.term).split(" ");

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
            setTotalAmount();
        }


        // $(document).ready(function() {
        // $('input[type="file"]').change(function(event) {
        //     var _size = this.files[0].size;
        //     var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
        // 	i=0;while(_size>900){_size/=1024;i++;}
        //     var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
        //         console.log('FILE SIZE = ',exactSize);
        // 	alert(exactSize);
        //     });
        // });
        // $('#itemSelect').on('select2:select', function (e) {
        //         var data = e.params.data;
        //         itemCountInitial.push(data);
        //         console.log("mark update....", data);
        // });


        function submitPurchase() {
            let due = $('#due_amount').val();
            // var input = document.getElementById('input_img');
            // var file = input.files[0];
            // console.log("size",file.size);
            // console.log("in data array", dataArr.length);
            
            console.log("in item id array ", itemIdCount);
            // console.log("in item id array initial", itemCountInitial.length);
            if(due >= 0){
                if(getDataArr.length != 0 && getDataArr.length > itemIdCount.length){
                    alertify.confirm("Are You Sure To Submit This?",
                    function() {
                        $('#preloader').modal('show');
                        var formData = new FormData($('#purchaseInsertForm')[0]);
                        $.ajax({
                            type: 'post',
                            url: './purchaseInserAjax',
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

                                if(response.status === true){
                                    alertify.success(response.message);
                                    document.getElementById("purchaseInsertForm").reset();
                                    // let printContents = document.getElementById("barcode-display-div").innerHTML = response.data;
                                    //   var originalContents = document.body.innerHTML;
                                    //   document.body.innerHTML = printContents;
                                    //   window.print();
                                    //   document.body.innerHTML = originalContents;
                                    //   document.getElementById("barcode-display-div").innerHTML = null;

                                    //Loop over barcode images and download
                                    let a,fileName;
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

                                } else if(response.status === 'validation-error'){
                                        $.each(response.data, function(index, value){
                                            alertify.error(value[0]);
                                        })
                                }else {
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
                }else{
                    $('#warningModalPurchase').modal('show');
                }
            }else{
                alertify.error('Invalid entry: Due amount must be zero or greater.');
            }
        }

        function submitDraftedPurchase() {
            let due = $('#due_amount').val();
            if(due == 0){
                if(getDataArr.length != 0 && getDataArr.length > itemIdCount.length){
                    alertify.confirm("Are You Sure To Submit This?",
                    function() {
                        $('#preloader').modal('show');
                        var formData = new FormData($('#purchaseInsertForm')[0]);
                        $.ajax({
                            type: 'post',
                            url: './draftedPurchaseInserAjax',
                            data: formData,
                            dataType: 'json',
                            enctype: 'multipart/form-data',
                            processData: false,
                            cache: false,
                            contentType: false,
                            timeout: 600000,
                            success: function(response) {
                                $('#preloader').modal('hide');

                                if(response.status === true){
                                    alertify.success(response.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 4000);

                                } else if(response.status === 'validation-error'){
                                        $.each(response.data, function(index, value){
                                            alertify.error(value[0]);
                                        })
                                }else {
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
                }else{
                    $('#warningModalPurchase').modal('show');
                }
            }else{
                alertify.error('Clear Due Amount');
            }
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
            var dueAmount = totalAmount - paidAmount;
            $('#due_amount').val(dueAmount.toFixed(2));
        }

        function setTotalAmount(jqElem) {

            let total = 0;
            $.each($("#itemInfo table tbody tr"), (k, v) => {
                let cost = Number($(v).find('td:nth-child(2) input')[0].value);
                let quantity = Number($(v).find('td:nth-child(7) input')[0].value);
                let row_total = cost * quantity;
                console.log("hamida", cost,quantity,row_total);
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

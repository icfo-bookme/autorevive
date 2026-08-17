@extends('layouts.backend.master')
@section('content')
@php
$userid=Auth::user()->id;
@endphp
    <style>
        #modal_image {
            max-width: 250px;
            max-height: 250px;
            object-fit: contain;
        }

        .table td {
            padding: 5px ;
        }
   
        img{
            max-height: 50px;
            min-height: 50px;
            object-fit: contain;
        }
        .card-body{
            padding-top: 0!important;
        }
        div.dataTables_wrapper div.dataTables_processing{
            background-color: transparent !important;
            z-index: 1 !important;
            box-shadow:none !important;
        }
        .processingColor{
            color: #7934f3;
        }
        #modal_details table{
           width:100% !important;
           
    }
        /* .modal-body {
    overflow-x: auto !important; 
    overflow-y: auto !important; 
} */

    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Stock View</div>
                <div class="card-body">
                    <div class="float-right mb-3"></div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="stockTable" class="table table-bordered table-hover table-checkable">
                            <thead class="text-center">
                            <tr>
                                <th>Confirm</th>
                                <th>Cancel</th>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                {{-- <th>Item Image</th> --}}
                                <th>Quantity</th>
                                <th>UOM</th>
                                <th>Cost Price</th>
                                <th>Category</th>
                                <th>Section</th>
                                <th>Regular Price</th>
                                <th>Offer Price</th>
                                <th>Wholesale Price</th>
                                {{-- <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="itemDetailsModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" style="overflow: scroll" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card" style="box-shadow: none;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <img src="" alt="" id="modal_image">
                            </div>
                            <div class="col-sm-7">
                                <h4 id="modal_header"></h4>
                                <h6 id="modal_price" class="text-danger"></h6>
                                <h6 id="modal_stock" class="text-info"></h6>
                                <p id="modal_details" style="overflow-x: auto"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Purchase edit from Stock modal --}}
    <div class="modal fade" id="editPurchaseModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated flipInX">
                <div class="modal-header">
                    <h4 class="modal-title " style="font-size: 18px;">Purchase Edit From Stock</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                   <h6 class="form-header text-uppercase text-center"> Invoice Number: <span id = "invoiceNumber"></span> </h6>
                   <p class="text-center">Invoice Date: <span id = "invoiceDate"></span></p>
                   <form class="form" method="POST" id="editPurchaseForm">
                       <div class="form-body">
                           <input type="hidden" id="update_purchase_id" name="purchase_id">
                           <input type="hidden" id="update_purchase_details_id" name="purchase_details_id">
                           <input type="hidden" id="update_purchase_item_barcode_id" name="purchase_item_barcode_id">
                           <input type="hidden" id="update_item_id" name="item_id">

                           <div class="form-group row">
                               <div class="col-md-4">
                                   <label>Total Amount</label>
                                   <input type="number" id="update_total_amount" name="total_amount" class="form-control square" readonly>
                               </div>
                               <div class="col-md-4">
                                   <label>Paid</label>
                                   <input type="number" id="update_paid_amount" name="paid_amount" class="form-control square"
                                        oninput="paidAmount(this)">
                               </div>
                               <div class="col-md-4">
                                   <label>Due</label>
                                   <input type="number" id="update_due_amount" name="due_amount" class="form-control square" readonly>
                               </div>
                           </div>
                           <div class="form-group row d-flex justify-content-start align-items-center">
                               <label class="col-md-3">Item name :</label>
                               <div class="col-md-5">
                                   <input id="item_name" name="item_name" class="form-control square" readonly>
                               </div>
                           </div>
                           <div class="form-group row justify-content-start align-items-center">
                                <label class="col-md-3">Quantity :</label>
                                <div class="col-md-5">
                                    <input type="number" step="any" min="1" class="form-control" id="update_quantity" name="quantity"
                                        oninput="setTotalAmount(this)">
                                </div>
                            </div>
                            <div class="form-group row justify-content-start align-items-center">
                                    <label class="col-md-3">Already Sold:</label>
                                    <div class="col-md-5">
                                        <input type="number" class="form-control" id="sold_quantity" readonly>
                                    </div>
                            </div>
                            <div class="form-group row d-flex justify-content-start align-items-center">
                                <label class="col-md-3">Cost price :</label>
                                <div class="col-md-5">
                                    <input type="number" id="update_cost_price" name="cost_price" class="form-control square" readonly>
                                </div>
                            </div>

                            <div class="form-group row justify-content-start align-items-center">
                                    <label class="col-md-3">Regular Price :</label>
                                    <div class="col-md-5">
                                        <input type="number" min="1" id="update_regular_price" name="regular_price" class="form-control square">
                                    </div>
                            </div>
                            <div class="form-group row justify-content-start align-items-center">
                                <label class="col-md-3">Offer price :</label>
                                <div class="col-md-5">
                                    <input type="number" min="1" id="update_sales_price" name="sales_price" class="form-control square">
                                </div>
                            </div>
                            <div class="form-group row justify-content-start align-items-center">
                                <label class="col-md-3">Wholesale price :</label>
                                <div class="col-md-5">
                                    <input type="number" min="1" id="update_wholesale_price" name="wholesale_price" class="form-control square">
                                </div>
                            </div>

                            </div>

                           <div class="modal-footer">
                               <div class="col text-center">
                                @if ($userid==env('SUPERADMIN_ID'))
                                   <button type="button" class="btn btn-primary" onclick="purchaseUpdateFromStock()">
                                       <i class="icon-cross2"></i> save
                                   </button>

                                   <button type="button" class="btn btn-danger" data-dismiss="modal">
                                       <i class="icon-cross2"></i> Cancel
                                   </button>
                                @endif
                               </div>
                           </div>
                       </div>
                   </form>
                </div>

            </div>
        </div>




    <script>
        $(document).ready(function () {

            let existing_cost = 0;
            let existing_total_amount = 0;


            const csrf_token = "{{ csrf_token() }}";
            // #### DATATABLE
            var dataTable = $('#stockTable').DataTable({
                responsive: true,
                lengthMenu: [5, 10, 25, 50, 100, 500],
                pageLength: 10,
                stateSave: true,
                language: {
                    'lengthMenu': 'Display _MENU_',
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw processingColor"></i>'
                },
                scrollY: 450,
                scrollX: true,
                scrollCollapse: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: route('listAllStocks'),
                    data: function (data) {
                        data._token = csrf_token;
                    },
                    type: 'post',
                },
                columns: [
                    {data: 'data_duplicate_flag', name: 'duplicate_flag', "orderable": false, searchable: false, width: "10%"},
                    {data: 'data_cross_flag', name: 'cross_flag', "orderable": true, searchable: false, width: "10%"},
                    {data: 'barcode', name: 'barcode', "orderable": false, searchable: true, width: "10%"},
                    {data: 'data_item_name', name: 'item.name', "orderable": true, "searchable": true, width: "10%"},
                    // {
                    //     data: 'data_item_image',
                    //     name: 'item.thumbnail',
                    //     "orderable": true,
                    //     "searchable": true,
                    //     width: "10%"
                    // },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {data: 'uom', name: 'uom', "orderable": false, searchable: true, width: "10%"},
                    {data: 'cost_price', name: 'cost_price', "orderable": true, "searchable": true, width: "10%"},
                    {
                        data: 'data_item_category_name',
                        name: 'item.category.name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {data: 'data_item_section_name', name: 'item.section.name', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'purchase_item_barcode.regular_price', name: 'purchase_item_barcode.regular_price', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'purchase_item_barcode.sales_price', name: 'purchase_item_barcode.sales_price', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'data_wholesale_price', name: 'data_wholesale_price', "orderable": true, "searchable": true, width: "10%"},

                    {data: 'action', name: 'action', "orderable": false, searchable: false, width: "10%"},
                ],
                dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],

            });
        });

        $("#update_quantity").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "1")
            }
        })


        /**
         * @name itemDetails
         * @role fetch info and load them into modal
         * @param id
         * @return
         *
         */
        function itemDetails(stockId) {
            $.ajax({
                url: `{{ URL('getItemDetailsForStockView/${stockId}') }}`,
                type: 'GET',
                success: response => {
                    if(response.status){
                        let stockData = response.data;
                        $('#modal_image').attr('src', stockData.item.thumbnail);
                        $('#modal_header').text(stockData.item.name);
                        $('#modal_price').text('৳' + stockData.purchase_item_barcode.sales_price);
                        $('#modal_stock').text(stockData.quantity + ' ' + stockData.uom + ' ' + ' in stock.');
                        $('#modal_details').html(stockData.item.details);
                        $('#itemDetailsModal').modal('show');
                    }
                }
            });
        }

        function setTotalAmount() {
            let quantity = $('#update_quantity').val();
            let cost_price = $('#update_cost_price').val();
            let changed_cost = cost_price * quantity;

            let new_total_amount = (existing_total_amount - existing_cost) + changed_cost;
            let updateTotal = $('#update_total_amount').val(new_total_amount);
            paidAmount();
        }


        function paidAmount() {
            var totalAmount = $('#update_total_amount').val();
            var paidAmount  = $('#update_paid_amount').val();
            $('#update_due_amount').val(totalAmount - paidAmount);
        }


        function editPurchaseModal(stockId){
            $.ajax({
                url: "{{ URL('getPriceAndQuantityForStockEdit') }}",
                method: "POST",
                data: {
                    stockId: stockId
                },
                dataType: "json",
                success: function (response) {
                    if(response.status){
                        let stockDetails = response.data.stockDetails;
                        let purchaseData = response.data.purchaseData;
                        let purchaseDetailsData = response.data.purchaseDetailsData;
                        let purchaseItemBarcodeData = response.data.purchaseItemBarcodeData;
                        let itemData = response.data.itemData;


                        $("#invoiceNumber").text(purchaseData.invoice_number);
                        $("#invoiceDate").text(purchaseData.purchase_date);
                        $("#update_purchase_id").val(purchaseData.id);
                        $("#update_purchase_details_id").val(purchaseDetailsData.id);
                        $("#update_purchase_item_barcode_id").val(purchaseItemBarcodeData.id);
                        $("#update_item_id").val(itemData.id);
                        $("#item_name").val(itemData.name);
                        $("#update_total_amount").val(purchaseData.total_amount);
                        $("#update_paid_amount").val(purchaseData.paid_amount);
                        $("#update_due_amount").val(purchaseData.due_amount);
                        $("#update_cost_price").val(purchaseDetailsData.cost_price);
                        $("#update_quantity").val(purchaseDetailsData.quantity);
                            existing_cost = purchaseDetailsData.cost_price * purchaseDetailsData.quantity;
                            existing_total_amount = purchaseData.total_amount;
                        $("#update_regular_price").val(purchaseItemBarcodeData.regular_price);
                        $("#update_sales_price").val(purchaseItemBarcodeData.sales_price);
                        $("#update_wholesale_price").val(purchaseDetailsData.wholesale_price);

                        let purchasedQuan = purchaseDetailsData.quantity;
                        let stockQuan = stockDetails.quantity;
                        $("#sold_quantity").val(purchasedQuan - stockQuan);

                        $("#editPurchaseModal").modal('show');
                    }
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.Verify Network.';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        alertify.warning(msg);
                        $('#preloader').modal('hide');
                    }
                }
            });
        }


        function purchaseUpdateFromStock() {
            event.preventDefault();
            alertify.confirm('Are You Sure ?', 'Purchase Will Be Updated', function () {
                $('#preloader').modal('show');
                $.ajax({
                    url: "{{ URL('purchaseUpdateFromStock') }}",
                    method: "POST",
                    data: $('#editPurchaseForm').serialize(),
                    success: function (result) {
                        if (result == "Success") {
                            alertify.success('Successfully Data Updated');
                            $('#preloader').modal('hide');
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000);

                        } else if (result.errors) {
                            console.log(result.errors);
                            $.each(result.errors, (index, value) => {
                                        alertify.error(value[0]);
                                    });
                            $('#preloader').modal('hide');

                        } else {
                            alertify.error('Error Found!');
                            $('#preloader').modal('hide');
                        }
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');

                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        }
                    }
                });
            }, function () {
                alertify.error('Cancel')
            });
        }


        function editRequest(userId,userName,currentUrl,previousUrl) {
            event.preventDefault();
            alertify.confirm('Are You Sure ?', 'Edit request will be sent', function () {
                $('#preloader').modal('show');
                $.ajax({
                    url: "{{ URL('editRequestAjax') }}",
                    method: "POST",
                    data: {
                        userId:userId,
                        userName:userName,
                        currentUrl:currentUrl,
                        previousUrl:previousUrl
                    },
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {
                            alertify.warning('Something Went Wrong');
                        } else {
                            alertify.success(data);
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000)

                        }
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');

                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        }
                    }
                });
            }, function () {
                alertify.error('Cancel')
            });
        }


        function duplicateFlag(id) {
                    $.ajax({
                        type: 'post',
                        url: './duplicateFlagAjax',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: response => {
                            if(response.status === true) {
                                alertify.success(response.message);
                            } else {
                                alertify.error(response.message);
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
        }

        function crossFlag(id) {
            $.ajax({
                type: 'post',
                url: './crossFlagAjax',
                data: {
                    id: id
                },
                dataType: 'json',
                success: response => {
                    if(response.status === true) {
                        alertify.success(response.message);
                        $('#stockTable').DataTable().ajax.reload();
                    } else {
                        alertify.error(response.message);
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
        }

    </script>

@endsection

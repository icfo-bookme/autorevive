@extends('layouts.backend.master')
@section('content')
<style>
    .footer {
        position: fixed !important;
        left: 0px !important;
        bottom: 0 !important;
    }
</style>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <h4 class="form-header text-uppercase text-center"> {{$itemTable->name}} </h4>
                            <form class="form" method="POST" id="updateItemPriceForm">
                                <div class="form-body">
                                    <input type="hidden" id="item_id" name="item_id" value="{{$itemTable->id}}">

                                    <div class="form-group row">
                                        <label class="col-md-3">Regular Price :</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="regular_price" id="update_regular_price" value="{{$itemTable->regular_price}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3">Offer Price :</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="sales_price" id="update_sales_price" value="{{$itemTable->sales_price}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3">Publish Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-control-sm" name="is_published" id="update_is_published">
                                                <option disabled selected value="">---select---</option>
                                                <option value="1" @if (@$itemTable->is_published == 1) selected @endif>Publish</option>
                                                <option value="0" @if (@$itemTable->is_published == 0) selected @endif>Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin:20px 20px;">
                                        <div class="col text-center">
                                            @if(auth()->user()->id == 1)
                                                <button type="button" class="btn btn-primary" onclick="itemPriceUpdate()">
                                                    <i class="icon-cross2"></i> save
                                                </button>
                                            @endif

                                                <button type="button" class="btn btn-danger"  onclick="window.history.back()">
                                                    <i class="icon-cross2"></i> Cancel
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </form>



                            {{-- Purchase List Div --}}
                            <div class="row col-lg-12 mt-4"><label for="">Purchase List</label></div>
                            <div class="row" id="itemInfo">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Invoice Id</th>
                                                <th>Cost Price</th>
                                                <th>Wholesale Price</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="selected_tbl">
                                            @foreach($productdetailsTable as $purchaseDetails)
                                            <tr>
                                                <td style="max-width: 20%; white-space: break-spaces;">{{$purchaseDetails->purchase['invoice_number']}}</td>
                                                <td style="max-width: 20%; white-space: break-spaces;">{{$purchaseDetails->cost_price}}</td>
                                                <td style="max-width: 20%; white-space: break-spaces;">{{$purchaseDetails->wholesale_price}}</td>
                                                <td style="max-width: 20%; white-space: break-spaces;">{{$purchaseDetails->quantity}}</td>
                                                <td class="whiteSpace_normal">
                                                    @if(auth()->user()->id == 1)
                                                    <button class="btn btn-primary btn-xs" onclick="editPurchaseDetails({{$purchaseDetails->id}})">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                    @endif

                                                    <a class="btn btn-primary btn-xs" href="{{@asset($purchaseDetails->purchase_item_barcode->barcode_image)}}" download><i class="fa fa-download"></i> Barcode</a>

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Purchase edit modal --}}
    <div class="modal fade" id="editPurchaseModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated flipInX">
                <div class="modal-header">
                    <h4 class="modal-title " style="font-size: 18px;">Edit Purchase Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <h6 class="form-header text-uppercase text-center"> Invoice Number: <span id = "invoiceNumber"></span> </h6>
                    <p class="text-center">Invoice Date: <span id = "invoiceDate"></span></p>
                    <form class="form" method="POST" id="editPurchaseForm">
                        <div class="form-body">
                            <input type="hidden" id="update_purchase_id" name="purchase_id">
                            <input type="hidden" id="update_purchase_details_id" name="purchase_details_id">
                            <input type="hidden" id="item_id" name="item_id" value="{{$itemTable->id}}">

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Total Amount</label>
                                    <input type="number" id="update_total_amount" name="total_amount" class="form-control square"
                                        name="" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>Paid Amount</label>
                                    <input type="number" id="update_paid_amount" name="paid_amount" class="form-control square"
                                     oninput="paidAmount(this)" name="" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Due Amount</label>
                                    <input type="number" id="update_due_amount" name="due_amount" class="form-control square" name="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3">Cost price :</label>
                                <div class="col-md-9">
                                    {{-- <input type="hidden" id="stock_id" name="stock_id"> --}}
                                    <input type="number" id="update_cost_price" name="cost_price" class="form-control square"
                                        name="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3">Wholesale price :</label>
                                <div class="col-md-9">
                                    {{-- <input type="hidden" id="stock_id" name="stock_id"> --}}
                                    <input type="number" min="1" id="update_wholesale_price" name="wholesale_price" class="form-control square"
                                        name="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3">Quantity :</label>
                                <div class="col-md-9">
                                    <input type="number" step="any" min="1" class="form-control" id="update_quantity" name="quantity"
                                        oninput="setTotalAmount(this)" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="col text-center">
                                <button type="button" class="btn btn-primary" onclick="purchaseUpdateFromStock()">
                                    <i class="icon-cross2"></i> save
                                </button>

                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



<!-- loader modal -->
<div class="modal" id="preloader" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <img src='{{asset('assets/images/preloader.gif')}}'
            style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>


<script>
    $(document).ready(function(){
        $(".js-select2").select2({
            closeOnSelect: true
        });

        $('#selected_tbl_invoice').on("DOMSubtreeModified", function () {
            calculateTotal();
        });

        let existing_cost = 0;
        let existing_total_amount = 0;
    });

    $("#update_quantity").on("input", function() {
        if (/^0/.test(this.value)) {
            this.value = this.value.replace(/^0/, "1")
        }
    })

    function itemPriceUpdate() {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
            $('#preloader').modal('show');
            $.ajax({
                url: "{{ URL('updateItemPrice') }}",
                method: "POST",
                data: $('#updateItemPriceForm').serialize(),
                success: function (result) {
                    console.log("success")
                    if (result == "Success") {
                        alertify.success('Successfully Data Updated');
                        $('#preloader').modal('hide');
                        setTimeout(function () {
                            location.reload(true);
                        }, 1000);

                    } else {

                        alertify.error('Error Found!');
                        $('#preloader').modal('hide');
                        setTimeout(function () {
                            //   location.reload(true);
                        }, 1000);

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

    function editPurchaseDetails(purchaseDetailsId) {
        $.ajax({
            url: "{{ URL('getPurchaseDetails') }}",
            method: "POST",
            data: {
                id: purchaseDetailsId
            },
            dataType: "json",
            success: function (result) {
                $("#invoiceNumber").text(result.purchase.invoice_number);
                $("#invoiceDate").text(result.purchase.purchase_date);
                $("#update_purchase_id").val(result.purchase.id);
                $("#update_purchase_details_id").val(result.purchaseDetails.id);
                $("#update_total_amount").val(result.purchase.total_amount);
                $("#update_paid_amount").val(result.purchase.paid_amount);
                $("#update_due_amount").val(result.purchase.due_amount);
                $("#update_cost_price").val(result.purchaseDetails.cost_price);
                $("#update_wholesale_price").val(result.purchaseDetails.wholesale_price);
                $("#update_quantity").val(result.purchaseDetails.quantity);
                existing_cost = result.purchaseDetails.cost_price * result.purchaseDetails.quantity;
                existing_total_amount = result.purchase.total_amount;

                $("#editPurchaseModal").modal('show');
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
        // var updateDueAmount = $('#update_due_amount').val();
        // if(updateDueAmount < 0){
        //   var currentPaidAmount = parseInt(paidAmount) + parseInt(updateDueAmount);
        //   $('#update_paid_amount').val(currentPaidAmount);
        //   $('#update_due_amount').val(0);
        // }
        // console.log("x...", updateDueAmount);
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

</script>
@endsection

@extends('layouts.backend.master')
@section('content')
<style>
    .alertify-notifier .ajs-message.ajs-error{
        color: #fff !important;
        background: rgba(217, 92, 92, 0,95);
        text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Purchase View</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="itemTable" class="table table-bordered" style="width: 100% !important">
                        <thead>
                            <tr>

                                <th>#</th>
                                <th>Vendor</th>
                                <th>Invoice Number</th>
                                <th>Purchase Date</th>
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($purchases as $purchase)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$purchase->vendor->name}}</td>
                                <td>{{$purchase->invoice_number}}</td>
                                <td>{{$purchase->purchase_date}}</td>
                                <td>{{$purchase->total_amount}}</td>
                                <td>{{$purchase->paid_amount}}</td>
                                <td>{{$purchase->due_amount}}</td>
                                <td>{{$purchase->created_by}}</td>
                                <td>{{$purchase->updated_by}}</td>

                                <td>

                                    <button class="btn btn-info btn-xs" onclick="location.href = '{{url('purchaseInfoView',$purchase->id)}}'">
                                        <i class="fa fa-info-circle"></i>
                                    </button>

                                    @if (Auth::user()->id == 1)
                                        <button class="btn btn-primary btn-xs" onclick="location.href = '{{url('purchaseInfoEdit',$purchase->id)}}'">
                                            <i class="fa fa-pencil"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs" onclick="purchaseDelete({{$purchase->id}})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif

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





<script>
    $(document).ready(function () {
        var table = $('#itemTable').DataTable({
            lengthChange: false,
            stateSave: true,
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true
        });

        table.buttons().container()
            .appendTo('#itemTable_wrapper .col-md-6:eq(0)');




    $('#itemUpdateForm').submit(function () {
            event.preventDefault();

            alertify.confirm("Are You Sure To Update This?",
                function () {
                 $("#category_id").prop( "disabled", false);
                    $.ajax({
                        type: 'post',
                        url: './itemUpdateAjax',
                        data: $("#itemUpdateForm").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {

                                alertify.warning(data.errors.name);
                            } else {
                                alertify.success(data);
                                clearForm();
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
                function () {
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');
        });


    });

    /**
     * @name roleEdit
     * @role fetch info and load them into modal for edit
     * @param role id
     * @return
     *
     */

    function itemEdit(id) {



        $.ajax({
            type: 'post',
            url: './getItemInfoAjax',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {

                    alertify.warning("Something went wrong");
                } else {

                    $('#itemId').val(data.id);
                    $('#subcategory_id').val(data.sub_category_id);
                    $('#category_id').val(data.category_id);
                    $('#brand_id').val(data.brand_id);
                    $('#name').val(data.name);
                    $('#barcode').val(data.barcode);
                    $('#length').val(data.length);
                    $('#height').val(data.height);
                    $('#width').val(data.width);
                    $('#regular_price').val(data.regular_price);
                    $('#sales_price').val(data.sales_price);
                    $('#is_published').val(data.is_published);
                    $('#largesizemodal').modal('show');

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





    /**
     * @name itemDelete
     * @role send ajax request to delete a role
     * @param role id
     * @return json response
     *
     */
    function purchaseDelete(id) {
        // alertify.confirm("Are You Sure To Delete This?" + "<br/>" + "<br/>" + "N.B. PRICES, UOM and PUBLISH-STATUS will remain same as this purchase.",
        alertify.confirm("Are You Sure To Delete This?" + "<br/>" + "<br/>" + "N.B. Item REGULAR Prices, OFFER Prices, and PUBLISH-STATUS at Website will remain same as this purchase.",
            function () {
                $.ajax({
                    type: 'post',
                    url: './purchaseDeleteAjax',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {

                        if(response.status === true){
                                alertify.success(response.message);
                                setTimeout(function() {
                                    location.reload(true);
                                }, 4000);

                            } else if (response.status === 'validation-error') {
                                $.each(response.data, function(index, value){
                                        alertify.error(value[0]);
                                    })

                            } else if(response.status === false) {
                                alertify.error(response.message);

                            }  else {
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

            },
            function () {
                alertify.error('Canceled');
            }).setHeader('<em> CONFIRM </em> ');

    }









</script>

@endsection

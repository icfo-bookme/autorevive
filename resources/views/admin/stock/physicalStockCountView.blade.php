@extends('layouts.backend.master')
@section('content')
@php
$userid=Auth::user()->id;
@endphp
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }

        .whiteSpace_normal {
            white-space: normal !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .must {
            color: red;
            font-size: 15px;
            font-weight: bold
        }

        .table td,
        .table th {
            font-size: 12px !important;
        }

        .screenFull {
            display: block;
            z-index: 9999;
            position: fixed;
            width: 100% !important;
            height: 100% !important;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            overflow: auto;
        }

        .btn__size {
            width: 30px !important;
            height: 30px !important;
            border-radius: 50%;
        }

        .custom__btn {
            background: #efefef;
            border: none;
        }

        .btn__size i {
            color: #585858;
        }

        .alertify-notifier .ajs-message.ajs-error{
            color: #fff !important;
            background: rgba(217, 92, 92, 0,95);
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
        }

        /* phone auto suggetion */
        .autocomplete {
            position: relative;
            display: inline-block;
        }
        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 12.5px;
            right: 12.5px;
            max-height: 287px;
            overflow-y: auto;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
       }
      .autocomplete-items div {
        padding: 7px 8px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
      }
      .autocomplete-items div:hover {
        background-color: #e9e9e9;
      }
      .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
      }
    @media only screen and (min-width: 1025px) and (max-width: 1150px) {
        .authorSign{
            margin-left: 5px
        }
    }
    @media only screen and (min-width: 576px) and (max-width: 890px) {
        .authorSign{
            margin-left: 5px
        }
    }
    </style>


    <div class="conatiner">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-12">
                <div class="card">
                    <div style="display: flex;justify-content: space-between;align-items: center;margin:0 15px;border-bottom: 1px solid rgba(0, 0, 0, 0.08);padding: 5px 5px">
                        <h5>Physical Inventory Count</h5>
                        <button class="btn btn-info btn-xs my-1" title="Discrepancy Report" style="font-size: 14px" onclick="window.open('{{url('discrepancyReport')}}');"><i class="fa fa-file-o mr-1"></i>Genrerate Report</button>
                    </div>
                    <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-12 ">
                                    <div class="form-group row d-flex justify-content-center align-items-center">
                                        <label for="" class="pt-2">Scan Barcode:</label>
                                       <input type="text" class="form-control ml-3" name="barcode" id="barcode" style="width: 35% !important;">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div style="display: flex;justify-content: space-between;align-items: center;margin:0 15px;border-bottom: 1px solid rgba(0, 0, 0, 0.08);padding: 5px 5px">
                        <h6><i class="fa fa-table mr-1"></i>Counted Items List</h6>
                        @if ($userid==env('SUPERADMIN_ID') || $userid==env('HOP_ID') || $userid==env('ACCOUNTS_ID'))
                            <button class="btn btn-danger btn-xs my-1" title="Clear Old List" style="font-size: 10px" onclick="ClearDataList()"><i class="fa fa-trash mr-1"></i>Clear</button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="countedItemTable" class="table table-bordered" style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Done By</th>
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



    <div class="modal fade" id="itemCountUpdateModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px 10px">
                    <h5 class="form-header text-uppercase text-center" style="margin: 0px;">
                        <i class="fa fa-user-circle-o"></i>
                          Update Quantity
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row d-flex justify-content-center align-items-center">

                        <div style="width: 100%">
                            <form id="itemCountUpdateForm">
                                <div class="form-group row px-2 ">
                                    <input type="hidden" name="id" id="id">
                                    <label for="quantity" class="col-sm-2 col-form-label">Quantity:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="quantity" name="quantity" min="0" placeholder="Quantity" required>
                                    </div>
                                </div>

                                <div class="modal-footer mt-3" style="padding: 10px 15px 0px 10px">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> SAVE</button>
                                    <button type="button" class="btn btn-danger" onclick="clearForm()"><i class="fa fa-times"></i> Cancel</button>
                                </div>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- loader modal -->
    <div class="modal" id="preloader" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <img src="{{ asset('assets/images/preloader.gif') }}"
                 style="display: block;margin: auto;margin-top:50%;width: 10%;">
        </div>
    </div>



    <script>

        $('#itemCountUpdateForm').submit(function () {
            event.preventDefault();
            alertify.confirm("Are You Sure To Update This?",
                function () {
                var formData = $('#itemCountUpdateForm').serialize();
                    $.ajax({
                        type: 'post',
                        url: '{{url("itemCountUpdateAjax")}}',
                        data: formData + '&_token={{ csrf_token() }}',

                        success: response => {
                            if (response.status === true) {
                                alertify.success(response.message);
                                clearForm();
                                setTimeout(function () {
                                    $('#countedItemTable').DataTable().ajax.reload();
                                }, 1000)

                            } else if (response.status == "validation-error") {
                                $.each(response.data, (index, value) => {
                                    alertify.error(value[0]);
                                });
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

                },
                function () {
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');
        });


        function clearForm() {
            $('#itemCountUpdateForm').trigger("reset");
            $('#itemCountUpdateModal').modal('hide');
            $('#itemCountUpdateForm')[0].reset();
        }



        function itemCountEdit(id) {
            $('#itemCountUpdateForm')[0].reset();
            $.ajax({
                type: 'post',
                url: './getItemCountDetailsAjax',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                dataType: 'json',

                success: function (response) {
                    if(response.status === true){

                        $('#id').val(response.data.id);
                        $('#quantity').val(response.data.quantity);
                        // $('#quantity').attr('max', response.data.quantity);
                        $('#itemCountUpdateModal').modal('show');
                    }else{
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


        function ClearDataList() {
            event.preventDefault();
            alertify.confirm("Are You Sure To Delete All Records?",
            function () {
                $('#preloader').modal('show');
                $.ajax({
                    type: 'post',
                    url: './backupAndClearCountDataList',

                    success: function (response) {
                        $('#preloader').modal('hide');
                        if(response.status === true){

                            alertify.success(response.message);
                            setTimeout(function () {
                                $('#countedItemTable').DataTable().ajax.reload();
                            }, 1000)
                        }else{
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
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');

        }


        $(document).ready(function () {
            const csrf_token = "{{ csrf_token() }}";
            // #### DATATABLE
            var dataTable = $('#countedItemTable').DataTable({
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
                    url: route('listAllPhysicalStockCount'),
                    data: function (data) {
                        data._token = csrf_token;
                    },
                    type: 'post',
                },
                columns: [

                    {
                        data: 'data_barcode_name',
                        name: 'barcode',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_item_name',
                        name: 'item_name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },

                    // added by monir: 02.05.2024
                    {
                        data: 'data_item_category_name',
                        name: 'item.category.name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_quantity_name',
                        name: 'quantity',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {data: 'data_updated_by', name: 'updated_by', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'action', name: 'action', "orderable": false, searchable: false, width: "10%"},
                ],
                dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            });


        });



        /**
         * Item search by barcode (route placed in PurchaseController)
         * @param barcode
         */
        var barcode_length = 10;
        $('[name="barcode"]').keyup(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let input_length = $(this).val().length;
            if (input_length >= barcode_length && ( e.keyCode == 13 || e.keyCode == 86)) {
                barcode = e.target.value;
                $.ajax({
                    url: '{{ URL('itemCountByBarcode') }}',
                    type: 'POST',
                    data: {
                        barcode:barcode
                    },
                    success: response => {
                        if(response.status === true){

                            $('#barcode').val('');
                            alertify.success("Item added!");
                            $('#countedItemTable').DataTable().ajax.reload();

                        } else{
                            $('#barcode').val('');
                            alertify.error(response.message);
                        }

                    },
                    error: function (jqXHR, exception) {
                        $('#barcode').val('');
                        $('#preloader').modal('hide');
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
        });

    </script>

@endsection

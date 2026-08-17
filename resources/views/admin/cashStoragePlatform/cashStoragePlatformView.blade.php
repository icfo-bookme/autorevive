@extends('layouts.backend.master')
@section('content')
<style>
    .alertify-notifier .ajs-message.ajs-error {
        color: #fff !important;
        background: rgba(217, 92, 92, 0, 95);
        text-shadow: -1px -1px 0 rgba(0, 0, 0, 0, 5);
    }
</style>

<div class="mb-3">
    <a href="/cashStoragePlatformView" class="btn btn-primary">Active</a>
    <a href="/cashStoragePlatformViewInactive" class="btn btn-outline-primary">Inactive</a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Ending Balance</div>

            <div class="card-body">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-8 col-sm-8 col-md-8">
                        <div class="d-flex justify-content-center">
                            <span>Last edit was made by {{$name}} {{$update_time}}</span>
                        </div>
                        <div class="my-3 float-right">
                            <button class="btn btn-info" data-toggle="modal" data-target="#cashPlatformInsertModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> New Cash Platform</button>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm-8 col-md-8 col-lg-8">
                        <div class="my-3 d-flex justify-content-between align-items-center">
                            <input type="hidden" id="totalCash" value="{{$total_cash}}">
                            <div>
                                <h5>Cash:</h5>
                                <h5 class="totalCashValue" style="text-decoration: underline; cursor: pointer;" onclick="calculationViewModal()">৳{{$total_cash}}</h5>
                            </div>
                            <h5 class="matchedText"></h5>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-8 col-sm-8 col-md-8">
                        <div class="table-responsive">
                            <table id="classTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cash Platform</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="drag_able">
                                    @foreach ($all_platforms as $cash_platform)
                                    <tr class="balanceRow deleteRow{{ $cash_platform->id }}">
                                        <td class="platformName">{{ $cash_platform->name }}</td>
                                        <td><input type="text" class="form-control amount" value={{ $cash_platform->amount }} onkeyup=matchBalance()></td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="deletePlatform({{ $cash_platform->id }})"
                                                style="padding: 5px 10px;" class="btn btn-default btn-xs border btn-danger"
                                                data-toggle="tooltip" title="" data-original-title="Inactive">
                                                <i class="fa fa-lock"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="editPlatformName({{ $cash_platform->id }})"
                                                style="padding: 5px 10px;" class="btn btn-default btn-xs border btn-primary"
                                                data-toggle="tooltip" title="" data-original-title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>

<!-- modal new cash storage platform -->
<div class="modal fade" id="cashPlatformInsertModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">New Cash Storage Platform</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>

            <form id="cashPlatformInsertForm">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Platform Name</label>
                        <input type="text" class="form-control" placeholder="Cash storage platform name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" step='any' placeholder="Cash amount" min="0" value="0" name="amount" required>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- cash storage platform edit modal -->
<div class="modal fade" id="cashPlatformEditModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Edit Balance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="cashPlatformUpdateForm">
                <div class="modal-body">
                    <input type="hidden" id="platform_id" name="platform_id" value="">

                    <div class="form-group">
                        <label>Platform Name</label>
                        <input type="text" class="form-control" id="platform_name" name="platform_name" required>
                    </div>

                    {{-- <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" min="0" id="platform_amount" name="amount" required>
                        </div> --}}

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="calculationViewModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <th colspan="4" style="color: green; font-weight: bold; font-size: 14px;">Income (+)</th>
                            <tr>
                                <th>Payment Collection Amount</th>
                                <th>Advance Payment Amount</th>
                                <th>Fund Amount</th>
                                <th>Reinvestment Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0);" class="openDetailsModal" data-type="PaymentCollectionAmount">
                                        {{$totalCashCalculationData['PaymentCollectionAmount']}}
                                    </a>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0);" class="openDetailsModal" data-type="AdvancePaymentAmount">
                                        {{$totalCashCalculationData['AdvancePaymentAmount']}}
                                    </a>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0);" class="openDetailsModal" data-type="FundAmount">
                                        {{$totalCashCalculationData['FundAmount']}}
                                    </a>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0);" class="openDetailsModal" data-type="ReinvestmentAmount">
                                        {{$totalCashCalculationData['ReinvestmentAmount']}}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive" style="margin-top: 60px">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th colspan="4" style="color: red; font-weight: bold; font-size: 14px;">Expense (-)</th>
                            </tr>
                            <tr>
                                <th>cost Amount</th>
                                <th>purchased Amount</th>
                                <th>purchased Drafted Amount</th>
                                <th>total Outsourced Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0);" class="openDetailsModal" data-type="costAmount">
                                        {{$totalCashCalculationData['costAmount']}}
                                    </a>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0);" class="openDetailsModal" data-type="puchasedAmount">
                                        {{$totalCashCalculationData['puchasedAmount']}}
                                    </a>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0);" class="openDetailsModal" data-type="puchaseDraftedAmount">
                                        {{$totalCashCalculationData['puchaseDraftedAmount']}}
                                    </a>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0);" class="openDetailsModal" data-type="totalOutsourcedCost">
                                        {{$totalCashCalculationData['totalOutsourcedCost']}}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive" style="margin-top: 60px">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th colspan="4" style="color: #FFD84D; font-weight: bold; font-size: 14px;">Total Cash</th>
                            </tr>
                            {{-- <tr>
                                    <th>Total = </th>
                                    <th>puchasedAmount</th>
                                    <th>puchaseDraftedAmount</th>
                                    <th>totalOutsourcedCost</th>
                                </tr> --}}
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">Total = </td>
                                <td style="text-align: center; vertical-align: middle;">{{($totalCashCalculationData['PaymentCollectionAmount']+$totalCashCalculationData['AdvancePaymentAmount']+$totalCashCalculationData['FundAmount']+$totalCashCalculationData['ReinvestmentAmount'])}} - {{($totalCashCalculationData['costAmount']+$totalCashCalculationData['puchasedAmount']+$totalCashCalculationData['puchaseDraftedAmount']+$totalCashCalculationData['totalOutsourcedCost'])}}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ number_format(
                                            ($totalCashCalculationData['PaymentCollectionAmount']
                                            + $totalCashCalculationData['AdvancePaymentAmount']
                                            + $totalCashCalculationData['FundAmount']
                                            + $totalCashCalculationData['ReinvestmentAmount'])
                                            - ($totalCashCalculationData['costAmount']
                                            + $totalCashCalculationData['puchasedAmount']
                                            + $totalCashCalculationData['puchaseDraftedAmount']
                                            + $totalCashCalculationData['totalOutsourcedCost']), 2)
                                        }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:80%; width:80%;">
        <div class="modal-content" style="height:90vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalTitle">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailsModalBody" style="overflow-y:auto; max-height:calc(80vh - 50px);">
            </div>
        </div>
    </div>
</div>

<script>
    let matched;
    let balanceData = [];

    $(document).ready(function() {
        balanceCheck();
        $('.openDetailsModal').click(function() {
            var type = $(this).data('type');
            var formattedType = type
                .replace(/([a-z])([A-Z])/g, '$1 $2') // Add space before capital letters
                .replace(/puchased/gi, 'purchased') // Fix 'puchased' typo
                .toUpperCase(); // Convert all letters to uppercase

            $('#detailsModalTitle')
                .text(formattedType + ' DETAILS')
                .css({
                    'font-weight': 'bold',
                    'font-size': '20px'
                });
            $('#detailsModal').modal('show');
            $('#detailsModalBody').html('<p class="text-center text-muted my-3">No data available for this section.</p>');

            $.ajax({
                url: "{{ url('totalCashCalculationDetails') }}",
                type: 'GET',
                data: {
                    type: type
                },
                success: function(response) {
                    console.log(response);
                    $('#detailsModalBody').html(response);
                },
                error: function() {
                    $('#detailsModalBody').html('<p class="text-danger text-center text-muted my-3">No data available for this section.</p>');
                }
            });
        });
    });

    function balanceCheck() {
        balanceData = [];
        sum = 0;
        $(document).find('.balanceRow').each(function(index, value) {
            let amount = Number($(this).find(".amount").val());
            sum += amount;
            let name = $(this).find('.platformName').text();
            balanceData.push({
                name,
                amount
            });
        });
        let totalCashValue = Number($('#totalCash').val());
        if (sum == totalCashValue) {
            $('.totalCashValue').css('color', 'green');
            $('.matchedText').text('Matched');
            $('.matchedText').css({
                "color": "green",
                "border": "1px solid green",
                "padding": "5px 10px",
                "border-radius": "25px",
                "font-size": "15px"
            });

            matched = 1;

        } else {
            $('.totalCashValue').css('color', 'red');
            $('.matchedText').text('Not Matched');
            $('.matchedText').css({
                "color": "red",
                "border": "1px solid red",
                "padding": "5px 10px",
                "border-radius": "25px",
                "font-size": "15px"
            });
            matched = 0;
        }
        console.log("balance check:", "total cash:", totalCashValue, "total platformwise:", sum)
    }

    //Matches total balance and store into database
    function matchBalance() {
        balanceCheck();
        if (matched) {
            alertify.confirm('Are You Sure you want to save the data?', 'Data will be updated', function() {
                console.log(balanceData);
                $.ajax({
                    type: 'post',
                    url: '{{URl("cashStoragePlatformUpdateAjax")}}',
                    dataType: 'json',
                    data: {
                        balanceData
                    },
                    success: function(response) {
                        if (response.status) {
                            alertify.success(response.message);
                        } else {
                            alertify.error(response.message);
                            console.log(response.data);
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
            }, function() {
                alertify.error('Cancel')
            });


        }
    }

    //Inserts Platform into database
    $('#cashPlatformInsertForm').submit(function() {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'New Platform Will Be Added', function() {

            $('#preloader').modal('show');
            $.ajax({
                type: 'post',
                url: '{{URl("cashStoragePlatformInsertAjax")}}',
                dataType: 'json',
                data: $('#cashPlatformInsertForm').serialize(),
                success: function(response) {
                    console.log(response);
                    $('#preloader').modal('hide');

                    if (response.status === true) {
                        alertify.success(response.message);
                        $('#cashPlatformInsertModal').modal('hide');

                        setTimeout(function() {
                            location.reload(true);
                        }, 1000)

                    } else if (response.status === 'validation-error') {
                        $.each(response.data, function(index, value) {
                            alertify.error(value[0]);
                        });

                    } else {
                        alertify.error(response.message)
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

        }, function() {
            alertify.error('Cancel')
        });
    });

    //Remove platform
    function deletePlatform(platformId) {
        alertify.confirm('Are You Sure you want to delete?', 'Data will be deleted', function() {
            $.ajax({
                type: 'post',
                url: '{{URl("cashStoragePlatformDeleteAjax")}}',
                dataType: 'json',
                data: {
                    platformId
                },
                success: function(response) {
                    if (response.status) {
                        $('.deleteRow' + platformId).remove();
                        balanceCheck();
                        alertify.success(response.message);
                    } else {
                        alertify.error(response.message);
                        console.log(response.data);
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
        }, function() {
            alertify.error('Cancel')
        });
    }

    //Get Platform name to edit
    function editPlatformName(id) {
        $.ajax({
            type: 'post',
            url: '{{URL("getCashPlatformName")}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    $('#platform_id').val(response.data.id);
                    $('#platform_name').val(response.data.name);
                    $('#cashPlatformEditModal').modal('show');
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
    }

    //Updates Platform name
    $('#cashPlatformUpdateForm').submit(function() {
        event.preventDefault();

        $.ajax({
            type: 'post',
            url: '{{URl("cashPlatformNameUpdate")}}',
            data: $('#cashPlatformUpdateForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === true) {
                    alertify.success(response.message);
                    setTimeout(function() {
                        location.reload(true);
                    }, 1000)

                } else if (response.status === false) {
                    alertify.error(response.message);
                } else if (response.status === "validation-error") {
                    for (let key in response.data) {
                        if (response.data.hasOwnProperty(key)) {
                            alertify.error(response.data[key][0]);
                        }
                    }
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
    });

    function calculationViewModal() {
        $("#calculationViewModal").modal('show');
    }
</script>
@endsection
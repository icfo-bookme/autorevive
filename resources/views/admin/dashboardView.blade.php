@extends('layouts.backend.master')
@section('content')
    @php
        $userid = Auth::user()->id;
    @endphp
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <div class="modal fade" id="totalCash" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated flipInX">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 18px;">Total Cash Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Sales <span class="text-success">(<i class="fa fa-plus" aria-hidden="true"></i>)</span></h4>
                                </div>
                                <div class="card-body" style="max-height: 400px;min-height: 400px;overflow:scroll;">
                                    <div class="row">
                                        <div class="py-2">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Invoice No</th>
                                                        <th>Pay Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalSaleAmount = 0;
                                                    @endphp
                                                    @foreach ($sales as $sale)
                                                        <tr style="text-align:center;">
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$sale->order_id}}</td>
                                                            <td>{{$sale->pay_date}}</td>
                                                            <td>{{$sale->amount}}</td>
                                                        </tr>
                                                        @php
                                                            $totalSaleAmount += $sale->amount;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="text-align: right">
                                                        <td colspan="3" class="font-weight-bold">Total</td>
                                                        <td>{{$totalSaleAmount}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Booking <span class="text-success">(<i class="fa fa-plus" aria-hidden="true"></i>)</span></h4>
                                </div>
                                <div class="card-body" style="max-height: 400px;min-height: 400px;overflow:scroll;">
                                    <div class="row">
                                        <div class="py-2">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Invoice No</th>
                                                        <th>Pay Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalBookingAmount = 0;
                                                    @endphp
                                                    @foreach ($bookings as $booking)
                                                        <tr style="text-align:center;">
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$booking->booking_id}}</td>
                                                            <td>{{$booking->pay_date}}</td>
                                                            <td>{{$booking->amount}}</td>
                                                        </tr>
                                                        @php
                                                            $totalBookingAmount += $booking->amount;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="text-align: right">
                                                        <td colspan="3" class="font-weight-bold">Total</td>
                                                        <td>{{$totalBookingAmount}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Funds <span class="text-success">(<i class="fa fa-plus" aria-hidden="true"></i>)</span></h4>
                                </div>
                                <div class="card-body" style="max-height: 400px;min-height: 400px;overflow:auto;">
                                    <div class="row">
                                        <div class="table-responsive py-2">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalFund = 0;
                                                    @endphp
                                                    @foreach ($funds as $fund)
                                                        <tr style="text-align: center">
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$fund->date}}</td>
                                                            <td>{{$fund->amount}}</td>
                                                        </tr>
                                                        @php
                                                            $totalFund += $fund->amount;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="text-align: right">
                                                        <td colspan="2" class="font-weight-bold">Total</td>
                                                        <td>{{$totalFund}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Reinvestments <span class="text-success">(<i class="fa fa-plus" aria-hidden="true"></i>)</span></h4>
                                </div>
                                <div class="card-body" style="max-height: 400px;min-height: 400px;overflow:auto;">
                                    <div class="row">
                                        <div class="table-reponsive py-2">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalReinvestment = 0;
                                                    @endphp
                                                    @foreach ($reinvestments as $reinvestment)
                                                        <tr style="text-align: center">
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$reinvestment->date}}</td>
                                                            <td>{{$reinvestment->amount}}</td>
                                                        </tr>
                                                        @php
                                                            $totalReinvestment += $reinvestment->amount;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="text-align: right">
                                                        <td colspan="2" class="font-weight-bold">Total</td>
                                                        <td>{{$totalReinvestment}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Costs <span class="text-danger">(<i class="fa fa-minus" aria-hidden="true"></i>)</span></h4>
                                </div>
                                <div class="card-body" style="max-height: 400px;min-height: 400px;overflow: auto;">
                                    <div class="row">
                                        <div class="table-responsive py-2">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Created Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalCost = 0;
                                                    @endphp
                                                    @foreach ($costs as $cost)
                                                        <tr style="text-align: center">
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{date('Y-m-d',strtotime($cost->created_at))}}</td>
                                                            <td>{{$cost->amount}}</td>
                                                        </tr>
                                                        @php
                                                            $totalCost += $cost->amount;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="text-align: right">
                                                        <td colspan="2" class="font-weight-bold">Total</td>
                                                        <td>{{$totalCost}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Purchases <span class="text-danger">(<i class="fa fa-minus" aria-hidden="true"></i>)</span></h4>
                                </div>
                                <div class="card-body" style="max-height: 400px;min-height: 400px;overflow: auto;">
                                    <div class="row">
                                        <div class="table-responsive py-2">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Invoice</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalPurchase = 0;
                                                    @endphp
                                                    @foreach ($purchases as $purchase)
                                                        <tr style="text-align: center">
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$purchase->invoice_number}}</td>
                                                            <td>{{$purchase->purchase_date}}</td>
                                                            <td>{{$purchase->paid_amount}}</td>
                                                        </tr>
                                                        @php
                                                            $totalPurchase += $purchase->paid_amount;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="text-align: right">
                                                        <td colspan="3" class="font-weight-bold">Total</td>
                                                        <td>{{$totalPurchase}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Drafts <span class="text-danger">(<i class="fa fa-minus" aria-hidden="true"></i>)</span></h4>
                                </div>
                                <div class="card-body" style="max-height: 400px;min-height: 400px;overflow: auto;">
                                    <div class="row">
                                        <div class="table-responsive py-2">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalDrafts = 0;
                                                    @endphp
                                                    @foreach ($drafts as $draft)
                                                        <tr style="text-align: center">
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{date('Y-m-d',strtotime($draft->created_at))}}</td>
                                                            <td>{{$draft->amount}}</td>
                                                        </tr>
                                                        @php
                                                            $totalDrafts += $draft->amount;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="text-align: right">
                                                        <td colspan="2" class="font-weight-bold">Total</td>
                                                        <td>{{$totalDrafts}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Outsource Costs <span class="text-danger">(<i class="fa fa-minus" aria-hidden="true"></i>)</span></h4>
                                </div>
                                <div class="card-body" style="max-height: 400px;min-height: 400px;overflow: auto;">
                                    <div class="row">
                                        <div class="table-responsive py-2">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Invoice</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalOutsource = 0;
                                                    @endphp
                                                    @foreach ($outsourceCosts as $outsource)
                                                        <tr style="text-align: center">
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>#0202{{$outsource->order_id}}</td>
                                                            <td>{{date('Y-m-d',strtotime($outsource->created_at))}}</td>
                                                            <td>{{$outsource->sum}}</td>
                                                        </tr>
                                                        @php
                                                            $totalOutsource += $outsource->sum;
                                                        @endphp
                                                    @endforeach
                                                    <tr style="text-align: right">
                                                        <td colspan="3" class="font-weight-bold">Total</td>
                                                        <td>{{$totalOutsource}}</td>
                                                    </tr>
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
        </div>
    </div>

    @if ( $userid ==env('SUPERADMIN_ID') || $userid ==env('HOP_ID') || $userid ==env('ACCOUNTS_ID') || $userid ==env('MANAGER_ID') )
        <div class="row mt-3">

            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-orange">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $total_site_visits }} <span class="float-right"><i
                                    class="fa fa-eye"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Visitors</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-bloody">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $orderCount }} <span class="float-right"><i
                                    class="fa fa-shopping-cart"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Total Orders </p>
                    </div>
                </div>
            </div>

            {{-- <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-quepal">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $pendingOrderCount }} <span class="float-right"><i class="fa fa-clock-o"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Pending Orders </p>
                    </div>
                </div>
            </div> --}}

            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-quepal">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $completedOrderCount }} <span class="float-right"><i
                                    class="fa fa-check"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Completed Orders </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-scooter">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $cancelledOrderCount }} <span class="float-right"><i
                                    class="fa fa-times"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Canceled Orders </p>
                    </div>
                </div>
            </div>

        </div>
        <!--End Row (1)-->

        {{-- Row (2) - Start --}}
        <div class="row mt-3">

            {{-- <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-orange">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $total_site_visits }} <span class="float-right"><i class="fa fa-eye"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Visitors</p>
                    </div>
                </div>
            </div> --}}

            {{-- unique items from purchase_details table --}}
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-ohhappiness">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $itemCount }} <span class="float-right"><i
                                    class="fa fa-shopping-bag"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        {{-- <p class="mb-0 text-white small-font">Total Unique Items (stocked) </p> --}}
                        <p class="mb-0 text-white small-font">Total Items Purchased (unique) </p>
                    </div>
                </div>
            </div>

            {{-- total cash amount of purchase --}}
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-deepblue">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ number_format($totalPurchase,2) }} <span class="float-right"><i
                                    class="fa fa-usd"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Total Purchase Value</p>
                    </div>
                </div>
            </div>

            {{-- existing stocked items price in total --}}
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-shifter">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ number_format($totalStockPrice,2) }} <span class="float-right"><i
                                    class="fa fa-usd"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Current Stock Value </p>
                    </div>
                </div>
            </div>


            {{-- total cash withdrawn from system --}}
            {{-- <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-deepblue">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $withdraw }} <span class="float-right"><i class="fa fa-envira"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Total Withdraw</p>
                    </div>
                </div>
            </div> --}}




            {{-- total cash exists in system  --}}
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-ibiza" onclick="totalCashModalShow()">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ number_format($totalCashCollected,2) }} <span class="float-right"><i
                                    class="fa fa-usd"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Total Cash Collected (deducting withdraw)</p>
                    </div>
                </div>
            </div>

        </div>
        <!--End Row (2)-->

        {{-- Row (3) - Start --}}
        <div class="row mt-3">


            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card  gradient-scooter">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ $saleCount }} <span class="float-right"><i
                                    class="fa fa-shopping-cart"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Total POS Sales</p>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card gradient-blooker">
                    <div class="card-body">
                        <h5 class="text-white mb-0">{{ number_format($totalDeliveryCharge,2) }} <span class="float-right"><i
                                    class="fa fa-usd"></i></span></h5>
                        <div class="progress my-3" style="height:3px;">
                            <div class="progress-bar" style="width:55%"></div>
                        </div>
                        <p class="mb-0 text-white small-font">Total Shipment Charge</p>
                    </div>
                </div>
            </div>

        </div>
    @endif



    <div class="row">
        <div class="col-12 col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-header">Average Order Completion Time
                    <div class="card-action">
                        <div class="dropdown">
                            {{-- <a href="javascript:void(0);" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown"> --}}
                            {{-- <i class="icon-options"></i> --}}
                            {{-- </a> --}}
                            {{-- <div class="dropdown-menu dropdown-menu-right"> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0);">Action</a> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0);">Another action</a> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0);">Something else here</a> --}}
                            {{-- <div class="dropdown-divider"></div> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0);">Separated link</a> --}}
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-inline">
                    </ul>
                    <div class="chart-container">
                        <div id="averageOrderComplete"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 col-xl-4">
            <div class="card">
                <div class="card-header">Average Shipment Time
                    <div class="card-action">
                        <div class="dropdown">
                            {{--                        <a href="javascript:void(0);" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown"> --}}
                            {{--                            <i class="icon-options"></i> --}}
                            {{--                        </a> --}}
                            {{--                        <div class="dropdown-menu dropdown-menu-right"> --}}
                            {{--                            <a class="dropdown-item" href="javascript:void(0);">Action</a> --}}
                            {{--                            <a class="dropdown-item" href="javascript:void(0);">Another action</a> --}}
                            {{--                            <a class="dropdown-item" href="javascript:void(0);">Something else here</a> --}}
                            {{--                            <div class="dropdown-divider"></div> --}}
                            {{--                            <a class="dropdown-item" href="javascript:void(0);">Separated link</a> --}}
                            {{--                        </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-inline">
                    </ul>
                    <div class="chart-container">
                        <div id="averageShipmentComplete"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Row-->

    <div class="row">
        <div class="col-12 col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-header">Deadline Miss
                    <div class="card-action">
                        <div class="dropdown">
                            {{--                        <a href="javascript:void(0);" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown"> --}}
                            {{--                            <i class="icon-options"></i> --}}
                            {{--                        </a> --}}
                            {{--                        <div class="dropdown-menu dropdown-menu-right"> --}}
                            {{--                            <a class="dropdown-item" href="javascript:void(0);">Action</a> --}}
                            {{--                            <a class="dropdown-item" href="javascript:void(0);">Another action</a> --}}
                            {{--                            <a class="dropdown-item" href="javascript:void(0);">Something else here</a> --}}
                            {{--                            <div class="dropdown-divider"></div> --}}
                            {{--                            <a class="dropdown-item" href="javascript:void(0);">Separated link</a> --}}
                            {{--                        </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-inline">
                    </ul>
                    <div class="chart-container">
                        <div id="deadlineMiss"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Row-->








    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script>
        function totalCashModalShow() {
            $('#totalCash').modal('show');
        }

        var $arrColors = ['#34495E', '#26B99A', '#666', '#3498DB', '#34495E', '#26B99A', '#666', '#3498DB', '#34495E',
            '#26B99A', '#666', '#3498DB', '#34495E', '#26B99A', '#666', '#3498DB', '#34495E', '#26B99A', '#666',
            '#3498DB', '#34495E', '#26B99A', '#666', '#3498DB', '#34495E', '#26B99A', '#666', '#3498DB', '#34495E',
            '#26B99A', '#666', '#3498DB'
        ];
        var getData = {
            avgShipmentComplete: <?php echo $shipmentTimes; ?>
        }

        getData.avgShipmentComplete.length > 0 ? morisBarShipment() : morisBarEmpty();

        function morisBarShipment() {
            Morris.Bar({
                element: 'averageShipmentComplete',
                data: getData.avgShipmentComplete,
                xkey: 'created',
                ykeys: ['difference'],
                labels: ['difference'],
                hideHover: 'auto',
                barColors: function(row, series, type) {
                    return $arrColors[row.x];
                },
                stacked: true
            });
        }

        function morisBarEmpty() {
            Morris.Bar({
                element: 'averageShipmentComplete',
                data: " ",
                xkey: "0",
                ykeys: "null",
                labels: "null",
                hideHover: 'auto',
                barColors: function(row, series, type) {
                    return $arrColors[row.x];
                },
                stacked: true
            });
        }


        var get_data = {
            deadlineMiss: <?php echo $shipmentTimes; ?>
        }

        get_data.deadlineMiss.length > 0 ? morisBarDeadline() : morisBarDeadlineEmpty();

        function morisBarDeadline() {
            Morris.Bar({
                element: 'deadlineMiss',
                data: get_data.deadlineMiss,
                xkey: 'created',
                ykeys: ['difference'],
                labels: ['difference'],
                hideHover: 'auto',
                barColors: function(row, series, type) {
                    return $arrColors[row.x];
                },
                stacked: true
            });
        }

        function morisBarDeadlineEmpty() {
            Morris.Bar({
                element: 'deadlineMiss',
                data: " ",
                xkey: "0",
                ykeys: "null",
                labels: "null",
                hideHover: 'auto',
                barColors: function(row, series, type) {
                    return $arrColors[row.x];
                },
                stacked: true
            });
        }

        var getdata = {
            averageOrderComplete: <?php echo $averageDeliveryTimes; ?>
        }

        getdata.averageOrderComplete.length > 0 ? morisBarOrder() : morisBarOrderEmpty();

        function morisBarOrder() {
            Morris.Bar({
                element: 'averageOrderComplete',
                data: getdata.averageOrderComplete,
                xkey: 'created_at',
                ykeys: ['difference'],
                labels: ['difference'],
                hideHover: 'auto',
                barColors: function(row, series, type) {
                    if ($arrColors[row.x] === undefined) {
                        return $arrColors[0];
                    }
                    return $arrColors[row.x];
                },
                stacked: true
            });
        }

        function morisBarOrderEmpty() {
            Morris.Bar({
                element: 'averageOrderComplete',
                data: " ",
                xkey: "0",
                ykeys: "null",
                labels: "null",
                hideHover: 'auto',
                barColors: function(row, series, type) {
                    return $arrColors[row.x];
                },
                stacked: true
            });
        }
    </script>
@endsection

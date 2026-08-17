@extends('layouts.backend.master')
@section('content')
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
            font-size: 14px;
            font-weight: bold
        }

        .table td,
        .table th {
            font-size: 14px !important;
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
        .mb-1{
            font-size: 14px !important;
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
        @php
            $salesArray = collect([
                [
                    'collected_payment' => $sale->collected_payment,
                    'created_at' => \Carbon\Carbon::parse($sale->updated_at)->format('d-m-Y H:i:s'),
                    'sales_by' => $sale->sales_by,
                    'table' => 'sales',
                    'priority' => 2
                ]
            ]);

            $salesArray->push([
                'collected_payment' => 0,
                'created_at' => \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y H:i:s'),
                'sales_by' => $sale->sales_by,
                'table' => 'sales',
                'priority' => 1
            ]);

            $saleNewLogsArray = $saleNewLogs->map(function($log) {
                return [
                    'collected_payment' => $log->collected_payment,
                    'created_at' => \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i:s'),
                    'sales_by' => $log->sales_by,
                    'table' => 'sales_new_logs',
                    'priority' => 1
                ];
            });

            $mergedSalesLogs = $salesArray->merge($saleNewLogsArray)
                ->sortBy(function ($log) {
                    return \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $log['created_at'])->timestamp;
                })
                ->sortBy('priority')
                ->values(); 
            
            $allPaymentsArray = $allPayments->map(function($log) {
                $collectedByName = 'N/A';
                if (isset($log->collected_by_user)) {
                    $collectedByUser = $log->collected_by_user;
                    $collectedByName = $collectedByUser ? $collectedByUser->first_name . ' ' . $collectedByUser->last_name : 'N/A';
                }

                return [
                    'created_at' => \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i:s'),
                    'type' => 'Due Payment',
                    'paid_amount' => number_format($log->paid_amount, 2),
                    'collected_by' => $collectedByName,
                    'source_table' => $log->source_table,
                    'due_collected_at' => $log->due_collected_at ? \Carbon\Carbon::parse($log->due_collected_at)->format('d-m-Y H:i:s') : null
                ];
            })
            ->values(); 

            $total_balance = $order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount;
            $sale_collected_payment = 0;
            $sale_advance_payment = $booking->isEmpty() ? 0 : $booking->first()->advance_payment;

            foreach ($mergedSalesLogs as $log) {
                if ($log['table'] === 'sales' && $log['priority'] == 2) {
                    $sale_collected_payment = $log['collected_payment'];
                    break; 
                }
            }

            if ($sale_advance_payment > 0) {
                $total_balance -= $sale_advance_payment;
            }
            
            if ($sale_collected_payment > 0) {
                $total_balance -= $sale_collected_payment;
            }

            foreach ($allPaymentsArray as $log) {
                if ($log['source_table'] == 'sales_due_payment') {
                    $total_balance -= (float) str_replace(',', '', $log['paid_amount']);
                }
            }

            $status = $total_balance <= 0 ? 'Completed' : 'Pending';
            $badgeClass = $total_balance <= 0 ? 'badge-success' : 'badge-warning';
        @endphp

        <div class="row mt-5 ">
            <div class="col-sm-12 mx-auto p-4 text-center">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Center: Payment History -->
                        <div class="text-center flex-grow-1">
                            <h5 class="form-header text-uppercase mb-0">
                                <i class="fa fa-user-circle-o"></i> Payment History 
                            </h5>
                            <h6 class="form-header mb-0 text-dark">Invoice: #0202{{$order['id']}}</h6>
                        </div>

                        <!-- Right: Balance & Status -->
                        <div class="small-card bg-light px-2 py-1 rounded shadow-sm">
                            <h6 class="mb-1">Due: <span class="text-danger">৳{{ number_format($total_balance, 2) }}</span></h6>
                            <h6 class="mb-1">Status:  
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            </h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>PAYMENT</th>
                                        <th>PREVIOUS DUE</th>
                                        <th>COLLECTED AMOUNT</th>
                                        <th>REMAINING DUE</th>
                                        <th>COLLECTED BY</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                        @php
                                            $total_balance = $order->total_price[0]->total + $order->is_shipment_charge_applied - $order->discount_amount;
                                            $table_balance = $total_balance;
                                            $temp_collected_payment = 0;
                                        @endphp

                                        @if ($sale_advance_payment > 0)
                                            @php $table_balance -= $sale_advance_payment; @endphp
                                            <!-- <tr>
                                                <td>{{ optional($booking->first())->created_at ? $booking->first()->created_at->format('d-m-y H:i:s') : 'N/A' }}</td>
                                                <td>Advance Payment</td>
                                                <td>৳{{ number_format($total_balance, 2) }}</td>
                                                <td>৳{{ number_format($sale_advance_payment, 2) }}</td>
                                                <td>৳{{ number_format($table_balance, 2) }}</td>
                                                <td>{{ optional($booking->first())->created_by ?? 'N/A' }}</td>
                                            </tr> -->
                                        @endif

                                        @if (count($mergedSalesLogs) > 2)
                                            @for ($i = 0; $i < count($mergedSalesLogs) - 1; $i++)
                                                @php
                                                    $temp_array = [];
                                                    $temp_total_due_amount = 0;
                                                @endphp

                                                @foreach ($allPaymentsArray as $log) 
                                                    @if(isset($mergedSalesLogs[$i + 1]) &&
                                                        $log['source_table'] == 'sales_due_payment_log' &&
                                                        $log['created_at'] == $mergedSalesLogs[$i]['created_at'])
                                                        @php
                                                            $temp_total_due_amount += floatval(str_replace(',', '', $log['paid_amount']));
                                                            $temp_array[] = $log; 
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @foreach ($temp_array as $log)
                                                    
                                                        @php 
                                                            $total_balance = $table_balance;
                                                            $paid_amount = floatval(str_replace(',', '', $log['paid_amount']));
                                                            $table_balance -= $paid_amount;
                                                        @endphp
                                                        @if ($paid_amount != 0)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($log['due_collected_at'])->format('d-m-y H:i:s') }}</td>
                                                            <td>{{ $log['type'] }}</td>
                                                            <td>৳{{ number_format($total_balance, 2) }}</td>
                                                            <td>৳{{ number_format($paid_amount, 2) }}</td>
                                                            <td>৳{{ number_format($table_balance, 2) }}</td>
                                                            <td>{{ $log['collected_by'] }}</td>
                                                        </tr>
                                                        @endif
                                                @endforeach

                                                
                                                    @php 
                                                        $total_balance = $table_balance;
                                                        $temp_collected_payment = $mergedSalesLogs[$i+1]['collected_payment'] - ($mergedSalesLogs[$i]['collected_payment'] + $temp_total_due_amount);
                                                    @endphp
                                                    
                                                    @if ($temp_collected_payment != 0) 
                                                        @php
                                                            $table_balance -= $temp_collected_payment;
                                                        @endphp

                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($mergedSalesLogs[$i]['created_at'])->format('d-m-y H:i:s') }}</td>
                                                            <td>Collected Payment</td>
                                                            <td>৳{{ number_format($total_balance, 2) }}</td>
                                                            <td>৳{{ number_format($temp_collected_payment, 2) }}</td>
                                                            <td>৳{{ number_format($table_balance, 2) }}</td>
                                                            <td>{{ $mergedSalesLogs[$i]['sales_by'] }}</td>
                                                        </tr>
                                                    @endif
                                            @endfor

                                            @php
                                                $temp_array = []; 
                                            @endphp
                                            @foreach ($allPaymentsArray as $log) 
                                                @if($log['source_table'] == 'sales_due_payment')
                                                    @php
                                                        $temp_array[] = $log; 
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @foreach ($temp_array as $log)
                                                        @php 
                                                            $total_balance = $table_balance;
                                                            $paid_amount = floatval(str_replace(',', '', $log['paid_amount']));
                                                            $table_balance -= $paid_amount;
                                                        @endphp
                                                        @if ($paid_amount != 0)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($log['created_at'])->format('d-m-y H:i:s') }}</td>
                                                            <td>{{ $log['type'] }}</td>
                                                            <td>৳{{ number_format($total_balance, 2) }}</td>
                                                            <td>৳{{ number_format($paid_amount, 2) }}</td>
                                                            <td>৳{{ number_format($table_balance, 2) }}</td>
                                                            <td>{{ $log['collected_by'] }}</td>
                                                        </tr>
                                                        @endif
                                                    
                                            @endforeach

                                        @elseif (count($mergedSalesLogs) == 2)
                                            @php 
                                                $temp_collected_payment = $mergedSalesLogs[1]['collected_payment']; 
                                            @endphp
                                            @if ($temp_collected_payment != 0)
                                                @php $table_balance -= $temp_collected_payment @endphp
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($mergedSalesLogs[count($mergedSalesLogs) - 1]['created_at'])->format('d-m-y H:i:s') }}</td>
                                                    <td>Collected Payment</td>
                                                    <td>৳{{ number_format($total_balance, 2) }}</td>
                                                    <td>৳{{ number_format($temp_collected_payment, 2) }}</td>
                                                    <td>৳{{ number_format($table_balance, 2) }}</td>
                                                    <td>{{ $mergedSalesLogs[count($mergedSalesLogs) - 1]['sales_by'] }}</td>
                                                </tr>
                                            @endif
                                            @foreach ($allPaymentsArray as $log)
                                                @if ($log['source_table'] == 'sales_due_payment')
                                                    @php 
                                                        $total_balance = $table_balance;
                                                        $paid_amount = floatval(str_replace(',', '', $log['paid_amount']));
                                                        $table_balance -= $paid_amount;
                                                    @endphp
                                                    @if ($paid_amount != 0)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($log['created_at'])->format('d-m-y H:i:s') }}</td>
                                                            <td>{{ $log['type'] }}</td>
                                                            <td>৳{{ number_format($total_balance, 2) }}</td>
                                                            <td>৳{{ number_format($paid_amount, 2) }}</td>
                                                            <td>৳{{ number_format($table_balance, 2) }}</td>
                                                            <td>{{ $log['collected_by'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                </tbody>
                            </table>
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

        $(document).ready(function() {

            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: false
            });

        });

    </script>

@endsection

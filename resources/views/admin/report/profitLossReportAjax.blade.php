@php
    $totalCost     = 0;
    $totalSale     = 0;
    $totalDiscount = 0;
    $totalShipping = 0;
    $totalProfit   = 0;
@endphp

@foreach ($salesDetails as $detail)

    @php
        $cost     = $detail->total_cost_price[0]->totalCost;
        $sale     = $detail->total_price[0]->total;
        $shipping = $detail->is_shipment_charge_applied;
        $discount = $detail->discount_amount;
        $profit   = ($sale - $cost)+$shipping-$discount;

        $totalCost     += $cost;
        $totalSale     += $sale;
        $totalShipping += $shipping;
        $totalDiscount +=  $discount;
        $totalProfit   += $profit;
    @endphp

    <tr style="text-align:center;">
        <td>{{$loop->iteration}}</td>
        @if ($detail->order->delivery_type == 'delivery' || $detail->order->delivery_type == 'pickup')
            <td>
                <a onclick="invoiceModal({{ @$detail->order_id }})" style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"
                    data-toggle="tooltip" title="" data-original-title="Invoice"> #0101{{ $detail->order_id }}
                </a>
            </td>
        @else
            <td>
                <a onclick="invoiceModal({{ @$detail->order_id }})" style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"
                    data-toggle="tooltip" title="" data-original-title="Invoice"> #0202{{ $detail->order_id }}
                </a>
            </td>
        @endif
        <td>{{date('Y-m-d',strtotime($detail->completed_at))}}</td>
        <td>{{$detail->invoice_date}}</td>
        <td>{{$detail->created_at}}</td>
        <td>{{$shipping}}</td>
        <td>{{$discount}}</td>
        <td>{{$sale}}</td>
        <td>{{$cost}}</td>
        <td>{{$profit}}</td>
    </tr>

@endforeach

@php
// $totalSale == 0 ? $profitPercentage = 0 : $profitPercentage = (($totalSale - $totalCost) / $totalCost) * 100;
$totalSale == 0 ? $profitPercentage = 0 : $profitPercentage = ($totalProfit / $totalCost) * 100;

@endphp

<tr>
    <td colspan="5" class="text-center font-weight-bold">Total</td>
    <td class="text-center">{{ $totalShipping }}</td>
    <td class="text-center">{{ $totalDiscount }}</td>
    <td class="text-center">{{ $totalSale }}</td>
    <td class="text-center">{{ $totalCost }}</td>
    <td class="text-center">{{ $totalProfit }} ({{ round($profitPercentage, 2) }}%)</td>

</tr>

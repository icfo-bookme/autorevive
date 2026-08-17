{{--@foreach ($orderDetails as $detail)--}}

{{--    @php--}}
{{--    $costPrice = $detail->order->total_cost_price()->first()['total'];--}}
{{--    $profit = ($detail->invoice_amount - $costPrice);--}}
{{--    @endphp--}}

{{--    <tr style="text-align:center;">--}}
{{--        <td>{{$loop->iteration}}</td>--}}
{{--        @if ($detail->order->delivery_type == 'delivery' || $detail->order->delivery_type == 'pickup')--}}
{{--            <td>--}}
{{--                <a onclick="invoiceModal({{ @$detail->order_id }})" style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"--}}
{{--                    data-toggle="tooltip" title="" data-original-title="Invoice"> #0101{{ $detail->order_id }}--}}
{{--                </a>--}}
{{--            </td>--}}
{{--        @else--}}
{{--            <td>--}}
{{--                <a onclick="invoiceModal({{ @$detail->order_id }})" style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"--}}
{{--                    data-toggle="tooltip" title="" data-original-title="Invoice"> #0202{{ $detail->order_id }}--}}
{{--                </a>--}}
{{--            </td>--}}
{{--        @endif--}}
{{--        <td>{{$profit}}</td>--}}
{{--    </tr>--}}

{{--@endforeach--}}

@foreach ($salesDetails as $detail)

    @php
        $cost     = $detail->total_cost_price[0]->totalCost;
        $sale     = $detail->total_price[0]->total;
        $shipping = $detail->is_shipment_charge_applied;
        $discount = $detail->discount_amount;
        $profit   = ($sale - $cost)+$shipping-$discount;

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
        <td>{{$profit}}</td>
    </tr>

@endforeach


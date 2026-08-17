@php
 $total = 0;
@endphp

@foreach ($soldItems as $soldItem)

<tr style="text-align:center;">

    <td>{{$loop->iteration}}</td>
    <td>
        <?php if($soldItem->product->is_outsourced == 0){ ?>
            <a onclick="getinvoiceListHistory({{ @$soldItem->barcode_id}}, '{{$fromDate}}', '{{$toDate}}')"
            class="custom_textDecoration" data-toggle="tooltip" title="Invoices" data-original-title="Invoice" style="cursor: pointer;color:#C70909">
                {{@$soldItem->barcode->barcode}}
            </a>
        <?php } else{ ?>
            
            <a onclick="invoiceModal({{ @$soldItem->order_id }})"
                class="custom_textDecoration" data-toggle="tooltip" title="Invoice" data-original-title="Invoice" style="cursor: pointer;color:#C70909">
                -- Outsorced --
             </a>
        <?php } ?>
    </td>
    {{-- <td>{{$soldItem->barcode_id}}</td> --}}
    <td>{{$soldItem->product->name}}</td>
    <td>{{$soldItem->quantitySum}}</td>
    <td>{{$soldItem->sum}}</td>

    @php
    $total+= $soldItem->sum
    @endphp
</tr>
@endforeach
<tr>
    <th colspan="4" class="text-center">Total</th>
    <td class="text-center">{{$total}}</td>
</tr>





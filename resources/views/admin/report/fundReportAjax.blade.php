@php
$total = 0;

@endphp

@foreach ($funds as $fund)
    <tr style="text-align:center;">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $fund->category->name }}</td>
        <?php if($fund->subcategory == null){?>
            <td>Not available</td>

       <?php } else{ ?>
            <td>{{ $fund->subcategory->name }}</td>
       <?php }?>
        
        {{-- <td>{{ $fund->description }}</td> --}}
        <td>{{ $amount = $fund->amount }}</td>
        @php
            $total += $amount;
        @endphp
    </tr>
@endforeach

<tr>
    <td colspan="3" style="text-align:right;">Total =</td>
    <td class="text-center">{{ $total }}</td>
</tr>
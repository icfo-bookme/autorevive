@php
$total = 0;

@endphp

@foreach ($endingBalances as $endingBalance)
    <tr style="text-align:center;">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $endingBalance->name }}</td>
        <td>{{ date('Y-m-d',strtotime($endingBalance->created_at)) }}</td>
        <td>{{ $amount = $endingBalance->amount }}</td>
        @php
            $total += $amount;
        @endphp
    </tr>
@endforeach

<tr>
    <td colspan="3" style="text-align:right;">Total =</td>
    <td class="text-center">{{ $total }}</td>
</tr>
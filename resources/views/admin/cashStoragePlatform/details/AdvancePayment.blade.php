<table id="AdvancePaymentTable" class="table table-bordered table-striped" 
       style="border-collapse: collapse; width: 100%; font-size: 14px; vertical-align: middle;">
    <thead>
        <tr>
            <th style="font-weight: bold; vertical-align: middle;">#</th>
            <th style="font-weight: bold; vertical-align: middle;">Booking</th>
            <th style="font-weight: bold; vertical-align: middle;">Paid Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Payable Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Collected By</th>
            <th style="font-weight: bold; vertical-align: middle;">Created At</th>
            <th style="font-weight: bold; vertical-align: middle;">Updated At</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        $('#AdvancePaymentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('totalCashCalculationDetails') }}?type=AdvancePaymentAmount&datatable=1",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'booking_reference', name: 'booking_reference', orderable: false },
                { data: 'paid_amount', name: 'paid_amount', orderable: true },
                { data: 'payable_amount', name: 'payable_amount', orderable: true, className: "text-right" },
                { data: 'payment_collected_by', name: 'payment_collected_by', orderable: false },
                { data: 'created_at', name: 'created_at', orderable: true },
                { data: 'updated_at', name: 'updated_at', orderable: true }
            ],
            pageLength: 10,
            responsive: true,
            autoWidth: false
        });
    });
</script>

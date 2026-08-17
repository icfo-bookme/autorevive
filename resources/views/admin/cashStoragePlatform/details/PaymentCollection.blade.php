<table id="PaymentCollectionTable" class="table table-bordered table-striped"
    style="border-collapse: collapse; width: 100%; font-size: 14px; vertical-align: middle;">
    <thead>
        <tr>
            <th style="font-weight: bold; vertical-align: middle;">#</th>
            <th style="font-weight: bold; vertical-align: middle;">Customer Name</th>
            <th style="font-weight: bold; vertical-align: middle;">Invoice Id</th>
            <th style="font-weight: bold; vertical-align: middle;">Payment Method</th>
            <th style="font-weight: bold; vertical-align: middle;">Invoice Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Total Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Collected By</th>
            <th style="font-weight: bold; vertical-align: middle;">Created At</th>
        </tr>
    </thead>
</table>

<script>
$(document).ready(function() {
    $('#PaymentCollectionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('totalCashCalculationDetails') }}?type=PaymentCollectionAmount&datatable=1",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'customer_name', name: 'customer_name', orderable: false },
            { data: 'invoice_id', name: 'invoice_id', orderable: false },
            { data: 'payment_method', name: 'payment_method', orderable: false },
            { data: 'invoice_amount', name: 'invoice_amount', orderable: false },
            { data: 'total_amount', name: 'total_amount', className: "text-right", orderable: true },
            { data: 'payment_collected_by', name: 'payment_collected_by', orderable: false },
            { data: 'created_at', name: 'created_at', orderable: true }
        ],
        pageLength: 10,
        responsive: true,
        autoWidth: false,
        language: {
            emptyTable: "No records found",
            processing: "Loading..."
        }
    });
});
</script>

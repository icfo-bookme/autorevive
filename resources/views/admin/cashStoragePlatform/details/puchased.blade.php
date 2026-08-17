<table id="PurchaseAmountTable" class="table table-bordered table-striped"
       style="border-collapse: collapse; width: 100%; font-size: 14px; vertical-align: middle;">
    <thead>
        <tr>
            <th style="font-weight: bold; vertical-align: middle;">#</th>
            <th style="font-weight: bold; vertical-align: middle;">Vendor Name</th>
            <th style="font-weight: bold; vertical-align: middle;">Purchase Date</th>
            <th style="font-weight: bold; vertical-align: middle;">Total Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Paid Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Due Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Completed At</th>
            <th style="font-weight: bold; vertical-align: middle;">Created By</th>
            <th style="font-weight: bold; vertical-align: middle;">Updated By</th>
            <th style="font-weight: bold; vertical-align: middle;">Created At</th>
            <th style="font-weight: bold; vertical-align: middle;">Updated At</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        $('#PurchaseAmountTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('totalCashCalculationDetails') }}?type=puchasedAmount&datatable=1",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'vendor_name', name: 'vendor_name', orderable: false },
                { data: 'purchase_date', name: 'purchase_date', orderable: true },
                { data: 'total_amount', name: 'total_amount', orderable: true},
                { data: 'paid_amount', name: 'paid_amount', orderable: true},
                { data: 'due_amount', name: 'due_amount', orderable: true, className: "text-right"},
                { data: 'completed_at', name: 'completed_at', orderable: true },
                { data: 'created_by', name: 'created_by', orderable: false },
                { data: 'updated_by', name: 'updated_by' , orderable: false },
                { data: 'created_at', name: 'created_at', orderable: true },
                { data: 'updated_at', name: 'updated_at', orderable: true }
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

<table id="PurchaseDraftedTable" class="table table-bordered table-striped"
       style="border-collapse: collapse; width: 100%; font-size: 14px; vertical-align: middle;">
    <thead>
        <tr>
            <th style="font-weight: bold; vertical-align: middle;">#</th>
            <th style="font-weight: bold; vertical-align: middle;">Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Note</th>
            <th style="font-weight: bold; vertical-align: middle;">Created At</th>
            <th style="font-weight: bold; vertical-align: middle;">Updated At</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        $('#PurchaseDraftedTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('totalCashCalculationDetails') }}?type=puchaseDraftedAmount&datatable=1",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'amount', name: 'amount', orderable: false },
                { data: 'note', name: 'note', orderable: false },
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

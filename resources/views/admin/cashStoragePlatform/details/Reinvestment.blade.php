<table id="ReinvestmentTable" class="table table-bordered table-striped"
       style="border-collapse: collapse; width: 100%; font-size: 14px; vertical-align: middle;">
    <thead>
        <tr>
            <th style="font-weight: bold; vertical-align: middle;">#</th>
            <th style="font-weight: bold; vertical-align: middle;">Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Date</th>
            <th style="font-weight: bold; vertical-align: middle;">Description</th>
            <th style="font-weight: bold; vertical-align: middle;">Created At</th>
            <th style="font-weight: bold; vertical-align: middle;">Created By</th>
            <th style="font-weight: bold; vertical-align: middle;">Updated By</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        $('#ReinvestmentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('totalCashCalculationDetails') }}?type=ReinvestmentAmount&datatable=1",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'amount', name: 'amount', orderable: true },
                { data: 'date', name: 'date', orderable: true },
                { data: 'description', name: 'description', orderable: true },
                { data: 'created_at', name: 'created_at', orderable: true },
                { data: 'created_by', name: 'created_by', orderable: false },
                { data: 'updated_by', name: 'updated_by', orderable: false }
            ],
            pageLength: 10,
            responsive: true,
            autoWidth: false
        });
    });
</script>

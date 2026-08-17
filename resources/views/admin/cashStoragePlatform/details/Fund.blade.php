<table id="FundAmountTable" class="table table-bordered table-striped" 
       style="border-collapse: collapse; width: 100%; font-size: 14px; vertical-align: middle;">
    <thead>
        <tr>
            <th style="font-weight: bold; vertical-align: middle;">#</th>
            <th style="font-weight: bold; vertical-align: middle;">Category</th>
            <th style="font-weight: bold; vertical-align: middle;">Subcategory</th>
            <th style="font-weight: bold; vertical-align: middle;">Amount</th>
            <th style="font-weight: bold; vertical-align: middle;">Date</th>
        </tr>
    </thead>
</table>


<script>
    $(document).ready(function() {
        $('#FundAmountTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('totalCashCalculationDetails') }}?type=FundAmount&datatable=1",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'category_id', name: 'category_id', orderable: false },
                { data: 'subcategory_id', name: 'subcategory_id', orderable: false },
                { data: 'amount', name: 'amount', orderable: true },
                { data: 'date', name: 'date', orderable: true }
            ],
            pageLength: 10,
            responsive: true,
            autoWidth: false
        });
    });
</script>

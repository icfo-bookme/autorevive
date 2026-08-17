<table id="OutsourceCostTable" class="table table-bordered table-striped"
       style="border-collapse: collapse; width: 100%; font-size: 14px; vertical-align: middle;">
    <thead>
        <tr>
            <th style="font-weight: bold; vertical-align: middle;">#</th>
            <th style="font-weight: bold; vertical-align: middle;">Product Name</th>
            <th style="font-weight: bold; vertical-align: middle;">Quantity</th>
            <th style="font-weight: bold; vertical-align: middle;">Unit Price</th>
            <th style="font-weight: bold; vertical-align: middle;">Price</th>
            <th style="font-weight: bold; vertical-align: middle;">Cost Price</th>
            <th style="font-weight: bold; vertical-align: middle;">Created By</th>
            <th style="font-weight: bold; vertical-align: middle;">Updated By</th>
            <th style="font-weight: bold; vertical-align: middle;">Created At</th>
            <th style="font-weight: bold; vertical-align: middle;">Updated At</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        $('#OutsourceCostTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('totalCashCalculationDetails') }}?type=totalOutsourcedCost&datatable=1",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'product_name', name: 'product_name', orderable: false },
                { data: 'quantity', name: 'quantity', orderable: true },
                { data: 'unit_price', name: 'unit_price', orderable: true },
                { data: 'price', name: 'price', orderable: true },
                { data: 'cost_price', name: 'cost_price', orderable: true},
                { data: 'created_by', name: 'created_by', orderable: false },
                { data: 'updated_by', name: 'updated_by', orderable: false },
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




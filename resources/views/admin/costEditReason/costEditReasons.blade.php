    <div class="modal-dialog modal-lg cost-edit-reason">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Edit Cost Reasons</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding-bottom: 15px">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="costEditReasonTable" style="width: 100%; table-layout: fixed;">
                        <thead class="table-dark">
                            <tr>
                                <th class="align-middle costEditReasonTableId">ID</th>
                                <th class="align-middle">Category</th>
                                <th class="align-middle">Subcategory</th>
                                <th class="align-middle">Amount</th>
                                <th class="align-middle">Prev Amount</th>
                                <th style="min-width: 30%!important; text-align:center;" class="align-middle reason-column">Reason</th>
                                <th class="align-middle">Created By</th>
                                <th class="align-middle">Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


<script>
    $(document).ready(function () {
        $('#costEditReasonTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('getCostEditReasonDetails') }}",
                type: "POST",
                data: function (d) {
                    d.id = "{{ request()->id }}";
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataSrc: function (response) {
                    return response.data || [];
                }
            },
            columns: [
                // { data: 'id', name: 'id' },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'category', name: 'category' },
                { data: 'subcategory', name: 'subcategory' },
                { data: 'amount', name: 'amount' },
                { data: 'prev_amount', name: 'prev_amount' },
                { 
                    data: 'reason', 
                    name: 'reason',
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).addClass('reason-column');
                    }
                },
                { data: 'created_by', name: 'created_by' },
                { data: 'created_at', name: 'created_at' }
            ]
        });
    });
</script>

<style>
    .cost-edit-reason {
        max-width: 75% !important;
        max-height: 75vh !important;
        height: auto !important;
    }

    .modal-body {
        padding: 0 15px;
    }

    .reason-column {
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
        width: 30%!important;
    }

    #costEditReasonTable {
        width: 100% !important; 
        table-layout: fixed; 
    }
        #modal-cost-edit-details .table td, .table th {
        white-space: break-spaces!important;
    }
    .costEditReasonTableId{
        width: 1%!important;
    }
</style>

@extends('layouts.backend.master')
@section('content')
<div class="mb-3">
    <a href="/costCategoryView" class="btn btn-primary">Active</a>
    <a href="/costCategoryViewInactive" class="btn btn-outline-primary">Inactive</a>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Cost Category Inactive View</div>
            <div class="card-body">
                
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="categoryTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>Category name</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {

        const csrf_token = "{{ csrf_token() }}";
        // #### DATATABLE
        var dataTable = $('#categoryTable').DataTable({
            responsive: true,
            lengthMenu: [5, 10, 25, 50, 100, 500],
            pageLength: 10,
            stateSave: true,
            language: {
                'lengthMenu': 'Display _MENU_',
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw processingColor"></i>'
            },
            scrollY: 450,
            scrollX: true,
            scrollCollapse: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: route('listAllCostCategoriesInactive'),
                data: function(data) {
                    data._token = csrf_token;
                },
                type: 'post',
            },
            columns: [{
                    data: 'name',
                    name: 'name',
                    "orderable": true,
                    "searchable": true,
                    width: "10%"
                },
                {
                    data: 'created_by',
                    name: 'created_by',
                    "orderable": true,
                    "searchable": true,
                    width: "10%"
                },
                {
                    data: 'updated_by',
                    name: 'updated_by',
                    "orderable": true,
                    "searchable": true,
                    width: "10%"
                },
                {
                    data: 'action',
                    name: 'action',
                    "orderable": false,
                    searchable: false,
                    width: "10%"
                },
            ],
            dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
        });

       
    });


    function costCategoryRestore(id) {
        alertify.confirm("Are You Sure To Restore This?",
            function() {
                $.ajax({
                    type: 'post',
                    url: '{{URL("costCategoryRestore")}}',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === true) {
                            alertify.success(response.message);
                            $('#categoryTable').DataTable().ajax.reload();
                        } else {
                            alertify.error("<span class='text-white'>" + response.message + "</span>");
                        }
                    },

                    error: function(jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            alertify.warning(msg);

                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            alertify.warning(msg);
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            alertify.warning(msg);
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            alertify.warning(msg);
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            alertify.warning(msg);
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            alertify.warning(msg);
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            alertify.warning(msg);
                        }
                    }
                });

            },
            function() {
                alertify.error("<span class='text-white'>Cancelled!</span>");
            }).setHeader('<em> CONFIRM </em> ');

    }
</script>
@endsection
@extends('layouts.backend.master')
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Add Cost</div>
                <div class="card-body">
                    <div class="mb-3" style="display: flex; justify-content:flex-end; align-items:center">
                        <div class="form-group mx-2" style="min-width: 200px; margin-bottom: 0px;">
                            <select class="form-control" id="approvalSort" onchange="listAllData(this.value)">
                              <option value="all" selected>All</option>
                              <option value="superadmin">Superadmin</option>
                              <option value="hop">Hop</option>
                              <option value="manager">Manager</option>
                              <option value="accounts">Accounts</option>
                              <option value="opManager">Operation Manager</option>
                            </select>
                          </div>
                        <a href="{{'costCategoryView'}}" class="btn btn-outline-info btn-md mx-2">Add Cost Category</a>
                        <a href="{{'costSubCategoryView'}}" class="btn btn-outline-secondary btn-md mx-2">Add Cost Sub-Category</a>
                        <button class="btn btn-success mx-2" data-toggle="modal" data-target="#modal-cost-insert">New Cost</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="costInsertTable" class="table table-bordered" style="width: 100% !important;">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Created At</th>
                                <th>Approved By</th>
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


    <!-- add cost modal -->
    <div class="modal fade" id="modal-cost-insert" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title" style="font-size: 18px;">New Cost</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="costInsertForm" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="input-1">Category Name</label>
                        <select class="form-control" name="category_id" id="categoryId">
                            <option selected disabled value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="input-1">Sub Category Name</label>
                            <select class="form-control" name="subcategory_id" id="subcategories-section">
                                <option selected disabled value="">Select sub category</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="input-1">Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter cost amount" min="0" step="any">
                        </div>
                        <div class="form-group">
                            <label for="input-1">Date</label>
                            <input type="date" name="date" class="form-control" max="{{date('Y-m-d')}}">
                        </div>
                        <div class="form-group">
                            <label for="input-1">Description (Option)</label>
                            <textarea name="description" id="" cols="8" rows="10" class="form-control" placeholder="Enter description..."></textarea>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- edit costmodal body goes here -->
    <div class="modal fade" id="modal-cost-update" style="display: none;" aria-hidden="true">
    </div>

    <!-- edit details of costmodal body goes here -->
    <div class="modal fade" id="modal-cost-edit-details" style="display: none;" aria-hidden="true">
        
    </div>


    <!-- cost log modal body goes here -->
    <div class="modal fade" id="modal-log" style="display: none;" aria-hidden="true">
    </div>

    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <script>
        const csrf_token = "{{ csrf_token() }}";
        $(document).ready(function() {
            let getApproval = $('#approvalSort').val();
            listAllData(getApproval);

            /**
             * Inserts cost sub category
             */
            $('#costInsertForm').submit(function(event) {
                event.preventDefault();

                alertify.confirm('Are You Sure ?', 'Data Will Be Inserted', function() {
                    $.ajax({
                        type: 'post',
                        url: '{{ URl('costInsert') }}',
                        data: $('#costInsertForm').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === true) {
                                alertify.success(response.message);
                                $('#modal-cost-insert').modal('hide');
                                $('#costInsertTable').DataTable().ajax.reload();
                                $('#costInsertForm')[0].reset();
                            } else if (response.status === false) {
                                alertify.error("<span class='text-white'>"+response.message+"</span>");
                            } else if (response.status === "validation-error") {
                                for (let key in response.data) {
                                    if (response.data.hasOwnProperty(key)) {
                                        alertify.error("<span class='text-white'>"+response.data[key][0]+"</span>");
                                    }
                                }
                            }
                        }
                    });

                }, function() {
                    alertify.error("<span class='text-white'>Cancelled!</span>");
                });
            });
        });

        function listAllData(getApproval){
            var dataTable = $('#costInsertTable').DataTable({
                "bDestroy": true,
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
                    url: route('listAllInsertedCosts'),
                    data: function(data) {
                        data._token = csrf_token;
                        data.getApproval = getApproval;
                    },
                    type: 'post',
                },
                columns: [
                    {
                        data: 'data_category_name',
                        name: 'data_category_name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_subcategory_name',
                        name: 'data_subcategory_name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'date',
                        name: 'date',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_approved_by',
                        name: 'data_approved_by',
                        "orderable": true,
                        "searchable": false,
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
        }

        /**
         * Fetch cost edit form and update
         * @param id
         */
        function costEdit(id) {
            $.ajax({
                type: 'post',
                url: '{{URL("getCostEditForm")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if(response.status){
                        $('#modal-cost-update').html(response.data);
                        $('#modal-cost-update').modal('show');

                        $('#costUpdateForm').submit(function (event) {
                            event.preventDefault();
                            let reason = $('textarea[name="reason"]').val().trim(); 
                            if (reason === '') {
                                alertify.error('Reason field is required!'); 
                                $('textarea[name="reason"]').focus(); 
                                return false;
                            }
                            alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
                                $.ajax({
                                    type: 'post',
                                    url: '{{URl("costUpdate")}}',
                                    data: $('#costUpdateForm').serialize(),
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.status === true) {
                                            alertify.success(response.message);
                                            $('#modal-cost-update').modal('hide');
                                            $('#costInsertTable').DataTable().ajax.reload();
                                            $('#costUpdateForm')[0].reset();
                                        } else if (response.status === false) {
                                            alertify.error("<span class='text-white'>"+response.message+"</span>");
                                        } else if (response.status === "validation-error") {
                                            for (let key in response.data) {
                                                if (response.data.hasOwnProperty(key)) {
                                                    alertify.error("<span class='text-white'>"+response.data[key][0]+"</span>");
                                                }
                                            }
                                        }
                                    }
                                });
                            }, function () {
                                alertify.error("<span class='text-white'>Cancelled!</span>");
                            });
                        });

                    } else{
                        console.log(response.data);
                        alertify.error("<span class='text-white'>"+response.message+"</span>");
                    }
                },
                error: function (jqXHR, exception) {
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
        }

        function costDetails(id) {
            $.ajax({
                type: 'post',
                url: '{{ route("showCostEditReasonPage") }}', 
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}' 
                },
                dataType: 'json',
                success: function (response) {
                    if(response.status){
                        $('#modal-cost-edit-details').html(response.data);
                        $('#modal-cost-edit-details').modal('show');
                    } else{
                        alertify.error("<span class='text-white'>"+response.message+"</span>");
                    }
                },
                error: function (jqXHR, exception) {
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
        }

        /**
         * Soft deletes cost
         * @param id
         */
        function costDelete(id) {
            alertify.confirm("Are You Sure To Delete This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: '{{URL("costDelete")}}',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === true) {
                                alertify.success(response.message);
                                $('#costInsertTable').DataTable().ajax.reload();
                            } else{
                                alertify.error("<span class='text-white'>"+response.message+"</span>");
                            }
                        },

                        error: function (jqXHR, exception) {
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
                function () {
                    alertify.error("<span class='text-white'>Cancelled!</span>");
                }).setHeader('<em> CONFIRM </em> ');

        }

        /**
         * Soft deletes cost
         * @param id
         */
        function approvalStatusChange(id,approvalStatus) {
            let approvalMessage = "Approve?";
            if(approvalStatus == 0){
                approvalMessage = "Not approve?";
            }

            // alertify.confirm(approvalMessage,
            //     function () {
            //         $.ajax({
            //             type: 'post',
            //             url: '{{URL("approvalStatusChange")}}',
            //             data: {
            //                 id: id,
            //                 approvalStatus: approvalStatus,
            //             },
            //             dataType: 'json',
            //             success: function (response) {
            //                 if (response.status === true) {
            //                     alertify.success(response.message);
            //                     $('#costInsertTable').DataTable().ajax.reload();
            //                 } else{
            //                     alertify.error("<span class='text-white'>"+response.message+"</span>");
            //                 }
            //             },

            //             error: function (jqXHR, exception) {
            //                 var msg = '';
            //                 if (jqXHR.status === 0) {
            //                     msg = 'Not connect.Verify Network.';
            //                     alertify.warning(msg);

            //                 } else if (jqXHR.status == 404) {
            //                     msg = 'Requested page not found. [404]';
            //                     alertify.warning(msg);
            //                 } else if (jqXHR.status == 500) {
            //                     msg = 'Internal Server Error [500].';
            //                     alertify.warning(msg);
            //                 } else if (exception === 'parsererror') {
            //                     msg = 'Requested JSON parse failed.';
            //                     alertify.warning(msg);
            //                 } else if (exception === 'timeout') {
            //                     msg = 'Time out error.';
            //                     alertify.warning(msg);
            //                 } else if (exception === 'abort') {
            //                     msg = 'Ajax request aborted.';
            //                     alertify.warning(msg);
            //                 } else {
            //                     msg = 'Uncaught Error.\n' + jqXHR.responseText;
            //                     alertify.warning(msg);
            //                 }
            //             }
            //         });
            //     },
            //     function () {
            //         alertify.error("<span class='text-white'>Cancelled!</span>");
            //     }).setHeader('<em> CONFIRM </em> ');

            // Proceed directly with the AJAX call
            $.ajax({
                type: 'post',
                url: '{{URL("approvalStatusChange")}}',
                data: {
                    id: id,
                    approvalStatus: approvalStatus,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === true) {
                        alertify.success(response.message);
                        $('#costInsertTable').DataTable().ajax.reload();
                    } else {
                        alertify.error("<span class='text-white'>" + response.message + "</span>");
                    }
                },
                error: function (jqXHR, exception) {
                    let msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect. Verify Network.';
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
        }

        /**
         * Fetch cost log
         * @param id
         */
        function costLog(id) {
            $.ajax({
                type: 'post',
                url: '{{URL("getCostLogForm")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if(response.status){
                        $('#modal-log').html(response.data);
                        $('#modal-log').modal('show');

                    } else{
                        console.log(response.data);
                        alertify.error("<span class='text-white'>"+response.message+"</span>");
                    }
                },
                error: function (jqXHR, exception) {
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
        }

        //In add modal
        $(document).on('change','#categoryId',function(){
            let categoryId = $(this).val();
            $.ajax({
                type: 'post',
                url: '{{URL("getSubcategoriesByCategoryId")}}',
                data: {
                    categoryId: categoryId
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === true) {
                        $('#subcategories-section').html('<option selected disabled value="">Select sub category</option>');
                        let html = '';
                        response.data.forEach((value,index) => {
                            console.log(value);
                           html += '<option value="'+value.id+'">'+value.name+'</option>';
                        });
                        $('#subcategories-section').append(html);

                    } else{
                        alertify.error("<span class='text-white'>"+response.message+"</span>");
                    }
                },

                error: function (jqXHR, exception) {
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
        });

        //In edit modal
        $(document).on('change','#categoryIdUpdate',function(){
            let categoryId = $(this).val();
            $.ajax({
                type: 'post',
                url: '{{URL("getSubcategoriesByCategoryId")}}',
                data: {
                    categoryId: categoryId
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === true) {
                        $('#subcategories-section-update').html('<option selected disabled value="">Select sub category</option>');
                        let html = '';
                        response.data.forEach((value,index) => {
                            console.log(value);
                           html += '<option value="'+value.id+'">'+value.name+'</option>';
                        });
                        $('#subcategories-section-update').append(html);

                    } else{
                        alertify.error("<span class='text-white'>"+response.message+"</span>");
                    }
                },

                error: function (jqXHR, exception) {
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
        });
    </script>
@endsection

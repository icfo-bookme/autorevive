@extends('layouts.backend.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Fund Sub Category View</div>
                <div class="card-body">
                    <div class="float-right mb-3">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-subcategory-insert">New Sub Category</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="subCategoryTable" class="table table-bordered" style="width: 100% !important;">
                            <thead class="text-center">
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
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


    <!-- add category modal -->
    <div class="modal fade" id="modal-subcategory-insert" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title" style="font-size: 18px;">New Sub-Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="fundSubCategoryInsertForm" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="input-1">Category Name</label>
                        <select class="form-control" name="category_id">
                            <option selected disabled value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="input-1">Sub Category Name</label>
                            <input type="text" class="form-control" placeholder="category name" name="name" required>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- edit category name modal body goes here -->
    <div class="modal fade" id="modal-subcategory-update" style="display: none;" aria-hidden="true">
    </div>

    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <script>
        $(document).ready(function() {

            const csrf_token = "{{ csrf_token() }}";

            var dataTable = $('#subCategoryTable').DataTable({
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
                    url: route('listAllFundSubCategories'),
                    data: function(data) {
                        data._token = csrf_token;
                    },
                    type: 'post',
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'category.name',
                        name: 'category.name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_created_by',
                        name: 'data_created_by',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_updated_by',
                        name: 'data_updated_by',
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

            /**
             * Inserts fund sub category
             */
            $('#fundSubCategoryInsertForm').submit(function(event) {
                event.preventDefault();

                alertify.confirm('Are You Sure ?', 'Data Will Be Inserted', function() {
                    $.ajax({
                        type: 'post',
                        url: '{{ URl('fundSubCategoryInsert') }}',
                        data: $('#fundSubCategoryInsertForm').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === true) {
                                alertify.success(response.message);
                                dataTable.ajax.reload();
                                $('#fundSubCategoryInsertForm')[0].reset();
                                $('#modal-subcategory-insert').modal('hide');
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

        /**
         * Fetch fund sub category edit form and update
         * @param id
         */
        function fundSubCategoryEdit(id) {
            $.ajax({
                type: 'post',
                url: '{{URL("getFundSubCategoryEditForm")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if(response.status){
                        $('#modal-subcategory-update').html(response.data);
                        $('#modal-subcategory-update').modal('show');

                        $('#fundSubCategoryUpdateForm').submit(function (event) {
                            event.preventDefault();
                            alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
                                $.ajax({
                                    type: 'post',
                                    url: '{{URl("fundSubCategoryUpdate")}}',
                                    data: $('#fundSubCategoryUpdateForm').serialize(),
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.status === true) {
                                            alertify.success(response.message);
                                            $('#modal-subcategory-update').modal('hide');
                                            $('#subCategoryTable').DataTable().ajax.reload();
                                            $('#fundSubCategoryUpdateForm')[0].reset();
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

        /**
         * Soft deletes fund sub category
         * @param id
         */
        function fundSubCategoryDelete(id) {
            alertify.confirm("Are You Sure To Delete This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: '{{URL("fundSubCategoryDelete")}}',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === true) {
                                alertify.success(response.message);
                                $('#subCategoryTable').DataTable().ajax.reload();
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
    </script>
@endsection

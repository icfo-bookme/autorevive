@extends('layouts.backend.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Add Fund</div>
                <div class="card-body">
                    <div class="float-right mb-3">
                        <a href="{{'fundCategoryView'}}" class="btn btn-outline-info btn-md">Add Fund Category</a>
                        <a href="{{'fundSubCategoryView'}}" class="btn btn-outline-secondary btn-md">Add Fund Sub-Category</a>
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-fund-insert">New Fund</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="fundInsertTable" class="table table-bordered" style="width: 100% !important;">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Created At</th>
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


    <!-- add fund modal -->
    <div class="modal fade" id="modal-fund-insert" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <div class="modal-header" style="border-bottom: none;">
                    <h4 class="modal-title" style="font-size: 18px;">New Fund</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="fundInsertForm" method="post">
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
                            <input type="number" name="amount" class="form-control" placeholder="Enter fund amount" min="0" step="any">
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


    <!-- edit fundmodal body goes here -->
    <div class="modal fade" id="modal-fund-update" style="display: none;" aria-hidden="true">
    </div>

    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <script>
        // $(document).ready(function() {
        //     window.addEventListener( "pageshow", function ( event ) {
        //     var perfEntries = performance.getEntriesByType("navigation");
        //         if (perfEntries[0].type === "back_forward") {
        //             location.reload();
        //         }
        //     });
        //     const [entry] = performance.getEntriesByType("navigation");
        //     if (entry["type"] === "back_forward")
        //         location.reload();
        // });

        $(document).ready(function() {
            window.addEventListener( "pageshow", function ( event ) {
            var perfEntries = performance.getEntriesByType("navigation");
                if (perfEntries[0].type === "back_forward") {
                    location.reload();
                }
            });
            
            const csrf_token = "{{ csrf_token() }}";

            var dataTable = $('#fundInsertTable').DataTable({
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
                    url: route('listAllInsertedFunds'),
                    data: function(data) {
                        data._token = csrf_token;
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
            $('#fundInsertForm').submit(function(event) {
                event.preventDefault();

                alertify.confirm('Are You Sure ?', 'Data Will Be Inserted', function() {
                    $.ajax({
                        type: 'post',
                        url: '{{ URl('fundInsert') }}',
                        data: $('#fundInsertForm').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === true) {
                                alertify.success(response.message);
                                dataTable.ajax.reload();
                                $('#fundInsertForm')[0].reset();
                                $('#modal-fund-insert').modal('hide');
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
         * Fetch fund edit form and update
         * @param id
         */
        function fundEdit(id) {
            $.ajax({
                type: 'post',
                url: '{{URL("getFundEditForm")}}',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if(response.status){
                        $('#modal-fund-update').html(response.data);
                        $('#modal-fund-update').modal('show');

                        $('#fundUpdateForm').submit(function (event) {
                            event.preventDefault();
                            alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
                                $.ajax({
                                    type: 'post',
                                    url: '{{URl("fundUpdate")}}',
                                    data: $('#fundUpdateForm').serialize(),
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.status === true) {
                                            alertify.success(response.message);
                                            $('#modal-fund-update').modal('hide');
                                            $('#fundInsertTable').DataTable().ajax.reload();
                                            $('#fundUpdateForm')[0].reset();
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
         * Soft deletes fund
         * @param id
         */
        function fundDelete(id) {
            alertify.confirm("Are You Sure To Delete This?",
                function () {
                    $.ajax({
                        type: 'post',
                        url: '{{URL("fundDelete")}}',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === true) {
                                alertify.success(response.message);
                                $('#fundInsertTable').DataTable().ajax.reload();
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
         
        //In add modal
        $(document).on('change','#categoryId',function(){
            let categoryId = $(this).val();
            $.ajax({
                type: 'post',
                url: '{{URL("getFundSubcategoriesByCategoryId")}}',
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
                url: '{{URL("getFundSubcategoriesByCategoryId")}}',
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

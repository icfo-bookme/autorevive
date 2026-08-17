@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Sub-Category View</div>

            <div class="card-body">
                <div class="float-right mb-3">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-subcategory-insert">New
                        Sub-Category</button>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="classTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Category name</th>
                                <th>Sub-Category name</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            

                            @foreach ($subCategories as $sub_cat)
                            <tr style="text-align:center;">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$sub_cat->category->name}}</td>
                                <td>{{$sub_cat->name}}</td>
                                <td>{{$sub_cat->created_by}}</td>
                             

                            <td>
                                <a href="javascript:void(0)" onclick="editSubCategory({{$sub_cat->id}})"
                                    style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                    data-toggle="tooltip" title="" data-original-title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="deleteSubCategory({{$sub_cat->id}})"
                                    style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                    data-toggle="tooltip" title="" data-original-title="Delete">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                            </tr>

                            @endforeach




                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal new subject -->
<div class="modal fade" id="modal-subcategory-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">New Sub-Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="subCategoryInsertForm">


                     <div class="form-group">
                         <label for="input-1">Category Name</label>
                            <select class="form-control form-control-sm" name="category_id">
                                <option selected disabled value="">---select category---</option>
                                @foreach ($categories as $category)
                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                     </div>

                    <div class="form-group">
                        <label for="input-1">Sub-Category Name</label>
                        <input type="text" class="form-control"  placeholder="sub-category name" name="name"
                            required>
                    </div>

                
            </div>
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
            </div>
            </form>
        </div>
    </div>
</div>









<!-- modal body goes here -->
<div class="modal fade" id="modal-subcategory-update" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Update Sub-Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="subCategoryUpdateForm">
                   <div class="form-group">
                       <label for="input-1">Category Name</label>
                       <input type="hidden" id="subCategoryId" name="id" value="">
                         <select class="form-control form-control-sm" name="category_id" id="category_id">
                                <option selected disabled value="">---select category---</option>
                                @foreach ($categories as $category)
                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                       
                   </div>


                    <div class="form-group">
                        <label for="input-1">Sub-Category Name</label>
                        <input type="text" class="form-control" id="sub_category_name" placeholder="sub-category name" name="name"
                            required>
                    </div>

            </div>
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
</form>

<script>
    $(document).ready(function () {

        var table = $('#classTable').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
        });

        table.buttons().container()
            .appendTo('#classTable_wrapper .col-md-6:eq(0)');

            
        $('#subCategoryInsertForm').submit(function () {
            event.preventDefault();

             alertify.confirm('Are You Sure ?', 'Data Will Be Inserted', function () {
            

            $.ajax({
                type: 'post',
                url: '{{URl("subCategoryInsertAjax")}}',
                data: $('#subCategoryInsertForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.error('Something Went Wrong');
                        $('#modal-subcategory-insert').modal('hide');
                    }else {
                        //alert(data);
                        alertify.success(data);
                        $('#modal-subcategory-insert').modal('hide');

                        setTimeout(function () {
                            location.reload(true);
                        }, 1000)


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

             }, function () {
             alertify.error('Cancel')
             });
        });




        $('#subCategoryUpdateForm').submit(function () {
            event.preventDefault();

            $.ajax({
                type: 'post',
                url: '{{URl("subCategoryUpdateAjax")}}',
                data: $('#subCategoryUpdateForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        alertify.warning('Something Went Wrong');
                        $('#modal-subcategory-update').modal('hide');
                    } else {
                        //alert(data);
                        alertify.success(data);
                        $('#modal-subcategory-update').modal('hide');

                        setTimeout(function () {
                            location.reload(true);
                        }, 1000)
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
    });

    /**
     * @name editClass
     * @role fetch info and load them into modal for edit
     * @param class id
     * @return
     *
     */

    function editSubCategory(id) {

       
        $.ajax({
            type: 'post',
            url: '{{URL("getSubCategoryDetails")}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {

                    alertify.warning("Something went wrong");
                } else {

                      $('#subCategoryId').val(data.id);
                      $('#category_id').val(data.category_id);
                      $('#sub_category_name').val(data.name);
                      $('#modal-subcategory-update').modal('show');

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
     * @name deleteClass
     * @role send ajax request to delete a class
     * @param role id
     * @return json response
     *
     */
    function deleteSubCategory(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("subCategoryDeleteAjax")}}',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.warning('Something Went Wrong');
                        } else {
                            //alert(data);
                            alertify.success(data);
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000)


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
                alertify.error('Canceled');
            }).setHeader('<em> CONFIRM </em> ');

    }

</script>
@endsection

@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Category View</div>

            <div class="card-body">
                <div class="float-right mb-3">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-category-insert">New
                        Category</button>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="classTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Category name</th>
                                <th>Priority</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($categories as $category)
                            <tr style="text-align:center;">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$category->name}}</td>
                            <td>
                                <a class="custom_textDecoration" onclick="editPriority({{$category->id}})"style="cursor:pointer">
                                    {{$category->priority}}
                                </a>
                            </td>
                            <td>{{$category->created_by}}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="editCategory({{$category->id}})"
                                    style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                    data-toggle="tooltip" title="" data-original-title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="deleteCategory({{$category->id}})"
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


<!-- add modal new subject -->
<div class="modal fade" id="modal-category-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">New Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryInsertForm">


                    <div class="form-group">
                        <label for="input-1">Category Name</label>
                        <input type="text" class="form-control" id="category_name" placeholder="category name" name="name"
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


<!-- edit category name modal body goes here -->
<div class="modal fade" id="modal-category-update" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Update Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryUpdateForm">
                   <div class="form-group">
                       <label for="input-1">Category Name</label>
                       <input type="hidden" id="categoryId" name="id" value="">
                       <input type="text" class="form-control" id="edit_category" placeholder="" name="name"
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



{{-- edit priority modal --}}

<div class="modal fade" id="editPriorityModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px;">
                    Set Priority
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST" id="updatePriorityForm">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-3"> Priority :</label>
                            <div class="col-md-9">
                                <input type="hidden" id="id" name="id">
                                <input type="text" id="update_priority" class="form-control square" name="priority" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" onclick="priorityUpdate()">
                                <i class="icon-cross2"></i> update
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="icon-cross2"></i> Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>

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




        $('#categoryInsertForm').submit(function (event) {
            event.preventDefault();

             alertify.confirm('Are You Sure ?', 'Data Will Be Inserted', function () {

            $.ajax({
                type: 'post',
                url: '{{URl("categoryInsertAjax")}}',
                data: $('#categoryInsertForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if(response.status === true){
                        alertify.success(response.message);
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000)
                    } else if(response.status === false){
                        alertify.error(response.message);
                    }  else if(response.status === "validation-error"){
                       alertify.error(response.data.name[0]);
                    }
                }
            });

             }, function () {
             alertify.error('Cancelled!')
             });
        });



        $('#categoryUpdateForm').submit(function (event) {
            event.preventDefault();

            $.ajax({
                type: 'post',
                url: '{{URl("categoryUpdateAjax")}}',
                data: $('#categoryUpdateForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if(response.status === true){
                        alertify.success(response.message);
                        setTimeout(function () {
                            location.reload(true);
                        }, 1000)
                    } else if(response.status === false){
                        alertify.error(response.message);
                    }  else if(response.status === "validation-error"){
                        alertify.error(response.data.name[0]);
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

    function editCategory(id) {


        $.ajax({
            type: 'post',
            url: '{{URL("getCategoryDetails")}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {

                    alertify.warning("Something went wrong");
                } else {
                     $('#categoryId').val(data.id);
                     $('#edit_category').val(data.name);
                     $('#modal-category-update').modal('show');

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
    function deleteCategory(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("categoryDeleteAjax")}}',
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

    /*PRIORITY
        EDIT
    */
         function editPriority(id) {
         $.ajax({
         url: "{{ URL('getCatPriority') }}",
         method: "POST",
         data: {
         id: id
         },
         dataType:"json",
         success: function (result) {
         //alert(result);
         // console.log(result);
         $("#id").val(result.id);
         $("#update_priority").val(result.priority);
         $("#editPriorityModal").modal('show');
         },
         error: function (jqXHR, exception) {
         var msg = '';
         if (jqXHR.status === 0) {
         msg = 'Not connect.Verify Network.';
         alertify.warning(msg);
         $('#preloader').modal('hide');

         } else if (jqXHR.status == 404) {
         msg = 'Requested page not found. [404]';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else if (jqXHR.status == 500) {
         msg = 'Internal Server Error [500].';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else if (exception === 'parsererror') {
         msg = 'Requested JSON parse failed.';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else if (exception === 'timeout') {
         msg = 'Time out error.';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else if (exception === 'abort') {
         msg = 'Ajax request aborted.';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else {
         msg = 'Uncaught Error.\n' + jqXHR.responseText;
         alertify.warning(msg);
         $('#preloader').modal('hide');
         }

         }
         });

         }


         function priorityUpdate() {
         event.preventDefault();
         alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
         $('#preloader').modal('show');
         $.ajax({
         url: "{{ URL('updateCatPriority') }}",
         method: "POST",
         data: $('#updatePriorityForm').serialize(),
         success: function (result) {
         //alert(result);
         console.log("success")
         if (result == "Success") {
         alertify.success('Successfully Data Updated');
         $('#preloader').modal('hide');
         $("#updateRouteModal").modal('hide');
         setTimeout(function () {

         location.reload(true);
         }, 1000);

         } else {

         alertify.error('Error Found!');
         $('#preloader').modal('hide');
         setTimeout(function () {

         // location.reload(true);
         }, 1000);

         }
         },
         error: function (jqXHR, exception) {
         var msg = '';
         if (jqXHR.status === 0) {
         msg = 'Not connect.Verify Network.';
         alertify.warning(msg);
         $('#preloader').modal('hide');

         } else if (jqXHR.status == 404) {
         msg = 'Requested page not found. [404]';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else if (jqXHR.status == 500) {
         msg = 'Internal Server Error [500].';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else if (exception === 'parsererror') {
         msg = 'Requested JSON parse failed.';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else if (exception === 'timeout') {
         msg = 'Time out error.';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else if (exception === 'abort') {
         msg = 'Ajax request aborted.';
         alertify.warning(msg);
         $('#preloader').modal('hide');
         } else {
         msg = 'Uncaught Error.\n' + jqXHR.responseText;
         alertify.warning(msg);
         $('#preloader').modal('hide');
         }

         }
         });
         }, function () {
         alertify.error('Cancel')
         });


         }

</script>
@endsection

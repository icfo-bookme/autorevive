@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Vendors View</div>

            <div class="card-body">
                <div class="float-right mb-3">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-vendor-insert">New
                        Vendor</button>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="classTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Vendor name</th>
                                <th>Address</th>
                                <th>Contact Person</th>
                                <th>Contact Number</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            

                            @foreach ($vendors as $vendor)
                            <tr style="text-align:center;">
                                <td>{{$loop->iteration}}</td>
                            <td>{{$vendor->name}}</td>
                            <td>{{$vendor->address}}</td>
                            <td>{{$vendor->contact_person}}</td>
                            <td>{{$vendor->phone_number}}</td>
                             <td>{{$vendor->created_by}}</td>

                            <td>
                                <a href="javascript:void(0)" onclick="editVendor({{$vendor->id}})"
                                    style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                    data-toggle="tooltip" title="" data-original-title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="deleteVendor({{$vendor->id}})"
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
<div class="modal fade" id="modal-vendor-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">New Vendor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="vendorInsertForm">


                    <div class="form-group">
                        <label for="input-1">Vendor Name</label>
                        <input type="text" class="form-control" id="school_name" placeholder="vendor name" name="name"
                            required>
                    </div>

                 

                    <div class="form-group">
                        <label for="input-1">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Address"
                            name="address" required>
                    </div>

                    <div class="form-group">
                        <label for="input-1">Contact Person</label>
                        <input type="text" class="form-control" id="contact_person"
                            placeholder="contact person" name="contact_person" required>
                    </div>

                     <div class="form-group">
                         <label for="input-1">Contact Number</label>
                         <input type="number" class="form-control" id="phone_number" placeholder="contact number"
                             name="phone_number" required>
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
<div class="modal fade" id="modal-vendor-update" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Update Vendor information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="vendorUpdateForm">
                   <div class="form-group">
                       <label for="input-1">Vendor Name</label>
                       <input type="hidden" id="vendorId" name="id" value="">
                       <input type="text" class="form-control" id="edit_vendor_name" placeholder="vendor name" name="name"
                           required>
                   </div>

                   <div class="form-group">
                       <label for="input-1">Address</label>
                       <input type="text" class="form-control" id="edit_address" placeholder="Address" name="address"
                           required>
                   </div>

                   <div class="form-group">
                       <label for="input-1">Contact Person</label>
                       <input type="text" class="form-control" id="edit_contact_person" placeholder="contact person"
                           name="contact_person" required>
                   </div>

                   <div class="form-group">
                       <label for="input-1">Contact Number</label>
                       <input type="number" class="form-control" id="edit_contact_number" placeholder="contact number"
                           name="phone_number" required>
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
            scrollY: 450,
            scrollX: true,
            scrollCollapse: true,
        });

        table.buttons().container()
            .appendTo('#classTable_wrapper .col-md-6:eq(0)');




        $('#vendorInsertForm').submit(function () {
            event.preventDefault();

             alertify.confirm('Are You Sure ?', 'Vendor Will Be Created', function () {
            

            $.ajax({
                type: 'post',
                url: '{{URl("vendorInsertAjax")}}',
                data: $('#vendorInsertForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {

                        alertify.error('Something Went Wrong');
                        $('#modal-vendor-insert').modal('hide');
                    }else {
                        //alert(data);
                        alertify.success(data);
                        $('#modal-vendor-insert').modal('hide');

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




        $('#vendorUpdateForm').submit(function () {
            event.preventDefault();

            $.ajax({
                type: 'post',
                url: '{{URl("vendorUpdateAjax")}}',
                data: $('#vendorUpdateForm').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                        alertify.warning('Something Went Wrong');
                        $('#modal-vendor-update').modal('hide');
                    } else {
                        //alert(data);
                        alertify.success(data);
                        $('#modal-vendor-update').modal('hide');

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

    function editVendor(id) {

       
        $.ajax({
            type: 'post',
            url: '{{URL("getVendorDetails")}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {

                    alertify.warning("Something went wrong");
                } else {
                    //alert(data);
                    console.log(data);
                    $('#vendorId').val(data.id);
                    $('#edit_vendor_name').val(data.name);
                    $('#edit_address').val(data.address);
                    $('#edit_contact_person').val(data.contact_person);
                    $('#edit_contact_number').val(data.phone_number);

                     $('#modal-vendor-update').modal('show');

                    // clearForm();

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
    function deleteVendor(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("vendorDeleteAjax")}}',
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

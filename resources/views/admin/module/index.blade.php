@extends('layouts.backend.master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Module View</h4>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="roleTable" style="width: 100% !important">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="rolesTableBody">
                                    @foreach ($modules as $iteration=>$module)
                                    <tr>
                                        <td>{{ $iteration+1 }}</td>
                                        <td>{{ $module->name }}</td>
                                        <td>{{$module->created_by}}</td>
                                        <td>
                                            <a href="javascript:void(0)" id="edit-module" data-id="{{ $module->id }}"
                                                class="btn btn-info">Edit</a>

                                            <a href="javascript:void(0)" id="delete-module" data-id="{{ $module->id }}"
                                                class="btn btn-danger">Delete</a>

                                        </td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>





                <div class="modal fade" id="module-update-modal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Module Update</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="form" id="moduleEditForm">
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    @csrf
                                                    <input type="hidden" name="module_id" id="module_id">
                                                    <label for="eventInput1">Module Name</label>
                                                    <input type="text" class="form-control" id="module_name"
                                                        name="moduleName">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id='save' onclick="editModule()">Save
                                    changes</button>
                                <button type="button" class="btn btn-secondary" id='close'
                                    data-dismiss="modal">Close</button>


                            </div>
                        </div>
                    </div>
                </div>
                {{-- end Modal --}}
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#roleTable').DataTable({
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true
        });
        $('body').on('click', '#edit-module', function () {

            // parent = $(this).parent('td');
            var module_id = $(this).data('id');
            // console.log(module_id);

            $('#module-update-modal').modal('show');

            $.ajax({
                type: 'get',
                url: '../admin/getModule/' + module_id,
                success: function (data) {
                    if (typeof data.errors !== 'undefined') { 
                        alertify.warning('Something Went Wrong');
                    } else {
                        $('#module_id').val(data.id);
                        $('#module_name').val(data.name);
                        $('#module_route').val(data.route);
                    }
                }

            });
        });





        $('body').on('click', '#delete-module', function () {
            console.log('DELETE_CLICKED');
            var module_id = $(this).data('id');
            // console.log(module_id);
            alertify.confirm(
                'Are you sure?', 'Your will not be able to recover this!',
                function () {
                    $.ajax({
                        type: 'post',
                        url: '../admin/modulesDeleteAjax',
                        data: {
                            module_id: module_id
                        },
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {
								alertify.alert("This is an alert dialog.", function() {
									alertify.error(data.errors.name);
								});
                            } else {
								console.log(data);
								alertify.success('Module deleted');
                                reload(1000);
                            }
                        },
                        error: function (data) {
							alertify.error(data);
                        }
                    });
                },
                function () {
                    alertify.error('Cancel')
                });
        });
    });

    function editModule() {
        $("#save").attr("disabled", true);
        event.preventDefault();
        var module_id = $('#module_id').val();
        console.log(module_id);

        $.ajax({
            type: 'post',
            url: '../admin/updateModule/' + module_id,
            data: $("#moduleEditForm").serialize(),
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {
                    // the variable is defined 
                    console.log(data.errors.name);

                } else {
                    // console.log(data);
                    // console.log(data.name);
                    $('#module-update-modal').modal('hide');
					alertify.success('Module Updated Successfully!')
                    $("#moduleEditForm").trigger('reset');

                    //location.reload(true);
                    reload(1000);

                }
            }

        });

    }

    function reload(timeoutPeriod) {
        setTimeout("location.reload(true);", timeoutPeriod);
    }

</script>
@endsection

@extends('layouts.backend.master')
@section('content')
        
                <h4 class="card-title">Permission Module View</h4>
                
                
           
                <div class="table-responsive">
                    <table class="table" id="roleTable">
                        <thead class="thead-inverse">
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
                                        class="btn btn-primary">Delete</a>

                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
      




        <div class="modal fade" id="module-update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Permission Module Name</h5>
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
                                            <label for="eventInput1">Permission Module Name</label>
                                            <input type="text" class="form-control" id="module_name" name="moduleName">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="editModule()">Save
                            changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                    </div>
                </div>
            </div>
        </div>
        
 

<script>
    $(document).ready(function () {

        $('body').on('click', '#edit-module', function () {
            var module_id = $(this).data('id');
            // console.log(module_id);

            $('#module-update-modal').modal('show');

            $.ajax({
                type: 'get',
                url: './getPermissionModule/' + module_id,
                success: function (data) {
                    if (typeof data.errors !=='undefined') { // the variable is defined alert(data.errors.name); } else

                    } else {
                        //  console.log(data);
                        // console.log(data.name);

                        $('#module_id').val(data.id);
                        //console.log(data.id);
                        $('#module_name').val(data.name);
                        $('#module_route').val(data.route);
                    }
                }

            });
        });


        $('body').on('click', '#delete-module', function () {
            var module_id = $(this).data('id');
            // console.log(module_id);
               alertify.confirm('Are You Sure ?', 'Data Will Be Deleted', function () {


                    $.ajax({
                        type: 'post',
                        url: './PermissionModulesDeleteAjax',
                        data: {
                            '_token':'{{ csrf_token() }}',
                            module_id: module_id
                        },
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {
                                 alertify.error(data.errors.name);
                            } else {
                               alertify.success('Succcessfully deleted!');
                               setTimeout(function () {
                               location.reload(true);
                               }, 1000);
                            }
                        },
                        error: function (data) {

                        }

                    });

                    }, function () {
                    alertify.error('Cancel');
                    });

                });
    });

    function editModule() {
        event.preventDefault();
        var module_id = $('#module_id').val();
        console.log(module_id);

        $.ajax({
            type: 'patch',
            url: './updatePermissionModule/' + module_id,
            data: $("#moduleEditForm").serialize(),
            dataType: 'json',
            success: function (data) {
                if (typeof data.errors !== 'undefined') {
                      alertify.error('Error');

                } else {
                    
                    $('#module-update-modal').modal('hide');
                    $("#moduleEditForm").trigger('reset');
                      alertify.success('Success');
                     setTimeout(function () {
                     location.reload(true);
                     }, 1000);

                }
            }

        });

    }

    function reload(timeoutPeriod) {
        setTimeout("location.reload(true);", timeoutPeriod);
    }

</script>
@endsection

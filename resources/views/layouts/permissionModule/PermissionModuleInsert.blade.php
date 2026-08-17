@extends('layouts.backend.master')
@section('content')
    <div class="col-md-12">
        
                <h4 class="card-title" id="basic-layout-form-center">Permission Module Registration</h4>
                    <form class="form" id="PermissionModuleInsertForm">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="eventInput1">Permission Module Name</label>
                                        <input type="text" id="moduleName" class="form-control"
                                            placeholder="Module Name" name="moduleName">
                                    </div>
                                    @csrf

                                </div>
                            </div>
                        </div>

                        <div class="form-actions center">

                            <button type="submit" class="btn btn-primary">
                                <i class="icon-check2"></i> Save
                            </button>
                            <button type="button" class="btn btn-danger mr-1" onclick="clearForm()">
                                <i class="icon-cross2"></i> Cancel
                            </button>
                        </div>
                    </form>

                </div>
<script>
    $(document).ready(function () {

        $("#PermissionModuleInsertForm").submit(function () {
            event.preventDefault()
            $.ajax({
                type: 'post',
                url: './PermissionModuleInsertAjax',
                data: $("#PermissionModuleInsertForm").serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                     
                         alertify.error('Error!');

                    } else {
                        //alert(data);
                        alertify.success('success');
                        clearForm();
                    }


                },
                error: function (data) {
                    
                }

            });

        });

        

    });

    function clearForm() {
    $('#PermissionModuleInsertForm').trigger("reset");
    }

</script>
@endsection

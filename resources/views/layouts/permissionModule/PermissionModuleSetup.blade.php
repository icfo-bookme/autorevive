@extends('layouts.backend.master')
@section('content')


                <h4 class="card-title" id="basic-layout-form-center">Permission Module Setup</h4>
                

                    <form class="form" id="moduleSetupInsertForm">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="projectinput6">Permission Module</label>
                                        <select id="module" name="module" class="form-control">
                                            <option selected="" disabled="">--SELECT MODULE--</option>
                                            @foreach ($modules as $module)
                                            <option  value="{{$module->id}}">{{$module->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="eventInput1">Route URL</label>
                                        <input type="text" id="moduleName" class="form-control"
                                            placeholder="Module Name" name="route">

                                    </div>
                                   

                                </div>
                            </div>
                        </div>

                        <div class="form-actions center">

                            <button type="submit" class="btn btn-primary">
                                <i class="icon-check2" id='get-module'></i> Save
                            </button>
                            <button type="button" class="btn btn-danger mr-1" onclick="clearForm()">
                                <i class="icon-cross2"></i> Cancel
                            </button>
                        </div>
                    </form>

                

<script>
    $(document).ready(function () {

        $("#moduleSetupInsertForm").submit(function () {
            event.preventDefault()
            $.ajax({
                type: 'post',
                url: './PermissionModuleDetailsInsertAjax',
                data: $("#moduleSetupInsertForm").serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
                         alertify.error(data.errors.module_id+" \n"+data.errors.route);
                    } else {
                        alertify.success('Success');
                        clearForm();
                    }


                },
                error: function (data) {

                }

            });

        });



    });

    function clearForm() {
        $('#moduleSetupInsertForm').trigger("reset");
    }

</script>
@endsection

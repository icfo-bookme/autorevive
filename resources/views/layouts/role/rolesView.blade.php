@extends('layouts.backend.master')
@section('content')

<div class="table-responsive">
                    <table class="table" id="roleTable">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Created by</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="rolesTableBody">

                            @foreach ($allRole as $serial => $role)
                               <tr>
                                <td>{{ $serial+1 }}</td>
                                    <td>{{$role->name }}</td>
                                    <td>{{ $role->created_by }}</td>
                                    <td>
                                        <button class="btn btn-danger" type="button" id='delete-role' data-id="{{ $role->id }}">Delete</button>
                                         <a  href='{{ route('role.edit',$role->id) }}' class="btn btn-primary" type="button">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                    </table>

<script>
 $(document).ready(function(){


$('body').on('click', '#delete-role', function () {
            var role_id = $(this).data('id');
            //console.log(role_id);

            alertify.confirm('Are You Sure ?', 'Data Will Be Deleted', function () {
                  
                    $.ajax({
                        type: 'post',
                        url: './deleteRole',
                        data: {
                            '_token':'{{ csrf_token() }}',
                            role_id: role_id
                        },
                        success: function (data) {
                            if (typeof data.errors !== 'undefined') {
                                 alertify.error('Error');
                            } else {
                               alertify.success('Success');
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

</script>
@endsection

        

@extends('layouts.backend.master')
@section('content')

<style>
    .table td, .table th {
         white-space: normal;
    }

    .card .table td, .card .table th {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Customer Feedbacks </div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="mailTable" class="table table-bordered text-justify" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allMail as $mail)
                            <tr style="text-align:center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$mail->name}}</td>
                                <td>{{$mail->contact_number}}</td>
                                <td>{{$mail->email}}</td>
                                <td>{{$mail->type}}</td>
                                <td> <p>{{$mail->message}}</p> </td>
                                <td>
                                    @if($mail->is_replied == 0)
                                    <button class='btn badge badge-info'>Pending</button>
                                    @elseif($mail->is_replied == 1)
                                        <button class='btn badge badge-primary'>Replied</button>
                                    @endif
                                </td>
                                <td>
                                    @if($mail->is_replied == 0)
                                    <button class='btn badge badge-primary' onclick="mailSendModal({{$mail->id}})"><i class="fa fa-envelope-open" aria-hidden="true"></i></button>
                                    @endif
                            
                                <button class='btn badge badge-danger' onclick="mailTrash({{$mail->id}})"><i class='fa fa-trash'></i></button>
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






<!-- Modal -->
<div class="modal fade" id="emailRepliedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Email Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="email_form">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Mail Body</label>
                <input type="hidden" name="mail_id" id="mail_id">
                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="message" name="mail_body" rows="3"></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick=sendMail() >Send</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>




 <!-- loader modal -->
    <div class="modal" id="preloader" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <img src='{{asset('assets/images/preloader.gif')}}'
                style="display: block;margin: auto;margin-top:50%;width: 10%;">
        </div>
    </div>








































<script>
    $(document).ready(function () {

        var table = $('#mailTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
        });

    });

    /**
     * @name editClass
     * @role fetch info and load them into modal for edit
     * @param class id
     * @return
     *
     */




     function mailTrash(id){
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{URL("contactMailDeleteAjax")}}',
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




     function mailSendModal(id){
        $('#mail_id').val(id);
        $('#emailRepliedModal').modal('show');
     }

     function sendMail(){
         alertify.confirm("send mail?",
            function () {

                $('#emailRepliedModal').modal('hide');
                $('#preloader').modal('show')
               
                $.ajax({
                    type: 'post',
                    url: '{{URL("contactMailReplyAjax")}}',
                    data: $('#email_form').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                             $('#preloader').modal('hide')
                            alertify.warning('Something Went Wrong');
                            $('#emailRepliedModal').modal('show');

                           
                        } else {
                            //alert(data);
                            $('#email_form').trigger('reset');
                            $('#emailRepliedModal').modal('hide');
                             $('#preloader').modal('hide')
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

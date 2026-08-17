@extends('layouts.master')
{{-- @section('title')
HOME
@endsection --}}
@section('content')
{{-- @include('partials.navBar') --}}
@section('styles')

@endsection

@if (isset($anchor))
<input type="hidden" name="anchor" id="anchor" value="{{ $anchor }}">
@endif

@if (isset($message))
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <strong>Thank You!</strong> {{$message}}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


 
  <div id="contactApp">
  
  </div>

	
<script src="{{asset('react/app.js')}}"></script>










<script>



    


	$("#contact_form").submit(function() {
		event.preventDefault();
		alertify.confirm('Are You Sure ?', ' Do you want to send this mail?', function () {

			$.ajax({
                type: 'post',
                url: '{{URl("contactMailSendAjax")}}',
                data: $('#contact_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (typeof data.errors !== 'undefined') {
						// $( "#contact_form" ).trigger( "reset" );
                        alertify.error('Something Went Wrong');
                       
                    }else {
                        //alert(data);
                        alertify.success(data);
						
						$( "#contact_form" ).trigger( "reset" );
                        // setTimeout(function () {
                        //     location.reload(true);
                        // }, 1000)


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


   
    
    
    
   


    








    
    
    </script>
    
    @section('scripts')
    {{-- <script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
    <script src="{{asset('js/shop_custom.js')}}"></script> --}}
    {{-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
    <script src="{{asset('js/contact_custom.js')}}"></script> --}}
    @endsection
    
    
    
    @endsection
    {{-- @include('partials.footer') --}}


     @push('footerasset')

    {{-- <script src="{{ asset('styles/bootstrap4/popper.js') }}"></script>
    <script src="{{ asset('styles/bootstrap4/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/TweenMax.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/TimelineMax.min.js') }}"></script>
    <script src="{{ asset('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/animation.gsap.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
    <script src="{{ asset('plugins/easing/easing.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA
    "></script>
    <script src="{{ asset('js/contact_custom.js') }}"></script> --}}

     @endpush
    

@include('partials.backend.header')

<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-6">
            <div class="card">
                {{-- <div class="card-header">{{ __('Reset Password') }}</div> --}}

                <div class="card-body">
                    <div class="text-center">
                        {{-- <img src="{{asset('assets/images/computershop.jpg')}}" alt="logo icon" class="rounded-circle" style="max-width: 20%;"> --}}
                        {{-- <img src="{{asset('img/images/medcalShop-logo.png')}}"  alt="logo icon" class="meditools__logo__size"> --}}
                        <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" width="200" alt="">
                    </div>
                    <h6 class="line-on-side text-muted text-center text-xs-center font-small-3 pt-2"><span>Give Your Email Address</span></h6>
                    @if (session('status'))
                        <div class="alert alert-success text-center py-2" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="text-dark mb-0">Back to Login page? <a href="{{url('login')}}"> Click here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


 <!--wrapper-->

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

    <!-- sidebar-menu js -->
    <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>

    <!-- Custom scripts -->
    <script src="{{asset('assets/js/app-script.js')}}"></script>



{{-- @endsection --}}


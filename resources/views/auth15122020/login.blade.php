{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" >
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection --}}





@include('partials.backend.header')


<body>

    <div id="wrapper">

        <div class="loader-wrapper">
            <div class="lds-ring">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="card card-authentication1 mx-auto my-5">
            <div class="card-body">
                <div class="card-content p-2">
                    <div class="text-center">
                        {{-- <img src="{{asset('assets/images/computershop.jpg')}}" alt="logo icon" class="rounded-circle" style="max-width: 30%;"> --}}
                        <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" width="200" alt="">
                    </div>
                    <div class="card-title text-uppercase text-center py-3">Sign In</div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername" class="sr-only">Email</label>
                            <div class="position-relative has-icon-right">


                                {{-- <input type="text" id="mobile"
                                    class="form-control input-shadow {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email" value="{{ old('email') }}" required autofocus
                                    placeholder="Enter Email"> --}}

                                      <input id="email" type="text"
                                          class="form-control{{$errors->has('email') || $errors->has('email') ? ' is-invalid' : '' }}"
                                          name="email" value="{{old('email') ?: old('email') }}" required
                                          autofocus placeholder="Username OR Email">
                                <div class="form-control-position">
                                    <i class="icon-user"></i>
                                </div>

                                  @if ($errors->has('username') || $errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{$errors->first('username') ?: $errors->first('email') }}</strong>
                                  </span>
                                  @endif






                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword" class="sr-only">Password</label>
                            <div class="position-relative has-icon-right">

                                 <input id="password" type="password"
                                     class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                     name="password" placeholder="********" required>

                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                               @if ($errors->has('password'))
                               <span class="invalid-feedback" role="alert">
                                   <strong>{{ $errors->first('password') }}</strong>
                               </span>
                               @endif
                            </div>
                        </div>
                        <!-- <div class="form-row">
			 <div class="form-group col-6">
			   <div class="icheck-material-primary">
                <input type="checkbox" id="user-checkbox" checked="" />
                <label for="user-checkbox">Remember me</label>
			  </div>
			 </div>
			 <div class="form-group col-6 text-right">
			  <a href="authentication-reset-password.html">Reset Password</a>
			 </div>
			</div> -->
                        <button type="submit" class="btn btn-primary btn-block"> {{ __('Login') }}</button>

                            <hr>
                         </button>
                            {{-- <center>OR</center>

                             <div class="text-center mt-3">
                                
                                     <center><a href="{{ url('login/facebook') }}" class="btn btn-social-icon btn-facebook"><i
                                             class="fa fa-facebook"
                                             style="color:white"></i>&nbsp;&nbsp;&nbsp;&nbsp;<b>Facebook</b></a>
                                             </center>
                             
                             </div> --}}


                        <div class="text-center mt-3">
                               @if (Route::has('password.request'))
                               <a class="btn btn-link" href="{{ route('password.request') }}">
                                   {{ __('Forgot Your Password?') }}
                               </a>
                               @endif
                        </div>




                        {{-- <div class="form-row mt-4">
			  <div class="form-group mb-0 col-6">
			   <button type="button" class="btn bg-facebook text-white btn-block"><i class="fa fa-facebook-square"></i> Facebook</button>
			 </div>
			 <div class="form-group mb-0 col-6 text-right">
			  <button type="button" class="btn bg-twitter text-white btn-block"><i class="fa fa-twitter-square"></i> Twitter</button>
			 </div>
			</div> --}}

                    </form>
                </div>
            </div>
            <div class="card-footer text-center py-3">
                {{--  --}}
                <p class="text-dark mb-0">Do not have an account? <a href="{{ route('register') }}"> Sign Up here</a>
                </p>

            </div>
        </div>

        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->



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

</body>
</html>










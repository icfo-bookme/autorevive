{{-- @extends('layouts.app')

@section('content') --}}
<style>

</style>
@include('partials.backend.header')

<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-6">
            <div class="card">
                {{-- <div class="card-header text-center">{{ __('Register') }}</div> --}}

            <div class="card-body">
                <div class="text-center">
                    {{-- <img src="{{asset('assets/images/computershop.jpg')}}" alt="logo icon" class="rounded-circle" style="max-width: 25%;"> --}}
                    <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" width="200" alt="">
                </div>
                <h6 class="line-on-side text-muted text-center text-xs-center font-small-3 pt-2"><span>Create Account</span></h6>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-8">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-8">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone"
                            class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>

                        <div class="col-md-8">
                            <input id="phone" type="text" class="form-control" name="phone" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address"
                            class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                        <div class="col-md-8">
                            <textarea id="address" class="form-control" name="address" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <p class="text-dark mb-0">Already have an account? <a href="{{url('login')}}"> Sign In here</a>
                </p>
            </div>
        </div>
    </div>
</div>
</div>
{{-- @endsection --}}


<!-- Bootstrap core JavaScript-->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<!-- sidebar-menu js -->
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>

<!-- Custom scripts -->
<script src="{{asset('assets/js/app-script.js')}}"></script>

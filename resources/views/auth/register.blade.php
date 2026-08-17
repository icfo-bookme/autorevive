{{-- @extends('layouts.app')

@section('content') --}}
<style>

</style>
@include('partials.backend.header')


<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" width="200" alt="">
                    </div>
                    <h6 class="line-on-side text-muted text-center text-xs-center font-small-3 pt-2"><span>Create Account</span>
                    </h6>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="">{{ __('First Name') }}</label>
                                    <div>
                                        <input id="first_name" type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            name="first_name" value="{{ old('first_name') }}" required
                                            autocomplete="first_name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="">{{ __('Last Name') }}</label>
                                    <div>
                                        <input id="last_name" type="text"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            name="last_name" value="{{ old('last_name') }}" required
                                            autocomplete="last_name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"
                                        class="">{{ __('E-Mail Address') }}</label>
                                    <div>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"
                                        class="">{{ __('Contact Number') }}</label>
                                    <div>
                                        <input id="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" value="{{ old('phone') }}" required pattern="[0-9]{11}" placeholder="01234123456">
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password" required
                                            autocomplete="new-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="password-confirm"
                                        class="">{{ __('Confirm Password') }}</label>
                                    <div>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" autocomplete="new-password" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">{{ __('country') }}</label>
                                    <div>
                                        <select class="form-control" id="country" name="country" required>
                                            <option>Bangladesh</option>
                                            <option>USA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="district">{{ __('district') }}</label>
                                    <div>
                                        <input type="text" id="district" class="form-control" name="district" required
                                            value="{{ old('district') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">{{ __('city') }}</label>
                                    <div>
                                        <input type="text" id="city" class="form-control" name="city" required
                                            value="{{ old('city') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thana">{{ __('thana') }}</label>
                                    <div>
                                        <input type="text" id="thana" class="form-control" name="thana" required
                                            value="{{ old('thana') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="area">{{ __('area') }}</label>
                                    <div>
                                        <input type="text" id="area" class="form-control" name="area" required
                                            value="{{ old('area') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="road_no">{{ __('road no') }}</label>
                                    <div>
                                        <input type="text" id="road_no" class="form-control" name="road_no" required
                                            value="{{ old('road_no') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="house_no">{{ __('house no') }}</label>
                                    <div>
                                        <input type="text" id="house_no" class="form-control" name="house_no" required
                                            value="{{ old('house_no') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="flat_no">{{ __('flat no') }}</label>
                                    <div>
                                        <input type="text" id="flat_no" class="form-control" name="flat_no" required
                                            value="{{ old('flat_no') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">{{ __('Address') }}</label>
                                    <div>
                                        <textarea id="address" class="form-control" name="address" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
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

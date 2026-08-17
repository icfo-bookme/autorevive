@extends('layouts.backend.master')
@section('content')
<style>

</style>
@include('partials.backend.header')

<div class="container">
    <div class="row py-2">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header text-center">{{ __('Register') }}</div> --}}

            <div class="card-body">
                <div class="text-center">
                    {{-- <img src="{{asset('assets/images/computershop.jpg')}}" alt="logo icon" class="rounded-circle" style="max-width: 25%;"> --}}
                    <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" width="200" alt="">
                </div>
                <h6 class="line-on-side text-muted text-center text-xs-center font-small-3 pt-2"><span>Create Account</span></h6>
                <form id="registerForm">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">                           
                            <div class="form-group">
                                <label for="name" class="">{{ __('Name') }}</label>
                                <div>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>

                                <div>
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

                            <div class="form-group">
                                <label for="phone">{{ __('Contact Number') }}</label>
                                <div>
                                    <input id="phone" type="tel" class="form-control" name="phone" required
                                        value="{{ old('phone') }}" pattern="[0-9]{11}" placeholder="01234123456">
                                </div>                               
                            </div>
                            <div class="form-group">
                                <label for="role"> Role </label>
                                <select id="role" name="role" class="form-control text-center">
                                    <option selected="">--select user role--</option>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"class="">{{ __('E-Mail Address') }}</label>
                                <div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="password-confirm"
                                    class="">{{ __('Confirm Password') }}</label>
                                <div>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation"  autocomplete="new-password" required>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <div >
                                    <textarea  id="address" class="form-control" name="address" required></textarea>
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
           
        </div>
    </div>
</div>
</div>

<script>

$(document).ready(function(){
    $("#registerForm").submit(function(event){

        event.preventDefault();
        $.ajax({
        url: '{{url("admin/adminRegister")}}',
        type: 'post',
        data:  $("#registerForm").serialize(),
        success: function (data) {

          alert("ok");
        },

        error: function () {
            alert("error");
        }
    });
    });
});


</script>


@endsection



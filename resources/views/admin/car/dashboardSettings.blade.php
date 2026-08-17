@extends('layouts.backend.master')
@section('content')

<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('mazley_assets/img/logo/automax-lg.png')}}" width="200" alt="">
                    </div>
                    <h6 class="line-on-side text-muted text-center text-xs-center font-small-3 pt-2">
                        <span>Update Account Information</span>
                    </h6>
                    <form method="POST" id="update_user_info_form" action="{{ URL('updateUserInfoAjax') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="">{{ __('First Name') }}</label>

                                    <div>
                                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                                            name="first_name"
                                            value="{{ $user->first_name }}" required autocomplete="first_name" autofocus>
                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>

                                    <div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="email" class="">{{ __('E-Mail Address') }}</label>

                                    <div>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $user->email }}" required autocomplete="email" disabled>
                                        <input type="hidden" name="email" value="{{$user->email}}">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country">{{ __('country') }}</label>

                                    <div>
                                        <select class="form-control" id="country" name="country" required
                                            value="{{ $user->country }}">
                                            <option>Bangladesh</option>
                                            <option>USA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="city">{{ __('city') }}</label>

                                    <div>
                                        <input type="text" id="city" class="form-control" name="city" required
                                            value="{{ $user->city }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area">{{ __('area') }}</label>

                                    <div>
                                        <input type="text" id="area" class="form-control" name="area" required
                                            value="{{ $user->area }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="house_no">{{ __('house no') }}</label>

                                    <div>
                                        <input type="text" id="house_no" class="form-control" name="house_no" required
                                            value="{{ $user->house_no }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">{{ __('Address') }}</label>

                                    <div>
                                        <textarea id="address" class="form-control" name="address"
                                            required>{{ $user->address }}</textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="">{{ __('Last Name') }}</label>

                                    <div>
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                                            name="last_name"
                                            value="{{ $user->last_name }}" required autocomplete="last_name" autofocus>
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="form-group ">
                                    <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>

                                    <div>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="phone">{{ __('Contact Number') }}</label>

                                    <div>
                                        <input id="phone" type="tel" class="form-control" name="phone" required
                                            value="{{ $user->phone }}" pattern="[0-9]{11}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="district">{{ __('district') }}</label>

                                    <div>
                                        <input type="text" id="district" class="form-control" name="district" required
                                            value="{{ $user->district }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="thana">{{ __('thana') }}</label>
                                    <div>
                                        <input type="text" id="thana" class="form-control" name="thana" required
                                            value="{{ $user->thana }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="road_no">{{ __('road no') }}</label>

                                    <div>
                                        <input type="text" id="road_no" class="form-control" name="road_no" required
                                            value="{{ $user->road_no }}">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="flat_no">{{ __('flat no') }}</label>

                                    <div>
                                        <input type="text" id="flat_no" class="form-control" name="flat_no" required
                                            value="{{ $user->flat_no }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="text-center my-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#update_user_info_form').on('submit', function (e) {
            e.preventDefault();

            alertify.confirm('Update Profile Information', 'Are sure to update profile information?', function () {
                $.ajax({
                    url: "{{ URL('updateUserInfoAjax') }}",
                    method: 'POST',
                    data: $('#update_user_info_form').serialize() + "&_token={{ csrf_token() }}",
                    success: response => {
                        if(response.status === true){
                            alertify.success(response.message);
                            setTimeout(() => redirectToAdminPages(), 1000);
                        } else if(response.status == "validation-error"){
                            alertify.error(response.data[0]);
                        } else{
                            alertify.error(response.message);
                        }
                    }
                });

            }, function () {
                alertify.error('Cancel');
            });
        });
    });

    function redirectToAdminPages() {
        location.href = `{{ URL('admin') }}`;
    }

</script>

@endsection

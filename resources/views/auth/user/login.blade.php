@extends('auth.layouts.app')
@section('title', 'Member Login')
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(../assets/login/images/admin.jpg);">
					<span class="login100-form-title-1">
						member login
					</span>
                </div>

                <form method="POST" action="{{ route('user.auth.loginUser') }}" class="login100-form validate-form">
                    @csrf
                    @if ($errors->has('email'))
                        <span class="is-invalid">{{ $errors->first('email') }}</span>
                    @endif
                    <div class="wrap-input100 validate-input m-b-26" data-validate="email is required">
                        <span class="label-input100">Email</span>
                        <input class="input100" type="text" name="email" placeholder="Enter email"
                               value="{{ old('email') }}">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                        <span class="label-input100">Password</span>
                        <input class="input100" type="password" name="password" placeholder="Enter password">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Submit') }}
                        </button> &emsp;
                        <!-- <button type="button" class="login100-form-btn" onclick="window.location.href = '{{ route('admin.auth.loginAdmin') }}';">
                            {{ __('Admin Login') }}
                        </button> -->
                         </div>
                         </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .is-invalid {
            color: red;
        }
    </style>
@endsection

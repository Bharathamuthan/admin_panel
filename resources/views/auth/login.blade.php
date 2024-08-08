@extends('auth.layouts.app')
@section('title', 'Admin Login')
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(https://healthyresumes.com/wp-content/uploads/2022/10/LinkedIn-Background-Photo-47-1.webp);">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" style="max-width:25%;">
                </div>

                <form method="POST" action="{{ route('auth.loginAdmin') }}" class="login100-form validate-form">
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

                    <div class="flex-sb-m w-full p-b-30">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="label-checkbox100" for="ckb1">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div>
                            @if (Route::has('password.request'))
                                <a class="" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Login') }}
                        </button>
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

@extends('auth.layouts.app')
@section('title', 'Login')
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(../assets/login/images/bg-01.jpg);">
					<span class="login100-form-title-1">
						 Login
					</span>
                </div>

                <form method="POST" action="{{ route('auth.loginAdmin') }}" class="login100-form validate-form">
                            <!-- <div>
                            <input type="radio" id="admin" name="role" value="admin">&emsp;Admin &emsp;
                            <input type="radio" id="member" name="role" value="member">&emsp;Member
                            </div> -->

                    <!-- <div>
                        <select>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div> -->

                    @csrf
                    @if ($errors->has('email'))
                    &emsp;<span class="is-invalid">{{ $errors->first('email') }}</span>
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

                    <div class="container-login100-form-btn">&emsp;
                        <button type="submit" class="login100-form-btn">
                            {{ __('Submit') }}
                        </button>&emsp;
                        <!-- <button type="button" class="login100-form-btn" onclick="window.location.href = '{{ route('user.auth.loginUser') }}';">
                            {{ __('Member Login') }}
                        </button> -->
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

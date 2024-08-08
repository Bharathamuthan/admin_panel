<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    public function login()
    {

        return view('auth.login');
    }

    public function loginAdmin(Request $request)
{
    // Validate the form data
    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Attempt to log the user in as an admin
    if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
        // if successful, create laravel passport token and redirect to admin dashboard
        $user = Auth::guard('admin')->user();
        $token = $user->createToken('adminApiToken')->accessToken;
        Cookie::queue('access_token', $token, 4500);
        return redirect()->route('admin.dashboard');
    }

    // Attempt to log the user in as a regular user
    if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
        // if successful, create laravel passport token and redirect to user dashboard
        $user = Auth::guard('user')->user();
        $token = $user->createToken('userApiToken')->accessToken;
        Cookie::queue('access_token', $token, 4500);
        // echo 1;die;
        return redirect()->route('user.dashboard');

    }

    // if unsuccessful, then redirect back to the login with the form data
    $errors = ['email' => 'Sorry! Wrong email or password '];
    return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors($errors);
}

    // public function loginAdmin (Request $request)
    // {
    //     // Validate the form data
    //     $this->validate($request, [
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);
    //     // Attempt to log the user in
    //     if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {

    //         // if successful, then create laravel passport token and redirect to their intended location
    //         $user = Auth::guard('admin')->user();
    //         $token = $user->createToken('adminApiToken')->accessToken;
    //         Cookie::queue('access_token', $token, 4500);
    //         return redirect()->route('admin.dashboard');
    //     }
    //     // if unsuccessful, then redirect back to the login with the form data
    //     $errors = ['email' => 'Sorry! Wrong email or password '];
    //     return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors($errors);
    // }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
    
        return redirect()->route('login');
    }    
}

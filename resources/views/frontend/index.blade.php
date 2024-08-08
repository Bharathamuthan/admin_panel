@extends('frontend.layouts.master')
@section('title', 'Home')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                    <a class="btn btn-success" href="{{ route('user.auth.loginUser') }}">Member Login</a>
                    <a class="btn btn-success" href="{{ route('admin.auth.loginAdmin') }}">Admin Login</a>


            </div>
        </div>
    </div>

@endsection

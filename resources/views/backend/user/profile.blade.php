@extends('backend.layouts.user_master')
@section('title', 'Profile')
@section('content')
<div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div>
                    <h1 style="color: #786c7f; font-weight: 500">Profile</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table id="manage_all" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <tbody>
                        <tr>
                            <td class="subject"> Name</td>
                            <td> :</td>
                            <td> {{ $user->name }} </td>
                        </tr>
                        <tr>
                            <td class="subject"> Email</td>
                            <td> :</td>
                            <td> {{ $user->email }} </td>
                        </tr>
                        <tr>
                            <td class="subject"> Status</td>
                            <td> :</td>
                            <td> @php $status = $user->status ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>' ;  @endphp {!! $status !!}   </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

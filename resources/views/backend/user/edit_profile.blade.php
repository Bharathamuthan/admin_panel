@extends('backend.layouts.user_master')
@section('title', 'Edit Profile')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>Edit Profile</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8"
                          class="needs-validation"
                          novalidate>
                        {{method_field('PATCH')}}
                        <div class="form-row">
                            <div id="status"></div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for=""> Name </label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}"
                                       placeholder=""
                                       required>
                                <span id="error_name" class="has-error"></span>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for=""> Email </label>
                                <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}"
                                       placeholder=""
                                       readonly required>
                                <span id="error_email" class="has-error"></span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6 mb-3">
                                <button type="submit" class="btn btn-success button-submit"
                                        data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {

            $('#loader').hide();

            $('#edit').validate({// <- attach '.validate()' to your form
                // Rules for form validation
                rules: {
                    name: {
                        required: true
                    },
                    phone: {
                        required: true,
                        number: true
                    }
                },
                // Messages for form validation
                messages: {
                    name: {
                        required: 'Enter name'
                    }
                },
                submitHandler: function (form) {

                    var myData = new FormData($("#edit")[0]);
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    myData.append('_token', CSRF_TOKEN);

                    $.ajax({
                        url: 'edit_profile',
                        type: 'POST',
                        data: myData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#loader').show();
                            $("#submit").prop('disabled', true); // disable button
                        },
                        success: function (data) {
                            if (data.type === 'success') {
                                notify_view(data.type, data.message);
                                $('#loader').hide();
                                $("#submit").prop('disabled', false); // disable button
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('#myModal').modal('hide'); // hide bootstrap modal
                                $('.has-error').html('');

                            } else if (data.type === 'error') {
                                $('.has-error').html('');
                                if (data.errors) {
                                    $.each(data.errors, function (key, val) {
                                        $('#error_' + key).html(val);
                                    });
                                }
                                $("#status").html(data.message);
                                $('#loader').hide();
                                $("#submit").prop('disabled', false); // disable button

                            }
                        }
                    });
                }
                // <- end 'submitHandler' callback
            });                    // <- end '.validate()'

        });
    </script>
@endsection

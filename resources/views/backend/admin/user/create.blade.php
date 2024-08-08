<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation" novalidate>
    <div class="form-row">
        <div id="status"></div>
        <br/>
        <div class="clearfix"></div>
        <div class="form-group col-md-6 col-sm-12">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="" required>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <label for="email">Email(use as user id for login)</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="" required>
            <span id="error_email" class="has-error"></span>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="" required>
            <span id="error_phone_number" class="has-error"></span>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <span id="error_password" class="has-error"></span>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <label for="confirm-password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
            <span id="error_confirm-password" class="has-error"></span>
        </div>
        {{-- <div class="col-md-12">
            <label for="photo">Logo (File must be jpg, jpeg, png)</label>
            <div class="input-group">
                <input id="photo" type="file" name="photo" style="display:none">
                <div class="input-group-prepend">
                    <a class="btn btn-secondary text-white" onclick="document.getElementById('photo').click();">Browse</a>
                </div>
             <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName" value="" readonly>
            </div>
            <script type="text/javascript">
                document.getElementById('photo').addEventListener('change', function () {
                    document.getElementById('SelectedFileName').value = this.value.split('\\').pop();
                });
            </script>
            <span id="error_photo" class="has-error"></span>
        </div> --}}
        {{-- <div class="clearfix"></div>
        <div class="col-sm-12 col-md-12 mb-3 mt-3">
            <strong>Terms and Conditions </strong>
            <div class='row mb-3 mt-3'>
                @foreach($roles as $role)
                    @if($role->guard_name != 'admin')
                        <div class="col-md-2 col-sm-12">
                            <input type="checkbox" name="all_role" class="data-check flat-green" value="{{$role->id}}"/>
                        </div>
                    @endif
                @endforeach
            </div>
        </div> --}}
        <div class="col-md-12 mb-3">
            <button type="submit" class="btn btn-success button-submit" data-loading-text="Loading...">
                <span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $('input[type="checkbox"].flat-green').iCheck({
            checkboxClass: 'icheckbox_flat-green',
        });

        // Clear error message on input change
        $('input').on('input', function () {
            var id = $(this).attr('id');
            $('#error_' + id).html('');
        });

        $('#create').validate({
            rules: {
                name: { required: true },
                email: { required: true, email: true },
                phone_number: { required: true },
                password: { required: true },
                'confirm-password': { required: true, equalTo: "#password" },
            },
            messages: {
                name: { required: 'Enter your name' },
                email: { required: 'Enter your email', email: 'Enter a valid email' },
                phone_number: { required: 'Enter your phone number' },
                password: { required: 'Enter a password' },
                'confirm-password': { required: 'Confirm your password', equalTo: 'Passwords do not match' },
            },
            submitHandler: function (form) {
                var list_id = [];
                $(".data-check:checked").each(function () {
                    list_id.push(this.value);
                });

                var myData = new FormData($("#create")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);
                myData.append('roles', list_id);

                $.ajax({
                    url: 'users',
                    type: 'POST',
                    data: myData,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.type === 'success') {
                            swal("Done!", "It was successfully saved!", "success");
                            reload_table();
                            notify_view(data.type, data.message);
                            $('#loader').hide();
                            $("#submit").prop('disabled', false);
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('#myModal').modal('hide');
                        } else if (data.type === 'error') {
                            if (data.errors) {
                                $.each(data.errors, function (key, val) {
                                    $('#error_' + key).html(val);
                                });
                            }
                            $("#status").html(data.message);
                            $('#loader').hide();
                            $("#submit").prop('disabled', false);
                            // swal("Error saving!", "Please try again", "error");
                        }
                    }
                });
            }
        });
    });
</script>


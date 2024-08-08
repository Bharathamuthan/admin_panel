<form id="create" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="file">Choose Excel File</label>
        <input type="file" name="file" class="form-control" required>
        <div class="invalid-feedback">Please choose a file.</div>
    </div>
    <button type="submit" class="btn btn-primary button-submit">Submit</button>
</form>

<script>
$(document).ready(function () {
    $('#create').submit(function (event) {
        event.preventDefault();

        var fileInput = $('input[name="file"]');
        if (fileInput.get(0).files.length === 0) {
            alert('The file field is required');
            return;
        }

        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.blogs.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert('File uploaded and saved successfully.');
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('Error uploading file:', error);
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            alert(errors[key]);
                        }
                    }
                }
            }
        });
    });
});
</script>

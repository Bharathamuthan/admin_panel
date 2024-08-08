@extends('backend.layouts.master')
@section('title', 'Blogs')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
            </div>
            <div>List</div>
            <div class="d-inline-block ml-2">
                @can('blogs-create')
                    <button class="btn btn-success" onclick="create()"><i class="glyphicon glyphicon-plus"></i> Import File</button>
                    <button class="btn btn-primary btn-sm export-btn">Export Data</button>
                @endcan
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="manage_imports" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mem.No</th>
                                <th scope="col">Status</th>
                                <th scope="col">Name</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Address</th>
                                <th scope="col">City_Location</th>
                                <th scope="col" style="display:none;">Location</th>
                                <th scope="col">State</th>
                                <th scope="col">Changed By</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($products) && $products->count() > 0)
                                @foreach($products as $product)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $product->unique_code }}</td>
                                        <td>
                                            <input type="checkbox" class="toggle-status round-toggle" data-id="{{ $product->id }}" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $product->status ? 'checked' : '' }}>
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td><a href="tel:{{ $product->contact_number }}">{{ $product->contact_number }}</a></td>
                                        <td>{{ $product->address }}</td>
                                        <td>{{ $product->location_1 }}</td>
                                        <td style="display:none;">{{ $product->location_2 }}</td>
                                        <td>{{ $product->location_3 }} , {{ $product->pin_code }}</td>
                                        <td>{{ $product->user ? $product->user->name : '--' }}</td>
                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">No Imports available.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media screen and (min-width: 768px) {
    #myModal .modal-dialog {
        width: 70%;
        border-radius: 5px;
    }
}

.round-toggle {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    outline: none;
    width: 50px;
    height: 25px;
    background-color: #ccc;
    border-radius: 15px; /* Adjust the radius to make it round */
    position: relative;
    cursor: pointer;
    transition: background-color 0.3s;
}

.round-toggle:checked {
    background-color: #66bb6a; /* Color when toggled on */
}

.round-toggle::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: white;
    border-radius: 50%; /* Makes it round */
    top: 2.5px;
    left: 2.5px;
    transition: left 0.3s; /* Smooth slide effect */
}

.round-toggle:checked::before {
    left: 27.5px; /* Position when toggled on */
}
</style>

<script>
$(document).ready(function () {
    var table = $('#manage_imports').DataTable({
        "paging": true,
        "searching": true,
        "lengthChange": true,
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 75, 100],
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'excel',
                text: 'Export Data',
                className: 'd-none'
            }
        ]
    });

    // Custom search placeholder
    $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
        'width': '220px',
        'height': '30px'
    });

    // Handle toggle change event using delegation
    $(document).on('change', '.toggle-status', function () {
        var status = $(this).prop('checked') ? 1 : 0;
        var productId = $(this).data('id');

        fetch('{{ route('toggleProductStatus') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ids: [productId], // Send single ID as array to match backend expectation
                status: status
            })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  toastr.success('Status updated successfully');
              } else {
                  toastr.error('Failed to update status');
              }
          }).catch(error => {
              toastr.error('An error occurred');
          });
    });

    // Trigger the export action when the custom button is clicked
    $('.export-btn').on('click', function () {
        window.location.href = '{{ route("admin.blog.export.imports") }}';
    });

    // View Form
    $("#manage_imports").on("click", ".view", function () {
        var id = $(this).attr('id');
        ajax_submit_view('blogs', id);
    });
});

function create() {
    ajax_submit_create('blogs');
}
</script>
@endsection

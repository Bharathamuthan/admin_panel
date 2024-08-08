@extends('backend.layouts.user_master')

@section('title', 'List')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
            </div>
            <div>List</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="manage_all" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mem.No</th>
                                <th scope="col">Status</th>
                                <th scope="col">Name</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Address</th>
                                <th scope="col">City Location</th>
                                <th scope="col">Location</th>
                                <th scope="col">State</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users) && $users->count() > 0)
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $user->unique_code }}</td>
                                         @if(isset($user->changed_by) &&  $user->changed_by !=   auth()->user()->id)
                                        <td>
                                              @if($user->status)
                                                Connected
                                              @else 
                                               
                                                    <input type="checkbox" class="toggle-status round-toggle" data-id="{{ $user->id }}" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $user->status ? 'checked' : '' }}>
                                                
                                                @endif
                                        </td>
                                           @else
                                                 <td>
                                                    <input type="checkbox" class="toggle-status round-toggle" data-id="{{ $user->id }}" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $user->status ? 'checked' : '' }}>
                                                 </td>
                                            @endif
                                        <td>{{ $user->name }}</td>
                                        <td><a href="tel:{{ $user->contact_number }}">{{ $user->contact_number }}</a></td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->location_1 }}</td>
                                        <td>{{ $user->location_2 }}</td>
                                        <td>{{ $user->location_3 }}, {{ $user->pin_code }}</td>
                                        
                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">No users found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
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

@push('scripts')
<script>
 @push('scripts')
<script>
$(document).ready(function () {
    var table = $('#manage_all').DataTable({
        paging: true,
        searching: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325, 350, 375, 400],
    });

    $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
        width: '220px',
        height: '30px'
    });

    // Handle toggle change event
    $(document).on('change', '.toggle-status', function () {
        var status = $(this).prop('checked') ? 1 : 0;
        var userId = $(this).data('id');

        fetch('https://call.crmondemand.in/user/toggle-user-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                id: userId,
                status: status
            })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  toastr.success('Status updated successfully');
                  var statusText = status ? 'Active' : 'Inactive';
                  var statusCell = $(this).closest('tr').find('.status-cell'); // Adjust class selector as per your actual markup
                  statusCell.text(statusText);
              } else {
                  toastr.error('Failed to update status');
                  // Optionally handle error feedback
              }
          }).catch(error => {
              toastr.error('An error occurred');
              console.error(error);
          });
    });
});
</script>
@endpush
</script>
@endpush

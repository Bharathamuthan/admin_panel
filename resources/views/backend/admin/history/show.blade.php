@extends('backend.layouts.master')
@section('title', 'History Details')
@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
            </div>
            <div>{{ $history->name }} Details</div>
<div class="row mb-3" style="margin-left:5px;margin-top:9px">
    <div class="col-md-12">
        <button id="exportButton" type="button" class="btn btn-primary">Export</button>
    </div>
</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="history_details" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Mem.No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Address</th>
                                <th scope="col">City_Location</th>
                                <th scope="col">Location</th>
                                <th scope="col">State</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($history->imports as $import)
                                <tr>
                                    <td>{{ $import->unique_code }}</td>
                                    <td>{{ $import->name }}</td>
                                    <td>{{ $import->contact_number }}</td>
                                    <td>{{ $import->address }}</td>
                                    <td>{{ $import->location_1 }}</td>
                                    <td>{{ $import->location_2 }}</td>
                                    <td>{{ $import->location_1 }}</td>
                                </tr>
                            @endforeach
                            @if($history->imports->isEmpty())
                                <tr>
                                    <td colspan="7">No imports available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var table = $('#history_details').DataTable({
            paging: true,
            searching: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                text: 'Export Data',
                className: 'd-none'
                }
            ]
        });

        // Trigger export on custom button click
        $('#exportButton').on('click', function() {
            table.button('.buttons-excel').trigger();
        });
    });
</script>

@endsection

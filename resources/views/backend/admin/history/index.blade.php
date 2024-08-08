@extends('backend.layouts.master')
@section('title', 'History')
@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
            </div>
            <div>History List</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="history_table" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Count</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($historys) && $historys->count() > 0)
                                @foreach($historys as $history)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <a href="{{ route('admin.history.show', $history->id) }}" class="name-click">{{ $history->name }}</a>
                                        </td>
                                        <td>{{ $history->count }}</td>
                                        <td>{{ $history->contact_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($history->imports_updated_at)->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No history available.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Custom CSS for the export button -->
                <style>
                    .buttons-excel {
                        background-color: #28a745;
                        color: #ffffff;
                        border: 1px solid #28a745;
                        margin-left: 10px;
                    }

                    .buttons-excel:hover {
                        background-color: #218838;
                        border-color: #1e7e34;
                    }

                    .custom-button {
                        background-color: #007bff;
                        color: #ffffff;
                        border: 1px solid #007bff;
                    }

                    .custom-button:hover {
                        background-color: #0056b3;
                        border-color: #004085;
                    }
                </style>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#history_table').DataTable({
                            language: {
                                searchPlaceholder: "Type here to search..."
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

@endsection

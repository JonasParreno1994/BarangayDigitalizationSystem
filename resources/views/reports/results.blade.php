@extends('layouts.adminlayout.index')

@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Report Results</h3>
        <div class="text-right">
            <a href="{{ route('reports.print', request()->all()) }}" class="btn btn-success">Print Report</a>
        </div>
    </div>
    <div class="panel-body">
        <div class="mb-4">
            <h4>Report Filters:</h4>
            <p><strong>Certificate Type:</strong> {{ ucfirst($filters['certificate_type']) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($filters['status']) }}</p>
            @if($filters['date_from'] || $filters['date_to'])
                <p><strong>Date Range:</strong> 
                    {{ $filters['date_from'] ? \Carbon\Carbon::parse($filters['date_from'])->format('M d, Y') : 'Start' }} 
                    to 
                    {{ $filters['date_to'] ? \Carbon\Carbon::parse($filters['date_to'])->format('M d, Y') : 'End' }}
                </p>
            @endif
            <p><strong>Total Records:</strong> {{ $totalCount }}</p>
        </div>

        @if(isset($results['clearances']))
        <div class="mb-5">
            <h4>Barangay Clearances ({{ $results['clearances']->count() }})</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Resident Name</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Date Issued</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results['clearances'] as $clearance)
                        <tr>
                            <td>{{ $clearance->id }}</td>
                            <td>{{ $clearance->resident->full_name }}</td>
                            <td>{{ $clearance->purpose }}</td>
                            <td>{{ ucfirst($clearance->status) }}</td>
                            <td>{{ $clearance->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if(isset($results['indigencies']))
        <div class="mb-5">
            <h4>Barangay Indigencies ({{ $results['indigencies']->count() }})</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Resident Name</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Date Issued</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results['indigencies'] as $indigency)
                        <tr>
                            <td>{{ $indigency->id }}</td>
                            <td>{{ $indigency->resident->full_name }}</td>
                            <td>{{ $indigency->purpose }}</td>
                            <td>{{ ucfirst($indigency->status) }}</td>
                            <td>{{ $indigency->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if(isset($results['morals']))
        <div class="mb-5">
            <h4>Certifications of Good Moral ({{ $results['morals']->count() }})</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Resident Name</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Date Issued</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results['morals'] as $moral)
                        <tr>
                            <td>{{ $moral->id }}</td>
                            <td>{{ $moral->resident->full_name }}</td>
                            <td>{{ $moral->purpose }}</td>
                            <td>{{ ucfirst($moral->status) }}</td>
                            <td>{{ $moral->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if(isset($results['residencies']))
        <div class="mb-5">
            <h4>Certifications of Residency ({{ $results['residencies']->count() }})</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Resident Name</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Date Issued</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results['residencies'] as $residency)
                        <tr>
                            <td>{{ $residency->id }}</td>
                            <td>{{ $residency->resident->full_name }}</td>
                            <td>{{ $residency->purpose }}</td>
                            <td>{{ ucfirst($residency->status) }}</td>
                            <td>{{ $residency->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@extends('layouts.adminlayout.index')

@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Special Population Report Results</h3>
        <div class="text-right">
            <a href="{{ route('special-reports.print', [
                'report_type' => $reportType,
                'age_range' => $ageRange,
                'pwd_type' => $pwdType,
                'civil_status' => $civilStatus
            ]) }}" class="btn btn-success">Print Report</a>
        </div>
    </div>
    <div class="panel-body">
        <div class="mb-4">
            <h4>Report Filters:</h4>
            <p><strong>Report Type:</strong> 
                @switch($reportType)
                    @case('seniors') Senior Citizens @break
                    @case('pwds') Persons with Disabilities @break
                    @case('solo_parents') Solo Parents @break
                    @case('all') All Special Populations @break
                @endswitch
            </p>
            
            @if($reportType === 'seniors' || $reportType === 'all')
                <p><strong>Age Range:</strong> {{ $ageRange === 'all' ? 'All Ages' : $ageRange }}</p>
            @endif
            
            @if($reportType === 'pwds' || $reportType === 'all')
                <p><strong>PWD Type:</strong> {{ $pwdType === 'all' ? 'All Types' : $pwdType }}</p>
            @endif
            
            @if($reportType === 'solo_parents' || $reportType === 'all')
                <p><strong>Civil Status:</strong> {{ $civilStatus === 'all' ? 'All Statuses' : $civilStatus }}</p>
            @endif
            
            <p><strong>Total Records:</strong> {{ $residents->count() }}</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Resident Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Category</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($residents as $resident)
                    <tr>
                        <td>{{ $resident->id }}</td>
                        <td>{{ $resident->full_name }}</td>
                        <td>{{ $resident->age }}</td>
                        <td>{{ $resident->address }}</td>
                        <td>{{ $resident->contact_number ?? 'N/A' }}</td>
                        <td>
                            @if($resident->is_senior_citizen) Senior Citizen @endif
                            @if($resident->is_pwd) @if($resident->is_senior_citizen), @endif PWD @endif
                            @if($resident->is_solo_parent) 
                                @if($resident->is_senior_citizen || $resident->is_pwd), @endif 
                                Solo Parent 
                            @endif
                        </td>
                        <td>
                            @if($resident->is_senior_citizen)
                                SC ID: {{ $resident->senior_citizen_id ?? 'N/A' }}<br>
                            @endif
                            @if($resident->is_pwd)
                                PWD ID: {{ $resident->pwd_id ?? 'N/A' }}<br>
                                Type: {{ $resident->pwd_type ?? 'N/A' }}<br>
                            @endif
                            @if($resident->is_solo_parent)
                                SP ID: {{ $resident->solo_parent_id ?? 'N/A' }}<br>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
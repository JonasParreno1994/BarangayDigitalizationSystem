@extends('layouts.adminLayout.index')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Age Bracket Population Report</h1>
        <a href="{{ route('special-reports.print-age-bracket', ['age_bracket' => $ageBracket]) }}" 
           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Print Report
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                Age Bracket: {{ $ageBracket === 'all' ? 'All Ages' : $ageBracket }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Civil Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($residents as $index => $resident)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}</td>
                            <td>{{ $resident->age }}</td>
                            <td>{{ $resident->sex }}</td>
                            <td>{{ $resident->purok ? $resident->purok->purok_name : $resident->address }}</td>
                            <td>{{ $resident->civil_status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
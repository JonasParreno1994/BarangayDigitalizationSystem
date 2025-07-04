@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Barangay Clearance Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('barangayclearance.edit', $clearance->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('barangayclearance.print', $clearance->id) }}" class="btn btn-success" target="_blank">Print</a>
                <form action="{{ route('barangayclearance.destroy', $clearance->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Resident Information</h3>
                    <p class="text-gray-600">{{ $clearance->resident->full_name }}</p>
                    <p class="text-gray-600">{{ $clearance->resident->address }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Clearance Details</h3>
                    <p class="text-gray-600">Purpose: {{ $clearance->purpose }}</p>
                    <p class="text-gray-600">Status: <span class="badge {{ $clearance->status == 'Issued' ? 'bg-success' : ($clearance->status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">{{ $clearance->status }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <h3 class="font-semibold">Date of Issuance</h3>
                    <p class="text-gray-600">{{ $clearance->date_of_issuance->format('F d, Y') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Cedula Number</h3>
                    <p class="text-gray-600">{{ $clearance->cedula_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">OR Number</h3>
                    <p class="text-gray-600">{{ $clearance->or_number ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Amount Paid</h3>
                    <p class="text-gray-600">{{ $clearance->amount_paid ? '₱' . number_format($clearance->amount_paid, 2) : 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Remarks</h3>
                    <p class="text-gray-600">{{ $clearance->remarks ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
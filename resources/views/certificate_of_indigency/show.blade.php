@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Certificate of Indigency Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('certificate_of_indigency.edit', $certificate->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('certificate_of_indigency.print', $certificate->id) }}" class="btn btn-success" target="_blank">Print</a>
                <form action="{{ route('certificate_of_indigency.destroy', $certificate->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                <a href="{{ route('certificate_of_indigency.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Resident Information</h3>
                    <p class="text-gray-600">Name: {{ $certificate->resident->full_name }}</p>
                    <p class="text-gray-600">Age: {{ \Carbon\Carbon::parse($certificate->resident->birth_date)->age }}</p>
                    <p class="text-gray-600">Address: {{ $certificate->resident->address }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Certificate Details</h3>
                    <p class="text-gray-600">Purpose: {{ $certificate->purpose }}</p>
                    <p class="text-gray-600">Status: <span class="badge {{ $certificate->status == 'Issued' ? 'bg-success' : ($certificate->status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">{{ $certificate->status }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <h3 class="font-semibold">Date of Issuance</h3>
                    <p class="text-gray-600">{{ $certificate->date_of_issuance->format('F d, Y') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">OR Number</h3>
                    <p class="text-gray-600">{{ $certificate->or_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Amount Paid</h3>
                    <p class="text-gray-600">{{ $certificate->amount_paid ? '₱' . number_format($certificate->amount_paid, 2) : 'N/A' }}</p>
                </div>
            </div>

            @if($certificate->remarks)
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <h3 class="font-semibold">Remarks</h3>
                    <p class="text-gray-600">{{ $certificate->remarks }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
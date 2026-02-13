@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        @include('partials.certificate_header')
        <div class="flex items-center justify-between mb-5 no-print">
            <h1 class="text-2xl font-bold">Good Moral Certificate Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('barangaygoodmoral.edit', $certificate->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('barangaygoodmoral.print', $certificate->id) }}" class="btn btn-success" target="_blank">Print</a>
                <form action="{{ route('barangaygoodmoral.destroy', $certificate->id) }}" method="POST">
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
                    <p class="text-gray-600"><strong>Name:</strong> {{ $certificate->resident->full_name }}</p>
                    <p class="text-gray-600"><strong>Age:</strong> {{ \Carbon\Carbon::parse($certificate->resident->birth_date)->age }}</p>
                    <p class="text-gray-600"><strong>Address:</strong> {{ $certificate->resident->address }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Certificate Details</h3>
                    <p class="text-gray-600"><strong>Purpose:</strong> {{ $certificate->purpose }}</p>
                    <p class="text-gray-600"><strong>Status:</strong> 
                        <span class="badge {{ $certificate->status == 'Issued' ? 'bg-success' : ($certificate->status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $certificate->status }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <h3 class="font-semibold">Date of Issuance</h3>
                    <p class="text-gray-600">{{ $certificate->date_of_issuance->format('F d, Y') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Cedula Number</h3>
                    <p class="text-gray-600">{{ $certificate->cedula_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">OR Number</h3>
                    <p class="text-gray-600">{{ $certificate->or_number ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Amount Paid</h3>
                    <p class="text-gray-600">{{ $certificate->amount_paid ? '₱' . number_format($certificate->amount_paid, 2) : 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Remarks</h3>
                    <p class="text-gray-600">{{ $certificate->remarks ?? 'N/A' }}</p>
                </div>
            </div>
            
            <div class="pt-4 flex justify-end">
                <a href="{{ route('barangaygoodmoral.index') }}" class="btn btn-outline-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
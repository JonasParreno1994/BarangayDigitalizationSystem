@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        @include('partials.certificate_header')
        <div class="flex items-center justify-between mb-5 no-print">
            <h1 class="text-2xl font-bold">Certificate of Indigency Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('cert_indigency_minor.print', $cert->id) }}" class="btn btn-success" target="_blank">Print</a>
                <form action="{{ route('cert_indigency_minor.destroy', $cert->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger delete-certificate">Delete</button>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Parent's Information</h3>
                    <p class="text-gray-600"><strong>Resident ID:</strong> {{ $cert->resident_id }}</p>
                    <p class="text-gray-600"><strong>Name:</strong> {{ $cert->resident->full_name }}</p>
                    <p class="text-gray-600"><strong>Age:</strong> {{ \Carbon\Carbon::parse($cert->resident->birth_date)->age }}</p>
                    <p class="text-gray-600"><strong>Address:</strong> {{ $cert->resident->address }}</p>
                    <p class="text-gray-600"><strong>Purok:</strong> {{ $cert->purok }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Certificate Details</h3>
                    <p class="text-gray-600"><strong>Certificate ID:</strong> {{ $cert->id }}</p>
                    <p class="text-gray-600"><strong>Date Issued:</strong> {{ $cert->date_of_issuance->format('F d, Y') }}</p>
                    <p class="text-gray-600"><strong>Status:</strong> <span class="badge {{ $cert->status == 'Issued' ? 'bg-success' : ($cert->status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">{{ $cert->status }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Child's Information</h3>
                    <p class="text-gray-600"><strong>Name:</strong> {{ $cert->childsName }}</p>
                    <p class="text-gray-600"><strong>Age:</strong> {{ $cert->childsAge }}</p>
                    <p class="text-gray-600"><strong>Gender:</strong> {{ $cert->childsGender }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Payment Details</h3>
                    <p class="text-gray-600"><strong>OR Number:</strong> {{ $cert->or_number ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Amount Paid:</strong> {{ $cert->amount_paid ? '₱' . number_format($cert->amount_paid, 2) : 'N/A' }}</p>
                </div>
            </div>

            @if($cert->remarks)
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <h3 class="font-semibold">Remarks</h3>
                    <p class="text-gray-600">{{ $cert->remarks }}</p>
                </div>
            </div>
            @endif
            
            <div class="pt-4 flex justify-end">
                <a href="{{ route('cert_indigency_minor.index') }}" class="btn btn-outline-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-certificate').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
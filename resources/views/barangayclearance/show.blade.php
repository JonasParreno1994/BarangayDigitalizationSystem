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
                    <button type="button" class="btn btn-danger delete-clearance">Delete</button>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Resident Information</h3>
                    <p class="text-gray-600"><strong>Name:</strong> {{ $clearance->resident->full_name }}</p>
                    <p class="text-gray-600"><strong>Age:</strong> {{ \Carbon\Carbon::parse($clearance->resident->birth_date)->age }}</p>
                    <p class="text-gray-600"><strong>Address:</strong> {{ $clearance->resident->address }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Clearance Details</h3>
                    <p class="text-gray-600"><strong>Clearance ID:</strong> {{ $clearance->id }}</p>
                    <p class="text-gray-600"><strong>Date Issued:</strong> {{ $clearance->date_of_issuance->format('F d, Y') }}</p>
                    <p class="text-gray-600"><strong>Status:</strong> 
                        <span class="badge {{ $clearance->status == 'Issued' ? 'bg-success' : ($clearance->status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $clearance->status }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Purpose</h3>
                    <p class="text-gray-600">{{ $clearance->purpose }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Payment Details</h3>
                    <p class="text-gray-600"><strong>OR Number:</strong> {{ $clearance->or_number ?? 'N/A' }}</p>
                    <p class="text-gray-600"><strong>Amount Paid:</strong> {{ $clearance->amount_paid ? '₱' . number_format($clearance->amount_paid, 2) : 'N/A' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Cedula Number</h3>
                    <p class="text-gray-600">{{ $clearance->cedula_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Remarks</h3>
                    <p class="text-gray-600">{{ $clearance->remarks ?? 'N/A' }}</p>
                </div>
            </div>
            
            <div class="pt-4 flex justify-end">
                <a href="{{ route('barangayclearance.index') }}" class="btn btn-outline-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-clearance').forEach(button => {
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
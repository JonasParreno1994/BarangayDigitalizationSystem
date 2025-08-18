@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Death Certificate Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('certificate-of-death.edit', $certificate->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('certificate-of-death.print', $certificate->id) }}" class="btn btn-success" target="_blank">Print</a>
                <form action="{{ route('certificate-of-death.destroy', $certificate->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger delete-certificate">Delete</button>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Resident Information</h3>
                    <p class="text-gray-600"><strong>Name:</strong> {{ $certificate->resident->last_name }}, {{ $certificate->resident->first_name }} {{ $certificate->resident->middle_name }}</p>
                    <p class="text-gray-600"><strong>Age at Death:</strong> {{ \Carbon\Carbon::parse($certificate->resident->birth_date)->diffInYears($certificate->date_of_death) }}</p>
                    <p class="text-gray-600"><strong>Address:</strong> {{ $certificate->resident->address }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Certificate Details</h3>
                    <p class="text-gray-600"><strong>Certificate #:</strong> {{ $certificate->certificate_number }}</p>
                    <p class="text-gray-600"><strong>Date Issued:</strong> {{ \Carbon\Carbon::parse($certificate->date_of_issuance)->format('F d, Y') }}</p>
                    <p class="text-gray-600"><strong>Status:</strong> 
                        <span class="badge {{ $certificate->status == 'Issued' ? 'bg-success' : 'bg-warning' }}">
                            {{ $certificate->status }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Death Details</h3>
                    <p class="text-gray-600"><strong>Date of Death:</strong> {{ \Carbon\Carbon::parse($certificate->date_of_death)->format('F d, Y') }}</p>
                    <p class="text-gray-600"><strong>Place of Death:</strong> {{ $certificate->place_of_death }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Cause of Death</h3>
                    <p class="text-gray-600">{{ $certificate->cause_of_death }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Issued By</h3>
                    <p class="text-gray-600">{{ $certificate->issued_by }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Remarks</h3>
                    <p class="text-gray-600">{{ $certificate->remarks ?? 'N/A' }}</p>
                </div>
            </div>
            
            <div class="pt-4 flex justify-end">
                <a href="{{ route('certificate-of-death.index') }}" class="btn btn-outline-secondary">Back to List</a>
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
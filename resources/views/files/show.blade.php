@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">File Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('resident.files.download', [$file->resident_id, $file->id]) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download
                </a>
                <form action="{{ route('resident.files.destroy', [$file->resident_id, $file->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger delete-file">
                        Delete
                    </button>
                </form>
                <a href="{{ route('resident.files.index', $file->resident_id) }}" class="btn btn-outline-secondary">
                    Back to Files
                </a>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">File Information</h3>
                    <p class="text-gray-600"><strong>File Name:</strong> {{ $file->file_name }}</p>
                    <p class="text-gray-600"><strong>Category:</strong> {{ $file->category->category_name }}</p>
                    <p class="text-gray-600"><strong>Type:</strong> {{ $file->file_type }}</p>
                    <p class="text-gray-600"><strong>Size:</strong> {{ round($file->file_size / 1024, 2) }} KB</p>
                </div>
                <div>
                    <h3 class="font-semibold">Additional Details</h3>
                    <p class="text-gray-600"><strong>Upload Date:</strong> {{ $file->upload_date->format('F d, Y h:i A') }}</p>
                    <p class="text-gray-600"><strong>Description:</strong> {{ $file->description ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-file').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This file will be permanently deleted.",
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

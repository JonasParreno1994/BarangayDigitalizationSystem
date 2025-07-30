@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Document Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('documents.download', $document->id) }}" class="btn btn-success">
                    Download
                </a>
                <form action="{{ route('documents.destroy', $document->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger delete-document">Delete</button>
                </form>
            </div>
        </div>

        <!-- Content Section -->
        <div class="space-y-4">
            <!-- Document Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Document Information</h3>
                    <p class="text-gray-600"><strong>Title:</strong> {{ $document->title }}</p>
                    <p class="text-gray-600"><strong>Category:</strong> {{ $document->category->category_name }}</p>
                    <p class="text-gray-600"><strong>Uploaded By:</strong> {{ $document->user->name }} ({{ $document->user->role }})</p>
                    <p class="text-gray-600"><strong>Upload Date:</strong> {{ $document->created_at->format('F d, Y H:i') }}</p>
                    <p class="text-gray-600"><strong>Last Updated:</strong> {{ $document->updated_at->format('F d, Y H:i') }}</p>
                </div>
                
                <!-- Document Preview -->
                <div>
                    <h3 class="font-semibold">Document Preview</h3>
                    @if(Str::endsWith($document->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                        <img src="{{ Storage::url($document->file_path) }}" alt="Document Preview" class="rounded-lg shadow-md mt-2 max-w-full">
                    @else
                        <div class="bg-blue-50 text-blue-700 p-3 rounded-md mt-2">
                            <i class="fa fa-file mr-1"></i> This document cannot be previewed. Please download to view.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($document->description)
            <div>
                <h3 class="font-semibold">Description</h3>
                <p class="text-gray-600">{{ $document->description }}</p>
            </div>
            @endif

            <!-- Back Button -->
            <div class="pt-4 flex justify-end">
                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">Back to Documents</a>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert Delete Confirmation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-document').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This document will be permanently deleted!",
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

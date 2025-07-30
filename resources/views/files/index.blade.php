@extends('layouts.adminLayout.index')

@section('content')
<style>
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
    }

    .badge-success {
        background-color: #10b981;
        color: white;
    }

    .badge-warning {
        background-color: #f59e0b;
        color: white;
    }

    .badge-danger {
        background-color: #ef4444;
        color: white;
    }

    .badge-info {
        background-color: #3b82f6;
        color: white;
    }

    .btn-icon {
        padding: 0.375rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon svg {
        width: 1rem;
        height: 1rem;
    }
</style>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif

<div class="animate__animated p-6">
    <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold">
        <button type="button" class="btn btn-success" onclick="openUploadModal()">
            <i class="fas fa-plus mr-2"></i> Upload File
        </button>
        <h1 class="ltr:mr-4 rtl:ml-3 text-center w-full">Files for {{ $resident->full_name }}</h1>
    </div>

    <div class="panel mt-6">
        @if($resident->files->isEmpty())
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                </svg>
                No files found for this resident.
            </div>
        @else
            <div class="table-responsive">
                <table id="filesTable" class="whitespace-nowrap">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Uploaded</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resident->files as $file)
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    @php
                                        $fileIcon = '';
                                        $fileClass = '';
                                        switch(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION))) {
                                            case 'pdf':
                                                $fileIcon = 'fa-file-pdf';
                                                $fileClass = 'text-red-500';
                                                break;
                                            case 'doc':
                                            case 'docx':
                                                $fileIcon = 'fa-file-word';
                                                $fileClass = 'text-blue-500';
                                                break;
                                            case 'xls':
                                            case 'xlsx':
                                                $fileIcon = 'fa-file-excel';
                                                $fileClass = 'text-green-500';
                                                break;
                                            case 'jpg':
                                            case 'jpeg':
                                            case 'png':
                                            case 'gif':
                                                $fileIcon = 'fa-file-image';
                                                $fileClass = 'text-purple-500';
                                                break;
                                            default:
                                                $fileIcon = 'fa-file';
                                                $fileClass = 'text-gray-500';
                                        }
                                    @endphp
                                    <i class="fas {{ $fileIcon }} {{ $fileClass }} mr-2 text-lg"></i>
                                    <span class="truncate" style="max-width: 200px;">{{ $file->file_name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $file->category->category_name }}</span>
                            </td>
                            <td>{{ strtoupper(pathinfo($file->file_name, PATHINFO_EXTENSION)) }}</td>
                            <td>{{ round($file->file_size / 1024, 2) }} KB</td>
                            <td>{{ $file->upload_date->format('M d, Y') }}</td>
                            <td>
                                <div class="flex space-x-2">
                                    <a href="{{ route('resident.files.download', [$resident->id, $file->id]) }}" 
                                       class="btn btn-sm btn-primary btn-icon" title="Download">
                                        <h1>Download</h1>
                                    </a>
                                    <a href="{{ route('resident.files.show', [$resident->id, $file->id]) }}" 
                                       class="btn btn-sm btn-info btn-icon" title="View Details">
                                        <h1>View Details</h1>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger btn-icon delete-file" 
                                            title="Delete"
                                            data-id="{{ $file->id }}"
                                            data-resident="{{ $resident->id }}">
                                        <h1>Delete</h1>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Upload File Modal -->
<div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" id="uploadModal">
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="panel my-8 w-full max-w-lg overflow-hidden rounded-lg border-0 p-0">
            <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                <div class="text-lg font-bold">Upload File for {{ $resident->full_name }}</div>
                <button type="button" class="text-white-dark hover:text-dark" onclick="closeUploadModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="p-5">
                <form method="POST" action="{{ route('resident.files.store', $resident->id) }}" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" class="form-select @error('category_id') is-invalid @enderror" 
                                name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label">File</label>
                        <input id="file" type="file" class="form-input @error('file') is-invalid @enderror" 
                               name="file" required>
                        @error('file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" class="form-textarea @error('description') is-invalid @enderror" 
                                  name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" class="btn btn-outline-secondary" onclick="closeUploadModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" id="deleteModal">
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="panel my-8 w-full max-w-lg overflow-hidden rounded-lg border-0 p-0">
            <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                <div class="text-lg font-bold">Confirm Deletion</div>
                <button type="button" class="text-white-dark hover:text-dark" onclick="closeDeleteModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="p-5">
                <p>Are you sure you want to delete this file? This action cannot be undone.</p>
                <form id="deleteForm" method="POST" class="mt-6">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end space-x-4">
                        <button type="button" class="btn btn-outline-danger" onclick="closeDeleteModal()">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>
<script>
document.addEventListener('alpine:init', () => {
    // Initialize DataTable
    new simpleDatatables.DataTable('#filesTable', {
        searchable: true,
        perPage: 10,
        perPageSelect: [10, 20, 30, 50, 100],
        columns: [
            { select: 0, sortable: true },
            { select: 1, sortable: true },
            { select: 2, sortable: true },
            { select: 3, sortable: true },
            { select: 4, sortable: true },
            { select: 5, sortable: false }
        ],
    });
});

// Upload Modal Functions
function openUploadModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
    // Reset form when closing
    document.getElementById('uploadForm').reset();
}

// Close modal when clicking outside
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUploadModal();
    }
});

// Delete File Confirmation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-file').forEach(button => {
        button.addEventListener('click', function() {
            const fileId = this.getAttribute('data-id');
            const residentId = this.getAttribute('data-resident');
            const form = document.getElementById('deleteForm');
            
            form.action = `/resident/${residentId}/files/${fileId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        });
    });
});

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Handle form submission success/error
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        openUploadModal();
    });
@endif
</script>
@endsection
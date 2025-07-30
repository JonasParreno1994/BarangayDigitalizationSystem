@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Edit Document</h1>
            <a href="{{ route('documents.index') }}" class="btn btn-outline-primary">Back to List</a>
        </div>

        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- Title --}}
            <div class="mb-4">
                <label class="form-label">Document Title <span class="text-red-500">*</span></label>
                <input type="text" class="form-input" name="title" required value="{{ $document->title }}">
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="form-label">Description (Optional)</label>
                <textarea class="form-textarea" name="description" rows="3">{{ $document->description }}</textarea>
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label class="form-label">Category <span class="text-red-500">*</span></label>
                <select class="form-select" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- File Section --}}
            <div class="mb-4">
                <label class="form-label">Current File:</label>
                <div class="mb-2">
                    <a href="{{ route('documents.download', $document->id) }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ basename($document->file_path) }}
                    </a>
                </div>
                <label class="form-label">Replace File (Optional)</label>
                <input type="file" name="document" class="form-input">
                <small class="text-gray-500">Leave blank to keep current file.</small>
            </div>

            {{-- Actions --}}
            <div class="mt-8 flex items-center justify-end">
                <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('documents.index') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Update Document</button>
            </div>
        </form>
    </div>
</div>
@endsection

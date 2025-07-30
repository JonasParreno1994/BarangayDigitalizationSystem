@extends('layouts.adminLayout.index')

@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Upload New Document</h3>
    </div>
    <div class="panel-body">
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="title">Document Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description (Optional)</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="document">Document File</label>
                <input type="file" name="document" id="document" class="form-control-file" required>
                <small class="form-text text-muted">Allowed file types: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Max: 2MB)</small>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Upload Document</button>
                <a href="{{ route('documents.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
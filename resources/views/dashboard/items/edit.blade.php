@extends('layouts.adminLayout.index')
@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Dashboard Item</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard-items.update', $dashboard_item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    @for($i = 1; $i <= 5; $i++)
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6>Item {{ $i }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="image{{ $i }}" class="form-label">Image {{ $i }}</label>
                                    <input type="file" class="form-control" id="image{{ $i }}" name="image{{ $i }}">
                                    
                                    @if($dashboard_item->{"image{$i}_path"})
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($dashboard_item->{"image{$i}_path"}) }}" class="img-thumbnail" style="max-height: 100px;">
                                            <small class="text-muted">Current image</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="description{{ $i }}" class="form-label">Description {{ $i }}</label>
                                    <textarea class="form-control" id="description{{ $i }}" name="description{{ $i }}" rows="2" required>{{ $dashboard_item->{"description{$i}"} }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('dashboard-items.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
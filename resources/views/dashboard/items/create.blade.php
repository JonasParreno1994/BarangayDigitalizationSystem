@extends('layouts.adminLayout.index')
@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Create New Dashboard Item</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard-items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
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
                                </div>
                                <div class="mb-3">
                                    <label for="description{{ $i }}" class="form-label">Description {{ $i }}</label>
                                    <textarea class="form-control" id="description{{ $i }}" name="description{{ $i }}" rows="2" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('dashboard-items.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
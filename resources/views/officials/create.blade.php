@extends('layouts.adminLayout.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="panel">
                <h2 class="text-lg font-semibold mb-4">Add New Official</h2>
                
                <form action="{{ route('officials.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="position_id" class="form-label">Position</label>
                        <select class="form-select" id="position_id" name="position_id" required>
                            <option value="">Select Position</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->position }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="committee" class="form-label">Committee</label>
                        <input type="text" class="form-control" id="committee" name="committee">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('officials.index') }}'">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
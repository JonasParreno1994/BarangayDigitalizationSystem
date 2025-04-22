@extends('layouts.adminLayout.index')
@section('content')

<div class="p-6">
    <div class="panel mb-4">
        <h2 class="text-2xl font-bold mb-4">Edit Official</h2>
        <form method="POST" action="{{ route('officials.update', $official->id) }}">
            @csrf
          
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Name</label>
                <input type="text" name="name" value="{{ old('name', $official->name) }}" class="form-input w-full" required>
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Position</label>
                <select name="position_id" class="form-select w-full" required>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}" {{ $official->position_id == $position->id ? 'selected' : '' }}>
                            {{ $position->position }}
                        </option>
                    @endforeach
                </select>
                @error('position_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Committee</label>
                <input type="text" name="committee" value="{{ old('committee', $official->committee) }}" class="form-input w-full">
                @error('committee') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Status</label>
                <select name="status" class="form-select w-full" required>
                    <option value="Active" {{ $official->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $official->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('officials.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Official</button>
            </div>
        </form>
    </div>
</div>

@endsection

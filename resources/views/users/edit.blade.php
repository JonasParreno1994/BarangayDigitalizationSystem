@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Edit User</h1>
            <a href="{{ route('users.list') }}" class="btn btn-outline-primary">Back to List</a>
        </div>

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="form-label">Name <span class="text-red-500">*</span></label>
                <input id="name" type="text" 
                    class="form-input @error('name') is-invalid @enderror" 
                    name="name" value="{{ old('name', $user->name) }}" required autofocus>

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="form-label">Email Address <span class="text-red-500">*</span></label>
                <input id="email" type="email" 
                    class="form-input @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email', $user->email) }}" required>

                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" 
                    class="form-input @error('password') is-invalid @enderror" 
                    name="password" autocomplete="new-password">
                <small class="text-gray-500">Leave blank to keep current password</small>

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-input" name="password_confirmation">
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label for="role" class="form-label">Role <span class="text-red-500">*</span></label>
                <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                    @foreach(App\Models\User::getRoles() as $role)
                        <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>

                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="mt-8 flex items-center justify-end">
                <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('users.list') }}'">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

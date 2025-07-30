@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">User Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger delete-user">Delete</button>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Basic Information</h3>
                    <p class="text-gray-600"><strong>Name:</strong> {{ $user->name }}</p>
                    <p class="text-gray-600"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="text-gray-600"><strong>Role:</strong> 
                        <span class="badge {{ $user->role == 'Secretary' ? 'bg-primary' : 'bg-success' }}">
                            {{ $user->role }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold">Account Details</h3>
                    <p class="text-gray-600"><strong>User ID:</strong> {{ $user->id }}</p>
                    <p class="text-gray-600"><strong>Email Verified:</strong> 
                        <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </span>
                    </p>
                    <p class="text-gray-600"><strong>Account Created:</strong> {{ $user->created_at->format('F d, Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold">Role Information</h3>
                    <p class="text-gray-600"><strong>Is Secretary:</strong> {{ $user->isSecretary() ? 'Yes' : 'No' }}</p>
                    <p class="text-gray-600"><strong>Is Treasurer:</strong> {{ $user->isTreasurer() ? 'Yes' : 'No' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold">Activity Information</h3>
                    <p class="text-gray-600"><strong>Last Updated:</strong> {{ $user->updated_at->format('F d, Y g:i A') }}</p>
                    <p class="text-gray-600"><strong>Email Verified At:</strong> {{ $user->email_verified_at ? $user->email_verified_at->format('F d, Y g:i A') : 'Not verified' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <h3 class="font-semibold">Additional Information</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600"><strong>Available Roles:</strong> {{ implode(', ', \App\Models\User::getRoles()) }}</p>
                        <p class="text-gray-600"><strong>Current Status:</strong> 
                            <span class="badge bg-success">Active</span>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="pt-4 flex justify-end">
                <a href="{{ route('users.list') }}" class="btn btn-outline-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
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
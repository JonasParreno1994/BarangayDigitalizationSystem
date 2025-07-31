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

    .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 12px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3b82f6;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
    }

    .select2-container .select2-selection--single:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

<div x-data="modal()" class="mb-5">
    <div class="animate__animated p-6" :class="[$store.app.animation]">
        <div x-data="multipleTable">
            <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold">
                <button type="button" class="btn btn-success" @click="toggle">
                    <i class="fas fa-plus"></i> Add New User
                </button>
                <h1 class="ltr:mr-4 rtl:ml-3 text-center w-full">User Management</h1>
            </div>
            <div class="panel mt-6">
                <table id="userTable" class="whitespace-nowrap"></table>
            </div>
        </div>

        <!-- Add User Modal -->
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="open && '!block'">
            <div class="flex min-h-screen items-start justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition x-transition.duration.300 class="panel my-8 max-w-2xl overflow-hidden rounded-lg border-0 p-0">
                    <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                        <div class="text-lg font-bold">CREATE NEW USER</div>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    <div class="p-5">
                        <form id="userForm" action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Name <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Enter full name">
                                    @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" class="form-input @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter email address">
                                    @error('email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Password <span class="text-red-500">*</span></label>
                                    <input type="password" class="form-input @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password" placeholder="Enter password">
                                    @error('password')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="form-label">Confirm Password <span class="text-red-500">*</span></label>
                                    <input type="password" class="form-input" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Role <span class="text-red-500">*</span></label>
                                    <select class="form-select @error('role') border-red-500 @enderror" name="role" required>
                                        <option value="">Select Role</option>
                                        @if(method_exists(App\Models\User::class, 'getRoles'))
                                            @foreach(App\Models\User::getRoles() as $role)
                                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                                            @endforeach
                                        @else
                                            <option value="Administrator">Administrator</option>
                                            <option value="Secretary">Secretary</option>  
                                            <option value="Staff">Staff</option>
                                        @endif
                                    </select>
                                    @error('role')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-end">
                                <button type="button" class="btn btn-outline-danger" @click="toggle">Cancel</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('modal', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
            if (this.open) {
                const form = document.getElementById('userForm');
                if (form) {
                    form.reset();
                    form.querySelectorAll('.error-message').forEach(el => el.remove());
                    form.querySelectorAll('input, select').forEach(el => {
                        el.style.borderColor = '';
                        el.classList.remove('border-red-500');
                    });
                }
            }
        }
    }));

    Alpine.data('multipleTable', () => ({
        datatable: null,
        init() {
            this.datatable = new simpleDatatables.DataTable('#userTable', {
                data: {
                    headings: ['ID', 'Name', 'Email', 'Role', 'Actions'],
                    data: [
                        @foreach ($users as $user)
                            [
                                '{{ $user->id }}',
                                '{{ $user->name }}',
                                '{{ $user->email }}',
                                `<span class="badge ${getRoleBadgeClass('{{ $user->role }}')}">
                                    {{ $user->role }}
                                </span>`,
                                `<div class="flex space-x-2">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-secondary">View</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-user">Delete</button>
                                    </form>
                                </div>`
                            ],
                        @endforeach
                    ],
                },
                searchable: true,
                perPage: 10,
                perPageSelect: [10, 20, 30, 50, 100],
                columns: [
                    { select: 0, sortable: true },
                    { select: 1, sortable: true },
                    { select: 2, sortable: true },
                    { select: 3, sortable: false, type: 'html' },
                    { select: 4, sortable: false, type: 'html' }
                ],
            });
        },
    }));
});

function getRoleBadgeClass(role) {
    switch(role) {
        case 'Administrator': return 'bg-primary';
        case 'Secretary': return 'bg-success';
        case 'Staff': return 'bg-warning';
        default: return 'bg-secondary';
    }
}

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

    const form = document.getElementById('userForm');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        form.querySelectorAll('.error-message').forEach(el => el.remove());

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = 'red';
                field.classList.add('border-red-500');
                isValid = false;
                const errorMsg = document.createElement('div');
                errorMsg.className = 'error-message text-red-500 text-sm mt-1';
                errorMsg.textContent = 'This field is required';
                field.parentNode.appendChild(errorMsg);
            } else {
                field.style.borderColor = '';
                field.classList.remove('border-red-500');
            }
        });

        const password = document.querySelector('input[name="password"]');
        const passwordConfirm = document.querySelector('input[name="password_confirmation"]');
        if (password.value && passwordConfirm.value && password.value !== passwordConfirm.value) {
            passwordConfirm.style.borderColor = 'red';
            passwordConfirm.classList.add('border-red-500');
            isValid = false;
            const errorMsg = document.createElement('div');
            errorMsg.className = 'error-message text-red-500 text-sm mt-1';
            errorMsg.textContent = 'Passwords do not match';
            passwordConfirm.parentNode.appendChild(errorMsg);
        }

        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fix the errors in the form',
            });
        }
    });

    form.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '';
                this.classList.remove('border-red-500');
                const errorMsg = this.parentNode.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });
    });

    const passwordConfirm = document.querySelector('input[name="password_confirmation"]');
    const password = document.querySelector('input[name="password"]');

    if (passwordConfirm && password) {
        passwordConfirm.addEventListener('input', function() {
            if (this.value === password.value) {
                this.style.borderColor = '';
                this.classList.remove('border-red-500');
                const errorMsg = this.parentNode.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });
    }

    @if($errors->any())
        setTimeout(() => {
            const modalElement = document.querySelector('[x-data*="modal"]');
            if (modalElement) {
                Alpine.$data(modalElement).open = true;
            }
        }, 100);
    @endif
});
</script>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>
@endsection

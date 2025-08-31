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

<div x-data="modal" class="mb-5">
    <div class="animate__animated p-6" :class="[$store.app.animation]">

    <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold mb-4">
        <a href="{{ route('households.create') }}" class="btn btn-success">Add New Household</a>
        <h1 class="ltr:mr-4 rtl:ml-3 text-center w-full">Household Records</h1>
    </div>

        <div class="panel" x-data="multipleTable">
            <div class="mb-5 flex flex-col gap-5 md:flex-row md:items-center">
                <h5 class="text-lg font-semibold dark:text-white-light">Household List</h5>
            </div>

            <div class="table-responsive">
                <table id="householdTable" class="table-hover"></table>
            </div>
        </div>
    </div>
</div>

<script>
    function getStatusBadgeClass(status) {
        switch(status) {
            case 'Active':
                return 'bg-success';
            case 'Inactive':
                return 'bg-secondary';
            default:
                return 'bg-secondary';
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('multipleTable', () => ({
            datatable: null,
            init() {
                this.datatable = new simpleDatatables.DataTable('#householdTable', {
                    data: {
                        headings: ['ID', 'Household Number', 'Address', 'Household Head', 'Members', 'Status', 'Actions'],
                        data: [
                            @foreach ($households as $household)
                                [
                                    '{{ $household->id }}',
                                    '{{ $household->household_number }}',
                                    @if($household->household_address)
                                        '{{ $household->household_address }}<br><small class="text-muted">{{ $household->barangay }}, {{ $household->city_municipality }}</small>'
                                    @else
                                        'Not specified'
                                    @endif,
                                    @if($household->householdHead)
                                        '{{ $household->householdHead->full_name }}'
                                    @else
                                        'No household head assigned'
                                    @endif,
                                    `<span class="badge bg-info">{{ $household->number_of_members }} members</span>`,
                                    `<span class="badge ${getStatusBadgeClass('{{ $household->status }}')}">
                                        {{ $household->status }}
                                    </span>`,
                                    `<div class="flex space-x-2">
                                        <a href="{{ route('households.show', $household) }}" class="btn btn-sm btn-info" title="View Details">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('households.print', $household) }}" target="_blank" class="btn btn-sm btn-success" title="Print">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('households.add-member', $household) }}" class="btn btn-sm btn-primary" title="Add Member">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('households.edit', $household) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('households.destroy', $household) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-household" data-id="{{ $household->id }}" title="Delete">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
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
                        { select: 3, sortable: true },
                        { select: 4, sortable: false, type: 'html' },
                        { select: 5, sortable: false, type: 'html' },
                        { select: 6, sortable: false, type: 'html' }
                    ],
                });

                // Handle delete confirmation with SweetAlert2
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.delete-household')) {
                        e.preventDefault();
                        const button = e.target.closest('.delete-household');
                        const form = button.closest('form');
                        const householdId = button.getAttribute('data-id');
                        
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This will delete the household and all its members permanently!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show loading
                                Swal.fire({
                                    title: 'Deleting...',
                                    text: 'Please wait while we delete the household.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                
                                form.submit();
                            }
                        });
                    }
                });
            },
        }));
    });
</script>
@endsection

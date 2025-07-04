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
        <div x-data="multipleTable">
            <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold">
                <button type="button" class="btn btn-success" @click="toggle">Issue Clearance</button>
                <h1 class="ltr:mr-4 rtl:ml-3 text-center w-full">List of Barangay Clearances</h1>
            </div>
            <div class="panel mt-6">
                <table id="clearanceTable" class="whitespace-nowrap"></table>
            </div>
        </div>
        
        <!-- Add Clearance Modal -->
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="open && '!block'">
            <div class="flex min-h-screen items-start justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition x-transition.duration.300 class="panel my-8 w-full max-w-4xl overflow-hidden rounded-lg border-0 p-0">
                    <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                        <div class="text-lg font-bold">ISSUE BARANGAY CLEARANCE</div>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-5">
                       <form id="clearanceForm" action="{{ route('barangayclearance.store') }}" method="POST">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Resident <span class="text-red-500">*</span></label>
                                    <select class="form-select" name="resident_id" required>
                                        <option value="">Select Resident</option>
                                        @foreach($residents as $resident)
                                            <option value="{{ $resident->id }}">
                                                {{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Purpose <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="purpose" required placeholder="Purpose of clearance">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Cedula Number</label>
                                    <input type="text" class="form-input" name="cedula_number" placeholder="Cedula Number">
                                </div>
                                <div>
                                    <label class="form-label">Date of Issuance <span class="text-red-500">*</span></label>
                                    <input type="date" class="form-input" name="date_of_issuance" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="form-label">OR Number</label>
                                    <input type="text" class="form-input" name="or_number" placeholder="OR Number">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Amount Paid</label>
                                    <input type="number" step="0.01" class="form-input" name="amount_paid" placeholder="0.00">
                                </div>
                                <div>
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="Issued" selected>Issued</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Remarks</label>
                                <textarea class="form-textarea" name="remarks" rows="2" placeholder="Additional notes"></textarea>
                            </div>
                            
                            <div class="mt-8 flex items-center justify-end">
                                <button type="button" class="btn btn-outline-danger" @click="toggle">Cancel</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Issue Clearance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View Clearance Modal -->
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" id="viewClearanceModal">
            <div class="flex min-h-screen items-start justify-center px-4">
                <div class="panel my-8 w-full max-w-4xl overflow-hidden rounded-lg border-0 p-0">
                    <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                        <div class="text-lg font-bold">CLEARANCE DETAILS</div>
                        <button type="button" class="text-white-dark hover:text-dark" onclick="closeViewModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-5" id="clearanceDetailsContent">
                        <!-- Content will be loaded here via AJAX -->
                        <div class="text-center py-10">
                            <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="mt-3">Loading clearance details...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// DataTable Initialization
document.addEventListener('alpine:init', () => {
    Alpine.data('multipleTable', () => ({
        datatable: null,
        init() {
            this.datatable = new simpleDatatables.DataTable('#clearanceTable', {
                // In the DataTable initialization part
                data: {
                    headings: ['ID', 'Resident', 'Purpose', 'Date of Issuance', 'Status', 'Actions'],
                    data: [
                        @foreach ($clearances as $clearance)
                            [
                                '{{ $clearance->id }}',
                                '{{ $clearance->resident->last_name }}, {{ $clearance->resident->first_name }}',
                                '{{ $clearance->purpose }}',
                                '{{ $clearance->date_of_issuance->format('m/d/Y') }}',
                                `<span class="badge ${getStatusBadgeClass('{{ $clearance->status }}')}">
                                    {{ $clearance->status }}
                                </span>`,
                                `<div class="flex space-x-2">
                                    <a href="{{ route('barangayclearance.show', $clearance->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('barangayclearance.print', $clearance->id) }}" target="_blank" class="btn btn-sm btn-success">Print</a>
                                    <a href="{{ route('barangayclearance.edit', $clearance->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('barangayclearance.destroy', $clearance->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-clearance">
                                            Delete
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
                    { select: 5, sortable: false, type: 'html' }
                ],
            });
        },
    }));
});

function getStatusBadgeClass(status) {
    switch(status) {
        case 'Issued': return 'bg-success';
        case 'Pending': return 'bg-warning';
        case 'Cancelled': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

// Clearance Modal Functions
function showClearanceModal(clearanceId) {
    document.getElementById('viewClearanceModal').classList.remove('hidden');
    
    fetch(`/barangayClearance/${clearanceId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('clearanceDetailsContent').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading clearance details:', error);
            document.getElementById('clearanceDetailsContent').innerHTML = `
                <div class="text-center py-10 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="mt-3">Failed to load clearance details. Please try again.</p>
                </div>
            `;
        });
}

function printClearance(clearanceId) {
    const printWindow = window.open(
        `/barangayClearance/${clearanceId}/print`, 
        '_blank',
        'toolbar=0,location=0,menubar=0,scrollbars=1,resizable=1'
    );
    if (printWindow) {
        printWindow.moveTo(0, 0);
        printWindow.resizeTo(screen.availWidth, screen.availHeight);
        printWindow.focus();
    }
}

function closeViewModal() {
    document.getElementById('viewClearanceModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('viewClearanceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeViewModal();
    }
});

// Delete Confirmation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-clearance').forEach(button => {
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

// Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('clearanceForm');
    
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = 'red';
                isValid = false;
                
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message text-red-500 text-sm mt-1';
                    errorMsg.textContent = 'This field is required';
                    field.parentNode.insertBefore(errorMsg, field.nextSibling);
                }
            } else {
                field.style.borderColor = '';
                const errorMsg = field.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('error-message')) {
                    errorMsg.remove();
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields',
            });
        }
    });
    
    form.querySelectorAll('[required]').forEach(field => {
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '';
                const errorMsg = this.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('error-message')) {
                    errorMsg.remove();
                }
            }
        });
    });
});
</script>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>
@endsection
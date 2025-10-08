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
    
    select.form-select:not(.select2-hidden-accessible) {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
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
    
    .select2-hidden-accessible {
        display: none !important;
    }
</style>

@if(session('print_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('print_success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif

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

<script>
    // Check if returning from print page
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.get('printed') === '1') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Barangay Certificate issued successfully!',
                timer: 3000,
                showConfirmButton: false
            });
            // Clean up URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>

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
        <div>
            <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold">
                <button type="button" class="btn btn-success" @click="toggle">Issue Certificate</button>
                <h1 class="ltr:mr-4 rtl:ml-3 text-center w-full">List of Barangay Certificates</h1>
            </div>
            <div class="panel mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h2 class="text-lg font-bold mb-4">Monthly Data Count</h2>
                    <canvas id="monthlyBarChart" height="50"></canvas>
                </div>
                <div>
                    <h2 class="text-lg font-bold mb-4">Generate Report</h2>
                    <form action="{{ route('barangay-certificate.report') }}" method="GET" class="mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="date_from" class="form-label">From:</label>
                                <input type="date" id="date_from" name="date_from" class="form-input" required>
                            </div>
                            <div>
                                <label for="date_to" class="form-label">To:</label>
                                <input type="date" id="date_to" name="date_to" class="form-input" required>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="btn btn-primary w-full">Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="panel mt-6" x-data="multipleTable">
                <table id="certificateTable" class="whitespace-nowrap"></table>
            </div>
        </div>
        
        <!-- Add Certificate Modal -->
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="open && '!block'">
            <div class="flex min-h-screen items-start justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition x-transition.duration.300 class="panel my-8 w-full max-w-4xl overflow-hidden rounded-lg border-0 p-0">
                    <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                        <div class="text-lg font-bold">ISSUE BARANGAY CERTIFICATE</div>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-5">
                       <form id="certificateForm" action="{{ route('barangay-certificate.store') }}" method="POST">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Resident <span class="text-red-500">*</span></label>
                                    <select class="form-select resident-search" name="resident_id" id="residentSelect" required>
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
                                    <input type="text" class="form-input" name="purpose" required placeholder="Purpose of certificate">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Residence Period (Years)</label>
                                    <input type="number" class="form-input" name="residence_period_years" min="0" placeholder="Years">
                                </div>
                                <div>
                                    <label class="form-label">Residence Period (Months)</label>
                                    <input type="number" class="form-input" name="residence_period_months" min="0" max="11" placeholder="Months">
                                </div>
                                <div>
                                    <label class="form-label">Cedula Number</label>
                                    <input type="text" class="form-input" name="cedula_number" placeholder="Cedula Number">
                                </div>
                                <div>
                                    <label class="form-label">Date of Issuance <span class="text-red-500">*</span></label>
                                    <input type="date" class="form-input" name="date_of_issuance" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                                <div>
                                    <label class="form-label">OR Number</label>
                                    <input type="text" class="form-input" name="or_number" placeholder="OR Number">
                                </div>
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
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Issue Certificate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<script>
// Alpine.js and DataTable Initialization
document.addEventListener('alpine:init', () => {
    Alpine.data('modal', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
            if (this.open) {
                const form = document.getElementById('certificateForm');
                if (form) {
                    form.reset();
                    form.querySelectorAll('.error-message').forEach(el => el.remove());
                    form.querySelectorAll('input, select, textarea').forEach(el => {
                        el.style.borderColor = '';
                        el.classList.remove('border-red-500');
                    });
                    // Reset Select2
                    setTimeout(() => {
                        $('#residentSelect').val(null).trigger('change');
                    }, 100);
                }
            }
        }
    }));

    Alpine.data('multipleTable', () => ({
        datatable: null,
        init() {
            this.datatable = new simpleDatatables.DataTable('#certificateTable', {
                // In the DataTable initialization part
                data: {
                    headings: ['ID', 'Resident', 'Purpose', 'Date of Issuance', 'Status', 'Actions'],
                    data: [
                        @foreach ($certificates as $certificate)
                            [
                                '{{ $certificate->id }}',
                                '{{ $certificate->resident->last_name }}, {{ $certificate->resident->first_name }}',
                                '{{ $certificate->purpose }}',
                                '{{ $certificate->date_of_issuance->format('m/d/Y') }}',
                                `<span class="badge ${getStatusBadgeClass('{{ $certificate->status }}')}">
                                    {{ $certificate->status }}
                                </span>`,
                                `<div class="flex space-x-2">
                                    <a href="{{ route('barangay-certificate.show', $certificate->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('barangay-certificate.print', $certificate->id) }}" target="_blank" class="btn btn-sm btn-success">Print</a>
                                    <a href="{{ route('barangay-certificate.edit', $certificate->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('barangay-certificate.destroy', $certificate->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-certificate">Delete</button>
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

// Delete Certificate Functions
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-certificate').forEach(button => {
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

function printCertificate(certificateId) {
    const printWindow = window.open(
        `/barangay-certificate/${certificateId}/print`, 
        '_blank',
        'toolbar=0,location=0,menubar=0,scrollbars=1,resizable=1'
    );
    if (printWindow) {
        printWindow.moveTo(0, 0);
        printWindow.resizeTo(screen.availWidth, screen.availHeight);
        printWindow.focus();
    }
}

// Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('certificateForm');
    
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Safe Select2 initialization function
    function initializeSelect2(selector, options = {}) {
        const element = $(selector);
        
        // Check if element exists and is not already initialized with Select2
        if (element.length && !element.hasClass('select2-hidden-accessible')) {
            element.select2(options);
        }
    }
    
    // Safe Select2 destroy function
    function destroySelect2(selector) {
        const element = $(selector);
        if (element.length && element.hasClass('select2-hidden-accessible')) {
            element.select2('destroy');
        }
    }
    
    // Initialize Select2 on page load
    initializeSelect2('#residentSelect', {
        width: '100%',
        placeholder: 'Search for a resident...',
        allowClear: true,
        dropdownParent: $('#residentSelect').closest('.panel, .modal, body')
    });
    
    // Handle modal toggle events if modal exists
    const modalElement = document.querySelector('[x-data="modal"]');
    if (modalElement) {
        modalElement.addEventListener('toggle', function(e) {
            if (e.detail && e.detail.open) {
                // Modal opened - reinitialize Select2 after a brief delay
                setTimeout(() => {
                    destroySelect2('#residentSelect');
                    initializeSelect2('#residentSelect', {
                        width: '100%',
                        placeholder: 'Search for a resident...',
                        allowClear: true,
                        dropdownParent: $('#residentSelect').closest('.panel, .modal, body')
                    });
                }, 100);
            } else {
                // Modal closed - destroy Select2 to prevent conflicts
                destroySelect2('#residentSelect');
            }
        });
    }
    
    // Handle Alpine.js modal events as backup
    document.addEventListener('alpine:init', () => {
        Alpine.data('modal', () => ({
            open: false,
            toggle() {
                this.open = !this.open;
                if (this.open) {
                    this.$nextTick(() => {
                        destroySelect2('#residentSelect');
                        initializeSelect2('#residentSelect', {
                            width: '100%',
                            placeholder: 'Search for a resident...',
                            allowClear: true,
                            dropdownParent: $('#residentSelect').closest('.panel, .modal, body')
                        });
                    });
                } else {
                    destroySelect2('#residentSelect');
                }
            }
        }));
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            
<script>
    const ctx = document.getElementById('monthlyBarChart').getContext('2d');

    const monthlyLabels = @json(array_keys($monthlyCounts));
    const monthlyData = @json(array_values($monthlyCounts));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Certificates Issued',
                data: monthlyData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' issued';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
</script>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>
@endsection
@extends('layouts.adminLayout.index')
@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-btn d-flex align-items-center gap-2">
            <a href="{{ route('barangayid.create') }}" class="btn btn-success btn-lg shadow-sm rounded-pill px-4 py-2 d-flex align-items-center">
            <i class="fa fa-plus me-2"></i> Add New Template
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Debug Info -->
            <div class="mb-3">
                @if($items->isEmpty())
                    <div class="alert alert-warning">No records found. <a href="{{ route('barangayid.create') }}">Create one?</a></div>
                @else
                    <div class="alert alert-info d-none">Loaded {{ $items->count() }} records.</div>
                @endif
            </div>

            <div class="table-responsive">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table id="customTable" class="w-full"></table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug: Check if items are available
    console.log('Items data:', @json($items));

    // Initialize datatable
    try {
        const datatable = new simpleDatatables.DataTable('#customTable', {
            data: {
                headings: [
                    'Logo 1', 'Logo 2', 'Header Info', 'Captain', 'Validity', 
                    'Emergency Contact', 'Color Scheme', 'Features', 'Actions'
                ],
                data: [
                    @foreach($items as $item)
                    [
                        `<img src="{{ Storage::url($item->logo1_path) }}" class="h-10 w-10 object-cover">`,
                        `<img src="{{ Storage::url($item->logo2_path) }}" class="h-10 w-10 object-cover">`,
                        `<div class="text-xs">
                            <div class="font-bold">{{ $item->heading1 }}</div>
                            <div>{{ $item->heading2 }}</div>
                            <div>{{ $item->heading3 }}</div>
                            @if($item->office_info)
                                <div class="text-gray-600">{{ $item->office_info }}</div>
                            @endif
                        </div>`,
                        `{{ $item->pass_captain }}`,
                        `<div class="text-xs">
                            <div>{{ $item->validity }}</div>
                            <div class="text-gray-600">{{ $item->validity_years ?? 3 }} years</div>
                        </div>`,
                        `<div class="text-xs">
                            @if($item->emergency_contact_name)
                                <div class="font-bold">{{ $item->emergency_contact_name }}</div>
                                <div>{{ $item->emergency_contact_number }}</div>
                            @else
                                <span class="text-gray-500">Not Set</span>
                            @endif
                        </div>`,
                        `<span class="badge badge-{{ $item->card_color_scheme ?? 'blue' }}">{{ ucfirst($item->card_color_scheme ?? 'blue') }}</span>`,
                        `<div class="text-xs">
                            @if($item->include_qr_code ?? true)
                                <span class="badge badge-success">QR Code</span>
                            @endif
                            @if($item->include_fingerprint ?? true)
                                <span class="badge badge-info">Fingerprint</span>
                            @endif
                        </div>`,
                        `<div class="action-buttons" style="display: flex; gap: 10px; align-items: center;">
                            <a href="{{ route('barangayid.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('barangayid.destroy', $item->id) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-item" title="Delete">
                                    Delete
                                </button>
                            </form>
                        </div>`
                    ],
                    @endforeach
                ]
            },
            searchable: true,
            perPage: 10,
            perPageSelect: [10, 20, 30, 50, 100],
            columns: [
                { select: 0, sortable: false, type: 'html' },
                { select: 1, sortable: false, type: 'html' },
                { select: 2, sortable: false, type: 'html' },
                { select: 3, sortable: true },
                { select: 4, sortable: false, type: 'html' },
                { select: 5, sortable: false, type: 'html' },
                { select: 6, sortable: true, type: 'html' },
                { select: 7, sortable: false, type: 'html' },
                { select: 8, sortable: false, type: 'html' }
            ]
        });
        console.log('Datatable initialized:', datatable);
    } catch (error) {
        console.error('Datatable error:', error);
    }

    // Delete confirmation - using event delegation for dynamic content
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-item')) {
            e.preventDefault();
            const form = e.target.closest('form');
            
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
        }
    });
});
</script>

<style>
    /* Ensure buttons are visible and properly styled */
    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .action-buttons .btn i {
        margin: 0;
    }
    /* Make sure the action column is wide enough */
    #customTable td:last-child {
        min-width: 120px;
    }
    
    /* Badge styles */
    .badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        margin: 0.1rem;
    }
    
    .badge-blue { background-color: #007bff; color: white; }
    .badge-green { background-color: #28a745; color: white; }
    .badge-red { background-color: #dc3545; color: white; }
    .badge-purple { background-color: #6f42c1; color: white; }
    .badge-success { background-color: #28a745; color: white; }
    .badge-info { background-color: #17a2b8; color: white; }
    
    .text-xs { font-size: 0.75rem; }
    .font-bold { font-weight: bold; }
    .text-gray-600 { color: #6b7280; }
    .text-gray-500 { color: #9ca3af; }
</style>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>
@endsection
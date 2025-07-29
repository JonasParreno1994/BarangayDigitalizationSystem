@extends('layouts.adminLayout.index')
@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-btn d-flex align-items-center gap-2">
            <a href="{{ route('dashboard-items.create') }}" class="btn btn-success btn-lg shadow-sm rounded-pill px-4 py-2 d-flex align-items-center">
                <i class="fa fa-plus me-2"></i> Add New Item
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                @if($items->isEmpty())
                    <div class="alert alert-warning">No records found. <a href="{{ route('dashboard-items.create') }}">Create one?</a></div>
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
  
    console.log('Items data:', @json($items));

  
    const tableData = [
        @foreach($items as $item)
        [
            `{!! $item->image1_path ? '<img src="' . asset('storage/' . $item->image1_path) . '" class="h-10 w-10 object-cover">' : '<span class="text-muted">No image</span>' !!}`,
            `{!! $item->image2_path ? '<img src="' . asset('storage/' . $item->image2_path) . '" class="h-10 w-10 object-cover">' : '<span class="text-muted">No image</span>' !!}`,
            `{!! $item->image3_path ? '<img src="' . asset('storage/' . $item->image3_path) . '" class="h-10 w-10 object-cover">' : '<span class="text-muted">No image</span>' !!}`,
            `{!! $item->image4_path ? '<img src="' . asset('storage/' . $item->image4_path) . '" class="h-10 w-10 object-cover">' : '<span class="text-muted">No image</span>' !!}`,
            `{!! $item->image5_path ? '<img src="' . asset('storage/' . $item->image5_path) . '" class="h-10 w-10 object-cover">' : '<span class="text-muted">No image</span>' !!}`,
            `{{ Str::limit($item->description1, 20) }}`,
            `{{ Str::limit($item->description2, 20) }}`,
            `{{ Str::limit($item->description3, 20) }}`,
            `{{ Str::limit($item->description4, 20) }}`,
            `{{ Str::limit($item->description5, 20) }}`,
            `<div class="action-buttons" style="display: flex; gap: 10px; align-items: center;">
                <a href='{{ route('dashboard-items.edit', $item->id) }}' class='btn btn-sm btn-primary'>Edit</a>
                <form action='{{ route('dashboard-items.destroy', $item->id) }}' method='POST' style='display: inline;'>
                    @csrf @method('DELETE')
                    <button type='button' class='btn btn-sm btn-danger delete-item' title='Delete'>Delete</button>
                </form>
            </div>`
        ],
        @endforeach
    ];

  
    try {
        const datatable = new simpleDatatables.DataTable('#customTable', {
            data: {
                headings: [
                    'Image 1', 'Image 2', 'Image 3', 'Image 4', 'Image 5',
                    'Description 1', 'Description 2', 'Description 3', 'Description 4', 'Description 5', 'Actions'
                ],
                data: tableData
            },
            searchable: true,
            perPage: 10,
            perPageSelect: [5, 10, 20, 50],
            columns: [
                { select: 0, sortable: false, type: 'html' },
                { select: 1, sortable: false, type: 'html' },
                { select: 2, sortable: false, type: 'html' },
                { select: 3, sortable: false, type: 'html' },
                { select: 4, sortable: false, type: 'html' },
                { select: 5, sortable: true },
                { select: 6, sortable: true },
                { select: 7, sortable: true },
                { select: 8, sortable: true },
                { select: 9, sortable: true },
                { select: 10, sortable: false, type: 'html' }
            ]
        });
        console.log('Datatable initialized:', datatable);
    } catch (error) {
        console.error('Datatable error:', error);
    }

    
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
    #customTable td:last-child {
        min-width: 100px;
    }
    #customTable td {
        vertical-align: middle;
    }
    #customTable img {
        max-width: 40px;
        max-height: 40px;
    }
</style>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>
@endsection

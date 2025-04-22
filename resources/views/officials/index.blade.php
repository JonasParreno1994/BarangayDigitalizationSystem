@extends('layouts.adminLayout.index')
@section('content') 

<div class="animate__animated p-6" :class="[$store.app.animation]">
    <!-- start main content section -->
    <div x-data="multipleTable">
        <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold">
            <h1 class="ltr:mr-4 rtl:ml-3">Barangay Officials</h1>
            <a href="{{ route('officials.create') }}" class="btn btn-primary ml-auto">Add New Official</a>
        </div>
        <div class="panel mt-6">
            <table id="myTable2" class="whitespace-nowrap"></table>
        </div>
    </div>
    <!-- end main content section -->
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('multipleTable', () => ({
            randomColor() {
                const colors = ['red', 'blue', 'green', 'yellow', 'purple'];
                return colors[Math.floor(Math.random() * colors.length)];
            },
            formatDate(date) {
                const options = { year: 'numeric', month: 'short', day: 'numeric' };
                return new Date(date).toLocaleDateString(undefined, options);
            },
            datatable2: null,
            init() {
                this.datatable2 = new simpleDatatables.DataTable('#myTable2', {
                    data: {
                                headings: ['Name', 'Position', 'Committee', 'Status', 'Actions'],
                                data: [
                                    @foreach($officials as $official)
                                        [
                                            '{{ $official->name }}', 
                                            '{{ $official->position?->position ?? 'N/A' }}', 
                                            '{{ $official->committee ?? 'N/A' }}',
                                            `<span style="padding: 3px 8px; border-radius: 4px; color: white; background-color: {{ $official->status == 'Active' ? 'green' : 'red' }};">
                                             {{ $official->status }}
                                             </span>`,
                                            `<div class="flex space-x-2">
                                                <a href="{{ route('officials.edit', $official->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('officials.destroy', $official->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
                        { select: 3, sortable: false },
                        { select: 4, sortable: false }
                    ],
                    firstLast: true,
                    firstText:
                        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    lastText:
                        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    prevText:
                        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    nextText:
                        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    labels: {
                        perPage: '{select}',
                    },
                    layout: {
                        top: '{search}',
                        bottom: '{info}{select}{pager}',
                    },
                });
            },
        }));
    });
</script>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>

@endsection
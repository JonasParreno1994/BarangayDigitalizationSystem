@extends('layouts.adminLayout.index')
@section('content')
<style>
    input[type="text"], textarea {
        text-transform: uppercase;
    }
</style>
<div x-data="modal" class="mb-5">
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <!-- start main content section -->
    <div x-data="multipleTable">
        <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold">
            <button type="button" class="btn btn-success" @click="toggle">Add KP Case</button>
            <h1 class="ltr:mr-4 rtl:ml-3 text-center w-full">Barangay KP Cases</h1>
        </div>
        <div class="panel mt-6">
            <table id="kpTable" class="whitespace-nowrap"></table>
        </div>
    </div>
    <!-- end main content section -->
</div>


<div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[999] overflow-y-auto bg-[black]/60" style="display: none;" @click.self="open = false">
    <div class="flex min-h-screen items-start justify-center px-4">
        <div @click.stop class="panel my-8 w-full max-w-lg overflow-hidden rounded-lg border-0 p-0 shadow-xl">
            <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                <div class="text-lg font-bold">Add KP Case</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="p-5">
                <div class="text-base font-medium text-[#1f2937] dark:text-white-dark/70">
                    <form action="{{ route('kp-cases.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="case_no" class="form-label">Barangay Case No.</label>
                            <input type="text" class="form-control w-full border border-gray-300 rounded-md" id="case_no" name="case_no" required>
                        </div>
                        <div class="mb-3">
                            <label for="complainants" class="form-label">Name of Complainants</label>
                            <textarea class="form-control w-full border border-gray-300 rounded-md" id="complainants" name="complainants" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="responders" class="form-label">Name of Responders</label>
                            <textarea class="form-control w-full border border-gray-300 rounded-md" id="responders" name="responders" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dispute_type" class="form-label">Name/Type of Dispute</label>
                            <input type="text" class="form-control w-full border border-gray-300 rounded-md" id="dispute_type" name="dispute_type" required>
                        </div>
                        <div class="mb-3">
                            <label for="nature_of_dispute" class="form-label">Nature of Dispute</label>
                            <select class="form-select w-full" id="nature_of_dispute" name="nature_of_dispute" >
                                <option value="">Select Nature</option>
                                <option value="Criminal">Criminal</option>
                                <option value="Civil">Civil</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mode_of_settlement" class="form-label">Mode of Settlement</label>
                            <select class="form-select w-full" id="mode_of_settlement" name="mode_of_settlement" >
                                <option value="">Select Mode</option>
                                <option value="Mediation">Mediation</option>
                                <option value="Conciliation">Conciliation</option>
                                <option value="Arbitration">Arbitration</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="action_taken" class="form-label">Action Taken</label>
                            <select class="form-select w-full" id="action_taken" name="action_taken" >
                                <option value="">Select Action</option>
                                <option value="Repudiated">Repudiated</option>
                                <option value="Withdrawn">Withdrawn</option>
                                <option value="Pending">Pending</option>
                                <option value="Dismissed">Dismissed</option>
                                <option value="Certified to file action">Certified to file action</option>
                                <option value="Referred to concerned agencies">Referred to concerned agencies</option>
                            </select>
                        </div>
                </div>
                <div class="mt-8 flex items-center justify-end">
                    <button type="button" class="btn btn-outline-danger" @click="toggle">Discard</button>
                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('multipleTable', () => ({
            datatable: null,
            init() {
                this.datatable = new simpleDatatables.DataTable('#kpTable', {
                    data: {
                        headings: ['Case No.', 'Complainants', 'Responders', 'Dispute Type', 'Nature', 'Mode', 'Action', 'Actions'],
                        data: [
                            @foreach($kpCases as $case)
                                [
                                    '{{ $case->case_no }}',
                                    '{{ $case->complainants }}',
                                    '{{ $case->responders }}',
                                    '{{ $case->dispute_type }}',
                                    '{{ $case->nature_of_dispute }}',
                                    '{{ $case->mode_of_settlement }}',
                                    '{{ $case->action_taken }}',
                                    `<div class="flex space-x-2">
                                        <a href="{{ route('kp-cases.print', $case->id) }}" class="btn btn-sm btn-info" target="_blank">Print</a>
                                        <a href="{{ route('kp-cases.edit', $case->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('kp-cases.destroy', $case->id) }}" method="POST" class="d-inline">
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
                        { select: 3, sortable: true },
                        { select: 4, sortable: true },
                        { select: 5, sortable: true },
                        { select: 6, sortable: true },
                        { select: 7, sortable: false },
                    ],
                    firstLast: true,
                    firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
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
<script>
    document.addEventListener('input', function(e) {
        if ((e.target.tagName === 'INPUT' && e.target.getAttribute('type') === 'text') || e.target.tagName === 'TEXTAREA') {
            let start = e.target.selectionStart;
            let end = e.target.selectionEnd;
            e.target.value = e.target.value.toUpperCase();
            e.target.setSelectionRange(start, end);
        }
    });
</script>
@endsection

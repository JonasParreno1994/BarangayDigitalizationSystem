@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <!-- Breadcrumb -->
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li><a href="{{ route('dashboard.residentsgraph') }}" class="text-primary hover:underline">Dashboard</a></li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <a href="{{ route('households.index') }}" class="text-primary hover:underline">Household Records</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <span>{{ $household->household_number }}</span>
        </li>
    </ul>

    <div class="pt-5">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold dark:text-white-light">Household Details - {{ $household->household_number }}</h5>
            <div class="flex gap-2">
                <a href="{{ route('households.print', $household) }}" 
                   class="btn btn-secondary" 
                   target="_blank">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Record
                </a>
                <a href="{{ route('households.add-member', $household) }}" class="btn btn-primary">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Add Household Member
                </a>
                <a href="{{ route('households.edit', $household) }}" class="btn btn-warning">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Household
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success-light alert-dismissible mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Household Information -->
            <div class="panel">
                <div class="mb-5">
                    <h6 class="text-lg font-semibold">Household Information</h6>
                </div>
                <table class="table-auto">
                    <tr><th class="px-2 py-1 w-1/2">Household No:</th><td class="font-semibold">{{ $household->household_number }}</td></tr>
                    <tr><th class="px-2 py-1">Region:</th><td>{{ $household->region ?: 'Not specified' }}</td></tr>
                    <tr><th class="px-2 py-1">Province:</th><td>{{ $household->province ?: 'Not specified' }}</td></tr>
                    <tr><th class="px-2 py-1">City/Municipality:</th><td>{{ $household->city_municipality ?: 'Not specified' }}</td></tr>
                    <tr><th class="px-2 py-1">Barangay:</th><td>{{ $household->barangay ?: 'Not specified' }}</td></tr>
                    <tr><th class="px-2 py-1">Address:</th><td>{{ $household->household_address ?: 'Not specified' }}</td></tr>
                    <tr><th class="px-2 py-1">Total Members:</th><td><span class="badge bg-info">{{ $household->number_of_members }}</span></td></tr>
                    <tr><th class="px-2 py-1">Status:</th><td><span class="badge {{ $household->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">{{ $household->status }}</span></td></tr>
                </table>
            </div>

            <!-- Household Members -->
            <div class="panel lg:col-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <h6 class="text-lg font-semibold">Household Members</h6>
                    <a href="{{ route('households.add-member', $household) }}" class="btn btn-primary btn-sm">
                        <svg class="h-4 w-4 mr-1" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Member
                    </a>
                </div>

                @if($household->members->count() > 0)
                    <div class="table-responsive">
                        <table class="table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Civil Status</th>
                                    <th>Relationship</th>
                                    <th>Occupation</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($household->members as $member)
                                    <tr class="{{ $member->is_head ? 'bg-warning-light' : '' }}">
                                        <td>
                                            <div class="font-semibold">{{ $member->full_name }}</div>
                                            @if($member->is_head)
                                                <span class="badge bg-warning">Household Head</span>
                                            @endif
                                        </td>
                                        <td>{{ $member->calculated_age ?: $member->age }}</td>
                                        <td>{{ $member->sex }}</td>
                                        <td>{{ $member->civil_status }}</td>
                                        <td>{{ $member->relationship_to_head ?: 'N/A' }}</td>
                                        <td>{{ $member->occupation ?: 'N/A' }}</td>
                                        <td>
                                            @if($member->labor_employment_status)
                                                <span class="badge bg-info">{{ $member->labor_employment_status }}</span>
                                            @else
                                                <span class="text-white-dark">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex gap-1">
                                                <a href="{{ route('households.edit-member', [$household, $member]) }}" 
                                                   class="btn btn-sm btn-outline-warning" x-tooltip="Edit">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('households.destroy-member', [$household, $member]) }}" 
                                                      method="POST" class="inline" 
                                                      onsubmit="return confirm('Are you sure you want to remove this member?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" x-tooltip="Remove">
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-white-dark">
                            <svg class="mx-auto mb-3 h-16 w-16" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div class="text-lg font-semibold mb-2">No household members found</div>
                            <a href="{{ route('households.add-member', $household) }}" class="btn btn-primary btn-sm">
                                <svg class="h-4 w-4 mr-1" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add First Member
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('households.index') }}" class="btn btn-outline-dark">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Households
            </a>
        </div>
    </div>
</div>
@endsection

@section('title', 'Household Details - ' . $household->household_number)

@section('content')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Household Details - {{ $household->household_number }}</h4>
                    
                    <div class="page-title-right">
                        <div class="btn-group">
                            <a href="{{ route('households.add-member', $household) }}" class="btn btn-primary">
                                <i class="mdi mdi-account-plus me-1"></i> Add Household Member
                            </a>
                            <a href="{{ route('households.edit', $household) }}" class="btn btn-warning">
                                <i class="mdi mdi-pencil me-1"></i> Edit Household
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Household Information -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Household Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%;">Household No:</th>
                                <td><strong>{{ $household->household_number }}</strong></td>
                            </tr>
                            <tr>
                                <th>Region:</th>
                                <td>{{ $household->region ?: 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Province:</th>
                                <td>{{ $household->province ?: 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>City/Municipality:</th>
                                <td>{{ $household->city_municipality ?: 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Barangay:</th>
                                <td>{{ $household->barangay ?: 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $household->household_address ?: 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Total Members:</th>
                                <td>
                                    <span class="badge bg-info">{{ $household->number_of_members }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $household->status == 'Active' ? 'success' : 'secondary' }}">
                                        {{ $household->status }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Household Members -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Household Members</h4>
                        <a href="{{ route('households.add-member', $household) }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Add Member
                        </a>
                    </div>
                    <div class="card-body">
                        @if($household->members->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Sex</th>
                                            <th>Civil Status</th>
                                            <th>Relationship</th>
                                            <th>Occupation</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($household->members as $member)
                                            <tr class="{{ $member->is_head ? 'table-warning' : '' }}">
                                                <td>
                                                    <strong>{{ $member->full_name }}</strong>
                                                    @if($member->is_head)
                                                        <br><small class="badge bg-warning text-dark">Household Head</small>
                                                    @endif
                                                </td>
                                                <td>{{ $member->calculated_age ?: $member->age }}</td>
                                                <td>{{ $member->sex }}</td>
                                                <td>{{ $member->civil_status }}</td>
                                                <td>{{ $member->relationship_to_head ?: 'N/A' }}</td>
                                                <td>{{ $member->occupation ?: 'N/A' }}</td>
                                                <td>
                                                    @if($member->labor_employment_status)
                                                        <small class="badge bg-info">{{ $member->labor_employment_status }}</small>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('households.edit-member', [$household, $member]) }}" 
                                                           class="btn btn-warning btn-sm" 
                                                           title="Edit">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('households.destroy-member', [$household, $member]) }}" 
                                                              method="POST" 
                                                              class="d-inline" 
                                                              onsubmit="return confirm('Are you sure you want to remove this member from the household?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-danger btn-sm" 
                                                                    title="Remove">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted">
                                    <i class="mdi mdi-account-group-outline mdi-48px d-block mb-2"></i>
                                    No household members found.
                                    <br>
                                    <a href="{{ route('households.add-member', $household) }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="mdi mdi-plus"></i> Add First Member
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-start">
                    <a href="{{ route('households.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Back to Households
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush

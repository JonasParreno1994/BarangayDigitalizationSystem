@extends('layouts.adminLayout.index')
@section('content')

<div class="p-6">
    <div class="panel mb-4">
        <h2 class="text-2xl font-bold mb-4">Edit KP Case</h2>
        <form method="POST" action="{{ route('kp-cases.update', $kpCase->id) }}">
            @csrf
            @method('PUT')
          
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Barangay Case No.</label>
                <input type="text" name="case_no" value="{{ old('case_no', $kpCase->case_no) }}" class="form-input w-full" required>
                @error('case_no') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Name of Complainants</label>
                <textarea name="complainants" class="form-input w-full" required>{{ old('complainants', $kpCase->complainants) }}</textarea>
                @error('complainants') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Name of Responders</label>
                <textarea name="responders" class="form-input w-full" required>{{ old('responders', $kpCase->responders) }}</textarea>
                @error('responders') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Name/Type of Dispute</label>
                <input type="text" name="dispute_type" value="{{ old('dispute_type', $kpCase->dispute_type) }}" class="form-input w-full" required>
                @error('dispute_type') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nature of Dispute</label>
                <select name="nature_of_dispute" class="form-select w-full">
                    <option value="">Select Nature</option>
                    <option value="Criminal" {{ $kpCase->nature_of_dispute == 'Criminal' ? 'selected' : '' }}>Criminal</option>
                    <option value="Civil" {{ $kpCase->nature_of_dispute == 'Civil' ? 'selected' : '' }}>Civil</option>
                    <option value="Others" {{ $kpCase->nature_of_dispute == 'Others' ? 'selected' : '' }}>Others</option>
                </select>
                @error('nature_of_dispute') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Mode of Settlement</label>
                <select name="mode_of_settlement" class="form-select w-full">
                    <option value="">Select Mode</option>
                    <option value="Mediation" {{ $kpCase->mode_of_settlement == 'Mediation' ? 'selected' : '' }}>Mediation</option>
                    <option value="Conciliation" {{ $kpCase->mode_of_settlement == 'Conciliation' ? 'selected' : '' }}>Conciliation</option>
                    <option value="Arbitration" {{ $kpCase->mode_of_settlement == 'Arbitration' ? 'selected' : '' }}>Arbitration</option>
                </select>
                @error('mode_of_settlement') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Action Taken</label>
                <select name="action_taken" class="form-select w-full">
                    <option value="">Select Action</option>
                    <option value="Repudiated" {{ $kpCase->action_taken == 'Repudiated' ? 'selected' : '' }}>Repudiated</option>
                    <option value="Withdrawn" {{ $kpCase->action_taken == 'Withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    <option value="Pending" {{ $kpCase->action_taken == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Dismissed" {{ $kpCase->action_taken == 'Dismissed' ? 'selected' : '' }}>Dismissed</option>
                    <option value="Certified to file action" {{ $kpCase->action_taken == 'Certified to file action' ? 'selected' : '' }}>Certified to file action</option>
                    <option value="Referred to concerned agencies" {{ $kpCase->action_taken == 'Referred to concerned agencies' ? 'selected' : '' }}>Referred to concerned agencies</option>
                </select>
                @error('action_taken') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('kp-cases.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update KP Case</button>
            </div>
        </form>
    </div>
</div>

@endsection

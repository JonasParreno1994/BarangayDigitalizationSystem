@extends('layouts.adminLayout.index')

@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Certification Footer Details</h3>
    </div>
    <div class="panel-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($footer)
            <div class="row">
                @if($footer->picture1)
                    <div class="col-md-4">
                        <h4>Picture 1</h4>
                        <img src="{{ asset('storage/'.$footer->picture1) }}" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                @endif

                @if($footer->logo1)
                    <div class="col-md-4">
                        <h4>Logo 1</h4>
                        <img src="{{ asset('storage/'.$footer->logo1) }}" class="img-thumbnail" style="max-height: 200px;">
                        <p>{{ $footer->logo1description }}</p>
                    </div>
                @endif

                @if($footer->logo2)
                    <div class="col-md-4">
                        <h4>Logo 2</h4>
                        <img src="{{ asset('storage/'.$footer->logo2) }}" class="img-thumbnail" style="max-height: 200px;">
                        <p>{{ $footer->logo2description }}</p>
                    </div>
                @endif
            </div>

            <div class="row mt-3">
                @if($footer->logo3)
                    <div class="col-md-4">
                        <h4>Logo 3</h4>
                        <img src="{{ asset('storage/'.$footer->logo3) }}" class="img-thumbnail" style="max-height: 200px;">
                        <p>{{ $footer->logo3description }}</p>
                    </div>
                @endif
            </div>

            <div class="mt-3">
                <a href="{{ route('certification-footer.edit', $footer->id) }}" class="btn btn-primary">Edit Footer</a>
            </div>
        @else
            <div class="alert alert-info">
                No certification footer details found. <a href="{{ route('certification-footer.create') }}" class="btn btn-primary">Create Now</a>
            </div>
        @endif
    </div>
</div>
@endsection